@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Manage Type Groups</h1>

        @include('argon::inc.alerts', (array) $errors)

        <form action="{{ route('cms:types:groups', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">

                <div class="card-header">Groups</div>

                <div class="card-block">

                    @if(($groups = $type->groups) && (!$groups->isEmpty()))

                        <input id="order-{{$type->id}}" type="hidden" name="order">

                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-sortable_field="order-{{$type->id}}">
                                @foreach ($groups as $group)
                                    <tr class="sortable-item" data-sortable_item="{{$group->id}}">
                                        <td>
                                            <span class="sortable-handle btn">&#8645;</span>
                                        </td>
                                        <td>
                                            <span data-toggle="tooltip" data-placement="left" title="Field ID: {{ $group->id }}">{{ $group->name }}</span>
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary-outline btn-sm" href="{{route('cms:types:groups:edit', [$type->id, $group->id])}}">Edit</a>
                                            <a class="btn btn-link btn-sm confirm" href="{{route('cms:types:groups:delete', [$type->id, $group->id])}}">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif

                    <a href="{{ route('cms:types:groups:create', [$type->id]) }}" class="btn btn-primary-outline">Add Group</a>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>

        </form>

    </div>
@endsection
