<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityType;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;

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

    public function create($parentId, $typeName, EntityTypeRepository $typeRepository)
    {
        $type = $typeRepository->findByField('name', $typeName)->first();

        return View::make('argon::pages.create', ['type' => $type, 'parentId' => $parentId]);
    }

    public function save(
        $parentId,
        $typeName,
        EntityTypeRepository $typeRepository,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionRepository,
        FieldDataRepository $fieldDataRepository,
        Request $request
    ) {
        /** @var EntityType $type */
        $type = $typeRepository->getTypeByName($typeName);
        $entity = $entityRepository->create(
            [
                'name' => Input::get('name'),
                'entity_type_id' => $type->id,
                'owner_id' => $request->user()->id,
                'parent' => $parentId,
                'locale' => $request->session()->get('locale')
            ]
        );

        $revision = $revisionRepository->create(
            [
                'entity_id' => $entity->id,
                'status' => RevisionStatus::DRAFT,
                'created_by' => $request->user()->id
            ]
        );

        $fields = Input::get('fields');

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

        return Redirect::route('cms:pages:manage');
    }

    public function edit($pageId, EntityRepository $entityRepository, EntityTypeRepository $typeRepository)
    {
        $page = $entityRepository->find($pageId);
        $type = $typeRepository->find($page->entity_type_id);

        return View::make('argon::pages.edit', ['page' => $page, 'type' => $type]);
    }

    public function update(
        $pageId,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionsRepository,
        FieldDataRepository $fieldDataRepository
    ) {
        $entity = $entityRepository->update(Input::only('name'), $pageId);

        $revision = $revisionsRepository->create([
            'entity_id' => $entity->id,
            'status' => RevisionStatus::DRAFT,
            'created_by' => $this->request->user()->id
        ]);

        $fields = Input::get('fields');

        foreach ($fields as $id => $value) {
            $fieldDataRepository->create([
                'field_id' => $id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => $value
            ]);
        }


        return Redirect::route('cms:pages:manage');
    }
}
