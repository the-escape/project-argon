@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-all')

@section('content')
    <div class="main">
        <h1 class="page-header">Users</h1>

        @include('argon::inc.alerts')

        <div class="dashboard-actions dashboard-actions--top">

            <a href="{{ route('cms:user:create') }}" class="btn btn-primary">Create</a>

            @if(!empty($roles))
                <div class="btn-group">
                    <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter by role:
                    </button>
                    <div class="dropdown-menu">

                        @foreach($roles as $role)

                            <a class="dropdown-item" href="?role={{ $role->id.($request->has('keywords') ? '&keywords='.$request->input('keywords') : '') }}">{{ $role->name }}</a>

                        @endforeach

                    </div>
                </div>
            @endif

            <a href="{{ route("cms:user:manage") }}" class="btn btn-primary-outline">Reset filers</a>

            <form method="get" class="form-inline search-form">
                @if($request->has('role'))
                    <input type="hidden" name="role" value="{{ $request->input('role') }}">
                @endif
                <input type="text" name="keywords" value="{{ $request->input('keywords') }}" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <div class="dashboard-content">
            <table class="table table-striped table-media table-media-all">
                <thead>
                    <tr>
                        <th>
                            @if($request->input('order') == 'name')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('role') ? '?order=name&dir=desc&role='.$request->input('role') : '?order=name&dir=desc' }}">Name <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('role') ? '?order=name&dir=asc&role='.$request->input('role') : '?order=name&dir=asc' }}">Name <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('role') ? '?order=name&dir=asc&role='.$request->input('role') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('role') ? '?order=name&dir=asc&role='.$request->input('role') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>
                            @if($request->input('order') == 'email')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('role') ? '?order=email&dir=desc&role='.$request->input('role') : '?order=email&dir=desc' }}">Email <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('role') ? '?order=email&dir=asc&role='.$request->input('role') : '?order=email&dir=asc' }}">Email <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('role') ? '?order=email&dir=asc&role='.$request->input('role') : '?order=email&dir=asc' }}">Email <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('role') ? '?order=email&dir=asc&role='.$request->input('role') : '?order=email&dir=asc' }}">Email <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>
                            @if($request->input('order') == 'email')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('role') ? '?order=created_at&dir=desc&role='.$request->input('role') : '?order=created_at&dir=desc' }}">Created at <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('role') ? '?order=created_at&dir=asc&role='.$request->input('role') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('role') ? '?order=created_at&dir=asc&role='.$request->input('role') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('role') ? '?order=created_at&dir=asc&role='.$request->input('role') : '?order=created_at&dir=asc' }}">Created at <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->all() as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td class="actions">
                                <a href="{{ route('cms:user:edit', ['userId' => $user->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                                <a href="{{ route('cms:user:delete', ['userId' => $user->id]) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-danger-outline btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($users->lastPage() > 1)

                <?php
                $pagination = easyPagination(range(1, $users->total()), $users->perPage(), $users->currentPage());
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
    </div>
@stop
