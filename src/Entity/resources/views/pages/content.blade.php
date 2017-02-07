@extends ('argon::layouts.master')
@section ('body')
    <form action="{{ action('\Escape\Argon\Entity\Http\Controllers\ContentController@update', [$entityLocalisationId]) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="array" value="{{ $entityRevisionGroupIds }}">
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
        <div class="row">
            <div class="col-sm-6">
                <div class="blocks">
                    <div class="form__group">
                        <input type="text" class="form__text icon blocks__search" placeholder="Search blocks">
                        <span class="icon search"></span>
                    </div>
                    <div class="blocks__container">
                        <ul id="entity-revision-groups">
                            @foreach ($entityRevisionGroups as $entityRevisionGroup)
                                @include ('argon.entity::partials.block-row', [
                                    'entityGroup' => $entityRevisionGroup->entityGroup,
                                    'entityGroupStatus' => $entityRevisionGroup->status,
                                ])
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="blocks">
                    <div class="form__group">
                        <input type="text" class="form__text icon blocks__search" placeholder="Search blocks">
                        <span class="icon search"></span>
                    </div>
                    <div class="blocks__container">
                        <ul id="entity-groups">
                            @foreach ($entityGroups as $entityGroup)
                                @include ('argon.entity::partials.block-row', ['entityGroup' => $entityGroup])
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include ('argon.entity::partials.block-footer')
    </form>
@endsection
