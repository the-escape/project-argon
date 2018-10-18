@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Field Groups</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:groups', [$type->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">

                <div class="o-form__title">Manage field groups</div>

                @if(($groups = $type->groups) && (!$groups->isEmpty()))

                    <input id="order-{{$type->id}}" type="hidden" name="order">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
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
                                    <a class="o-btn o-btn--xs" href="{{route('cms:types:groups:edit', [$type->id, $group->id])}}">Edit</a>
                                    <a class="o-btn o-btn--xs o-btn--danger confirm" href="{{route('cms:types:groups:delete', [$type->id, $group->id])}}">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @endif

                <a href="{{ route('cms:types:groups:create', [$type->id]) }}" class="o-btn o-btn--sm">Add Field Group</a>

            </div>
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:edit', [$type->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>

@endsection
