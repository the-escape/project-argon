<li id="node-{{$entity->id}}"
    data-type="{{$entity->type->name}}"
    title="Content type: '{{$entity->type->name}}'" {{ !$entity->hasChildren() ? 'data-deletable=true' : '' }}>{{$entity->name}}
    @if ($entity->hasChildren())
        <ul>
            @each('argon::pages.tree.item', $entity->getChildren(), 'entity')
        </ul>
    @endif
</li>
