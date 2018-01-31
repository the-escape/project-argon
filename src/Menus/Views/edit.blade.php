@extends('argon::layout.master')

@section('content')

    <div class="main">
        <h1>Menu</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:menus:update', [$menu->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">

                <div class="card-header">Menu details</div>

                <div class="card-block">

                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="{{ old('name', $menu->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="slug" class="required">Slug</label>
                        <input type="text" class="form-control required " id="slug" name="slug" placeholder="slug" value="{{ old('slug', $menu->slug) }}">
                    </div>

                </div>

            </div>

            <div class="card">

                <div class="card-header">Menu tree</div>

                <div class="card-block">

                    <div id="navtree"></div>

                    <div>
                        <button id="navtree-add-root" class="btn btn-primary-outline btn-sm">Add new item</button>
                        <button id="navtree-add-child" class="btn btn-primary-outline btn-sm">Add child item</button>
                        <button id="navtree-remove" class="btn btn-primary-outline btn-sm">Remove item</button>
                    </div>
                </div>

            </div>


            <div class="card" id="navtree-form">

                <div class="card-header" id="navtree-header">Edit item</div>

                <div class="card-block">

                    <div class="form-group">
                        <label for="item_label" class="required">Label</label>
                        <input type="text" class="form-control required" id="item_label" name="item_label" placeholder="Label">
                    </div>

                    <div class="form-group">
                        <label for="item_url" class="required">URL</label>
                        <input type="text" class="form-control required " id="item_url" name="item_url" placeholder="URL">
                    </div>

                    <div>
                        <button id="navtree-update" class="btn btn-primary-outline btn-sm">Update item</button>
                        <button id="navtree-deselect" class="btn btn-primary-outline btn-sm">Deselect</button>
                    </div>

                </div>

            </div>




            <textarea id="navtree-output" class="form-control" name="menu">{{ old('menu', $menu->json()) }}</textarea>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>

    </div>

@stop

@section('styles')
    @include("argon_menus::styles")
@stop

@section('footer')
    @include("argon_menus::scripts")
@stop
