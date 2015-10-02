<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityFieldRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
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
            ->with('message', Lang::get('argon-entities::type.created'));
    }

    public function update($typeId)
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $this->typeRepository->update(Input::all(), $typeId);

        return Redirect::route('cms:types:edit', [$type->id])
            ->with('message', Lang::get('argon-entities::type.updated'));
    }

    public function edit($typeId)
    {
        $type = $this->typeRepository->find($typeId);

        return View::make('argon::types.edit', ['type' => $type]);
    }

    public function addField($typeId, FieldTypesManager $fieldTypesManager, EntityGroupRepository $groupRepository)
    {
        $type = $this->typeRepository->find($typeId);

        $fieldTypes = $fieldTypesManager->getFieldTypes();
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make('argon::types.fields.add', [
            'type' => $type,
            'fieldTypes' => $fieldTypes,
            'fieldGroups' => $fieldGroups,
        ]);
    }

    public function saveField(
        $typeId,
        EntityFieldRepository $fieldRepository,
        FieldTypesManager $fieldTypesManager,
        EntityGroupRepository $groupRepository
    ) {
        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
        ]);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));

        $settings = $fieldType->getDefaultSettings();

        $groupId = 0;

        if ($groupName = Input::get('group'))
        {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group)
            {
                if ($group->id == $groupName)
                {
                    $found = $group;
                    break;
                }
            }

            if (!$found)
            {
                $found = $groupRepository->create([
                    'name'=>$groupName,
                    'entity_type_id'=>$typeId,
                ]);
            }

            $groupId = $found->id;
        }

        $attributes = array_merge_recursive(Input::all(), [
            'entity_type_id' => $typeId,
            'entity_group_id' => $groupId,
            'settings' => $settings,
        ]);

        $field = $fieldRepository->create($attributes);

        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-entities::field.created'));
    }

    public function editField(
        $typeId,
        $fieldId,
        FieldTypesManager $fieldTypesManager,
        EntityFieldRepository $fieldRepository,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);
        $fieldTypes = $fieldTypesManager->getFieldTypes();
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make(
            'argon::types.fields.edit',
            [
                'type' => $type,
                'field' => $field,
                'fieldTypes' => $fieldTypes,
                'fieldGroups' => $fieldGroups,
            ]
        );
    }

    public function updateField(
        $typeId,
        $fieldId,
        EntityFieldRepository $fieldRepository,
        FieldTypesManager $fieldTypesManager,
        EntityGroupRepository $groupRepository
    ) {

        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
        ]);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));

        $defaultSettings = $fieldType->getDefaultSettings();

        $oldField = $fieldRepository->find($fieldId);

        // if field type has changed use default settings
        $settings = ($oldField->field_type != $fieldType->getKey())
            ? $defaultSettings
            : array_intersect_key(Input::all(), (array) $defaultSettings);


        $groupId = 0;

        if ($groupName = Input::get('group'))
        {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group)
            {
                if ($group->id == $groupName)
                {
                    $found = $group;
                    break;
                }
            }

            if (!$found)
            {
                $found = $groupRepository->create([
                    'name'=>$groupName,
                    'entity_type_id'=>$typeId,
                ]);
            }

            $groupId = $found->id;
        }

        $attributes = array_merge_recursive(Input::all(), [
            'entity_type_id' => $typeId,
            'entity_group_id' => $groupId,
            'settings' => $settings,
        ]);

        $field = $fieldRepository->update($attributes, $fieldId);

        // Don't redirect to cms:types:edit since if the field's type has changed
        // new properties will be displayed and likely to customise.
        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-entities::field.updated'));
    }

    public function groupsManage(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    )
    {
        $type = $typeRepository->find($typeId);
        $groups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make('argon::groups.manage',['type' => $type, 'groups' => $groups]);
    }

    public function createGroup($typeId, EntityTypeRepository $typeRepository)
    {
        $type = $typeRepository->find($typeId);

        return View::make('argon::groups.create', ['type' => $type]);
    }

    public function saveGroup($typeId, EntityGroupRepository $groupRepository)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'order' => 'numeric',
        ]);

        $groupName = Input::get('name');
        $groupOrder = Input::get('order', 0);

        $group = $groupRepository->create([
            'name'=>$groupName,
            'order'=>$groupOrder,
            'entity_type_id'=>$typeId,
        ]);

        return Redirect::route('cms:types:groups', [$typeId])
            ->with('message', Lang::get('argon-entities::group.created'));
    }

    public function editGroup(
        $typeId,
        $groupId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    )
    {
        $type = $typeRepository->find($typeId);
        $group = $groupRepository->find($groupId);

        return View::make('argon::groups.edit', ['type' => $type, 'group' => $group,]);
    }

    public function updateGroup(
        $typeId,
        $groupId,
        FieldTypesManager $fieldTypesManager,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    )
    {
        $type = $typeRepository->find($typeId);
        $group = $groupRepository->find($groupId);

        $this->validate($this->request, [
            'name' => 'required',
            'order' => 'numeric',
        ]);

        $group = $groupRepository->update(Input::all(), $group->id);

        return Redirect::route('cms:types:groups', [$type->id])
            ->with('message', Lang::get('argon-entities::group.updated'));
    }

    public function deleteGroup(
        $typeId,
        $groupId,
        FieldTypesManager $fieldTypesManager,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        EntityFieldRepository $fieldRepository
    )
    {
        $type = $typeRepository->find($typeId);
        $group = $groupRepository->find($groupId);

        $usedGroups = $groupRepository->getUsedGroupsByEntityType($type->id);

        $inUse = false;
        foreach ($usedGroups as $usedGroup)
        {
            if ($usedGroup->id == $group->id)
            {
                $inUse = true;
            }
        }
        if ($inUse)
        {
            $fields = $fieldRepository->findByField('entity_group_id', $group->id);

            $inUse = [];
            foreach ($fields as $field)
            {
                $inUse[] = 'ID:'.$field->id;
            }

            $inUse = implode(', ', $inUse);

            return Redirect::route('cms:types:groups', [$type->id])
                ->with('errors', "Couldn't remove. Group assigned to some of the fields ({$inUse}).");
        }

        $deleted = $groupRepository->delete($group->id);

        return Redirect::route('cms:types:groups', [$type->id])
            ->with('message', Lang::get('argon-entities::group.deleted'));
    }

}
