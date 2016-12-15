@extends('argon::layout.master')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Search</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <button type="button" class="btn btn-primary btn-upload">Upload</button>

        <form action="{{ route("cms:media:search") }}" method="get">
            <input type="text" name="keywords" value="{{ $request->input('keywords') }}">
            <button type="submit" class="btn btn-primary btn-sm ">Search</button>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline btn-sm">Back to All</a>
        </form>

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
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($media as $mediaItem)
                    <tr>
                        <td>{{ $mediaItem->getId() }}</td>
                        @if($mediaItem->isImage())
                        <td><a href="{{ $mediaItem->getUrl() }}" target="_blank" title="Open in new tab"><img src="{{ $mediaItem->getUrl() }}"></a></td>
                        @else
                            <td>&mdash;</td>
                        @endif
                        <td>{{ $mediaItem->getFullName() }}</td>
                        <td data-folder-id="{{ $mediaItem->mediaFolder->id }}">{{ $mediaItem->mediaFolder->name }}</td>
                        <td>{{ $mediaItem->getUrl() }}</td>
                        <td>{{ $mediaItem->getFriendlyFilesize() }}</td>
                        @if($mediaItem->isImage())
                            <td>{{ $mediaItem->getWidth() }} x {{ $mediaItem->getHeight() }} pixels</td>
                        @else
                            <td>&mdash;</td>
                        @endif
                        <td>{{ $mediaItem->created_at }}</td>
                        <td>
                            <a href="{{ $mediaItem->getUrl() }}" target="_blank"  title="Open in new tab" class="btn btn-primary-outline btn-sm">View</a>
                            <a href="{{ route("cms:media:edit", [$mediaItem->getId()]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route("cms:media:delete", [$mediaItem->getId()]) }}" class="btn btn-danger-outline btn-sm confirm">Delete</a>
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
