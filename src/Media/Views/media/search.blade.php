@extends('argon::layout.master')

@section('body-class', 'dashboard media media-search')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Search</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="{{ route("cms:media:upload") }}" class="btn btn-primary btn-upload">Upload</a>
            <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Media Folders</a>
            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline">
                <input type="text" name="keywords" value="{{ $request->input('keywords') }}"  class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <table class="table table-striped table-media table-media-search">
            <thead>
            <tr>
                <th>
                    @if($request->input('order') == 'id')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=id&dir=desc' }}">ID <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=id&dir=asc' }}">ID <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=id&dir=asc' }}">ID <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=id&dir=asc' }}">ID <i class="fa fa-sort" aria-hidden="true"></i></a>
                    @endif
                </th>
                <th>Thumbnail</th>
                <th>
                    @if($request->input('order') == 'name')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=name&dir=desc' }}">Name <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=name&dir=asc' }}">Name <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                    @endif
                </th>
                <th>
                    @if($request->input('order') == 'extension')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=extension&dir=desc' }}">Extension <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=extension&dir=asc' }}">Extension <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=extension&dir=asc' }}">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=extension&dir=asc' }}">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                    @endif
                </th>
                <th>URL</th>
                <th>Dimensions</th>
                <th>
                    @if($request->input('order') == 'size')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=size&dir=desc' }}">Size <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=size&dir=asc' }}">Size <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=size&dir=asc' }}">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=size&dir=asc' }}">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                    @endif
                </th>
                <th>
                    @if($request->input('order') == 'folder')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=folder&dir=desc' }}">Folder <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=folder&dir=asc' }}">Folder <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=folder&dir=asc' }}">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=folder&dir=asc' }}">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                    @endif
                </th>
                <th>
                    @if($request->input('order') == 'uploaded_at')
                        @if($request->input('dir') == 'asc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=uploaded_at&dir=desc' }}">Uploaded At <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                        @elseif($request->input('dir') == 'desc')
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                        @else
                            <a href="{{ '?keywords='.$request->input('keywords').'&order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    @else
                        <a href="{{ '?keywords='.$request->input('keywords').'&order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
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
                    <td>
                        @if($mediaItem->isImage())
                            {{ $mediaItem->getWidth() }} x {{ $mediaItem->getHeight() }} pixels
                            @else
                            &mdash;
                        @endif
                    </td>
                    <td>{{ $mediaItem->getFriendlyFilesize() }}</td>
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
