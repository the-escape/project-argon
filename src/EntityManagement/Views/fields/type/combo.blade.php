@if(@$field)

    {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
    @if($submitted = old("combo.{$field->id}"))

        @foreach($submitted as $hash => $subfields)

            <div class="card combo field-{{ $field->id }}">

                <div class="card-header">{{ $field->name }}</div>

                <div class="card-block">

                    @foreach($field->subfields as $subfield)

                        @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash])

                    @endforeach

                </div>

            </div>

        @endforeach

    @else

        <?php

        // build multiple instances of combo when multiple from saved values....

        // get the value
        $page_fieldById = isset($page) ? $page->fieldById($field->id) : '';
        ?>

        @if($page_fieldById)
            <?php
            $combos = [];

            foreach ($page_fieldById as $v)
            {
                foreach (json_decode($v, true) as $hash => $fieldDataId)
                {
                    $combos[$hash][] = $fieldDataId;
                }
            }
            ?>

            @foreach ($combos as $hash => $fieldDataIds)

                <div class="card combo field-{{ $field->id }}">

                    <div class="card-header">{{ $field->name }}</div>

                    <div class="card-block">

                        @foreach($field->subfields as $subfield)

                            @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash, 'fieldDataIds'=>$fieldDataIds])

                        @endforeach

                    </div>

                </div>

            @endforeach

        @else

            <div class="card combo field-{{ $field->id }}">

                <div class="card-header">{{ $field->name }}</div>

                <div class="card-block">

                    <?php
                    $hash = str_replace('.', '', microtime(true));
                    ?>

                    @foreach($field->subfields as $subfield)

                        @include('argon::fields.field', ['field'=>$subfield, 'hash'=>$hash])

                    @endforeach

                </div>

            </div>

        @endif



    @endif

    @if(!@$clone)
        @if(@$field->settings->multiple)
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->id}}">Add Field</a>
        @endif
    @endif

@endif