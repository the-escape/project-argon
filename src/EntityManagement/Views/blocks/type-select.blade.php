@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Blocks</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:blocks:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Blocks</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:blocks:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New block</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">

        <div class="o-form">
            <div class="o-form__title">Select block type</div>
            <div class="o-form__group">
                <div class="o-form__vertical-list">
                    @foreach($types as $type)
                        <p>
                            <a href="{{ route('cms:blocks:create', ['typeId'=>$type->id]) }}" class="o-btn o-btn--sm">{{ $type->name }}</a>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>

    </main>

@stop