@extends('argon::layouts.master')
@section('body')
    <div class="actions">Update page search engine optimisation attributes</div>
    <form class="form" action="{{ route('cms:user:store') }}" method="post">
        {{ csrf_field() }}
        <div class="form__group">
            <label for="name">Page title</label>
            <input id="name" name="name" type="text" class="form__text" value="{{ old('name') ? old('name') : $entity->name }}">
            @if ($errors->has('name'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('name') }}</div>
                </div>
            @endif
        </div>
        <div class="form__group">
            <label for="slug">Meta description</label>
            <input id="slug" name="slug" type="text" class="form__text" value="{{ old('slug') ? old('slug') : $entity->slug }}">
            @if ($errors->has('slug'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('slug') }}</div>
                </div>
            @endif
        </div>
        <div class="form__group">
            <label for="password_confirmation">Meta keywords</label>
            <input id="slug" name="slug" type="text" class="form__text" value="{{ old('slug') ? old('slug') : $entity->slug }}">
            @if ($errors->has('slug'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('slug') }}</div>
                </div>
            @endif
        </div>
    </form>
@endsection
