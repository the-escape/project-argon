@if(isset($items))

    @foreach ($items as $name => $property)

        <?php
        $property = is_array($property) ? (object)$property : $property;
        $parent = false;
        $child= false;
        $classes = ['field-type-settings'];

        if (isset($children))
        {
            $child = true;
            $classes[] = 'child';
        }

        if (isset($property->children))
        {
            $parent= true;
            $classes[] = 'parent';
        }
        $classes = implode(' ', $classes);
        ?>

        @if ($property->type == 'boolean')

            <div class="checkbox {{$classes}}">
                <label>
                    <input type="hidden" value="0" name="{{$name}}">
                    @if($parent)
                        <input type="checkbox" value="1" name="{{$name}}" class="parent" @if (@$field->settings->$name) checked @endif>
                    @else
                        <input type="checkbox" value="1" name="{{$name}}" class="child" @if (@$field->settings->$name) checked @endif>
                    @endif
                    {{ $property->label }}
                </label>
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>

        @elseif ($property->type == 'integer')

            <div class="form-group {{$classes}}">
                <label for="{{$name}}">{{$property->label}}</label>
                <input id="{{$name}}" type="number" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}" placeholder="{{$property->default}}">
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>

        @elseif ($property->type == 'text')

            <div class="form-group {{$classes}}">
                <label for="{{$name}}">{{$property->label}}</label>
                <input id="{{$name}}" type="text" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}" placeholder="{{$property->default}}">
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>

        @elseif ($property->type == 'options')

            @if(is_array(@$field->settings->$name))

                <input id="order-{{$field->id}}" type="hidden" name="options_order">

                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="sortable" data-sortable_field="order-{{$field->id}}">
                    @foreach($field->settings->$name as $opt_id => $opt_value)
                        <tr class="sortable-item" data-sortable_item="{{ $opt_id }}">
                            <td>
                                <span class="sortable-handle btn">&#8645;</span>
                            </td>
                            <td>
                                <span data-toggle="tooltip" data-placement="left" title="Option ID: {{ $opt_id }}">{{ $opt_value }}</span>
                            </td>
                            <td>
                                @if($field->parent_field_id)
                                    <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:combos:fields:options:edit', [$type->id, $field->parent_field_id, $field->id, $opt_id]) }}">Edit</a>
                                    <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:combos:fields:options:delete', [$type->id, $field->parent_field_id, $field->id, $opt_id]) }}">Remove</a>
                                @else
                                    <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:fields:options:edit', [$type->id, $field->id, $opt_id]) }}">Edit</a>
                                    <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:fields:options:delete', [$type->id, $field->id, $opt_id]) }}">Remove</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @endif

            @if($field->parent_field_id)
                <a href="{{ route('cms:types:combos:fields:options:create',[$type->id, $field->parent_field_id, $field->id]) }}" class="btn btn-primary-outline">Add Option</a>
            @else
                <a href="{{ route('cms:types:fields:options:create',[$type->id, $field->id]) }}" class="btn btn-primary-outline">Add Option</a>
            @endif




        @endif

    @endforeach

@endif
