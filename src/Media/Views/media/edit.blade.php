@extends('argon::layout.master')

@section('body-class', 'dashboard media media-edit')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Edit</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ $media->getUrl() }}" target="_blank"  title="Open in new tab" class="btn btn-primary-outline">View</a>
            <a href="{{ route("cms:media:delete", [$media->getId()]) }}" class="btn btn-danger-outline confirm">Delete</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline search-form">
                <input type="text" name="keywords" value="" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        {{--@if($media->isImage())--}}
            {{--<div class="preview">--}}
                {{--<img src="{{ $media->getUrl() }}">--}}
            {{--</div>--}}
        {{--@endif--}}

        <form action="{{ route("cms:media:update", [$media->getId()]) }}" method="post">

            <div class="form-group">
                <label for="name" class="required">Name</label>
                <input type="text" id="name" class="form-control required " name="name" value="{{ $media->filename }}">
            </div>

            <div class="form-group">
                <label for="parent" class="required">Parent Folder</label>

                <select name="parent" id="parent" class="form-control">
                    <option value="{{ $root->getId() }}" @if($root->getId() == $currentFolder->getId()) selected @endif>{{ $root->name }}</option>

                    @foreach($root->children as $child)
                        @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>'- ', 'parentFolderId'=>$currentFolder->getId(), 'currentFolderId'=>null])
                    @endforeach
                </select>
            </div>

            {{csrf_field()}}
            {{method_field('PUT')}}

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Back to Media Folders</a>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>

        </form>



    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
