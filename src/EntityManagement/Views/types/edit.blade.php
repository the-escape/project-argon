@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Type</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:update', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $type->name) }}">
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <div>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-page" name="type" value="page" @if($type->type == 'page') checked @endif> Page</label>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="block" @if($type->type == 'block') checked @endif> Block</label>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="email" @if($type->type == 'email') checked @endif> Email</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Fields</div>
                <div class="card-block">

                    @if(($groups = $type->groups) && (!$groups->isEmpty()))

                    <input id="order-{{$type->id}}" type="hidden" name="order">

                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Group</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="sortable" data-sortable_field="order-{{$type->id}}">
                        @foreach ($groups as $group)
                            @foreach ($group->fields as $field)
                                <tr class="sortable-item" data-sortable_item="{{$field->id}}">
                                    <td>
                                        <span class="sortable-handle btn">&#8645;</span>
                                    </td>
                                    <td>
                                        <span data-toggle="tooltip" data-placement="left" title="Field ID: {{ $field->id }}">{{ $field->name }}</span>
                                    </td>
                                    <td>
                                        {{ $field->field_slug }}
                                    </td>
                                    <td>
                                        {{ $field->field_type }}
                                    </td>
                                    <td>
                                        {{ @$field->group->name }}

                                        @if(empty($lastGroup) || $lastGroup !== $field->group->id)
                                            <a class="js-export-json text-muted" data-toggle="tooltip" data-placement="top" title="Export Field Group" href="{{ route('cms:types:groups:export', [$type->id,$field->group->id]) }}"><span class="fa fa-files-o"></span></a>
                                            <?php $lastGroup = $field->group->id; ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if($field->field_type == $comboFieldType->getKey())
                                            <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:combos:edit', [$type->id, $field->id]) }}">Edit</a>
                                            <a class="btn btn-link btn-sm confirm" data-confirm="This will remove combo and all subfields.\nAre you sure you want to continue?" href="{{ route('cms:types:combos:delete', [$type->id, $field->id]) }}">Remove</a>
                                        @else
                                            <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:fields:edit', [$type->id, $field->id]) }}">Edit</a>
                                            <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:fields:delete', [$type->id, $field->id]) }}">Remove</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    @endif

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Add Field
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('cms:types:fields:add', [$type->id]) }}" class="btn btn-block">Field</a></li>
                            <li><a href="{{ route('cms:types:combos:add', [$type->id]) }}" class="btn btn-block">Combo</a></li>
                        </ul>
                    </div>

                    {{--<a href="{{ route('cms:types:groups', [$type->id]) }}" class="btn btn-primary-outline">Manage Groups</a>--}}

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage Groups
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('cms:types:groups', [$type->id]) }}" class="btn btn-block">Show All Groups</a></li>
                            <li><a href="{{ route('cms:types:groups:import-json', [$type->id]) }}" class="btn btn-block">Import Group</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection

@section('footer')
    @parent

    <script>
        $(function(){
            $('.js-export-json').on('click' ,function(e){
                e.preventDefault();

                var $btn = $(this),
                    url = $btn.attr('href');

                $.ajax(url).done(function(r){

                    if ($('.modals').find('#groupExport').length){
                        $('.modals').find('#groupExport .modal-content').html($(r).find('.modal-content').html());
                    } else {
                        $('.modals').append($(r));
                    }

                    $('#groupExport').modal('show');
                });
            });

            $('.modals').on('click','.js-copy-to-clip', function(e){

                $('[name=group-export-json]').select()
                    .on("focus", function() {
                        document.execCommand('selectAll',false,null)
                    })
                    .focus();

                var success = document.execCommand("copy");

                if(success){
                    $(this).html('Copied!').addClass('btn-success').removeClass('btn-primary').prop('disabled',true);
                }

                setTimeout(function(){
                    $('#groupExport').modal('hide');
                }, 300);

            })
        });
    </script>
@endsection

@section('footer')



@endsection