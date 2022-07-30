@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Combo</h1>

        @include('argon::inc.alerts', compact('errors'))

        <form action="{{ route('cms:types:combos:update', [$type->id, $combo->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">

                <div class="card-header">Details</div>

                <div class="card-block">

                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required  {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $combo->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="field_slug" class="required">Slug</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_slug') }}" id="field_slug" name="field_slug" placeholder="Slug" value="{{ old('field_slug', $combo->field_slug) }}">
                    </div>

                    <div class="form-group">
                        <label for="group" class="required">Field Group</label>
                        <select class="form-control groupCreate required  {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'group') }}" name="group" id="group">
                            <option value="">Choose one...</option>

                            <?php
                            $submittedGroup = old('group', $combo->entity_group_id);
                            $selected = 0;
                            ?>
                            @foreach ($fieldGroups as $fieldGroup)
                                @if($fieldGroup->id == $submittedGroup)
                                    <?php $selected = 1;?>
                                    <option value="{{$fieldGroup->id}}" selected>{{$fieldGroup->name}}</option>
                                @else
                                    <option value="{{$fieldGroup->id}}">{{$fieldGroup->name}}</option>
                                @endif
                            @endforeach

                            @if($submittedGroup && !$selected)
                                <option value="{{$submittedGroup}}" selected="selected">{{$submittedGroup}}</option>
                            @endif

                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>

                    @include('argon::types.fields.loop', ['field'=>$combo, 'items'=>$combo->type->getProperties()])

                </div>

            </div>


            <div class="card">
                <div class="card-header">Subfields</div>
                <div class="card-block">

                    @if(($subfields = $combo->subfields) && (!$subfields->isEmpty()))

                        <input id="order-{{$combo->id}}" type="hidden" name="subfields_order">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-sortable_field="order-{{$combo->id}}">
                                @foreach($subfields as $field)
                                    <tr class="sortable-item" data-sortable_item="{{$field->id}}">
                                        <td>
                                            <span class="sortable-handle btn">&#8645;</span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" data-placement="left" title="Field ID: {{ $field->id }}">{{ $field->name }}</span>
                                        </td>
                                        <td>
                                            {{ $field->field_slug }}
                                        </td>
                                        <td>
                                            {{ $field->field_type }}
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:combos:fields:edit', [$type->id, $combo->id, $field->id]) }}">Edit</a>
                                            <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:combos:fields:delete', [$type->id, $combo->id, $field->id]) }}">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif

                    <a href="{{ route('cms:types:combos:fields:add', [$type->id, $combo->id]) }}" class="btn btn-primary-outline">Add Subfield</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>

    </div>
@endsection
