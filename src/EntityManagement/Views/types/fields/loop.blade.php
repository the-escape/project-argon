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
                <input id="{{$name}}" type="number" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}">
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>

        @elseif ($property->type == 'text')

            <div class="form-group {{$classes}}">
                <label for="{{$name}}">{{$property->label}}</label>
                <input id="{{$name}}" type="text" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}">
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>

        @endif

    @endforeach

@endif
