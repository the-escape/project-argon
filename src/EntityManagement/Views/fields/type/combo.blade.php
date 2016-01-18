@if(!isset($clone))

    <div class="field-combo field-{{ $field->getId() }}">

    <label>{{ $field->getFieldName() }}</label>

@endif

    {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
    @if($submitted = old("combo.{$field->getId()}"))

        @foreach($submitted as $hash => $subfields)

            <div class="card combo field-{{ $field->getId() }}">

                <div class="card-block">

                    @foreach($field->getSubfields() as $subfield)

                        @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash])

                    @endforeach

                </div>

            </div>

        @endforeach

    @else

        <?php

        // build multiple instances of combo when multiple from saved values....

        // get the value
        $page_fieldById = isset($page) ? $latest->getField($field->getId()) : '';

        ?>

        @if($page_fieldById)
            <?php
                $combos = [];

                foreach ($page_fieldById as $hash => $v)
                {
                    $combos[$hash] = $v;
                }
            ?>

            @foreach ($combos as $hash => $value)


                <div class="input-group sortable-item">

                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    <div class="form-control">
                        @foreach($field->getSubfields() as $subfield)

                            <?php
                                if (isset($value[$subfield->getId()])) {
                                    $v = $value[$subfield->getId()];
                                } else {
                                    $v = null;
                                }
                            ?>

                            @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash, 'value'=>$v])

                        @endforeach
                    </div>

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

            @endforeach

        @else

            <div class="input-group sortable-item">

                <div class="input-group-addon sortable-handle">&#8645;</div>

                <div class="form-control">
                    <?php
                        $hash = str_replace('.', '', microtime(true));
                    ?>

                    @foreach($field->getSubfields() as $subfield)

                        @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash])

                    @endforeach
                </div>

                <div class="input-group-addon field-remove">&#10005;</div>
            </div>

        @endif

    @endif

    @if(!isset($clone))
        @if($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}">Add Field</a>
        @endif

    </div>
@endif
