@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Group</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:groups:update', [$type->id, $group->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $group->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="sortable">
                            <input type="hidden" value="0" name="sortable">
                            <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'sortable') }}" @if($group->sortable) checked @endif id="sortable" name="sortable" value="1">
                            Sortable
                        </label>
                    </div>

                    @if($type->isPage())
                        <div class="form-group">
                            <label for="renderable">
                                <input type="hidden" value="0" name="renderable">
                                <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'renderable') }}" @if($group->renderable) checked @endif id="renderable" name="renderable" value="1">
                                Renderable
                            </label>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="settings" class="required">Settings</label>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="settings[slug][key]" placeholder="slug" value="slug">
                                    <div class="input-group-addon">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="settings[slug][value]" placeholder="{{ str_slug(old('name', $group->name)) }}" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="settings[location][key]" placeholder="Key" value="location">
                                    <div class="input-group-addon">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="settings[location][value]" placeholder="i.e. sidebar" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="settings[image][key]" placeholder="Key" value="image">
                                    <div class="input-group-addon">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="settings[image][value]" placeholder="url string" value="">
                            </div>
                        </div>

                        @if($settings = old('settings'))

                            @foreach($settings as $setting)
                                @include('argon::groups.setting', ['key'=>$setting['key'], 'value'=>$setting['value']])
                            @endforeach

                        @else

                            @forelse ($group->settings as $key => $value)
                                @include('argon::groups.setting')
                            @empty
                                @include('argon::groups.setting')
                            @endforelse

                        @endif

                        <button class="btn btn-secondary-outline btn-sm" id="settings-add">Add New</button>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:groups', [$type->id])}}">Back to manage groups</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
