<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityType;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroup;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
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
        /** @var $slug
         * Slug validation based on slug and parent lookup
         * If entered, will be validated.
         * If left empty, will be generated from name and validated.
         */

        $this->validate($this->request, [
            'name' => "required",
            'slug' => "min:1", // not required, will attempt to auto generated from name
        ]);

        // use submitted slug or auto-generate from name
        $slug = str_slug( ($input_slug = Input::get('slug')) ? $input_slug : Input::get('name') );

        $slugTaken = $entityRepository->findWhere(['slug'=>$slug, 'parent'=>$parentId]);

        if (!$slugTaken->isEmpty())
        {
            // update input value that goes back in the form to reflect str_slug
            Input::merge(array('slug' => $slug));

            $return =  Redirect::route('cms:content:create', [$parentId, $typeId])->withInput();

            if (!$input_slug)
            {
                $return->with('errors', "The auto-generated slug '{$slug}' has already been taken. Please try a different one.");
            }
            else
            {
                $return->with('errors', "The slug '{$slug}' has already been taken. Please try a different one.");
            }

            return $return;

        }

        /** @var EntityType $type */
        $type = $typeRepository->find($typeId);
        $entity = $entityRepository->create(
            [
                'name' => Input::get('name'),
                'entity_type_id' => $type->id,
                'owner_id' => $request->user()->id,
                'parent' => $parentId,
                'locale' => $request->session()->get('locale'),
                'slug' => $slug,
            ]
        );

        $revision = $revisionRepository->create(
            [
                'entity_id' => $entity->id,
                'status' => RevisionStatus::DRAFT,
                'created_by' => $request->user()->id
            ]
        );

        $fields = Input::get('fields', []);

        foreach ($type->fields as $field) {
            $fieldDataRepository->create(
                [
                    'field_id' => $field->id,
                    'entity_revision_id' => $revision->id,
                    'language' => 'en', // TODO: Make language dynamic
                    'value' => $fields[$field->id]
                ]
            );
        }

        // return Redirect::route('cms:pages:manage');
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
        FieldDataRepository $fieldDataRepository
    ) {
        $page = $entityRepository->find($pageId);

        $this->validate($this->request, [
            'name' => "required",
            'slug' => "required|min:1",
        ]);

        $slug = str_slug( Input::get('slug') );

        $slugTaken = $entityRepository->findWhere(['slug'=>$slug, 'parent'=>$page->parent, ['id', '!=', $page->id]]);

        if (!$slugTaken->isEmpty())
        {
            // update input value that goes back in the form to reflect str_slug
            Input::merge(array('slug' => $slug));

            return Redirect::route('cms:pages:edit', [$pageId])
                ->withInput()
                ->with('errors', "The slug '{$slug}' has already been taken. Please try a different one.");
        }

        $entity = $entityRepository->update(Input::only(['name', 'slug']), $pageId);

        $revision = $revisionsRepository->create([
            'entity_id' => $entity->id,
            'status' => RevisionStatus::DRAFT,
            'created_by' => $this->request->user()->id
        ]);

        $fields = Input::get('fields', []);

        foreach ($fields as $id => $value) {
            $fieldDataRepository->create([
                'field_id' => $id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => $value
            ]);
        }

        // return Redirect::route('cms:pages:manage');
        return Redirect::route('cms:pages:edit', ['page' => $entity->id])
            ->with('message', Lang::get('argon-entities::page.updated'));
    }

}
