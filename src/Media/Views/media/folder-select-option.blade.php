@if($currentFolderId !== $child->getId())
    <option value="{{$child->id}}" @if($child->getId() == $parentFolderId) selected @endif>{{ $indent }}{{ $child->name }}</option>
    @foreach($child->children as $child)
        @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>$indent.'- ', 'parentFolderId'=>$parentFolderId, 'currentFolderId'=>$currentFolderId])
    @endforeach
@endif