<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\LocalisationRepository;
use Escape\Argon\EntityManagement\Helpers\Fields as FieldsHelpers;
use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
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

class PagesController extends BaseController
{
    public function manage(
        EntityTypeRepository $typeRepository,
        LocaleRepository $localeRepository,
        EntityRepository $entityRepository
    ) {
        $types = $typeRepository->page();

        $locales = $localeRepository->all();

        $entities = $entityRepository->pages();

        $entities = $entities->keyBy('id');

        foreach ($entities as $id => $entity) {
            if ($entity->parent_id) {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        $entities = $entities->filter(function ($entity) {
            return $entity->parent_id == null;
        });

        return view('argon::pages.manage', ['types' => $types, 'entities' => $entities, 'locales' => $locales]);
    }

    public function delete($pageId, EntityRepository $entityRepository, Solr $solr)
    {
        $entityRepository->delete($pageId);
        $solr->unindexEntity($pageId);

        return Redirect::route('cms:pages:manage');
    }

    public function create(
        $parentId,
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        MediaFolderRepository $folderRepository
    ) {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->getUsedGroupsByEntityType($typeId, ['order']);
        return view(
            'argon::pages.create',
            [
                'type' => $type,
                'parentId' => $parentId,
                'groups' => $groups,
                'root' => $folderRepository->root(),
            ]
        );
    }

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

        $entity = $entityRepository->update(Input::only(['redirect_url', 'group_order', 'group_render']), $entity->id);

        event(new PageSaved($entity, $localisation, $request));

        $solr->indexEntity($entity, $localisation);

        return Redirect::route(
            'cms:pages:edit_locale',
            ['page' => $entity->id, 'locale' => $localisation->getLocaleId()]
        )->with('message', Lang::get('argon-entities::page.created'));
    }

    public function edit($pageId, EntityRepository $entityRepository)
    {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);
        $locale = $page->getDefaultLocalisation();

        return Redirect::route('cms:pages:edit_locale', ['page' => $pageId, 'locale' => $locale->getLocaleId()]);
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
            $request->merge(['slug' => '/']);
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

        if (!$preview) {
            $entity->update($request->only(['name', 'slug', 'status', 'redirect_url', 'group_order', 'group_render']));
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
        foreach ($localisations as $localisation) {
            $solr->indexEntity($entity, $localisation);
        }

        event(new PageSaved($entity, $currentLocalisation, $request));

        return Redirect::route('cms:pages:edit_locale', ['page' => $entity->id, 'locale'=>$currentLocalisation->getLocaleId()])
            ->with('message', Lang::get('argon-entities::page.updated'));
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
            $request->merge(['slug' => '/']);
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

        return Redirect::route('cms:pages:edit_locale', ['page' => $entity->id, 'locale'=>$currentLocalisation->getLocaleId()])
            ->with('message', "Revision has been saved.");
    }

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

        if ($revisionId)
        {
            $revisionsRepository = app()->make(EntityRevisionRepository::class);
            $latestRevision = $revisionsRepository->findWhere(['id' => $revisionId])->first();

            if ($latestRevision === null)
            {
                return back()->with('message', 'Invalid revision.');
            }
        }
        else
        {
            $latestRevision = $localisation->publishedRevision();
        }

        $revisions = $localisation->archivedRevisions(5, ['*'], 'revisions');

        $revisionsPagination = easyPagination(range(1, $revisions->total()), $revisions->perPage(), $revisions->currentPage());

        $groups = $groupRepository->getUsedGroupsByEntityType($page->entity_type_id, ['order']);

        $currentLocales = $page->getLocalisations()->getLocales();

        $locales = Locale::all()->filter(function ($locale) use ($currentLocales) {
            return !$currentLocales->contains($locale);
        });

        return view(
            'argon::pages.edit',
            [
                'page' => $page,
                'localisation' => $localisation,
                'latest' => $latestRevision,
                'root' => $folderRepository->root(),
                'groups' => $groups,
                'locales' => $locales,
                'localeId' => $localeId,
                'revisions' => $revisions,
                'revisionsPagination' => $revisionsPagination,
            ]
        );
    }

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

        return Redirect::route('cms:pages:edit_locale', ['page' => $pageId, 'locale' => $localeId]);
    }


    public function deleteLocale($pageId, $localeId)
    {
        $entityRepository = app()->make(EntityRepository::class);
        $page = $entityRepository->find($pageId);
        $currentLocale = Locale::find($localeId);
        $defaultLocale = $page->getDefaultLocalisation();
        $localisation = $page->getLocalisation($currentLocale);

        $localisation->delete();

        return Redirect::route('cms:pages:edit_locale', ['page' => $pageId, 'locale' => $defaultLocale->getLocaleId()]);
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
        foreach ($localisations as $localisation) {
            $solr->indexEntity($page, $localisation);
        }

        return json_encode(['success' => $result]);
    }

    /**
     * Deprecated, as revisions handled within page edit view.
     * @param $pageId
     * @param $localeId
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

        return back()->with('message', 'Revision restored.');
    }
}
