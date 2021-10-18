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
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Helpers\Solr;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Input;
use Redirect;
use stdClass;
use View;
use Lang;

class BlocksController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:content:manage');

        parent::__construct($request);
    }

    public function manage(
        EntityTypeRepository $typeRepository,
        LocaleRepository $localeRepository,
        EntityRepository $entityRepository
    ) {
        $types = $typeRepository->block();
        $locales = $localeRepository->all();
        $blocks = $entityRepository->blocks();
        return view('argon::blocks.manage', ['types' => $types, 'blocks' => $blocks, 'locales' => $locales]);
    }

    public function delete($pageId, EntityRepository $entityRepository, Solr $solr)
    {
        $entityRepository->delete($pageId);
        $solr->unindexEntity($pageId);
        EntityCache::uncache($pageId);
        return Redirect::route('cms:blocks:manage');
    }

    public function create(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        MediaFolderRepository $folderRepository
    ) {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->getUsedGroupsByEntityType($typeId, ['order']);
        return view(
            'argon::blocks.create',
            [
                'type' => $type,
                'groups' => $groups,
                'root' => $folderRepository->root(),
            ]
        );
    }


    public function save(
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

        $parentId = null;

        $type = $typeRepository->find($typeId);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        // use submitted slug or auto-generate from name
        $slug = Str::slug($request->input('slug', $request->input('name')));

        // update input slug value to reflect Str::slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
            'slug' => "required|unique:entities,slug,NULL,id,parent_id,NULL,deleted_at,NULL",
        ];

        list($niceNames, $rules) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules);

        $this->validate($request, $rules, [], $niceNames);

        $entity = $entityRepository->create([
            'name' => $request->input('name'),
            'entity_type_id' => $type->id,
            'owner_id' => $request->user()->id,
            'parent_id' => $parentId,
            'slug' => $slug,
        ]);

        $locale = $localeRepository->getDefault();

        $localisation = $localisationRepository->create([
            'entity_id' => $entity->getId(),
            'locale_id' => $locale->getId(),
        ]);

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $locale);

        $group_order = new stdClass();
        $group_order->{$localisation->getLocaleId()} = $request->input('group_order', $entity->getGroupOrderString($localisation->getLocaleId()));
        $request->merge(['group_order' => $group_order]);

        $entity = $entityRepository->update(Input::only(['group_order']), $entity->id);

        $solr->indexEntity($entity, $localisation);

        EntityCache::cache($entity, $localisation);

        return Redirect::route(
            'cms:blocks:edit_locale',
            ['page' => $entity->id, 'locale' => $localisation->getLocaleId()]
        )->with('message', Lang::get('argon-entities::page.created'));
    }

    public function edit($pageId, EntityRepository $entityRepository)
    {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);
        $locale = $page->getDefaultLocalisation();

        return Redirect::route('cms:blocks:edit_locale', ['page' => $pageId, 'locale' => $locale->getLocaleId()]);
    }

    public function update(
        $pageId,
        $localeId,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionsRepository,
        FieldDataRepository $fieldDataRepository,
        EntityTypeRepository $typeRepository,
        Request $request,
        Solr $solr
    ) {
        $page = $entityRepository->find($pageId);

        $currentLocale = Locale::find($localeId);

        $localisation = $page->getLocalisation($currentLocale);

        $type = $typeRepository->find($page->entity_type_id);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        $slug = Str::slug($request->input('slug'));

        // update input slug value to reflect Str::slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
        ];

        $rules['slug'] = "required|unique:entities,slug,{$page->id},id,parent_id,NULL,deleted_at,NULL";

        $messages = [];

        list($niceNames, $rules, $messages) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules, $messages);

        $this->validate($this->request, $rules, $messages, $niceNames);

        $group_order = ($page->group_order instanceof stdClass) ? $page->group_order : new stdClass();
        $group_order->{$localeId} = $request->input('group_order', $page->getGroupOrderString($localeId));
        $request->merge(['group_order' => $group_order]);

        $entity = $entityRepository->update(Input::only(['name', 'slug', 'group_order']), $pageId);

        $revision = $revisionsRepository->create([
            'entity_localisation_id' => $localisation->id,
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $this->request->user()->id
        ]);

        $revisionsRepository->archiveRevisions($localisation->id, $revision->id);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository, $currentLocale);


        $localisations = $entity->localisations;

        foreach ($localisations as $localisation)
        {
            $solr->indexEntity($entity, $localisation);

            EntityCache::cache($entity, $localisation);
        }

        return Redirect::route('cms:blocks:edit_locale', ['page' => $entity->id, 'locale'=>$localisation->getLocaleId()])
            ->with('message', Lang::get('argon-entities::page.updated'));
    }

    public function editLocale(
        $pageId,
        $localeId,
        EntityRepository $entityRepository,
        EntityGroupRepository $groupRepository,
        MediaFolderRepository $folderRepository
    ) {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);

        $currentLocale = Locale::find($localeId);

        $localisation = $page->getLocalisation($currentLocale);

        $latestRevision = $localisation->latestRevision();

        $groups = $groupRepository->getUsedGroupsByEntityType($page->entity_type_id, ['order']);

        $currentLocales = $page->getLocalisations()->getLocales();

        $locales = Locale::all()->filter(function ($locale) use ($currentLocales) {
            return !$currentLocales->contains($locale);
        });

        return view(
            'argon::blocks.edit',
            [
                'page' => $page,
                'localisation' => $localisation,
                'latest' => $latestRevision,
                'root' => $folderRepository->root(),
                'groups' => $groups,
                'locales' => $locales,
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

            $locale = Locale::find($localeId);
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
        }

        $solr->indexEntity($page, $localisation);

        EntityCache::cache($page, $localisation);

        return Redirect::route('cms:blocks:edit_locale', ['page' => $pageId, 'locale' => $localeId]);
    }
}
