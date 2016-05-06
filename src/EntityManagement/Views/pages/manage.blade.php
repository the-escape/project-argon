@extends('argon::layout.master')

@section('content')
    {{--@if (count($locales) > 1)--}}
        {{--<div class="locale-selector" style="height: 54px; padding: 10px 5px; background: #999; margin: 0 -0.9375rem">--}}
            {{--<select id="locale-select" class="c-select">--}}
                {{--@foreach ($locales as $locale)--}}
                    {{--<option value="{{$locale->id}}" @if(Session::get('locale') == $locale->id) selected @endif >{{$locale->name}}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
        {{--</div>--}}
    {{--@endif--}}

    <div class="main">
        <h1>Pages</h1>


        <div id="site-structure">
            <ul>
                @each('argon::pages.tree.item', $entities, 'entity')
            </ul>
        </div>

        <a href="" id="edit-button" disabled class="btn btn-primary-outline btn-sm">Edit</a>
        <div class="btn-group add-child-dropdown">
            <button type="button" disabled class="btn btn-primary-outline btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add Child</button>
            <div class="dropdown-menu">
                @foreach ($types as $type)
                    <a class="dropdown-item" data-type="{{$type->id}}" href="">{{ $type->name }}</a>
                @endforeach
            </div>
        </div>
        <form id="delete-form" style="display: inline" method="POST" action="">
            {{csrf_field()}}
            {{method_field('DELETE')}}
            <button type="submit" class="btn btn-danger btn-sm" disabled>Delete</button>
        </form>
    </div>
@stop

@section('styles')
@stop

@section('footer')
    <script src="/argon/js/jstree.min.js"></script>
    <script>
        $('#site-structure').jstree({
            plugins: [
                'dnd',
                'search'
            ],
            "core" : {
                // so that create works
                "check_callback" : true,
                "multiple": false
            }
        }).jstree("open_all");
        // 7 bind to events triggered on the tree
        $('#site-structure').on("changed.jstree", function (e, data) {
            if (data.selected) {
                var id = data.selected[0].split('-')[1];

                $('#edit-button')
                    .prop('disabled', false)
                    .attr('href', 'pages/' + id + '/edit');
                $('#delete-form')
                    .attr('action', argon.root() + '/pages/' + id);
                $('#delete-form button')
                    .prop('disabled', false)
//                $('#create-button').attr('href', 'content/' + id + '/addchild');
                $('.add-child-dropdown a').each(function (index, element) {
                    var type = $(element).attr('data-type');
                    $(element).attr('href', 'pages/' + id + '/addchild/' + type);
                });
                $('.add-child-dropdown button').prop('disabled', false);
            }
        });

        $('#site-structure').on("move_node.jstree", function (e, data, foo) {
            console.log(e, data, foo);
        });
        $('#site-structure').on("dblclick.jstree", function (e) {
            var node = $(e.target).closest("li");
            var id = node[0].id.split('-')[1];
            location.href = 'pages/' + id + '/edit';
        });
    </script>
@stop
