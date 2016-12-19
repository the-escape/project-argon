<li class="folder" id="folder-{{$folder->id}}" data-id="{{$folder->id}}">
    {{ $folder->name }}

    @if($items = $folder->items)
        <ul>
            @foreach($items as $mediaItem)
                @if(\Escape\Argon\Media\Helpers\Media::isImage($mediaItem->mimetype))
                    <li class="mediaitem" data-jstree='{"icon":"fa fa-file-image-o"}' data-id="{{ $mediaItem->getId() }}" data-info="Dimensions {{ $mediaItem->getWidth() }} x {{ $mediaItem->getHeight() }} pixels | Size: {{ $mediaItem->getFriendlyFilesize() }} | URL: {{ $mediaItem->getUrl() }} | Uploaded At: {{ $mediaItem->created_at }}">
                        {{ $mediaItem->getFullName() }}
                    </li>
                @elseif(\Escape\Argon\Media\Helpers\Media::isPdf($mediaItem->mimetype))
                    <li class="mediaitem" data-jstree='{"icon":"fa fa-file-pdf-o"}'data-id="{{ $mediaItem->getId() }}" data-info="Size: {{ $mediaItem->getFriendlyFilesize() }} | URL: {{ $mediaItem->getUrl() }} | Uploaded At: {{ $mediaItem->created_at }}">
                        {{ $mediaItem->getFullName() }}
                    </li>
                @else
                    <li class="mediaitem" data-jstree='{"icon":"fa fa-file-o"}'data-id="{{ $mediaItem->getId() }}" data-info="Size: {{ $mediaItem->getFriendlyFilesize() }} | URL: {{ $mediaItem->getUrl() }} | Uploaded At: {{ $mediaItem->created_at }}">
                        {{ $mediaItem->getFullName() }}
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @if($folder->hasChildren())
        <ul>
            @each('argon::media.folder-single', $folder->children, 'folder')
        </ul>
    @endif

</li>
