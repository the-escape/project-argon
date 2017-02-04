<li>
    <a href="{{ $page->toPage()->getUrl() }}">{{ $page->name }}</a>
    @if ($page->hasChildren())
        <ul>
            @each('argon::pages.partials.sitemap-item', $page->getChildren(), 'page')
        </ul>
    @endif
</li>
