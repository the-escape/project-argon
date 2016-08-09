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
use Escape\Argon\Helpers\Solr;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;
use Lang;

class PagesController extends BaseController
{
    public function manage(
        EntityTypeRepository $typeRepository,
        LocaleRepository $localeRepository,
        EntityRepository $entityRepository,
        Request $request
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

        return View::make('argon::pages.manage', ['types' => $types, 'entities' => $entities, 'locales' => $locales]);
    }

    public function delete($pageId, EntityRepository $entityRepository)
    {
        $entityRepository->delete($pageId);

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
        return View::make(
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
        Request $request
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
            'slug' => "required|unique:entities,slug,NULL,id,parent_id,{$parentId}",
        ];

        list($niceNames, $rules) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules);

        $this->validate($request, $rules, [], $niceNames);

        $entity = $entityRepository->create([
            'name' => $request->input('name'),
            'entity_type_id' => $type->id,
            'owner_id' => $request->user()->id,
            'parent_id' => $parentId,
            'locale' => $request->session()->get('locale'),
            'slug' => $slug,
        ]);

        $localisation = $localisationRepository->create([
            'entity_id' => $entity->getId(),
            'locale_id' => 1 // TODO: Wire up properly.
        ]);

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $request->user()->id
        ]);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository);

        $redirect_url = new \stdClass();
        $redirect_url->{$localisation->getLocaleId()} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $entity = $entityRepository->update(Input::only(['redirect_url']), $entity->id);

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

        $slug = str_slug($request->input('slug'));

        // update input slug value to reflect str_slug, then validate it
        $request->merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
        ];

        if ($page->parent_id != null) {
            $rules['slug'] = "required|unique:entities,slug,{$page->id},id,parent_id,{$page->parent_id}";
        } else {
            $request->merge(['slug' => '/']);
        }

        $messages = [];

        list($niceNames, $rules, $messages) = FieldsHelpers::validationFieldsSetup($request, $fields, $niceNames, $rules, $messages);

        $this->validate($this->request, $rules, $messages, $niceNames);

        $redirect_url = ($page->redirect_url instanceof \stdClass) ? $page->redirect_url : new \stdClass();
        $redirect_url->{$localeId} = $request->input('redirect_url');
        $request->merge(['redirect_url' => $redirect_url]);

        $entity = $entityRepository->update(Input::only(['name', 'slug', 'status', 'redirect_url']), $pageId);

        $revision = $revisionsRepository->create([
            'entity_localisation_id' => $localisation->id,
            'status' => RevisionStatus::PUBLISHED,
            'created_by' => $this->request->user()->id
        ]);

        $revisionsRepository->archiveRevisions($localisation->id, $revision->id);

        FieldsHelpers::saveFields($request, $fields, $revision, $fieldDataRepository);

        $r = $solr->indexEntity($entity, $localisation);

        return Redirect::route('cms:pages:edit_locale', ['page' => $entity->id, 'locale'=>$localisation->getLocaleId()])
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

        return View::make(
            'argon::pages.edit',
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
        EntityRevisionRepository $revisionRepository
    ) {
        $localeId = (int)$request->input('locale');

        $localisation = $localisationRepository->create([
            'locale_id' => $localeId,
            'entity_id' => $pageId
        ]);

        $revision = $revisionRepository->create([
            'entity_localisation_id' => $localisation->getId(),
            'status' => RevisionStatus::DRAFT,
            'created_by' => $request->user()->id
        ]);

        return Redirect::route('cms:pages:edit_locale', ['page' => $pageId, 'locale' => $localeId]);
    }


    // Handles JSTree ajax reorder requests
    public function updateParent($pageId, $parentId, EntityRepository $entityRepository)
    {
        /** @var Entity $page */
        $page = $entityRepository->find($pageId);
        $parent = $entityRepository->find($parentId);

        $page->parent_id = $parent->id;
        $result = $page->save();

        return json_encode(['success' => $result]);
    }

    public function revisions($pageId, EntityRevisionRepository $entityRevisionRepository)
    {
        $revisions = $entityRevisionRepository->all();

        return view('argon::pages.revisions')->with(compact('revisions'));
    }

}
