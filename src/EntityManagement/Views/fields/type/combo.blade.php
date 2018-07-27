<?php /*
@if(!$isCloning)

    <div class="field field-combo field-{{ $field->getId() }}"
        data-field="{{$field->getId()}}">

        <label>{{ $field->getFieldName() }}</label>

        <div class="field-values">
@endif

    @foreach ($value as $hash => $v)

        <div class="input-group sortable-item">

            @if($field->allowMultiple())
                <div class="input-group-addon sortable-handle">&#8645;</div>
            @endif

            <div class="form-control">
                @foreach($field->getSubFields() as $subField)

                    {!! $subField->render($value->getValueForSubField($hash, $subField->getId()), ['hash' => $hash]) !!}

                @endforeach
            </div>

            @if($field->allowMultiple())
                <div class="input-group-addon field-remove">&#10005;</div>
            @endif
        </div>

    @endforeach

@if(!$isCloning)
        </div>
        @if($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}">Add Field</a>
        @endif
    </div>
@endif
*/ ?>

@foreach ($value as $hash => $v)
    <div class="o-combo__item">
        <div class="o-combo__header">

            @if($field->allowMultiple())
                <div class="o-combo__drag-handle js-combo-drag">
                    <div class="o-combo__drag-wrap">
                        <svg>
                            <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                        </svg>
                    </div>
                </div>
            @endif

            <div class="o-combo__title js-combo-title">{{ $field->getFieldName() }}</div>

            @if($field->allowMultiple())
                <div class="o-combo__actions">
                    <div class="o-confirm-btn__container js-confirm">
                        <div class="o-confirm-btn__questions">
                            <button class="o-confirm-btn" data-question="duplicate" title="Duplicate">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#duplicate"></use>
                                </svg>
                            </button>
                            <button class="o-confirm-btn" data-question="delete" title="Delete">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="o-confirm-btn__decline">
                            <button class="o-confirm-btn o-confirm-btn--danger js-confirm-decline">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="o-confirm-btn__accept">
                            <button class="o-confirm-btn o-confirm-btn--success js-confirm-accept">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="o-combo__body">
            <div class="o-combo__form">

                @foreach($field->getSubFields() as $subField)

                    <div class="o-form__group">
                        {!! $subField->render($value->getValueForSubField($hash, $subField->getId()), ['hash' => $hash]) !!}
                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endforeach