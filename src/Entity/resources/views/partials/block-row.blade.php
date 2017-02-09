<li class="block" data-id="{{ $entityGroup->id }}" data-name="{{ $entityGroup->name }}">
    <div class="block__overlay">
        <a href="{{ route('cms:pages:block', [$entity->id, $entityLocalisationId, $entityGroup->id]) }}" class="block__edit modal__link">Edit block content</a>
        <div class="block__actions">
            <a href="#" class="block__delete"></a>
            <span class="drag">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 10" class="ic-drag"><path d="M0 0h18v2H0zm0 4h18v2H0zm0 4h18v2H0z"/></svg>
            </span>
        </div>
    </div>
    <a href="#" class="block__add">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ic-add"><g><path d="M12 2A10 10 0 1 1 2 12 10 10 0 0 1 12 2m0-2a12 12 0 1 0 12 12A12 12 0 0 0 12 0z"/><path d="M11 6h2v12h-2z"/><path d="M6 11h12v2H6z"/></g></svg>
    </a>
    <div class="block__content">
        <div class="block__img">
            <img src="/blocks/{{ strtolower($entityGroup->name) }}.png" width="120" height="60" alt="{{ $entityGroup->name }}"/>
        </div>
        <div class="block__title">{{ $entityGroup->name }}</div>
    </div>
    <div class="block__status status status--{{ isset($entityGroupStatus) && $entityGroupStatus === 1 ? 'green' : 'red' }}"></div>
</li>
