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

            <a href="" id="edit-button" class="btn btn-primary-outline">Edit</a>
            <button id="add-button" disabled class="btn btn-primary-outline">Add Subfolder</button>
            <button id="delete-button" disabled class="btn btn-danger-outline confirm">Delete</button>

            <div class="pull-xs-right">
                <a href="{{ route("cms:media:upload:get") }}" class="btn btn-primary btn-upload">Upload</a>
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