<li class="block" data-id="{{ $entityGroup->id }}" data-name="{{ strtolower($entityGroup->name) }}">
    <div class="block__loading"></div>
    <div class="block__overlay">
        <a href="{{ route('cms:pages:block', [$entity->id, $entityLocalisationId, $entityGroup->id]) }}" class="block__edit">Edit block content</a>
        <a href="#" class="block__add"></a>
        <div class="block__actions">
            <a href="#" class="block__delete"></a>
            <span class="drag"></span>
        </div>
    </div>
    <div class="block__content">
        <div class="block__img"></div>
        <div class="block__title">{{ $entityGroup->name }}</div>
    </div>
    <div class="block__status">
        <span class="status status--green"></span>
    </div>
</li>
