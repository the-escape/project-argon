<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRevisionRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityType;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;

class ContentController extends BaseController
{
    public function manage(EntityTypeRepository $typeRepository)
    {
        $types = $typeRepository->all();
        return View::make('argon::content.manage', ['types' => $types]);
    }

    public function create($typeName, EntityTypeRepository $typeRepository)
    {
        $type = $typeRepository->findByField('name', $typeName)->first();
        return View::make('argon::content.create', ['type' => $type]);
    }

    public function save(
        $typeName,
        EntityTypeRepository $typeRepository,
        EntityRepository $entityRepository,
        EntityRevisionRepository $revisionRepository,
        FieldDataRepository $fieldDataRepository,
        Request $request
    ) {
        /** @var EntityType $type */
        $type = $typeRepository->findByField('name', $typeName)->first();
        $entity = $entityRepository->create(
            [
                'name' => Input::get('name'),
                'entity_type_id' => $type->id,
                'owner_id' => $request->user()->id
            ]
        );

        $revision = $revisionRepository->create(
            [
                'entity_id' => $entity->id,
                'status' => 0,
                'created_by' => $request->user()->id
            ]
        );

        foreach ($type->fields as $field) {
            $fieldDataRepository->create(
                [
                    'field_id' => $field->id,
                    'entity_revision_id' => $revision->id,
                    'language' => 'en', // TODO: Make language dynamic
                    'value' => Input::get($field->name)
                ]
            );
        }

        return Redirect::route('cms:content:manage');
    }
}
