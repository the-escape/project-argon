<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityFieldRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Illuminate\Http\Request;
use Input;
use Lang;
use Redirect;
use View;

class EntityTypeController extends BaseController
{
    protected $typeRepository;

    public function __construct(Request $request, EntityTypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;

        parent::__construct($request);
    }

    public function manage(EntityTypeRepository $typeRepository)
    {
        $types = $typeRepository->all();

        return View::make('argon::types.manage', ['types' => $types]);
    }

    public function create()
    {
        return View::make('argon::types.create');
    }

    public function save()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $this->typeRepository->create(Input::all());

        return Redirect::route('cms:types:edit', [$type->id])
            ->with('message', Lang::get('argon-content::type.created'));
    }

    public function edit($typeId)
    {
        $type = $this->typeRepository->find($typeId);

        return View::make('argon::types.edit', ['type' => $type]);
    }

    public function addField($typeId, FieldTypesManager $fieldTypesManager)
    {
        $type = $this->typeRepository->find($typeId);

        $fieldTypes = $fieldTypesManager->getFieldTypes();

        return View::make('argon::types.fields.add', ['type' => $type, 'fieldTypes' => $fieldTypes]);
    }

    public function saveField($typeId, EntityFieldRepository $fieldRepository, FieldTypesManager $fieldTypesManager)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
        ]);

        $fieldType = $fieldTypesManager->get(Input::get('field_type'));

        $field = $fieldRepository->create(
            array_merge(
                Input::all(),
                [
                    'entity_type_id' => $typeId,
                    'settings' => $fieldType->getDefaultSettings()
                ]
            )
        );

        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-content::field.created'));
    }

    public function editField(
        $typeId,
        $fieldId,
        FieldTypesManager $fieldTypesManager,
        EntityFieldRepository $fieldRepository,
        EntityTypeRepository $typeRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);
        $fieldTypes = $fieldTypesManager->getFieldTypes();

        return View::make(
            'argon::types.fields.edit',
            [
                'type' => $type,
                'field' => $field,
                'fieldTypes' => $fieldTypes,
            ]
        );
    }

    public function updateField(
        $typeId,
        $fieldId,
        EntityFieldRepository $fieldRepository,
        FieldTypesManager $fieldTypesManager
    ) {
        $fieldType = $fieldTypesManager->get(Input::get('field_type'));

        $properties = (array) $fieldType->getDefaultSettings();

        $oldField = $fieldRepository->find($fieldId);

        // if field type has changed use default settings
        $settings = ($oldField->field_type != $fieldType->getKey())
            ? $fieldType->getDefaultSettings()
            : array_intersect_key(Input::all(), $properties);

        $attributes = array_merge(Input::all(), ['entity_type_id' => $typeId, 'settings' => $settings]);

        $field = $fieldRepository->update($attributes, $fieldId);

        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-content::field.created'));
    }



}
