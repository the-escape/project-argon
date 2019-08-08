<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityCache;
use Escape\Argon\EntityManagement\Eloquent\LocalisationRepository;
use Escape\Argon\EntityManagement\Helpers\Fields as FieldsHelpers;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\Helpers\Pages;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Events\BeforePageSaved;
use Escape\Argon\Helpers\Solr;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Escape\Argon\Events\PageSaved;
use Illuminate\Http\Request;
use Input;
use Redirect;
use stdClass;
use View;
use Lang;
use Escape\Argon\EntityManagement\FieldTypes\ComboFieldType;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use Illuminate\Support\Facades\DB;

class PagesController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:content:manage');

        parent::__construct($request);
    }

    public function manage(EntityTypeRepository $typeRepository, LocaleRepository $localeRepository)
    {
        $types = $typeRepository->page();
        $locales = $localeRepository->all();
        $entities = Pages::sitetree();

        return view('argon::pages.manage', [
            'types' => $types,
            'entities' => $entities,
            'locales' => $locales,
        ]);
    }

    public function delete($pageId, EntityRepository $entityRepository, Solr $solr)
    {
        $entityRepository->delete($pageId);
        $solr->unindexEntity($pageId);
        EntityCache::uncache($pageId);
        return Redirect::route('cms:pages:manage');
    }

    /**
     * create a new child node in the site tree
     *
     * @param $parentId
     * @param $typeId
     * @param EntityTypeRepository $typeRepository
     * @param EntityGroupRepository $groupRepository
     * @param MediaFolderRepository $folderRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(
        $parentId,
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        MediaFolderRepository $folderRepository
    ) {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->getUsedGroupsByEntityType($typeId, ['order']);
        $tree = Pages::sitetree();

        return view('argon::pages.create', [
            'type' => $type,
            'parentId' => $parentId,
            'groups' => $groups,
            'root' => $folderRepository->root(),
            'tree' => $tree,
        ]);
    }

    /**
     * save new child node in the site tree
     *
     * @param $parentId
     * @param $typeId
     * @param EntityTypeRepository $typeRepository
     * @param EntityRepository $entityRepository
     * @param EntityRevisionRepository $revisionRepository
     * @param FieldDataRepository $fieldDataRepository
     * @param LocalisationRepository $localisationRepository
     * @param LocaleRepository $localeRepository
     * @param Request $request
     * @param Solr $solr
     *
     * @return mixed
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(
        $parentId,
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionRepository,
        FieldDataRepository $fieldDataRepository,
        LocalisationRepository $localisationRepository,
        LocaleRepository $localeRepository,
        Request $request,
        Solr $solr
    ) {
        $type = $typeRepository->find($typeId);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        // update input slug value to reflect str_slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
            'slug' => "required|unique:entities,slug,NULL,id,parent_id,{$parentId},deleted_at,NULL",
        ];

        list($niceNames, $rules) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules);

        $this->validate($request, $rules, [], $niceNames);

        $entity = $entityRepository->create([
            'name' => $request->input('name'),
            'entity_type_id' => $type->id,
            'owner_id' => $request->user()->id,
            'parent_id' => $parentId,
            'slug' => $slug,
            'status' => $request->input('status'),
        ]);

        $parentEntity = EntityCache::where('entity_id', $parentId)->first();
        $locale = $localeRepository->getFullLocaleById($parentEntity->entity_locale_id);

        $localisation = $localisationRepository->create([
            'entity_id' => $entity->getId(),
            'locale_id' => $locale->getId(),
        ]);

        $result = event(new BeforePageSaved($entity, $localisation, $request));

        if (isset($result->request))
        {
            $request = $result->request;
        }

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $locale);

        $redirect_url = new stdClass();
        $redirect_url->{$localisation->getLocaleId()} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $group_order = new stdClass();
        $group_order->{$localisation->getLocaleId()} = $request->input('group_order', $entity->getGroupOrderString($localisation->getLocaleId()));
        $request->merge(['group_order' => $group_order]);

        $group_render = new stdClass();
        $group_render->{$localisation->getLocaleId()} = $request->input('group_render', []);
        $request->merge(['group_render' => $group_render]);

        $settings = new stdClass();
        $settings->{$localisation->getLocaleId()} = new stdClass();
        $settings->{$localisation->getLocaleId()}->pointer = $request->has('entity_pointer') ? $request->input('entity_pointer') : null;
        $request->merge(['settings' => $settings]);

        $entity = $entityRepository->update(Input::only(['redirect_url', 'group_order', 'group_render', 'settings']), $entity->id);

        $solr->indexEntity($entity, $localisation);

        EntityCache::cache($entity, $localisation);

        event(new PageSaved($entity, $localisation, $request));

        return Redirect::route('cms:pages:edit_locale',[
            'page' => $entity->id,
            'locale' => $localisation->getLocaleId(),
        ])->with('message', Lang::get('argon-entities::page.created'));
    }

    /**
     * create a new root node in the site tree
     *
     * @param $typeId
     * @param EntityTypeRepository $typeRepository
     * @param EntityGroupRepository $groupRepository
     * @param MediaFolderRepository $folderRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createRoot(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        MediaFolderRepository $folderRepository
    ) {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->getUsedGroupsByEntityType($typeId, ['order']);
        $tree = Pages::sitetree();

        return view('argon::pages.create-root', [
            'type' => $type,
            'parentId' => null,
            'groups' => $groups,
            'root' => $folderRepository->root(),
            'tree' => $tree,
        ]);
    }

    /**
     * save new root node in the site tree
     *
     * @param $typeId
     * @param EntityTypeRepository $typeRepository
     * @param EntityRepository $entityRepository
     * @param EntityRevisionRepository $revisionRepository
     * @param FieldDataRepository $fieldDataRepository
     * @param LocalisationRepository $localisationRepository
     * @param LocaleRepository $localeRepository
     * @param Request $request
     * @param Solr $solr
     *
     * @return mixed
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRoot(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionRepository,
        FieldDataRepository $fieldDataRepository,
        LocalisationRepository $localisationRepository,
        LocaleRepository $localeRepository,
        Request $request,
        Solr $solr
    ) {
        $type = $typeRepository->find($typeId);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        // update input slug value to reflect str_slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
            'slug' => "required|unique:entities,slug,NULL,id,deleted_at,NULL",
        ];

        list($niceNames, $rules) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules);

        $this->validate($request, $rules, [], $niceNames);

        $entity = $entityRepository->create([
            'name' => $request->input('name'),
            'entity_type_id' => $type->id,
            'owner_id' => $request->user()->id,
            'parent_id' => null,
            'slug' => $slug,
            'status' => $request->input('status'),
        ]);

        $locale = $localeRepository->getDefault();

        $localisation = $localisationRepository->create([
            'entity_id' => $entity->getId(),
            'locale_id' => $locale->getId(),
        ]);

        $result = event(new BeforePageSaved($entity, $localisation, $request));

        if (isset($result->request))
        {
            $request = $result->request;
        }

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $locale);

        $redirect_url = new stdClass();
        $redirect_url->{$localisation->getLocaleId()} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $group_order = new stdClass();
        $group_order->{$localisation->getLocaleId()} = $request->input('group_order', $entity->getGroupOrderString($localisation->getLocaleId()));
        $request->merge(['group_order' => $group_order]);

        $group_render = new stdClass();
        $group_render->{$localisation->getLocaleId()} = $request->input('group_render', []);
        $request->merge(['group_render' => $group_render]);

        $settings = new stdClass();
        $settings->{$localisation->getLocaleId()} = new stdClass();
        $settings->{$localisation->getLocaleId()}->pointer = $request->has('entity_pointer') ? $request->input('entity_pointer') : null;
        $request->merge(['settings' => $settings]);

        $entity = $entityRepository->update(Input::only(['redirect_url', 'group_order', 'group_render', 'settings']), $entity->id);

        $solr->indexEntity($entity, $localisation);

        EntityCache::cache($entity, $localisation);

        event(new PageSaved($entity, $localisation, $request));

        return Redirect::route('cms:pages:edit_locale',[
            'page' => $entity->id,
            'locale' => $localisation->getLocaleId(),
        ])->with('message', Lang::get('argon-entities::page.created'));
    }

    public function edit($pageId, EntityRepository $entityRepository)
    {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);
        $locale = $page->getDefaultLocalisation();

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $pageId,
            'locale' => $locale->getLocaleId(),
        ]);
    }

    public function update(
        $pageId,
        $localeId,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionsRepository,
        FieldDataRepository $fieldDataRepository,
        EntityTypeRepository $typeRepository,
        Request $request,
        Solr $solr)
    {
        $entity = $entityRepository->find($pageId);

        $currentLocale = Locale::find($localeId);

        $currentLocalisation = $entity->getLocalisation($currentLocale);

        $result = event(new BeforePageSaved($entity, $currentLocalisation, $request));

        if (isset($result->request))
        {
            $request = $result->request;
        }

        $type = $typeRepository->find($entity->entity_type_id);

        $fields = $type->fields;

        $preview = $request->exists('preview_page');

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        $slug = str_slug($request->input('slug'));

        // update input slug value to reflect str_slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
        ];

        if ($entity->parent_id != null) {
            $rules['slug'] = "required|unique:entities,slug,{$entity->id},id,parent_id,{$entity->parent_id},deleted_at,NULL";
        } else {
            if (empty($entity->slug) || $entity->slug == '/')
            {
                $request->merge(['slug' => '/']);
            }
            else
            {
                $rules['slug'] = "required|unique:entities,slug,{$entity->id},id,parent_id,NULL,deleted_at,NULL";
            }
        }

        $messages = [];

        list($niceNames, $rules, $messages) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules, $messages);

        $this->validate($this->request, $rules, $messages, $niceNames);

        $redirect_url = ($entity->redirect_url instanceof stdClass) ? $entity->redirect_url : new stdClass();
        $redirect_url->{$localeId} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $group_order = ($entity->group_order instanceof stdClass) ? $entity->group_order : new stdClass();
        $group_order->{$localeId} = $request->input('group_order', $entity->getGroupOrderString($localeId));
        $request->merge(['group_order' => $group_order]);

        $group_render = ($entity->group_render instanceof stdClass) ? $entity->group_render : new stdClass();
        $group_render->{$localeId} = $request->input('group_render', []);
        $request->merge(['group_render' => $group_render]);

        $settings = ($entity->settings instanceof stdClass) ? $entity->settings : new stdClass();
        if (!isset($settings->{$localeId}))
        {
            $settings->{$localeId} = new stdClass();
        }
        $settings->{$localeId}->pointer = $request->has('entity_pointer') ? $request->input('entity_pointer') : null;
        $request->merge(['settings' => $settings]);

        if (!$preview) {
            $entity->update($request->only(['name', 'slug', 'status', 'redirect_url', 'group_order', 'group_render', 'settings']));
        }

        $revision = $revisionsRepository->create([
            'entity_localisation_id' => $currentLocalisation->id,
            'status' => $preview ? RevisionStatus::PREVIEW : RevisionStatus::PUBLISHED,
            'created_by' => $this->request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $currentLocale);

        if ($preview) {
            $revisionsRepository->deletePreviews([$revision->id]);
            $previewUrl = url($entity->toPage()->getUrl($currentLocale).'?'.http_build_query(['preview_page' => $revision->id]));
            return response($previewUrl);
        }

        $revisionsRepository->archiveRevisions($currentLocalisation->id, $revision->id);

        $localisations = $entity->localisations;

        foreach ($localisations as $localisation)
        {
            $solr->indexEntity($entity, $localisation);
            EntityCache::cache($entity, $localisation);
        }

        event(new PageSaved($entity, $currentLocalisation, $request));

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $entity->id,
            'locale'=>$currentLocalisation->getLocaleId(),
        ])->with('message', Lang::get('argon-entities::page.updated'));
    }

    public function saveRevision(
        $pageId,
        $localeId,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionsRepository,
        FieldDataRepository $fieldDataRepository,
        EntityTypeRepository $typeRepository,
        Request $request
    )
    {
        $entity = $entityRepository->find($pageId);

        $currentLocale = Locale::find($localeId);

        $currentLocalisation = $entity->getLocalisation($currentLocale);

        $type = $typeRepository->find($entity->entity_type_id);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        $slug = str_slug($request->input('slug'));

        // update input slug value to reflect str_slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
        ];

        if ($entity->parent_id != null) {
            $rules['slug'] = "required|unique:entities,slug,{$entity->id},id,parent_id,{$entity->parent_id},deleted_at,NULL";
        } else {
            if($entity->slug !== '/')
            {
                $request->merge(['slug' => '/' . $entity->slug]);
            }
            else
            {
                $request->merge(['slug' => '/']);
            }
        }

        $messages = [];

        list($niceNames, $rules, $messages) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules, $messages);

        $this->validate($this->request, $rules, $messages, $niceNames);

        $redirect_url = ($entity->redirect_url instanceof stdClass) ? $entity->redirect_url : new stdClass();
        $redirect_url->{$localeId} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $group_order = ($entity->group_order instanceof stdClass) ? $entity->group_order : new stdClass();
        $group_order->{$localeId} = $request->input('group_order', $entity->getGroupOrderString($localeId));
        $request->merge(['group_order' => $group_order]);

        $group_render = ($entity->group_render instanceof stdClass) ? $entity->group_render : new stdClass();
        $group_render->{$localeId} = $request->input('group_render', []);
        $request->merge(['group_render' => $group_render]);

        $revision = $revisionsRepository->create([
            'entity_localisation_id' => $currentLocalisation->id,
            'status' =>  RevisionStatus::PREVIOUSLY_PUBLISHED,
            'created_by' => $this->request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $currentLocale);

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $entity->id,
            'locale'=>$currentLocalisation->getLocaleId(),
        ])->with('message', "Revision has been saved.");
    }

    /**
     * edit the details of an existing locale (country / language)
     *
     * @param $pageId
     * @param $localeId
     * @param null $revisionId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * @throws \Exception
     */
    public function editLocale(
        $pageId,
        $localeId,
        $revisionId=null
    ) {
        $entityRepository = app()->make(EntityRepository::class);
        $groupRepository = app()->make(EntityGroupRepository::class);
        $folderRepository = app()->make(MediaFolderRepository::class);

        /** @var Entity $page */
        $page = $entityRepository->find($pageId);

//        if ($clone) {
//            $localisation = $page->getDefaultLocalisation();
//        } else {
        $currentLocale = Locale::find($localeId);
        $localisation = $page->getLocalisation($currentLocale);
//        }

        $currentRevision = null;
        $publishedRevision = $localisation->publishedRevision();

        if ($revisionId)
        {
            $revisionsRepository = app()->make(EntityRevisionRepository::class);
            $currentRevision = $revisionsRepository->findWhere(['id' => $revisionId])->first();

            if ($currentRevision === null)
            {
                return back()->with('message', 'Invalid revision.');
            }
        }
        else
        {
            $currentRevision = $publishedRevision;
        }

        $revisions = $localisation->archivedRevisions(5, ['*'], 'revisions');

        $revisionsPagination = easyPagination(range(1, $revisions->total()), $revisions->perPage(), $revisions->currentPage());

        $groups = $groupRepository->getUsedGroupsByEntityType($page->entity_type_id, ['order']);

        $currentLocales = $page->getLocalisations()->getLocales();

        $locales = Locale::all()->filter(function ($locale) use ($currentLocales) {
            return !$currentLocales->contains($locale);
        });

        $tree = Pages::sitetree();

        return view('argon::pages.edit', [
            'page' => $page,
            'localisation' => $localisation,
            'publishedRevision' => $publishedRevision,
            'root' => $folderRepository->root(),
            'groups' => $groups,
            'locales' => $locales,
            'localeId' => $localeId,
            'revisions' => $revisions,
            'revisionsPagination' => $revisionsPagination,
            'currentRevision' => $currentRevision,
            'tree' => $tree,
        ]);
    }

    /**
     * create a new locale (country / language)
     *
     * @param $pageId
     * @param Request $request
     * @param LocalisationRepository $localisationRepository
     * @param EntityRevisionRepository $revisionRepository
     * @param EntityRepository $entityRepository
     * @param Solr $solr
     *
     * @return mixed
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createLocale(
        $pageId,
        Request $request,
        LocalisationRepository $localisationRepository,
        EntityRevisionRepository $revisionRepository,
        EntityRepository $entityRepository,
        Solr $solr
    ) {
        $localeId = (int)$request->input('locale');
        $clone = (int)$request->input('clone');

        $locale = Locale::find($localeId);

        if (!$locale)
        {
            return Redirect::route('cms:pages:edit_locale', ['page' => $pageId, 'locale' => 1])->with('message', 'Locale is required.');
        }

        $localisation = $localisationRepository->create([
            'locale_id' => $localeId,
            'entity_id' => $pageId
        ]);

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::DRAFT,
            'created_by' => $request->user()->id
        ]);

        $page = $entityRepository->find($pageId);

        if ($clone)
        {
            $typeRepository = app()->make(EntityTypeRepository::class);
            $fieldDataRepository = app()->make(FieldDataRepository::class);

            $pageData = [];

            $defaultLocalisation = $page->getDefaultLocalisation();
            $latestRevision = $defaultLocalisation->publishedRevision();
            $latestRevisionFields = $latestRevision->getFields();

            $redirect_url = ($page->redirect_url instanceof stdClass) ? $page->redirect_url : new stdClass();
            $redirect_url->{$localeId} = isset($redirect_url->{$defaultLocalisation->getLocaleId()}) ? $redirect_url->{$defaultLocalisation->getLocaleId()} : null;
            $pageData['redirect_url'] = $redirect_url;

            $group_order = ($page->group_order instanceof stdClass) ? $page->group_order : new stdClass();
            $group_order->{$localeId} = isset($group_order->{$defaultLocalisation->getLocaleId()}) ? $group_order->{$defaultLocalisation->getLocaleId()} : null;
            $pageData['group_order'] = $group_order;

            $group_render = ($page->group_render instanceof stdClass) ? $page->group_render : new stdClass();
            $group_render->{$localeId} = isset($group_render->{$defaultLocalisation->getLocaleId()}) ? $group_render->{$defaultLocalisation->getLocaleId()} : null;
            $pageData['group_render'] = $group_render;

            $page->update($pageData);

            $type = $typeRepository->find($page->entity_type_id);
            $fields = $type->fields;

            foreach ($fields as $field)
            {
                if (!$latestRevisionFields->has($field->id))
                {
                    continue;
                }

                switch ($field->field_type)
                {
                    case 'combo':
                    case 'image':
                    case 'file':
                    case 'location':
                    case 'select':
                    case 'item':
                        $value = $latestRevisionFields[$field->id]->getData();
                        break;

                    default:
                        $value = (string)$latestRevisionFields[$field->id];
                }

                FieldsHelpers::saveField($field, $revision, $value, $fieldDataRepository, $locale);
            }

            if ($page->status == 1) {
                event(new PageSaved($page, $localisation, $request));
            }
        }

        $solr->indexEntity($page, $localisation);

        EntityCache::cache($page, $localisation);

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $pageId,
            'locale' => $localeId,
        ]);
    }

    /**
     * delete an existing locale
     *
     * @param $pageId
     * @param $localeId
     *
     * @return mixed
     */
    public function deleteLocale($pageId, $localeId)
    {
        $entityRepository = app()->make(EntityRepository::class);
        $page = $entityRepository->find($pageId);
        $currentLocale = Locale::find($localeId);
        $defaultLocale = $page->getDefaultLocalisation();
        $localisation = $page->getLocalisation($currentLocale);

        $localisation->delete();
        EntityCache::uncache($pageId, $localeId);

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $pageId,
            'locale' => $defaultLocale->getLocaleId(),
        ]);
    }


    // Handles JSTree ajax reorder requests
    public function updateParent($pageId, $parentId, EntityRepository $entityRepository, Solr $solr)
    {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);
        $parent = $entityRepository->find($parentId);

        $page->parent_id = $parent->id;
        $result = $page->save();

        $localisations = $page->localisations;
        foreach ($localisations as $localisation)
        {
            $solr->indexEntity($page, $localisation);
            EntityCache::cache($page, $localisation);
        }

        return json_encode(['success' => $result]);
    }

    /**
     * Deprecated, as revisions handled within page edit view.
     * @param $pageId
     * @param $localeId
     *
     * @return mixed
     */
    public function revisions($pageId, $localeId)
    {
        $entityRepository = app()->make(EntityRepository::class);
        $page = $entityRepository->find($pageId);
        $currentLocale = Locale::find($localeId);
        $localisation = $page->getLocalisation($currentLocale);

        $entityRevisionRepository = app()->make(EntityRevisionRepository::class);
        $revisions = $entityRevisionRepository->archivedRevisions($localisation->id);

        return view('argon::pages.revisions')->with(compact('revisions'));
    }

    public function revisionRestore($revisionId, Request $request)
    {
        $revisionsRepository = app()->make(EntityRevisionRepository::class);
        $revision = $revisionsRepository->findWhere(['id' => $revisionId])->first();

        if ($revision === null)
        {
            return back()->with('message', 'Invalid revision.');
        }

        $localisation = $revision->localisation;

        $revision->status = RevisionStatus::PUBLISHED;
        $revision->save();

        $revisionsRepository->archiveRevisions($localisation->id, $revision->id);

        $entity = $localisation->entity;

        event(new PageSaved($entity, $localisation, $request));

        $solr = app()->make(Solr::class);

        $solr->indexEntity($entity, $localisation);

        EntityCache::cache($entity, $localisation, $revision);

        return back()->with('message', 'Revision restored.');
    }

    public function importTranslation($pageId, $localeId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'xml' => 'required'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $file = $request->file('xml');

        libxml_use_internal_errors(true);

        $xml = new DOMDocument("1.0", "utf-8");
        $xml->load($file);

        if ($xml === false)
        {
            $errors = libxml_get_errors();
            libxml_clear_errors();

            $validator->errors()->add('xml', 'The uploaded file is invalid.');
            foreach($errors as $error)
            {
                $validator->errors()->add('xml', $error->message);
            }

            return redirect()->back()->withErrors($validator->errors());
        }

        $schema = __DIR__.'/../../../public/translation-schema.xsd';

        if (file_exists($schema) && !$xml->schemaValidate($schema)) {
            $validator->errors()->add('xml', 'The uploaded file has failed the schema valiadtion.');
            return redirect()->back()->withErrors($validator->errors());
        }

        $xmlData = $this->getDataFromImportedTranslationXml($xml);

        $typeRepository = app()->make(EntityTypeRepository::class);
        $fieldDataRepository = app()->make(FieldDataRepository::class);
        $entityRepository = app()->make(EntityRepository::class);
        $revisionRepository = app()->make(EntityRevisionRepository::class);
        $solr = app()->make(Solr::class);

        $pageData = [];

        $page = $entityRepository->find($pageId);
        $defaultLocalisation = $page->getDefaultLocalisation();
        $latestRevision = $defaultLocalisation->publishedRevision();
        $latestRevisionFields = $latestRevision->getFields();

        $redirect_url = ($page->redirect_url instanceof stdClass) ? $page->redirect_url : new stdClass();
        $redirect_url->{$localeId} = isset($redirect_url->{$defaultLocalisation->getLocaleId()}) ? $redirect_url->{$defaultLocalisation->getLocaleId()} : null;
        $pageData['redirect_url'] = $redirect_url;

        $group_order = ($page->group_order instanceof stdClass) ? $page->group_order : new stdClass();
        $group_order->{$localeId} = isset($group_order->{$defaultLocalisation->getLocaleId()}) ? $group_order->{$defaultLocalisation->getLocaleId()} : null;
        $pageData['group_order'] = $group_order;

        $group_render = ($page->group_render instanceof stdClass) ? $page->group_render : new stdClass();
        $group_render->{$localeId} = isset($group_render->{$defaultLocalisation->getLocaleId()}) ? $group_render->{$defaultLocalisation->getLocaleId()} : null;
        $pageData['group_render'] = $group_render;

        $page->update($pageData);



        $currentLocale = Locale::find($localeId);
        $currentLocalisation = $page->getLocalisation($currentLocale);

        DB::beginTransaction();

        try
        {
            $revision = $revisionRepository->create([
                'entity_localisation_id' => $currentLocalisation->getId(),
                'status' => RevisionStatus::PUBLISHED, // TODO: check if needs to be published straight away
                'created_by' => $request->user()->id
            ]);

            $type = $typeRepository->find($page->entity_type_id);
            $fields = $type->fields;

            foreach ($fields as $field)
            {
                if (!$latestRevisionFields->has($field->id))
                {
                    continue;
                }

                switch ($field->field_type)
                {
                    case 'image':
                    case 'file':
                    case 'location':
                    case 'select':
                    case 'item':
                    case 'grid':
                        $value = $latestRevisionFields[$field->id]->getData();
                        break;
                    case 'combo':
                        $defaultValue = $latestRevisionFields[$field->id]->getData();
                        $value = isset($xmlData[$field->id]) ? $xmlData[$field->id] : [];
                        $vKeys = array_keys($value);
                        $dvKeys = array_keys($defaultValue);

                        foreach($value as $hash => $combo)
                        {
                            $valueIndex = array_search($hash, $vKeys);
                            $defaultHash = $valueIndex !== false && isset($dvKeys[$valueIndex]) ? $dvKeys[$valueIndex] : false;

                            if ($defaultHash)
                            {
                                $defaultValueFields = $defaultValue[$defaultHash]->fields;

                                foreach($defaultValueFields as $subfieldId => $subfieldValue)
                                {
                                    if (!isset($combo->fields[$subfieldId]))
                                    {
                                        $combo->fields[$subfieldId] = $subfieldValue;
                                    }
                                }
                            }
                        }
                        break;

                    default:
                        $value = isset($xmlData[$field->id]) ? $xmlData[$field->id] : '';
                        break;
                }

                FieldsHelpers::saveField($field, $revision, $value, $fieldDataRepository, $currentLocale);
            }

            $revisionRepository->archiveRevisions($currentLocalisation->id, $revision->id);

            EntityCache::cache($page, $currentLocalisation);

            $solr->indexEntity($page, $currentLocalisation);

            DB::commit();

        }
        catch(Exception $e)
        {
            DB::rollBack();

            dd($e);

            return Redirect::route('cms:pages:edit_locale', [
                'page' => $pageId,
                'locale' => $currentLocalisation->getLocaleId(),
            ])->with('message', 'Something went wrong when saving the translation.');
        }

        return Redirect::route('cms:pages:edit_locale', [
            'page' => $pageId,
            'locale' => $currentLocalisation->getLocaleId(),
        ])->with('message', 'Translation uploaded successfully.');
    }

    private function getDataFromImportedTranslationXml($xml)
    {
        $dom = $xml->documentElement;
        $fields = $dom->getElementsByTagName('field');
        if($fields->length)
        {
            foreach($fields as $field)
            {
                $xmlFieldId = $field->getAttribute('id');
                $xmlFieldType = $field->getAttribute('type');

                $translationContent = $field->getElementsByTagName('translationContent');
                if($xmlFieldType !== 'combo' && $translationContent->length)
                {
                    $xmlFieldValue = [];
                    foreach($translationContent as $node)
                    {
                        $xmlFieldValue[] = $node->nodeValue;
                    }

                    $xmlData[$xmlFieldId] = $xmlFieldValue;
                }

                $subfieldsWrapper = $field->getElementsByTagName('subfields');
                if($subfieldsWrapper->length)
                {
                    $subfieldsNode = $subfieldsWrapper->item(0); // need multiple!
                    $subfields = $subfieldsNode->getElementsByTagName('field');
                    if ($subfields->length)
                    {
                        $xmlFieldSubfields = [];

                        foreach($subfields as $subfield)
                        {
                            $xmlSubFieldValue = [];
                            $xmlSubFieldId = $subfield->getAttribute('id');
                            $xmlSubFieldType = $subfield->getAttribute('type');

                            $translationContent = $subfield->getElementsByTagName('translationContent');
                            if($translationContent->length)
                            {
                                foreach($translationContent as $node)
                                {
                                    $xmlSubFieldValue[] = $node->nodeValue;
                                }
                            }

                            if($xmlSubFieldType !== 'grid')
                            {
                                $xmlFieldSubfields['fields'][$xmlSubFieldId] = $xmlSubFieldValue;
                            }
                        }

                        $xmlData[$xmlFieldId][guid()] = (object) $xmlFieldSubfields;
                    }
                }
            }
        }

        return $xmlData;
    }

    public function downloadTranslationTemplate($pageId, $localeId)
    {
        $entityRepository = app()->make(EntityRepository::class);
        $groupRepository = app()->make(EntityGroupRepository::class);
        $localeRepository = app()->make(LocaleRepository::class);

        /** @var Entity $page */
        $page = $entityRepository->find($pageId);

        $defaultLocale = $localeRepository->getDefault(); // original content
        $currentLocale = Locale::find($localeId); // translation

        $defaultLocalisation = $page->getLocalisation($defaultLocale);
        $currentLocalisation = $page->getLocalisation($currentLocale);

        $defaultPublishedRevision = $defaultLocalisation->publishedRevision();
        $currentPublishedRevision = $currentLocalisation->publishedRevision();

        $groups = $groupRepository->getUsedGroupsByEntityType($page->entity_type_id, ['order']);
        $fields = [];

        foreach($groups as $group)
        {
            foreach ($group->getFields() as $field)
            {
                $fieldValue = $defaultPublishedRevision->getField($field->getId());
                $translationFieldValue = $currentPublishedRevision->getField($field->getId());

                $fields[] = [
                    'field' => $field,
                    'content' => $fieldValue,
                    'translation' => $translationFieldValue,
                ];
            }
        }

        $xml = $this->generateXmlFile($fields);
        $fileName = sprintf('Translation %s %s.xml', strtoupper($currentLocale->language->language_code), $page->name);

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => sprintf('attachment; filename=%s', $fileName),
        ]);
    }

    private function generateXmlFile(array $fields)
    {
        // TODO: need to reference the schema in an xml
        $xml = new DOMDocument( "1.0", "utf-8" );

        $xmlFields = $xml->createElement('translation');

        $skipFieldTypes = [
            'boolean',
            'item',
            'image',
            'file',
            'video',
            'user',
            'select',
            'colourpicker',
            'datetime',
            'location',
            'button',
            'grid',
        ];

        foreach($fields as $field)
        {
            if(!empty($field['content']) && !$field['content']->isEmpty())
            {
                if ($field['field'] instanceof ComboFieldType)
                {
                    $hash = guid();
                    $originalValue = $field['content'];
                    $translationValue = $field['translation'];

                    $xmlField = $xml->createElement('field');
                    $xmlField->setAttribute('label', $field['field']->getFieldName());
                    $xmlField->setAttribute('name', $field['field']->getFormFieldName($hash));
                    $xmlField->setAttribute('id', $field['field']->getId());
                    $xmlField->setAttribute('multiple', $field['field']->allowMultiple() ? "true" : "false");
                    $xmlField->setAttribute('type', $field['field']->getKey());

                    $subfields = $field['field']->getSubFields();

                    $xmlSubFields = $xml->createElement('subfields');

                    foreach($subfields as $subfield)
                    {
                        $subfieldValue = $originalValue->field($subfield->getFieldSlug());
                        $subfieldTranslationValue = $translationValue ? $translationValue->field($subfield->getFieldSlug()) : null;

                        if(!in_array($subfield->getKey(), $skipFieldTypes) && !empty($subfieldValue) && !$subfieldValue->isEmpty())
                        {
                            $xmlSubField = $xml->createElement('field');
                            $xmlSubField->setAttribute('label', $subfield->getFieldName());
                            $xmlSubField->setAttribute('name', $subfield->getFormFieldName($hash));
                            $xmlSubField->setAttribute('id', $subfield->getId());
                            $xmlSubField->setAttribute('multiple', $subfield->allowMultiple() ? "true" : "false");
                            $xmlSubField->setAttribute('type', $subfield->getKey());

                            foreach($subfieldValue as $value)
                            {
                                $value = htmlspecialchars($value);
                                $xmlOriginalContent = $xml->createElement('originalContent', $value);
                                $xmlSubField->appendChild($xmlOriginalContent);
                            }

                            if(!empty($subfieldTranslationValue))
                            {
                                foreach($subfieldTranslationValue as $value)
                                {
                                    $value = htmlspecialchars($value);
                                    $xmlTranslationContent = $xml->createElement('translationContent', $value);
                                    $xmlSubField->appendChild($xmlTranslationContent);
                                }
                            }
                            else
                            {
                                $xmlTranslationContent = $xml->createElement('translationContent');
                                $xmlSubField->appendChild($xmlTranslationContent);
                            }

                            $xmlSubFields->appendChild($xmlSubField);
                        }
                    }
                    $xmlField->appendChild($xmlSubFields);
                    $xmlFields->appendChild($xmlField);
                }
                elseif(!in_array($field['field']->getKey(), $skipFieldTypes))
                {
                    $hash = '';

                    $xmlField = $xml->createElement('field');
                    $xmlField->setAttribute('label', $field['field']->getFieldName());
                    $xmlField->setAttribute('name', $field['field']->getFormFieldName($hash));
                    $xmlField->setAttribute('id', $field['field']->getId());
                    $xmlField->setAttribute('multiple', $field['field']->allowMultiple() ? "true" : "false");
                    $xmlField->setAttribute('type', $field['field']->getKey());

                    foreach($field['content'] as $value)
                    {
                        $value = htmlspecialchars($value);
                        $xmlOriginalContent = $xml->createElement('originalContent', $value);
                        $xmlField->appendChild($xmlOriginalContent);
                    }


                    if(!empty($field['translation']))
                    {
                        foreach($field['translation'] as $value)
                        {
                            $value = htmlspecialchars($value);
                            $xmlTranslationContent = $xml->createElement('translationContent', $value);
                            $xmlField->appendChild($xmlTranslationContent);
                        }
                    }
                    else
                    {
                        $xmlTranslationContent = $xml->createElement('translationContent');
                        $xmlField->appendChild($xmlTranslationContent);
                    }

                    $xmlFields->appendChild($xmlField);
                }

            }
        }

        $xml->appendChild($xmlFields);

        return $xml->saveXML();
    }
}
