@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>User</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:user:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Users</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:user:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New user</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:user:edit', [$user->id]) }}">
                        <div class="c-tab__btn-container">
                            <span>Edit {{ $user->name }}</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:user:update', [$user->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">
                <div class="o-form__title">Edit user</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="o-form-status__message">
                            <div class="o-form-status__icon">
                                <div class="o-form-status__icon--error">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                </div>
                                <div class="o-form-status__icon--success">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                </div>
                            </div>
                            <div class="o-form-status__message-bar">
                                <label for="name">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="email">Email*</label>
                            <input type="email" id="email" name="email" placeholder="Email..." value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="o-form-status__message">
                            <div class="o-form-status__icon">
                                <div class="o-form-status__icon--error">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                </div>
                                <div class="o-form-status__icon--success">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                </div>
                            </div>
                            <div class="o-form-status__message-bar">
                                <label for="email">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__title">Change password (optional)</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="password">New Password*</label>
                            <input type="password" id="password" name="password" placeholder="Password...">
                        </div>
                        <div class="o-form-status__message">
                            <div class="o-form-status__icon">
                                <div class="o-form-status__icon--error">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                </div>
                                <div class="o-form-status__icon--success">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                </div>
                            </div>
                            <div class="o-form-status__message-bar">
                                <label for="password">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__title">Roles</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form__list">
                            @foreach ($roles as $role)
                                <div class="o-checkbox">
                                    <label>
                                        <input type="checkbox" name="roles[]" {{ $user->hasRole($role->name) ? 'checked="checked"' : '' }} id="role{{$role->id}}" value="{{$role->id}}">
                                        <span>
                                            <svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg>
                                        </span>
                                    </label>
                                    <label for="role{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="o-form-status__message">
                            <div class="o-form-status__icon">
                                <div class="o-form-status__icon--error">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                </div>
                                <div class="o-form-status__icon--success">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                </div>
                            </div>
                            <div class="o-form-status__message-bar">
                                <label for="roles">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div>
                            <a href="{{ route('cms:user:delete', ['userId' => $user->id]) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="o-btn o-btn--sm o-btn--danger">Delete</a>
                        </div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="{{ route('cms:user:manage') }}" class="o-btn o-btn--sm">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>

@endsection
