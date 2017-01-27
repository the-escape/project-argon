@extends ('argon::layouts.master')
@section ('body')
    <form action="{{ action('\Escape\Argon\EntityManagement\Http\Controllers\ContentController@update', [$entityLocalisationId]) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="groups" value="{{ $entityRevisionGroupIds }}">
        <div class="row">
            <div class="col-sm-12">
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
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="blocks">
                            <div class="form__group">
                                <input type="text" class="form__text icon blocks__search" placeholder="Search blocks">
                                <span class="icon search"></span>
                            </div>
                            <div class="block__container">
                                <ul id="blocks-selected" data->
                                    @foreach ($entityRevisionGroups as $entityRevisionGroup)
                                        @include ('argon.entity::partials.block-row', [
                                            'entityGroup' => $entityRevisionGroup->entityGroup,
                                            'entityGroupId' => $entityRevisionGroup->entity_group_id,
                                            'isEntityRevisionGroup' => true,
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
                            <div class="block__container">
                                <ul id="blocks-all">
                                    @foreach ($entityGroups as $entityGroup)
                                        @include ('argon.entity::partials.block-row', [
                                            'entityGroup' => $entityGroup,
                                            'entityGroupId' => $entityGroup->id,
                                            'isEntityRevisionGroup' => false,
                                        ])
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="footer__container">
                            <div class="footer__right">
                                <button type="submit" name="publish" class="form__btn">PUBLISH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
