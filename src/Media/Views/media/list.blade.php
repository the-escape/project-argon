@extends('argon::layout.master')

@section('body-class', 'dashboard medialib medialib-all')

@section('content')

    <div class="main">
        <h1 class="page-header">Media</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">

            <a href="{{ route("cms:media:upload:get") }}" class="btn btn-primary btn-upload">Upload</a>
            <a href="{{ route("cms:media:folders") }}" class="btn btn-primary-outline">Media Folders</a>

            @if($folders = Escape\Argon\Media\Helpers\Media::traverseFolders(Escape\Argon\Media\Helpers\Media::getFolderTree(), function($folder) {
                return sprintf('<a class="dropdown-item" href="?folder=%u">%s %s</a>', $folder['id'], str_repeat('- ', $folder['level']), $folder['name']);
            }))
                <div class="btn-group">
                    <button type="button" class="btn btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter by folder:
                    </button>
                    <div class="dropdown-menu">

                        @foreach($folders as $folder)

                            {!! $folder !!}

                        @endforeach

                    </div>
                </div>
            @endif

            <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Reset filers</a>

            <form action="{{ route("cms:media:search") }}" method="get" class="form-inline search-form">
                <input type="text" name="keywords" value="" class="form-control">
                <button type="submit" class="btn btn-primary-outline">Search</button>
            </form>

        </div>

        <div class="dashboard-content">

            <table class="table table-striped table-media table-media-all">
                <thead>
                <tr>
                    <th>
                        @if($request->input('order') == 'id')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=id&dir=desc&folder='.$request->input('folder') : '?order=id&dir=desc' }}">ID <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=id&dir=asc&folder='.$request->input('folder') : '?order=id&dir=asc' }}">ID <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=id&dir=asc&folder='.$request->input('folder') : '?order=id&dir=asc' }}">ID <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=id&dir=asc&folder='.$request->input('folder') : '?order=id&dir=asc' }}">ID <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>Thumbnail</th>
                    <th>
                        @if($request->input('order') == 'name')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=name&dir=desc&folder='.$request->input('folder') : '?order=name&dir=desc' }}">Name <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=name&dir=asc&folder='.$request->input('folder') : '?order=name&dir=asc' }}">Name <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=name&dir=asc&folder='.$request->input('folder') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=name&dir=asc&folder='.$request->input('folder') : '?order=name&dir=asc' }}">Name <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'description')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=description&dir=desc&folder='.$request->input('folder') : '?order=description&dir=desc' }}">Has Alt? <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=description&dir=asc&folder='.$request->input('folder') : '?order=description&dir=asc' }}">Has Alt? <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=description&dir=asc&folder='.$request->input('folder') : '?order=description&dir=asc' }}">Has Alt? <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=description&dir=asc&folder='.$request->input('folder') : '?order=description&dir=asc' }}">Has Alt? <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'extension')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=extension&dir=desc&folder='.$request->input('folder') : '?order=extension&dir=desc' }}">Extension <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=extension&dir=asc&folder='.$request->input('folder') : '?order=extension&dir=asc' }}">Extension <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=extension&dir=asc&folder='.$request->input('folder') : '?order=extension&dir=asc' }}">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=extension&dir=asc&folder='.$request->input('folder') : '?order=extension&dir=asc' }}">Extension <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>URL</th>
                    <th>Dimensions</th>
                    <th>
                        @if($request->input('order') == 'size')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=size&dir=desc&folder='.$request->input('folder') : '?order=size&dir=desc' }}">Size <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=size&dir=asc&folder='.$request->input('folder') : '?order=size&dir=asc' }}">Size <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=size&dir=asc&folder='.$request->input('folder') : '?order=size&dir=asc' }}">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=size&dir=asc&folder='.$request->input('folder') : '?order=size&dir=asc' }}">Size <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    <th>
                        @if($request->input('order') == 'folder')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=folder&dir=desc&folder='.$request->input('folder') : '?order=folder&dir=desc' }}">Folder <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=folder&dir=asc&folder='.$request->input('folder') : '?order=folder&dir=asc' }}">Folder <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=folder&dir=asc&folder='.$request->input('folder') : '?order=folder&dir=asc' }}">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=folder&dir=asc&folder='.$request->input('folder') : '?order=folder&dir=asc' }}">Folder <i class="fa fa-sort" aria-hidden="true"></i></a>
                        @endif
                    </th>
                    @if(auth()->user()->hasRole('Admin'))
                        <th>
                            @if($request->input('order') == 'uploaded_by')
                                @if($request->input('dir') == 'asc')
                                    <a href="{{ $request->has('folder') ? '?order=uploaded_by&dir=desc&folder='.$request->input('folder') : '?order=uploaded_by&dir=desc' }}">Uploaded By <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                @elseif($request->input('dir') == 'desc')
                                    <a href="{{ $request->has('folder') ? '?order=uploaded_by&dir=asc&folder='.$request->input('folder') : '?order=uploaded_by&dir=asc' }}">Uploaded By <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $request->has('folder') ? '?order=uploaded_by&dir=asc&folder='.$request->input('folder') : '?order=uploaded_by&dir=asc' }}">Uploaded By <i class="fa fa-sort" aria-hidden="true"></i></a>
                                @endif
                            @else
                                <a href="{{ $request->has('folder') ? '?order=uploaded_by&dir=asc&folder='.$request->input('folder') : '?order=uploaded_by&dir=asc' }}">Uploaded By <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        </th>
                    @endif
                    <th>
                        @if($request->input('order') == 'uploaded_at')
                            @if($request->input('dir') == 'asc')
                                <a href="{{ $request->has('folder') ? '?order=uploaded_at&dir=desc&folder='.$request->input('folder') : '?order=uploaded_at&dir=desc' }}">Uploaded At <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            @elseif($request->input('dir') == 'desc')
                                <a href="{{ $request->has('folder') ? '?order=uploaded_at&dir=asc&folder='.$request->input('folder') : '?order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            @else
                                <a href="{{ $request->has('folder') ? '?order=uploaded_at&dir=asc&folder='.$request->input('folder') : '?order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
                            @endif
                        @else
                            <a href="{{ $request->has('folder') ? '?order=uploaded_at&dir=asc&folder='.$request->input('folder') : '?order=uploaded_at&dir=asc' }}">Uploaded At <i class="fa fa-sort" aria-hidden="true"></i></a>
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
                            <td><a href="{{ $mediaItem->getUrl() }}" target="_blank" title="Open in new tab"><img src="{{ $mediaItem->getUrl() }}"
                            @if ($mediaItem->description != '')
                            alt="{{ $mediaItem->description }}"
                            @endif
                            ></a></td>
                        @else
                            <td><i class="fa fa-file-o" aria-hidden="true" style="font-size: 50px; color: #aaa;"></i></td>
                        @endif
                        <td>{{ $mediaItem->getName() }}
                        @if ($mediaItem->description != '')
                        <br><small>Alt: {{ $mediaItem->description }}</small>
                        @endif
                        </td>
                        <td style="text-align: center;">@if ($mediaItem->description != '')<i class="fa fa-check" aria-hidden="true" style="font-size: 20px; color: Green;" title="{{ $mediaItem->description }}"></i>@else<i class="fa fa-close" aria-hidden="true" style="font-size: 20px; color: #f00;"></i>@endif</td>
                        <td>{{ $mediaItem->getExtension() }}</td>
                        <td><a href="{{ $mediaItem->getUrl() }}" target="_blank"  title="Open in new tab">{{ $mediaItem->getUrl(['updatedAt'=>false]) }}</a></td>
                        <td>
                            @if($mediaItem->isImage())
                                {{ $mediaItem->getWidth() }} x {{ $mediaItem->getHeight() }} pixels
                                @else
                                &mdash;
                            @endif
                        </td>
                        <td>{{ $mediaItem->getFriendlyFilesize() }}</td>
                        <td data-folder-id="{{ $mediaItem->mediaFolder->id }}"><a href="{{ route('cms:media:folders:edit', [$mediaItem->mediaFolder->id]) }}" title="Edit folder">{{ $mediaItem->mediaFolder->name }}</a></td>
                        @if(auth()->user()->hasRole('Admin'))
                            <td>{{ $mediaItem->user->name or 'unknown' }}</td>
                        @endif
                        <td>{{ $mediaItem->created_at }}</td>
                        <td class="actions">
                            <a href="{{ $mediaItem->getUrl() }}" target="_blank"  title="Open in new tab" class="btn btn-primary-outline btn-sm">View</a>
                            <a href="{{ route("cms:media:edit", [$mediaItem->getId()]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route("cms:media:delete", [$mediaItem->getId()]) }}" class="btn btn-danger-outline btn-sm confirm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination pagination-media">

                <a href="{{ $media->previousPageUrl() }}" class="btn btn-sm btn-secondary">Previous</a>

                @for($i=1; $i<=$media->lastPage(); $i++)

                    <a href="{{ getUrlWithQueryString(['page'=>$i]) }}" class="btn btn-sm btn-secondary @if($i == $media->currentPage()) active @endif">{{ $i }}</a>

                @endfor

                <a href="{{ $media->nextPageUrl() }}" class="btn btn-sm btn-secondary">Next</a>

            </div>

        </div>

    </div>

@stop

@section('styles')
@stop

@section('footer')
@stop
