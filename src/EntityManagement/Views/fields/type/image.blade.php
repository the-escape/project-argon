<?php
$name = $field->getFormFieldName($hash);
?>

<div class="field field-media field-image" data-type="text" data-settings="{{json_encode($field->getSettings())}}" data-name="{{ $name }}">
    <label>{{ $field->getFieldName() }}</label>

    <div class="files sortable">
        @if($value->isEmpty() || $isCloning)

            <input class="hdnImageId" type="hidden" name="<?=$name.'['.guid().'][id]'?>">

        @else

            @foreach($value as $k => $v)

                @if(!$v)
                    <input class="hdnImageId" type="hidden" name="<?=$name.'['.guid().'][id]'?>">
                @else
                    <?php
                    if (!$field->isInCombo()) $hash = guid();
                    $name = $field->getFormFieldName($hash);
                    $name = $name.'['.guid().']';
                    ?>

                    <div class="input-group sortable-item">
                        @if ($field->allowMultiple())

                            <div class="input-group-addon sortable-handle">&#8645;</div>
                        @endif
                        <div class="form-control">
                            <input type="hidden" name="{{ $name }}[id]" value="{{ $v->getId() }}">
                            <input type="hidden" name="{{ $name }}[width]" value="{{ $v->getWidth()}}">
                            <input type="hidden" name="{{ $name }}[height]" value="{{ $v->getHeight()}}">

                            <div class="media-preview">
                                <img src="{{ $v->getUrl() }}" alt="">
                            </div>

                            <div class="file-name"> Url: <a target="_blank" href="{{ $v->getUrl() }}">{{ $v->getUrl(['updatedAt'=>false]) }}</a> (<a href="{{ route('cms:media:edit', [$v->getId()]) }}">edit</a>)</div>
                            <div class="file-name"> Size: {{ $v->getFriendlyFilesize() }}</div>
                            <div class="file-name"> Dimensions: {{ $v->getWidth() }} x {{ $v->getHeight() }} pixels</div>
                            <input type="text" name="{{$name}}[alt]" value="{{ $v->getAlt() }}" placeholder="Alt text" class="form-control inline">
                        </div>

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                @endif

            @endforeach
        @endif
    </div>


    <a href="#addField" class="btn btn-secondary-outline btn-sm field-add-file" data-field="{{$field->getId()}}">Add File</a>
</div>

