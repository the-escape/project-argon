<li>
    <a href="#" class="search__result" data-id="{{ $entity->id }}" data-parent="{{ $entity->parent_id }}">
        <span class="title"><i class="status status--green"></i>{{ $entity->name }}</span>
        <span class="date">{{ $entity->updated_at->format('d M Y') }}</span>
    </a>
</li>
