@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Role</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:role:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Roles</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:role:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New role</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:role:edit', [$role->id]) }}">
                        <div class="c-tab__btn-container">
                            <span>Edit {{ $role->name }}</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">
        <form action="{{ route('cms:role:update', [$role->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('argon::inc.alerts')

            <div class="c-actions__container">
                <div class="c-actions__content">
                    <div class="o-form">
                        <div class="o-form__title">Edit role</div>
                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="name">Name*</label>
                                    <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $role->name) }}">
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

                        <div class="o-form__title">Permissions</div>
                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form__vertical-list">
                                    @foreach ($permissions->getDefinedPermissions() as $permission)
                                        <div class="o-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    {{ $role->hasPermission($permission) ? 'checked="checked"' : '' }}
                                                    name="permissions[]"
                                                    id="role{{$permission}}"
                                                    value="{{$permission}}">
                                                <span>
                                                    <svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg>
                                                </span>
                                            </label>
                                            <label for="role{{ $permission }}">{{ $permission }}</label>
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
                                        <label for="permissions">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">Save</button>
                        <a href="{{ route('cms:role:manage') }}" class="o-btn o-btn--grey">Cancel</a>
                        <a href="{{ route('cms:role:delete', ['id' => $role->id]) }}" onclick="return confirm('Are you sure you want to delete this role?');" class="o-btn o-btn--danger">Delete</a>
                    </div>
                </div>
            </div>
        </form>
    </main>

@endsection
