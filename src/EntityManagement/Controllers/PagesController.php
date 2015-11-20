<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityType;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Http\Request;
use Input;use Redirect;
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
        $types = $typeRepository->custom();

        $locales = $localeRepository->all();

        $entities = $entityRepository->forLocale($request->session()->get('locale'));

        $entities = $entities->keyBy('id');

        foreach ($entities as $id => $entity) {
            if ($entity->parent) {
                $entities[$entity->parent]->addChild($entity);
            }
        }

        $entities = $entities->filter(function ($entity) {
            return $entity->parent == null;
        });

        return View::make('argon::pages.manage', ['types' => $types, 'entities' => $entities, 'locales' => $locales]);
    }

    public function create($parentId, $typeId, EntityTypeRepository $typeRepository, EntityGroupRepository $groupRepository)
    {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->getUsedGroupsByEntityType($typeId, ['order']);
        return View::make('argon::pages.create', ['type' => $type, 'parentId' => $parentId, 'groups' => $groups]);
    }

    public function save(
        $parentId,
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionRepository,
        FieldDataRepository $fieldDataRepository,
        Request $request
    ) {

        $type = $typeRepository->find($typeId);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        // use submitted slug or auto-generate from name
        $slug = str_slug( ($input_slug = Input::get('slug')) ? $input_slug : Input::get('name') );

        // update input slug value to reflect str_slug, then validate it
        Input::merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
            'slug' => "required|unique:entities,slug,NULL,id,parent,{$parentId}",
        ];

        foreach ($fields as $field)
        {
            $niceNames["fields.{$field->id}"] = $field->name;

            $settings = $field->settings;

            if ($settings->required)
            {
                $rules["fields.{$field->id}"][] = 'required';
            }

            if ($settings->minlength)
            {
                $rules["fields.{$field->id}"][] = "min:{$settings->minlength}";
            }

            if ($settings->maxlength)
            {
                $rules["fields.{$field->id}"][] = "max:{$settings->maxlength}";
            }

            if (@$rules["fields.{$field->id}"])
            {
                $rules["fields.{$field->id}"] = implode('|', $rules["fields.{$field->id}"]);
            }
        }

        $this->validate($this->request, $rules, [], $niceNames);

        $entity = $entityRepository->create([
            'name' => Input::get('name'),
            'entity_type_id' => $type->id,
            'owner_id' => $request->user()->id,
            'parent' => $parentId,
            'locale' => $request->session()->get('locale'),
            'slug' => $slug,
        ]);

        $revision = $revisionRepository->create([
            'entity_id' => $entity->id,
            'status' => RevisionStatus::DRAFT,
            'created_by' => $request->user()->id
        ]);

        foreach ($fields as $field) {
            $fieldDataRepository->create([
                'field_id' => $field->id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => Input::get("fields.{$field->id}"),
            ]);
        }

        return Redirect::route('cms:pages:edit', ['page' => $entity->id])
            ->with('message', Lang::get('argon-entities::page.created'));
    }

    public function edit($pageId, EntityRepository $entityRepository, EntityGroupRepository $groupRepository)
    {
        $page = $entityRepository->find($pageId);

        $groups = $groupRepository->getUsedGroupsByEntityType($page->entity_type_id, ['order']);

        return View::make('argon::pages.edit', ['page' => $page, 'groups' => $groups]);
    }

    public function update(
        $pageId,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionsRepository,
        FieldDataRepository $fieldDataRepository,
        EntityTypeRepository $typeRepository
    ) {
        $page = $entityRepository->find($pageId);

        $type = $typeRepository->find($page->entity_type_id);

        $fields = $type->fields;

        $niceNames = [
            'name' => 'Name',
            'slug' => 'URL Slug'
        ];

        $slug = str_slug( Input::get('slug') );

        // update input slug value to reflect str_slug, then validate it
        Input::merge(array('slug' => $slug));

        $rules = [
            'name' => "required",
            'slug' => "required|unique:entities,slug,{$page->id},id,parent,{$page->parent}",
        ];

        foreach ($fields as $field)
        {
            $niceNames["fields.{$field->id}"] = $field->name;

            $settings = $field->settings;

            if ($settings->required)
            {
                $rules["fields.{$field->id}"][] = 'required';
            }

            if ($settings->minlength)
            {
                $rules["fields.{$field->id}"][] = "min:{$settings->minlength}";
            }

            if ($settings->maxlength)
            {
                $rules["fields.{$field->id}"][] = "max:{$settings->maxlength}";
            }

            if (@$rules["fields.{$field->id}"])
            {
                $rules["fields.{$field->id}"] = implode('|', $rules["fields.{$field->id}"]);
            }
        }

        $this->validate($this->request, $rules, [], $niceNames);


        $entity = $entityRepository->update(Input::only(['name', 'slug']), $pageId);

        $revision = $revisionsRepository->create([
            'entity_id' => $entity->id,
            'status' => RevisionStatus::DRAFT,
            'created_by' => $this->request->user()->id
        ]);

        foreach ($fields as $field) {
            $fieldDataRepository->create([
                'field_id' => $field->id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => Input::get("fields.{$field->id}")
            ]);
        }

        return Redirect::route('cms:pages:edit', ['page' => $entity->id])
            ->with('message', Lang::get('argon-entities::page.updated'));
    }

}