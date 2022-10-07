@extends('argon::layout.medialib')

@section('body-class', 'dashboard medialib medialib-edit medialib-modal')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Upload</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {!! session('message') !!}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">

            <a href="{{ route("cms:media:modal:folders") }}" class="btn btn-primary-outline">Media Folders</a>

            <form action="{{ route("cms:media:modal:search") }}" method="get" class="form-inline search-form">
                <input type="text" name="keywords" value="" class="form-control">
                @foreach(request()->only('CKEditor', 'CKEditorFuncNum', 'langCode') as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}" class="form-control">
                @endforeach
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <div class="dashboard-content">

            <form action="{{ route("cms:media:modal:upload:post") }}" method="post" enctype="multipart/form-data">

                <div class="card">

                    <div class="card-header">Upload Images</div>

                    <div class="card-block">

                        <div class="alert alert-info" role="alert">
                            Please consider optimising your images for web. We recommend online service  <a href="https://tinypng.com/" target="_blank">TinyPNG</a>
                        </div>

                        <div class="form-group">
                            <label for="file">Select Image:</label>
                            <input type="file" name="file[]" multiple id="file" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="folder" class="required">Select Folder:</label>

                            <select name="folder" id="folder" class="form-control">
                                <option value="{{ $root->getId() }}" @if($root->getId() == 0) selected @endif>{{ $root->name }}</option>

                                @foreach($root->children as $child)
                                    @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>'- ', 'parentFolderId'=>0, 'currentFolderId'=>null])
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{csrf_field()}}

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route("cms:media:modal:all") }}" class="btn btn-primary-outline">Back to All</a>

            </form>

        </div>
    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
