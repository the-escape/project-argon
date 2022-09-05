@extends('argon::layout.medialib')
@section('body-class', 'dashboard medialib medialib-edit medialib-modal')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Edit</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">

            <a href="{{ $media->getUrl() }}" target="_blank"  title="Open asset in new tab" class="btn btn-primary-outline">View</a>
            <a href="{{ route("cms:media:modal:delete", [$media->getId()]) }}" class="btn btn-danger-outline confirm">Delete</a>

            <form action="{{ route("cms:media:modal:search") }}" method="get" class="form-inline search-form">
                <input type="text" name="keywords" value="" class="form-control">
                @foreach($request->only('CKEditor', 'CKEditorFuncNum', 'langCode') as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}" class="form-control">
                @endforeach
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <div class="dashboard-content">

            <form action="{{ route("cms:media:modal:update", [$media->getId()]) }}" method="post" enctype="multipart/form-data">

                <div class="card">

                    <div class="card-header">
                        Asset details
                    </div>

                    <div class="card-block">

                        @if($media->isImage())
                            <div class="form-group">
                                <div class="preview">
                                    <a href="{{ $media->getUrl() }}" target="_blank"  title="Open asset in new tab"><img src="{{ $media->getUrl() }}"></a>
                                </div>
                            </div>
                        @endif


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

                        <div class="form-group">
                            <label for="url">Generated Url - not editable</label>
                            <p class="form-control disabled"><a href="{{ $media->getUrl() }}" target="_blank"  title="Open asset in new tab">{{ $media->getUrl(['updatedAt'=>false]) }}</a></p>
                        </div>

                    </div>

                </div>

                <div class="card">

                    <div class="card-header">
                        Overwrite existing asset?
                    </div>

                    <div class="card-block">

                        <div class="form-group">
                            <label for="file">Select Image:</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>

                    </div>

                </div>


                {{csrf_field()}}
                {{method_field('PUT')}}

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route("cms:media:modal:folders") }}" class="btn btn-primary-outline">Back to Media Folders</a>
                <a href="{{ route("cms:media:modal:all") }}" class="btn btn-primary-outline">Back to All</a>

            </form>

        </div>
    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
