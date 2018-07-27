<?php /*
<div class="field field-boolean field-{{ $field->getId() }}">
    <label>{{ $field->getFieldName() }}</label>

    <div>
        <input type="radio" class="boolean-radio-off" id="field-{{ $field->getId() }}-off" name="{{ $field->getFormFieldName($hash) }}" value="0" @if($value->isFalse()) checked @endif>
        <input type="radio" class="boolean-radio-on" id="field-{{ $field->getId() }}-on" name="{{ $field->getFormFieldName($hash) }}" value="1" @if($value->isTrue()) checked @endif>
        <button type="button" class="boolean-on">On</button><button type="button" class="boolean-off">Off</button>
    </div>
</div>
*/ ?>


<div class="o-form-status">
    <div class="o-form__list">
        <div class="o-switch">
            <label>
                <input type="hidden" name="{{ $field->getFormFieldName($hash) }}" class="js-toggle-value" value="0">
                <input type="checkbox" id="field-{{ $field->getId() }}" class="js-toggle-input">
                <label>
                    <div class="o-switch__text" data-yes="on" data-no="off"></div>
                </label>
            </label>
            <label for="field-{{ $field->getId() }}">{{ $field->getFieldName() }}</label>
        </div>
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
            <label for="title">Error Message</label>
        </div>
    </div>
</div>
@if(false)
    <div class="o-form__help-text l-full">
        <p>Help Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
    </div>
@endif