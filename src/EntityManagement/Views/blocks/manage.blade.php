@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-all')

@section('content')
    <div class="main">
        <h1 class="page-header">Blocks</h1>

        @include('argon::inc.alerts')

        <div class="dashboard-actions dashboard-actions--top">

            @if(!empty($types))

                <div class="btn-group" role="group">

                    <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Add Block
                        <span class="caret"></span>
                    </button>

                    <div class="dropdown-menu">
                        @foreach($types as $type)
                            <li><a href="{{ route('cms:blocks:create', ['typeId'=>$type->id]) }}" class="btn btn-block">{{ $type->name }}</a></li>
                        @endforeach
                    </div>

                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter by type:
                    </button>
                    <div class="dropdown-menu">

                        @foreach($types as $type)

                            <a class="dropdown-item" href="?type={{ $type->id.($request->has('keywords') ? '&keywords='.$request->input('keywords') : '') }}">{{ $type->name }}</a>

                        @endforeach

                    </div>
                </div>

                <a href="{{ route("cms:blocks:manage") }}" class="btn btn-primary-outline">Reset filers</a>

                <form method="get" class="form-inline search-form">
                    @if($request->has('type'))
                        <input type="hidden" name="role" value="{{ $request->input('type') }}">
                    @endif
                    <input type="text" name="keywords" value="{{ $request->input('keywords') }}" class="form-control">
                    <button type="submit" class="btn btn-primary-outline">Search</button>
                </form>

            @else

                <a href="{{ route('cms:types:create') }}" class="btn btn-primary-outline">Add a block type</a>

            @endif

        </div>

        @if(!$blocks->isEmpty())

            <div class="dashboard-content">
                <table class="table table-striped table-media table-media-all">
                    <thead>
                    <tr>
                        <th>
                            @if($request->input('order') == 'name')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('type') ? '?order=name&dir=desc&type='.$request->input('type') : '?order=name&dir=desc' }}">Name <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('type') ? '?order=name&dir=asc&type='.$request->input('type') : '?order=name&dir=asc' }}">Name <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('type') ? '?order=name&dir=asc&type='.$request->input('type') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('type') ? '?order=name&dir=asc&type='.$request->input('type') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>
                            @if($request->input('order') == 'type')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('type') ? '?order=type&dir=desc&type='.$request->input('type') : '?order=type&dir=desc' }}">Content Type <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('type') ? '?order=type&dir=asc&type='.$request->input('type') : '?order=type&dir=asc' }}">Content Type <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('type') ? '?order=type&dir=asc&type='.$request->input('type') : '?order=type&dir=asc' }}">Content Type <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('type') ? '?order=type&dir=asc&type='.$request->input('type') : '?order=type&dir=asc' }}">Content Type <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>
                            @if($request->input('order') == 'created_at')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('type') ? '?order=created_at&dir=desc&type='.$request->input('type') : '?order=created_at&dir=desc' }}">Created at <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('type') ? '?order=created_at&dir=asc&type='.$request->input('type') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('type') ? '?order=created_at&dir=asc&type='.$request->input('type') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('type') ? '?order=created_at&dir=asc&type='.$request->input('type') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($blocks->all() as $block)
                        <tr>
                            <td>{{$block->name}}</td>
                            <td>{{$block->type->name}}</td>
                            <td>{{$block->created_at}}</td>
                            <td class="actions">
                                <a href="{{ route('cms:blocks:edit', ['blockId' => $block->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                                <a href="{{ route('cms:blocks:delete', ['blockId' => $block->id]) }}" onclick="return confirm('Are you sure you want to delete this block?');" class="btn btn-danger-outline btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>



                @if($blocks->lastPage() > 1)

                    <?php
                    $pagination = easyPagination(range(1, $blocks->total()), $blocks->perPage(), $blocks->currentPage());
                    $presenter = paginationPresenter($pagination, '...', 1, 2, function($element, $hellip, $current_page_number)
                    {
                        if ($element != $hellip)
                        {
                            return '<li class="page-item class="'.(($element == $current_page_number) ? "active" : "").'"><a class="page-link" href="'.getUrlWithQueryString(['page'=>$element]).'">'.$element.'</a></li>';
                        }
                        return '<li class="page-item"><span class="page-link">'.$element.'</span></li>';
                    });
                    ?>

                    <nav>
                        <ul class="pagination pagination-sm">
                            <li class="page-item @if(!$pagination['page_prev']) disabled @endif">
                                @if($pagination['page_prev'])
                                    <a class="page-link" href="{{ getUrlWithQueryString(['page'=>$pagination['page_prev']])  }}" tabindex="-1">Previous</a>
                                @else
                                    <span class="page-link">Previous</span>
                                @endif
                            </li>

                            @foreach ($presenter as $li)
                                {!! $li !!}
                            @endforeach

                            <li class="page-item @if(!$pagination['page_next']) disabled @endif">
                                @if($pagination['page_next'])
                                    <a class="page-link" href=" {{ getUrlWithQueryString(['page'=>$pagination['page_next']])  }}">Next</a>
                                @else
                                    <span class="page-link">Next</span>
                                @endif
                            </li>
                        </ul>
                    </nav>

                @endif

            </div>








            {{--<div class="dashboard-content">--}}
                {{--<table class="table table-striped">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>Name</th>--}}
                        {{--<th>Content Type</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach ($blocks as $block)--}}
                        {{--<tr>--}}
                            {{--<td>{{$block->name}}</td>--}}
                            {{--<td>{{$block->type->name}}</td>--}}
                            {{--<td>--}}
                                {{--<a href="{{ route('cms:blocks:edit', ['blockId'=>$block->id, ]) }}" class="btn btn-primary-outline btn-sm">Edit</a>--}}
                                {{--<a href="{{ route('cms:blocks:delete', ['blockId'=>$block->id]) }}" class="btn btn-danger-outline btn-sm confirm">Delete</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}

        @endif

    </div>
@stop