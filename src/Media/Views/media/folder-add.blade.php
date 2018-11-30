@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-folder-add')

@section('content')
    <div class="c-container">
        <div class="main">
            <h1 class="page-header">Add Folder</h1>

            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="dashboard-content">

                <form action="{{ route("cms:media:folders:save") }}" method="post">

                    <div class="form-group">
                        <label for="name" class="required">Forder Name</label>
                        <input type="text" id="name" class="form-control required" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="parent" class="required">Parent Folder</label>

                        <select name="parent" id="parent" class="form-control">
                            <option value="{{ $root->getId() }}" @if($root->getId() == $parentFolder->getId()) selected @endif>{{ $root->name }}</option>

                            @if($parentFolder->getId())
                                @foreach($root->children as $child)
                                    @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>'- ', 'parentFolderId'=>$parentFolder->getId(), 'currentFolderId'=>null])
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{csrf_field()}}

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Back to Media Folders</a>
                    <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>

                </form>

            </div>
        </div>
    </div>
@stop

@section('styles')
@stop

@section('footer')
@stop
