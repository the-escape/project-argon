@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-edit')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Upload</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Media Folders</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline search-form">
                <input type="text" name="keywords" value="" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <form action="{{ route("cms:media:upload:post") }}" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="file">Select Image:</label>
                <input type="file" name="file[]" multiple id="file" class="form-control">
            </div>

            <div class="form-group">
                <label for="folder">Select Folder:</label>
                <select name="folder" id="folder" class="form-control">
                    @foreach($folders as $folder)

                        <option value="{{ $folder->getId() }}">{{ $folder->getName() }}</option>

                    @endforeach
                </select>
            </div>

            {{csrf_field()}}

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>

        </form>

    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
