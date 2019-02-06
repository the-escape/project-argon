<div class="c-sidebar js-sidebar">
    <div class="c-sidebar__overlay"></div>

    <div class="c-sidebar__container">
        <div class="c-user">
            <div class="c-user__img">
                <img src="{{ auth()->user()->profile('image','/argon/images/user-icon.png') }}">
            </div>
            <span class="c-user__name">{{ $currentUser->name }}</span>
            <a href="{{ route('logout') }}" class="c-user__logout">
                <svg><use xlink:href="/argon/images/svgicons.svg#logout"></use></svg>
            </a>
        </div>

        <nav>
            @foreach ($plugins->getNavLinksForUser($currentUser) as $group)
                <ul class="c-navigation">
                    @foreach ($group as $plugin)
                        @if($currentUser->hasPermission($plugin->access))
                            <li class="c-navigation__item">
                                <a class="c-navigation__link {{ $plugin->active ? 'active' : '' }}" href="{{ $plugin->url }}">
                                    <div class="c-navigation__icon c-navigation__icon--{{ $plugin->icon }}">
                                        <svg><use xlink:href="/argon/images/svgicons.svg#{{ $plugin->icon }}"></use></svg>
                                    </div>
                                    <div class="c-navigation__text">{{ $plugin->name }}</div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        </nav>

        <a class="c-sidebar__logo" href="http://www.the-escape.co.uk/?utm_source={{ urlencode(config('argon.client_name','')) }}&amp;utm_medium=website&amp;utm_campaign=cms_link" target="_blank">
            <svg><use xlink:href="/argon/images/svgicons.svg#escape"></use></svg>
        </a>
    </div>
</div>
