@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-all')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Folders</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="" id="edit-button" class="btn btn-primary-outline" data-item-edit="{{ route("cms:media:edit", ['%%ID%%']) }}" data-folder-edit="{{ route("cms:media:folders:edit", ['%%ID%%']) }}">Edit</a>
            <button id="add-button" disabled class="btn btn-primary-outline" data-folder-add="{{ route("cms:media:folders:add", ['%%ID%%']) }}">Add Subfolder</button>
            <button id="delete-button" disabled class="btn btn-danger confirm" data-item-delete="{{ route("cms:media:delete", ['%%ID%%']) }}" data-folder-delete="{{ route("cms:media:folders:remove", ['%%ID%%']) }}">Delete</button>


            <div class="pull-xs-right">
                <a href="{{ route("cms:media:upload:get") }}" class="btn btn-primary btn-upload" id="upload-button">Upload</a>
                <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>
            </div>

        </div>

        <div id="folders">
            <ul>
                @each('argon::media.folder-single', [$root], 'folder')
            </ul>
        </div>

    </div>

@stop

@include('argon::media.styles')
@include('argon::media.scripts')