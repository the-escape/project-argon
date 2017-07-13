@extends('argon::layout.medialib')

@section('body-class', 'dashboard medialib medialib-all medialib-modal')

@section('content')

    <div class="main">

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">

            <a href="" id="edit-button" class="btn btn-primary-outline" data-item-edit="{{ route("cms:media:modal:edit", ['%%ID%%']) }}" data-folder-edit="{{ route("cms:media:modal:folders:edit", ['%%ID%%']) }}">Edit</a>
            <button id="add-button" disabled class="btn btn-primary-outline" data-folder-add="{{ route("cms:media:modal:folders:add", ['%%ID%%']) }}">Add Subfolder</button>
            <button id="delete-button" disabled class="btn btn-danger-outline confirm" data-item-delete="{{ route("cms:media:modal:delete", ['%%ID%%']) }}" data-folder-delete="{{ route("cms:media:modal:folders:remove", ['%%ID%%']) }}">Delete</button>

            <div class="pull-xs-right">
                <a href="{{ route("cms:media:modal:upload:get") }}" class="btn btn-primary btn-upload">Upload</a>
                <a href="{{ route("cms:media:modal:all") }}" class="btn btn-primary-outline">Back to All</a>
            </div>

        </div>

        <div class="dashboard-content">
            <div id="folders">
                <ul>
                    @each('argon::media.folder-single', [$root], 'folder')
                </ul>
            </div>
        </div>

    </div>

@stop

@include('argon::media.styles')
@include('argon::media.scripts')
