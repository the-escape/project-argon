<li class="block" data-id="{{ $entityGroup->id }}" data-name="{{ strtolower($entityGroup->name) }}">
    <div class="block__loading"></div>
    <a href="#" class="block__add"></a>
    <a href="{{ route('cms:pages:block', [$entity->id, $entityLocalisationId, $entityGroupId]) }}" class="block__edit">Edit block content</a>
    <div class="block__actions">
        <a href="#" class="delete"></a>
        <span class="drag"></span>
    </div>
    <div class="block__img"></div>
    <div class="block__title">{{ $entityGroup->name }}</div>
</li>
