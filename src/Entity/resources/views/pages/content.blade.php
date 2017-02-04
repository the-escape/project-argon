@extends ('argon::layouts.master')
@section ('body')
    <form action="{{ action('\Escape\Argon\Entity\Http\Controllers\ContentController@update', [$entityLocalisationId]) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="groups" value="{{ $entityRevisionGroupIds }}">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="margin-t-no">Page preview</h2>
                <p>Here you can edit, duplicate, remove or re-order page content.</p>
            </div>
            <div class="col-sm-6">
                <h2 class="margin-t-no">Page builder</h2>
                <p>Add blocks to create your own custom page layout.</p>
            </div>
        </div>
        <page-builder
                entity-localisation-id="{{ $entityLocalisationId }}">
        </page-builder>
        @include ('argon.entity::partials.block-footer')
    </form>
@endsection
