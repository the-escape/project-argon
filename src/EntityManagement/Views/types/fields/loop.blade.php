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
            $classes[] = 'child o-form__group--indent';
        }

        if (isset($property->children))
        {
            $parent= true;
            $classes[] = 'parent';
        }
        $classes = implode(' ', $classes);
        ?>

        @if ($property->type == 'boolean')

            <?php
            $checked = $property->default;

            if (property_exists($field->settings, $name))
            {
                if (in_array($field->settings->$name, [1, '1', true, 'true'], true))
                {
                    $checked = true;
                } else {

                    $checked = false;
                }
            }
            ?>

            <div class="o-form__group {{$classes}}">
                <div class="o-form-status">
                    <div class="o-form__list">
                        <div class="o-checkbox">
                            <input type="hidden" name="{{$name}}" class="js-toggle-value" value="{{ $checked ? '1' : '0' }}">
                            @if($parent)
                                <label><input type="checkbox" value="1" id="{{$name}}" class="parent js-toggle-input" {{ $checked ? 'checked' : '' }}><span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span></label>
                            @else
                                <label><input type="checkbox" value="1" id="{{$name}}" class="child js-toggle-input" {{ $checked ? 'checked' : '' }}><span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span></label>
                            @endif
                            <label for="{{$name}}">{{ $property->label }}</label>
                        </div>
                    </div>
                </div>
                @if (!empty($property->help))
                    <div class="o-form__help-text l-full">
                        <p>{{$property->help}}</p>
                    </div>
                @endif
            </div>

            @if($parent)
                @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
            @endif

            <?php /*
                    <div class="checkbox {{$classes}}">
                        <label>
                            <input type="hidden" value="0" name="{{$name}}">
                            @if($parent)
                                <input type="checkbox" value="1" name="{{$name}}" class="parent" @if ($checked) checked @endif>
                            @else
                                <input type="checkbox" value="1" name="{{$name}}" class="child" @if ($checked) checked @endif>
                            @endif
                            {{ $property->label }}
                        </label>
                        @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                        @if($parent)
                            @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                        @endif
                    </div>
        */ ?>

        @elseif ($property->type == 'integer')

            <div class="o-form__group {{$classes}}">
                <div class="o-form-status">
                    <div class="o-form-status__input">
                        <label for="{{$name}}">{{$property->label}}</label>
                        <input type="number" id="{{$name}}" name="{{$name}}" placeholder="{{$property->default}}" value="{{ old($name, @$field->settings->$name) }}">
                    </div>
                    <div class="o-form-status__message">
                        <div class="o-form-status__icon">
                            <div class="o-form-status__icon--error">
                                <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                            </div>
                            <div class="o-form-status__icon--success">
                                <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                            </div>
                        </div>
                        <div class="o-form-status__message-bar">
                            <label for="{{$name}}">Error Message</label>
                        </div>
                    </div>
                </div>
                @if (!empty($property->help))
                    <div class="o-form__help-text l-full">
                        <p>{{$property->help}}</p>
                    </div>
                @endif
            </div>

            @if($parent)
                @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
            @endif

            <?php /*
                <div class="form-group {{$classes}}">
                    <label for="{{$name}}">{{$property->label}}</label>
                    <input id="{{$name}}" type="number" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}" placeholder="{{$property->default}}">
                    @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                    @if($parent)
                        @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                    @endif
                </div>
            */ ?>

        @elseif ($property->type == 'text')

            <div class="o-form__group {{$classes}}">
                <div class="o-form-status">
                    <div class="o-form-status__input">
                        <label for="{{$name}}">{{$property->label}}</label>
                        <input type="text" id="{{$name}}" name="{{$name}}" placeholder="{{$property->default}}" value="{{ old($name, @$field->settings->$name) }}">
                    </div>
                    <div class="o-form-status__message">
                        <div class="o-form-status__icon">
                            <div class="o-form-status__icon--error">
                                <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                            </div>
                            <div class="o-form-status__icon--success">
                                <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                            </div>
                        </div>
                        <div class="o-form-status__message-bar">
                            <label for="{{$name}}">Error Message</label>
                        </div>
                    </div>
                </div>
                @if (!empty($property->help))
                    <div class="o-form__help-text l-full">
                        <p>{{$property->help}}</p>
                    </div>
                @endif
            </div>

            @if($parent)
                @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
            @endif

            <?php /*
                <div class="form-group {{$classes}}">
                    <label for="{{$name}}">{{$property->label}}</label>
                    <input id="{{$name}}" type="text" class="form-control" name="{{$name}}" value="{{ old($name, @$field->settings->$name) }}" placeholder="{{$property->default}}">
                    @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                    @if($parent)
                        @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                    @endif
                </div>
            */ ?>

        @elseif ($property->type == 'select')

            <div class="o-form__group {{$classes}}">
                <div class="o-form-status">
                    <div class="o-form-status__input">
                        <label for="{{$name}}">{{$property->label}}</label>

                        @if(is_array(@$property->options))
                            <?php
                                // try to get submitted value first, then saved, then initial
                                $defaultOpt = !empty($field->settings->$name) ? $field->settings->$name : null;
                                $v = old($name, $defaultOpt);
                                if ($v === null) {
                                    $v = $property->default;
                                }
                            ?>

                            <select name="{{$name}}" id="{{$name}}" class="js-select">
                                @foreach($property->options as $value => $label)
                                    <option value="{{ $value }}"@if((int)$value === (int)$v) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="o-form-status__message">
                        <div class="o-form-status__icon">
                            <div class="o-form-status__icon--error">
                                <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                            </div>
                            <div class="o-form-status__icon--success">
                                <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                            </div>
                        </div>
                        <div class="o-form-status__message-bar">
                            <label for="{{$name}}">Error Message</label>
                        </div>
                    </div>
                </div>
                @if (!empty($property->help))
                    <div class="o-form__help-text l-full">
                        <p>{{$property->help}}</p>
                    </div>
                @endif
            </div>


            @if($parent)
                @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
            @endif

            <?php /*
            <div class="form-group {{$classes}}">
                <label for="{{$name}}">{{$property->label}}</label>

                @if(is_array(@$property->options))
                    <?php // try to get submitted value first, then saved, then initial
                        $v = old($name, @$field->settings->$name);
                        if ($v === null) {
                            $v = $property->default;
                        }
                    ?>

                    <select name="{{$name}}" id="{{$name}}" class="form-control inline">
                        @foreach($property->options as $value => $label)
                            <option value="{{ $value }}"@if((int)$value === (int)$v) selected @endif>{{ $label }}</option>
                        @endforeach
                    </select>
                @endif
                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                @if($parent)
                    @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                @endif
            </div>
 */ ?>

        @elseif ($property->type == 'options')


            <div class="o-form__title">Options</div>

            <input id="order-{{$field->type->getId()}}" type="hidden" name="options_order">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name (label)</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="sortable" data-sortable_field="order-{{$field->type->getId()}}">
                    @foreach($field->type->getOptions() as $opt_id => $opt_value)
                        <?php
                        $opt_value = (is_object($opt_value)) ? (array)$opt_value : [$opt_value => $opt_value];
                        ?>

                        <tr class="sortable-item" data-sortable_item="{{ $opt_id }}">
                            <td>
                                <span class="sortable-handle btn">&#8645;</span>
                            </td>
                            <td>
                                <span>{{ current($opt_value) }}</span>
                            </td>
                            <td>
                                {{ key($opt_value) }}
                            </td>
                            <td>
                                <input type="hidden" name="options[][{{ key($opt_value) }}]" value="{{current($opt_value)}}">
                                @if($field->type->getParentId())
                                    <a class="o-btn o-btn--xs" href="{{ route('cms:types:combos:fields:options:edit', [$type->getId(), $field->type->getParentId(), $field->type->getId(), $opt_id]) }}">Edit</a>
                                    <a class="o-btn o-btn--xs o-btn--danger confirm" href="{{ route('cms:types:combos:fields:options:delete', [$type->getId(), $field->type->getParentId(), $field->type->getId(), $opt_id]) }}">Remove</a>
                                @else
                                    <a class="o-btn o-btn--xs" href="{{ route('cms:types:fields:options:edit', [$type->getId(), $field->type->getId(), $opt_id]) }}">Edit</a>
                                    <a class="o-btn o-btn--xs o-btn--danger confirm" href="{{ route('cms:types:fields:options:delete', [$type->getId(), $field->type->getId(), $opt_id]) }}">Remove</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($field->type->getParentId())
                <a href="{{ route('cms:types:combos:fields:options:create',[$type->getId(), $field->type->getParentId(), $field->type->getId()]) }}" class="o-btn o-btn--sm">Add Option</a>
            @else
                <a href="{{ route('cms:types:fields:options:create',[$type->getId(), $field->type->getId()]) }}" class="o-btn o-btn--sm">Add Option</a>
            @endif



        @elseif ($property->type == 'items')

            <div class="o-form__group {{$classes}}">
                <div class="o-form-status">
                    <div class="o-form-status__input">
                        <label for="{{$name}}">{{$property->label}}</label>

                        @if(!$customTypes->isEmpty())
                            <select name="{{$name}}[]" id="{{$name}}" class="js-select" multiple>
                                <?php
                                    // try to get submitted value
                                    $v = old($name, @$field->settings->$name);
                                    if (!$v) $v = [];
                                ?>
                                @foreach($customTypes->sortBy('name') as $customType)
                                    <option value="{{ $customType->id }}" {{ in_array($customType->id, $v) ? 'selected' : '' }}>{{ $customType->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="o-form-status__message">
                        <div class="o-form-status__icon">
                            <div class="o-form-status__icon--error">
                                <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                            </div>
                            <div class="o-form-status__icon--success">
                                <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                            </div>
                        </div>
                        <div class="o-form-status__message-bar">
                            <label for="{{$name}}">Error Message</label>
                        </div>
                    </div>
                </div>
                @if (!empty($property->help))
                    <div class="o-form__help-text l-full">
                        <p>{{$property->help}}</p>
                    </div>
                @endif
            </div>

            @if($parent)
                @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
            @endif

            <?php /*
                <div class="form-group {{$classes}}">
                    <label for="{{$name}}">{{$property->label}}</label>

                    @if(!$customTypes->isEmpty())
                        <?php // try to get submitted value
                        $v = old($name, @$field->settings->$name);
                        if (!$v) $v = [];
                        ?>
                        <select name="{{$name}}[]" id="{{$name}}" class="form-control inline" multiple>
                            @foreach($customTypes->sortBy('name') as $customType)
                                <option value="{{ $customType->id }}"@if(in_array($customType->id, $v)) selected @endif>{{ $customType->name }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                    @if($parent)
                        @include('argon::types.fields.loop', ['items'=>$property->children, 'children' => true])
                    @endif
                </div>
            */ ?>

        @endif

    @endforeach

@endif
