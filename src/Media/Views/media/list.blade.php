@extends('argon::layout.master')

@section('content')

    <div class="main">
        <h1 class="page-header">Media</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <button type="button" class="btn btn-primary btn-upload">Upload</button>

        <table class="table table-striped media-list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Folder</th>
                    <th>URL</th>
                    <th>Size</th>
                    <th>Dimensions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mediaItems as $mediaItem)
                    <tr>
                        <td>{{ $mediaItem->getId() }}</td>
                        @if($mediaItem->isImage())
                        <td><a href="{{ $mediaItem->getUrl() }}" target="_blank" title="Open in new tab"><img src="{{ $mediaItem->getUrl() }}"></a></td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $mediaItem->getFullName() }}</td>
                        <td data-folder-id="{{ $mediaItem->mediaFolder->id }}">{{ $mediaItem->mediaFolder->name }}</td>
                        <td>{{ $mediaItem->getUrl() }}</td>
                        <td>{{ $mediaItem->getFriendlyFilesize() }}</td>
                        @if($mediaItem->isImage())
                            <td>{{ $mediaItem->getWidth() }} x {{ $mediaItem->getHeight() }} pixels</td>
                        @else
                            <td></td>
                        @endif
                        <td>
                            <a href="{{ $mediaItem->getUrl() }}" target="_blank"  title="Open in new tab" class="btn btn-primary-outline btn-sm">View</a>
                            <a href="" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="" class="btn btn-danger-outline btn-sm confirm">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
