<?php
    $isInCombo = $field->getParentId() != 0;
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
?>

<div class="field field-media field-file" data-type="text" data-settings="{{json_encode($field->getSettings())}}" data-name="{{ $name }}">
    <label>{{ $field->getFieldName() }}</label>

    <div class="files sortable">
        @foreach($value as $k => $v)
            <div class="input-group sortable-item">
                <input type="hidden" name="{{ $name }}" value="{{ $v->getId() }}">
            @if ($field->allowMultiple())

                    <div class="input-group-addon sortable-handle">&#8645;</div>
            @endif
                        <div class="file-name form-control"> {{$v->filename}}.{{$v->extension}} </div>
                        <div class="input-group-addon field-remove">&#10005;</div>
                </div>
        @endforeach
    </div>

    <a href="#addField" class="btn btn-secondary-outline btn-sm field-add-file" data-field="{{$field->getId()}}">Add File</a>
</div>




<div class="o-form-status">
    <div class="o-form-status__input">
        <label for="select">{{ $field->getFieldName() }}</label>

        <div class="o-file js-file-input">
            <input type="hidden" name="file-input" value="/argon/images/user-bg.png">
            <div class="o-file__preview">
                <div class="o-file__preview-wrap">
                    <svg><use xlink:href="/argon/images/svgicons.svg#files"></svg>
                </div>
            </div>
            <div class="o-file__help-text">
                <p>Help Text goes here.</p>
                <button class="o-btn o-btn--sm o-file__btn">select</button>
            </div>
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