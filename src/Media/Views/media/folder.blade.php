<li id="folder-{{$folder->id}}">
    {{ $folder->name }}
    @if ($folder->hasChildren())
	<ul>
	    @each('argon::media.folder', $folder->children, 'folder')
	</ul>
    @endif
</li>
