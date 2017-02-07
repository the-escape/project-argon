@extends('argon::layouts.master')
@section('body')
    <div class="actions">
        You are editing <span>{{ ucwords($entityRevisionGroup->entityGroup->name) }}</span>
    </div>
    <form class="form" action="{{ route('cms:pages:block:update', [$entity->id, $entityLocalisationId, $entityRevisionGroup->entity_group_id]) }}" method="post">
        {{ csrf_field() }}
        @foreach ($entityRevisionGroup->entityGroup->getFields() as $entityField)
            <div class="form__group">
                {!! $entityField->render($entityRevision->getField($entityField->getId())) !!}
            </div>
        @endforeach
        <div class="form__group">
            <label for="status">Enabled*</label>
            <label class="switch">
                <input type="checkbox" name="status" value="1" {{ $entityRevisionGroup->status ? 'checked' : '' }}>
                <div class="slider">
                    <span>YES</span>
                    <span>NO</span>
                </div>
            </label>
        </div>
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="footer__container">
                            <a href="{{ route('cms:pages:content', [$entity->id, $entityLocalisationId]) }}" class="form__btn form__btn--grey">CANCEL</a>
                            <button type="submit" class="form__btn">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
