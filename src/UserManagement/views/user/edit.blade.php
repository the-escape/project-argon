@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <a href="{{ route('cms:user:manage') }}" class="c-header__back">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-left"></use>
                </svg>
            </a>
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

    <main class="c-container c-container--main">
        <form action="{{ route('cms:user:update', [$user->id]) }}" method="POST" autocomplete="false"  enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('argon::inc.alerts')

            <div class="c-actions__container">
                <div class="c-actions__content">
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
                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="profile_image">Profile picture</label>

                                    <div class="o-file js-file">
                                        <div class="o-file__preview o-file__preview--small">
                                            <div class="o-file__preview-wrap">

                                                <div class="h-background--primary">
                                                    <img class="o-file__image-preview" src="{{ $user->profile('image','/argon/images/user-icon.png') }}">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="o-file__help-text">
                                            <p>
                                                @if($user->profile('image'))
                                                    Upload your new profile picture.
                                                @else
                                                    Please upload your profile picture.
                                                @endif
                                                <br><span class="h-text--grey-dark">Max file size: 1MB</span>
                                            </p>
                                            <label>
                                                <span class="o-btn o-btn--xs o-file__btn">select</span>
                                                <input type="file" class="o-file__input" name="profile_picture">
                                                <span class="o-file__name"></span>
                                            </label>

                                        </div>
                                    </div>


                                    {{--<input type="file"--}}
                                        {{--id="profile_image"--}}
                                        {{--class="js-file-pond"--}}
                                        {{--name="profile['image']"--}}
                                        {{--data-max-file-size="3MB"--}}
                                        {{--data-max-files="3">--}}

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
                </div>
                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">save</button>
                        <a href="{{ route('cms:user:manage') }}" class="o-btn o-btn--light-grey">cancel changes</a>
                        <a href="{{ route('cms:user:delete', ['userId' => $user->id]) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="o-btn o-btn--danger">Delete</a>
                    </div>
                </div>
            </div>
        </form>
    </main>

@endsection

@section('styles')
    @parent

    {{--<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">--}}
    {{--<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">--}}
@endsection
