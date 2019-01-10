<div class="c-widget">
    <div class="c-links-widget">
        @if(!empty($blogLink))
            <a class="c-links-widget__link" href="{{ $blogLink }}">
                <svg><use xlink:href="/argon/images/svgicons.svg#plus-large"></use></svg>
                <span>{{ $blogLabel or 'Create new blog post' }}</span>
            </a>
        @endif
        <a class="c-links-widget__link" href="{{ route('cms:media:manage') }}">
            <svg><use xlink:href="/argon/images/svgicons.svg#media-large"></use></svg>
            <span>Upload media</span>
        </a>
    </div>
</div>
