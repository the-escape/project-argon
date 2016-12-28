<option value="{{$child->id}}" @if($child->getId() == $parentId) selected @endif>{{ $indent }}{{ $child->name }}</option>
@foreach($child->children as $child)
    @include('argon::media.folder-select-option', ['child'=>$child, 'indent'=>$indent.'- ', 'parentId'=>$parentId])
@endforeach