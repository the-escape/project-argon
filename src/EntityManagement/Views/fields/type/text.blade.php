<?php /*
@if(!$isCloning)
    <div class="field field-text field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
        data-field="{{$field->getId()}}"
        data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        <div class="field-values">
@endif

        @foreach($value as $k => $v)

            @if($field->allowMultiple())
                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>
            @endif

                <input type="text" class="form-control" name="{{ $field->getFormFieldName($hash) }}" value="{{$v}}">

            @if($field->allowMultiple())
                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>
            @endif

        @endforeach


@if(!$isCloning)
        </div>
        </div>
        @if ($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>
        @endif
    </div>
@endif
*/ ?>


<div class="o-form-status">
    <div class="o-form-status__input">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        @foreach($value as $k => $v)

            <input type="text"
                   id="fields-{{ $field->getId() }}-0"
                   name="{{ $field->getFormFieldName($hash) }}"
                   placeholder="{{ $field->getFieldName() }}"
                   value="{{ $v }}">

        @endforeach

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
            <label for="fields-{{ $field->getId() }}-0">Error Message</label>
        </div>
    </div>
</div>
@if(false)
    <div class="o-form__help-text l-full">
        <p>{{ 'help text' }}</p>
    </div>
@endif
