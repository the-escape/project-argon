<li id="node-{{$entity->id}}">{{$entity->name}}
    @if ($entity->hasChildren())
        <ul>
            @each('argon::pages.tree.item', $entity->getChildren(), 'entity')
        </ul>
    @endif
</li>
