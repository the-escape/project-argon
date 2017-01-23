@extends('argon::layout.medialib')

@section('body-class', 'dashboard medialib medialib-library medialib-folder-edit medialib-modal')

@section('content')

    <div class="main">
        <h1 class="page-header">Edit Folder</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ route("cms:media:modal:folders:remove", [$currentFolder->getId()]) }}" class="btn btn-danger-outline confirm">Delete</a>

        </div>

        <form action="{{ route("cms:media:modal:folders:update", [$currentFolder->getId()]) }}" method="post">

            <div class="form-group">
                <label for="name" class="required">Folder Name</label>
                <input type="text" id="name" class="form-control required " name="name" value="{{ $currentFolder->getName() }}">
            </div>

            <div class="form-group">
                <label for="parent" class="required">Parent Folder</label>

                <select name="parent" id="parent" class="form-control">
                    <option value="{{ $root->getId() }}" @if($root->getId() == $currentFolder->getId()) selected @endif>{{ $root->name }}</option>

                    @if($currentFolder->getParentId())
                        @foreach($root->children as $child)
                            @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>'- ', 'parentFolderId'=>$currentFolder->getParentId(), 'currentFolderId'=>$currentFolder->getId()])
                        @endforeach
                    @endif
                </select>
            </div>

            {{csrf_field()}}
            {{method_field('PUT')}}

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route("cms:media:modal:folders") }}" class="btn btn-primary-outline">Back to Media Folders</a>
            <a href="{{ route("cms:media:modal:all") }}" class="btn btn-primary-outline">Back to All</a>

        </form>

    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
