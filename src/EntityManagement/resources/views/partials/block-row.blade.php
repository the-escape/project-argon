<li class="block" data-id="{{ $group->id }}" data-name="{{ strtolower($group->name) }}">
    <a href="#" class="block__add"></a>
    <a href="{{ route('cms:pages:block', [$entity->id, $group->id]) }}" class="block__edit">Edit block content</a>
    <div class="block__actions">
        <a href="#" class="delete"></a>
        <span class="drag"></span>
    </div>
    <div class="block__img"></div>
    <div class="block__title">{{ isset($group) ? $group->name : 'Default Block' }}</div>
</li>
