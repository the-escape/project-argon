@extends('argon::layout.master')

@section('content')

    <div class="main">
        <h1 class="page-header">Media</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <a href="{{ $media->getUrl() }}" target="_blank"  title="Open in new tab" class="btn btn-primary-outline btn-sm">View</a>
        <a href="{{ route("cms:media:delete", [$media->getId()]) }}" class="btn btn-danger-outline btn-sm confirm">Delete</a>

        {{--@if($media->isImage())--}}
            {{--<div class="preview">--}}
                {{--<img src="{{ $media->getUrl() }}">--}}
            {{--</div>--}}
        {{--@endif--}}

        <form action="{{ route("cms:media:update", [$media->getId()]) }}" method="post">

            <div class="form-group">
                <label for="name" class="required">Name</label>
                <input type="text" id="filename" class="form-control required " name="filename" value="{{ $media->filename }}">
            </div>

            <div class="form-group">
                <label for="folder" class="required">Folder</label>
                <select name="folder" id="folder">
                    @foreach($folders as $folder)

                        <option value="{{ $folder->getId() }}">{{ $folder->getName() }}</option>

                    @endforeach
                </select>
            </div>

            {{csrf_field()}}
            {{method_field('PUT')}}

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline btn-sm">Back to All</a>

        </form>



    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
