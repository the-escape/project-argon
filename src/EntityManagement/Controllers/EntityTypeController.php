<?php

namespace Escape\Argon\EntityManagement\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\EntityManagement\Eloquent\EntityFieldRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityGroupRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\EntityTypeRepository;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\FieldTypes\ComboFieldType;
use Escape\Argon\EntityManagement\FieldTypes\ItemFieldType;
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
        $types = $typeRepository->getOrdered();

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

    public function update($typeId, EntityFieldRepository $fieldRepository)
    {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $this->typeRepository->update(Input::all(), $typeId);

        if ($order = Input::get('order')) {
            // get type fields for extra validation checks
            $fields = $type->fields->keyBy('id');

            if ($order = explode(',', $order)) {
                foreach ($order as $i => $fieldId) {
                    // make sure $fieldId is a valid field of this content type
                    // don't want to accidentally update unrelated fields...
                    if (!isset($fields[$fieldId])) {
                        return Redirect::route('cms:types:combos:edit', [$type->id])
                            ->with('errors', "Field ID: {$fieldId} doesn't belong to this content type.");
                    }

                    $fieldRepository->update(['order'=>$i], $fieldId);
                }
            }
        }

        return Redirect::route('cms:types:edit', [$type->id])
            ->with('message', Lang::get('argon-entities::type.updated'));
    }

    public function edit($typeId, ComboFieldType $comboFieldType)
    {
        $type = $this->typeRepository->find($typeId);
        return View::make('argon::types.edit', ['type' => $type, 'comboFieldType' => $comboFieldType]);
    }

    public function delete(
        $typeId,
        EntityFieldRepository $fieldRepository,
        EntityGroupRepository $groupRepository
    ) {
        // Delete content type.
        $type = $this->typeRepository->find($typeId);
        $this->typeRepository->delete($type->id);

        // Delete content type groups.
        $groups = $groupRepository->findByField('entity_type_id', $type->id);
        foreach ($groups as $group) {
            $groupRepository->delete($group->id);
        }

        // Delete content type fields.
        $fields = $fieldRepository->findByField('entity_type_id', $type->id);
        foreach ($fields as $field) {
            $fieldRepository->delete($field->id);
        }

        return Redirect::route('cms:types:manage')
            ->with('message', Lang::get('argon-entities::type.deleted'));
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
            'group' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,NULL,id,entity_type_id,{$typeId},parent_field_id,0",
        ]);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));

        $settings = $fieldType->getDefaultSettings();

        $groupId = 0;

        if ($groupName = Input::get('group')) {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group) {
                if ($group->id == $groupName) {
                    $found = $group;
                    break;
                }
            }

            if (!$found) {
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
            'parent_field_id' => 0,
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

        // make sure we edit top level fields only here
        // subfields should be handled within combo edit method
        if ($field->parent_field_id) {
            return Redirect::route('cms:types:edit', [$type->id])
                ->with('errors', "Field ID: {$fieldId} is a subfield.");
        }

        // get all custom content types form Item field to serve as options
        $customTypes = null;
        $field_type = $field->type;
        if ($field_type instanceof ItemFieldType) {
            $customTypes = $typeRepository->custom();
        }

        $fieldTypes = $fieldTypesManager->getFieldTypes();
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make(
            'argon::types.fields.edit',
            [
                'type' => $type,
                'field' => $field,
                'fieldTypes' => $fieldTypes,
                'fieldGroups' => $fieldGroups,
                'customTypes' => $customTypes,
            ]
        );
    }

    public function updateField(
        $typeId,
        $fieldId,
        EntityFieldRepository $fieldRepository,
        EntityTypeRepository $typeRepository,
        FieldTypesManager $fieldTypesManager,
        EntityGroupRepository $groupRepository,
        Request $request
    ) {

        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
            'group' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,{$fieldId},id,entity_type_id,{$typeId},parent_field_id,0",
        ]);

        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));

        $defaultSettings = $fieldType->getDefaultSettings();

        // if field type has changed, reset settings
        if ($field->field_type != $fieldType->getKey()) {
            $settings = $defaultSettings;
        } else {
            // otherwise update setting
            $settings = $field->settings;
            foreach ($defaultSettings as $k => $v) {
                $settings->{$k} = $request->input($k, $v);
            }
        }

        // update order on options
        if ($order = Input::get('options_order')) {
            if ($order = explode(',', $order)) {
                $fieldSettings = $field->settings;
                $settings->options = [];

                foreach ($order as $i => $optionId) {
                    // make sure $optionId is a valid option
                    if (!array_key_exists($optionId, $fieldSettings->options)) {
                        return Redirect::route('cms:types:fields:edit', [$type->id, $field->id])
                            ->with('errors', "Option ID: {$optionId} doesn't exist.");
                    }

                    $settings->options[$i] = $fieldSettings->options[$optionId];
                }
            }
        }

        $groupId = 0;

        if ($groupName = Input::get('group')) {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group) {
                if ($group->id == $groupName) {
                    $found = $group;
                    break;
                }
            }

            if (!$found) {
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
            'parent_field_id' => 0,
            'settings' => $settings,
        ]);

        $fieldRepository->update($attributes, $fieldId);

        // Don't redirect to cms:types:edit since if the field's type has changed
        // new properties will be displayed and likely to customise.
        return Redirect::route('cms:types:edit', [$typeId])
            ->with('message', Lang::get('argon-entities::field.updated'));
    }

    public function deleteField(
        $typeId,
        $fieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        $deleted = $fieldRepository->delete($field->id);

        return Redirect::route('cms:types:edit', [$type->id])
            ->with('message', Lang::get('argon-entities::field.deleted'));
    }

    public function groupsManage(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    ) {
        $type = $typeRepository->find($typeId);
        return View::make('argon::groups.manage', ['type' => $type]);
    }


    public function saveGroups(
        $typeId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository
    ) {
        $type = $typeRepository->find($typeId);

        if ($order = Input::get('order')) {
            // get type fields for extra validation checks
            $groups = $type->groups->keyBy('id');

            if ($order = explode(',', $order)) {
                foreach ($order as $i => $groupId) {
                    // make sure $fieldId is a valid field of this content type
                    // don't want to accidentally update unrelated fields...
                    if (!isset($groups[$groupId])) {
                        return Redirect::route('cms:types:groups', [$type->id])
                            ->with('errors', "Groupd ID: {$groupId} doesn't belong to this content type.");
                    }

                    $groupRepository->update(['order'=>$i], $groupId);
                }
            }
        }
        return Redirect::route('cms:types:groups', [$type->id])
            ->with('message', Lang::get('argon-entities::groups.updated'));
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
        ]);

        $groupName = Input::get('name');

        $group = $groupRepository->create([
            'name'=>$groupName,
            'order'=>0,
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
    ) {
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
    ) {
        $type = $typeRepository->find($typeId);
        $group = $groupRepository->find($groupId);

        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $group = $groupRepository->update(Input::all(), $group->id);

        return Redirect::route('cms:types:groups', [$type->id])
            ->with('message', Lang::get('argon-entities::group.updated'));
    }

    public function deleteGroup(
        $typeId,
        $groupId,
        EntityTypeRepository $typeRepository,
        EntityGroupRepository $groupRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $group = $groupRepository->find($groupId);

        $usedGroups = $groupRepository->getUsedGroupsByEntityType($type->id);

        $inUse = false;
        foreach ($usedGroups as $usedGroup) {
            if ($usedGroup->id == $group->id) {
                $inUse = true;
            }
        }
        if ($inUse) {
            $fields = $fieldRepository->findByField('entity_group_id', $group->id);

            $inUse = [];
            foreach ($fields as $field) {
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

    public function addCombo($typeId, FieldTypesManager $fieldTypesManager, EntityGroupRepository $groupRepository)
    {
        $type = $this->typeRepository->find($typeId);

        $fieldTypes = $fieldTypesManager->getFieldTypes();
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make('argon::types.combos.add', [
            'type' => $type,
            'fieldTypes' => $fieldTypes,
            'fieldGroups' => $fieldGroups,
        ]);
    }

    public function saveCombo(
        $typeId,
        EntityFieldRepository $fieldRepository,
        EntityGroupRepository $groupRepository,
        ComboFieldType $comboFieldType
    ) {
        $this->validate($this->request, [
            'name' => 'required',
            'group' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,NULL,id,entity_type_id,{$typeId}",
        ]);

        $settings = $comboFieldType->getDefaultSettings();

        $groupId = 0;

        if ($groupName = Input::get('group')) {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group) {
                if ($group->id == $groupName) {
                    $found = $group;
                    break;
                }
            }

            if (!$found) {
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
            'parent_field_id' => 0,
            'field_type' => $comboFieldType->getKey(),
            'settings' => $settings,
        ]);

        $field = $fieldRepository->create($attributes);

        return Redirect::route('cms:types:combos:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-entities::combo.created'));
    }

    public function editCombo(
        $typeId,
        $comboId,
        EntityFieldRepository $fieldRepository,
        EntityGroupRepository $groupRepository,
        EntityTypeRepository $typeRepository
    ) {
        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make(
            'argon::types.combos.edit',
            [
                'type' => $type,
                'combo' => $combo,
                'fieldGroups' => $fieldGroups,
            ]
        );
    }

    public function updateCombo(
        $typeId,
        $comboId,
        EntityFieldRepository $fieldRepository,
        EntityGroupRepository $groupRepository,
        ComboFieldType $comboFieldType,
        EntityTypeRepository $typeRepository
    ) {

        $this->validate($this->request, [
            'name' => 'required',
            'group' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,$comboId,id,entity_type_id,{$typeId}",
        ]);

        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);

       // update settings
        $settings = $combo->settings;
        foreach ($settings as $k => &$v) {
            $v = Input::get($k, $v);
        }

        $groupId = 0;

        if ($groupName = Input::get('group')) {
            $groups = $groupRepository->findByField('entity_type_id', $typeId);

            $found = false;

            foreach ($groups as $group) {
                if ($group->id == $groupName) {
                    $found = $group;
                    break;
                }
            }

            if (!$found) {
                $found = $groupRepository->create([
                    'name'=>$groupName,
                    'entity_type_id'=>$typeId,
                ]);
            }

            $groupId = $found->id;
        }

        if ($order = Input::get('subfields_order')) {
            // get subfields for extra validation checks
            $subfields = $combo->subfields->keyBy('id');

            if ($order = explode(',', $order)) {
                foreach ($order as $i => $subfieldId) {
                    // make sure $subfieldId is a valid subfield of this combo
                    // don't want to accidentally update unrelated fields...
                    if (!isset($subfields[$subfieldId])) {
                        return Redirect::route('cms:types:combos:edit', [$type->id, $combo->id])
                            ->with('errors', "Field ID: {$subfieldId} is not a subfield of this combo field.");
                    }

                    $fieldRepository->update(['order'=>$i], $subfieldId);
                }
            }
        }

        // reject order since not related to combo itself
        $attributes = array_merge_recursive(Input::all(), [
            'entity_type_id' => $type->id,
            'entity_group_id' => $groupId,
            'parent_field_id' => 0,
            'settings' => $settings,
        ]);

        $combo = $fieldRepository->update($attributes, $combo->id);

        // Don't redirect to cms:types:edit since if the field's type has changed
        // new properties will be displayed and likely to customise.
        return Redirect::route('cms:types:combos:edit', [$type->id, $combo->id])
            ->with('message', Lang::get('argon-entities::combo.updated'));
    }

    public function deleteCombo(
        $typeId,
        $comboId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);

        $fields = $type->fields->keyBy('id');

        // make sure combo belongs to type
        if (!isset($fields[$comboId])) {
            return Redirect::route('cms:types:edit', [$type->id])
                ->with('errors', "Combo ID: {$comboId} doesn't belong to this content type.");
        }

        $combo = $fieldRepository->find($comboId);
        $subfields = $combo->subfields;

        // delete combo
        $deleted = $fieldRepository->delete($combo->id);

        // delete all combo's subfields
        if ($deleted) {
            foreach ($subfields as $subfield) {
                $fieldRepository->delete($subfield->id);
            }
        }

        return Redirect::route('cms:types:edit', [$type->id])
            ->with('message', Lang::get('argon-entities::combos.deleted'));
    }


    // Combo sublieds
    public function addComboField(
        $typeId,
        $comboId,
        FieldTypesManager $fieldTypesManager,
        EntityGroupRepository $groupRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $this->typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $fieldTypes = $fieldTypesManager->getFieldTypes();
        $fieldGroups = $groupRepository->findByField('entity_type_id', $type->id);

        return View::make('argon::types.combos.subfields.add', [
            'type' => $type,
            'combo' => $combo,
            'fieldTypes' => $fieldTypes,
        ]);
    }


    public function saveComboField(
        $typeId,
        $comboId,
        EntityFieldRepository $fieldRepository,
        FieldTypesManager $fieldTypesManager
    ) {
        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,NULL,id,entity_type_id,{$typeId},parent_field_id,{$comboId}",
        ]);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));
        $combo = $fieldRepository->find($comboId);

        $settings = $fieldType->getDefaultSettings();

        $groupId = 0;

        $attributes = array_merge_recursive(Input::all(), [
            'entity_type_id' => $typeId,
            'entity_group_id' => $groupId,
            'parent_field_id' => $combo->id,
            'settings' => $settings,
        ]);

        $field = $fieldRepository->create($attributes);

        return Redirect::route('cms:types:combos:fields:edit', [$typeId, $combo->id, $field->id])
            ->with('message', Lang::get('argon-entities::field.created'));
    }

    public function editComboField(
        $typeId,
        $comboId,
        $fieldId,
        FieldTypesManager $fieldTypesManager,
        EntityFieldRepository $fieldRepository,
        EntityTypeRepository $typeRepository
    ) {
        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);
        $fieldTypes = $fieldTypesManager->getFieldTypes();

        // get all custom content types form Item field to serve as options
        $customTypes = null;
        $field_type = $field->type;
        if ($field_type instanceof ItemFieldType) {
            $customTypes = $typeRepository->custom();
        }

        return View::make(
            'argon::types.combos.subfields.edit',
            [
                'type' => $type,
                'combo' => $combo,
                'field' => $field,
                'fieldTypes' => $fieldTypes,
                'customTypes' => $customTypes,
            ]
        );
    }

    public function updateComboField(
        $typeId,
        $comboId,
        $fieldId,
        EntityFieldRepository $fieldRepository,
        EntityTypeRepository $typeRepository,
        FieldTypesManager $fieldTypesManager,
        EntityGroupRepository $groupRepository
    ) {
        $this->validate($this->request, [
            'name' => 'required',
            'field_type' => 'required',
            'field_slug' => "required|unique:entity_fields,field_slug,{$fieldId},id,entity_type_id,{$typeId},parent_field_id,{$comboId}",
        ]);

        $type = $typeRepository->find($typeId);

        $fieldType = $fieldTypesManager->getType(Input::get('field_type'));

        $combo = $fieldRepository->find($comboId);

        $defaultSettings = $fieldType->getDefaultSettings();

        $field = $fieldRepository->find($fieldId);

        // if field type has changed, reset settings
        if ($field->field_type != $fieldType->getKey()) {
            $settings = $defaultSettings;
        } else { // otherwise update setting
            $settings = $field->settings;
            foreach ($settings as $k => &$v) {
                $v = Input::get($k, $v);
            }
        }

        // update order on options
        if ($order = Input::get('options_order')) {
            if ($order = explode(',', $order)) {
                $fieldSettings = $field->settings;
                $settings->options = [];

                foreach ($order as $i => $optionId) {
                    // make sure $optionId is a valid option
                    if (!array_key_exists($optionId, $fieldSettings->options)) {
                        return Redirect::route('cms:types:fields:edit', [$type->id, $field->id])
                            ->with('errors', "Option ID: {$optionId} doesn't exist.");
                    }

                    $settings->options[$i] = $fieldSettings->options[$optionId];
                }
            }
        }

        $groupId = 0;

        $attributes = array_merge_recursive(Input::all(), [
            'entity_type_id' => $typeId,
            'entity_group_id' => $groupId,
            'parent_field_id' => $combo->id,
            'settings' => $settings,
        ]);

        $fieldRepository->update($attributes, $fieldId);

        // Don't redirect to cms:types:edit since if the field's type has changed
        // new properties will be displayed and likely to customise.
        return Redirect::route('cms:types:combos:edit', [$type->id, $combo->id])
            ->with('message', Lang::get('argon-entities::field.updated'));
    }

    public function deleteComboField(
        $typeId,
        $comboId,
        $subfieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);

        $fields = $type->fields->keyBy('id');

        // make sure combo belongs to type
        if (!isset($fields[$comboId])) {
            return Redirect::route('cms:types:edit', [$type->id])
                ->with('errors', "Combo ID: {$comboId} doesn't belong to this content type.");
        }

        $combo = $fieldRepository->find($comboId);
        $subfields = $combo->subfields->keyBy('id');

        // make sure subfield belong to combo
        if (!isset($subfields[$subfieldId])) {
            return Redirect::route('cms:types:combos:edit', [$type->id, $combo->id])
                ->with('errors', "Subfield ID: {$subfieldId} doesn't belong to this combo.");
        }

        $subfield = $fieldRepository->find($subfieldId);

        // delete subfield
        $deleted = $fieldRepository->delete($subfield->id);

        return Redirect::route('cms:types:combos:edit', [$type->id, $combo->id])
            ->with('message', Lang::get('argon-entities::field.deleted'));
    }

    public function createOption(
        $typeId,
        $fieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        return View::make('argon::options.create', [
            'type' => $type,
            'field' => $field,
        ]);
    }

    public function saveOption(
        $typeId,
        $fieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);


        $settings = $field->settings;
        $settings->options[] = Input::get('name');

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-entities::options.created'));

    }

    public function editOption(
        $typeId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;

        $option_name = @$settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:fields:edit', [$type->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        $option = new \stdClass();
        $option->id = $optionId;
        $option->name = $option_name;

        return View::make('argon::options.edit', [
            'type' => $type,
            'field' => $field,
            'option' => $option,
        ]);
    }

    public function updateOption(
        $typeId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {

        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;

        $option_name = @$settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:fields:edit', [$type->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        $option = new \stdClass();
        $option->id = $optionId;
        $option->name = Input::get('name');

        $settings->options[$option->id] = $option->name;

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:fields:options:edit', [$typeId, $field->id, $option->id])
            ->with('message', Lang::get('argon-entities::options.updated'));
    }

    public function deleteOption(
        $typeId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;

        $option_name = @$settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:fields:edit', [$type->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        unset($settings->options[$optionId]);

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:fields:edit', [$typeId, $field->id])
            ->with('message', Lang::get('argon-entities::options.deleted'));
    }

    public function createComboOption(
        $typeId,
        $comboId,
        $fieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);

        return View::make('argon::types.combos.suboptions.create', [
            'type' => $type,
            'combo' => $combo,
            'field' => $field,
        ]);
    }

    public function saveComboOption(
        $typeId,
        $comboId,
        $fieldId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;
        $settings->options[] = Input::get('name');

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:combos:fields:edit', [$typeId, $combo->id, $field->id])
            ->with('message', Lang::get('argon-entities::options.created'));
    }

    public function editComboOption(
        $typeId,
        $comboId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;
        $option_name = @$settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:combos:fields:edit', [$type->id, $combo->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        $option = new \stdClass();
        $option->id = $optionId;
        $option->name = $option_name;

        return View::make('argon::types.combos.suboptions.edit', [
            'type' => $type,
            'combo' => $combo,
            'field' => $field,
            'option' => $option,
        ]);
    }

    public function updateComboOption(
        $typeId,
        $comboId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {

        $this->validate($this->request, [
            'name' => 'required',
        ]);

        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;
        $option_name = @$settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:combos:fields:edit', [$type->id, $combo->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        $option = new \stdClass();
        $option->id = $optionId;
        $option->name = Input::get('name');

        $settings->options[$option->id] = $option->name;

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:combos:fields:options:edit', [$typeId, $combo->id, $field->id, $option->id])
            ->with('message', Lang::get('argon-entities::options.updated'));
    }

    public function deleteComboOption(
        $typeId,
        $comboId,
        $fieldId,
        $optionId,
        EntityTypeRepository $typeRepository,
        EntityFieldRepository $fieldRepository
    ) {
        $type = $typeRepository->find($typeId);
        $combo = $fieldRepository->find($comboId);
        $field = $fieldRepository->find($fieldId);

        $settings = $field->settings;
        $option_name = $settings->options[$optionId];

        if (!$option_name) {
            return Redirect::route('cms:types:combos:fields:edit', [$type->id, $combo->id, $field->id])
                ->with('errors', "Option ID: {$optionId} doesn't exist.");
        }

        unset($settings->options[$optionId]);

        $field = $fieldRepository->update(['settings' => $settings], $field->id);

        return Redirect::route('cms:types:combos:fields:edit', [$typeId, $combo->id, $field->id])
            ->with('message', Lang::get('argon-entities::options.deleted'));
    }


    public function cloneField($fieldId, EntityFieldRepository $fieldRepository, Request $request)
    {
        $field = $fieldRepository->find($fieldId)->type;
        $field->setIsCloning();
        $hash = $request->input('hash');
        return $field->render(null, ['hash' => $hash]);
    }
}
