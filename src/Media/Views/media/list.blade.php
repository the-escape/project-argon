@extends('argon::layout.master')

@section('body-class', 'dashboard media media-all')

@section('content')

    <div class="main">
        <h1 class="page-header">Media</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ route("cms:media:upload") }}" class="btn btn-primary btn-upload">Upload</a>
            <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Media Folders</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline">
                <input type="text" name="keywords" value="" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <table class="table table-striped table-media table-media-all">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>
                        @if($request->input('order') == 'name')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=name&dir=desc">Name <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=name&dir=asc">Name <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=name&dir=asc">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=name&dir=asc">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'extension')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=extension&dir=desc">Extension <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=extension&dir=asc">Extension <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=extension&dir=asc">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=extension&dir=asc">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>URL</th>
                    <th>
                        @if($request->input('order') == 'size')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=size&dir=desc">Size <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=size&dir=asc">Size <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=size&dir=asc">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=size&dir=asc">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'width')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=width&dir=desc">Width <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=width&dir=asc">Width <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=width&dir=asc">Width <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=width&dir=asc">Width <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'height')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=height&dir=desc">Height <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=height&dir=asc">Height <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=height&dir=asc">Height <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=height&dir=asc">Height <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'folder')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=folder&dir=desc">Folder <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=folder&dir=asc">Folder <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=folder&dir=asc">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=folder&dir=asc">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'uploaded_at')
                            @if($request->input('dir') == 'asc')
                                <a href="?order=uploaded_at&dir=desc">Uploaded At <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="?order=uploaded_at&dir=asc">Uploaded At <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="?order=uploaded_at&dir=asc">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="?order=uploaded_at&dir=asc">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
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
                            <td><i class="fa fa-file-o" aria-hidden="true" style="font-size: 50px; color: #aaa;"></i></td>
                        @endif
                        <td>{{ $mediaItem->getName() }}</td>
                        <td>{{ $mediaItem->getExtension() }}</td>
                        <td><a href="{{ $mediaItem->getUrl() }}" target="_blank"  title="Open in new tab">{{ $mediaItem->getUrl() }}</a></td>
                        <td>{{ $mediaItem->getFriendlyFilesize() }}</td>
                        <td>
                            @if($mediaItem->isImage())
                                {{ $mediaItem->getWidth('px') }}
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td>
                            @if($mediaItem->isImage())
                                {{ $mediaItem->getHeight('px') }}
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td data-folder-id="{{ $mediaItem->mediaFolder->id }}">{{ $mediaItem->mediaFolder->name }}</td>
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
