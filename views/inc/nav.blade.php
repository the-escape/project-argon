<?php /*
<nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
    <ul class="nav navbar-nav pull-xs-right">
        @if($currentUser->hasPermission('cms:settings'))
            <li class="nav-item"><a class="nav-link" href="{{ route('settings') }}">Settings</a></li>
        @endif
        <li class="nav-item"><a class="nav-link" href="{{ route('cms:user:profile') }}">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
    </ul>
    <a class="navbar-brand" href="{{ route('dashboard') }}"><img class="logo-admin" src="{{config('argon.client_logo_light', '/argon/images/logo.png')}}" alt="{{config('argon.client_name', 'Argon')}}"></a>
</nav>
*/ ?>


<div class="c-sidebar js-sidebar">
    <div class="c-sidebar__overlay"></div>

    <div class="c-sidebar__container">
		<div class="c-user">
            <div class="c-user__img">
                <img src="{{config('argon.client_logo_light', '/argon/images/logo.png')}}" alt="{{config('argon.client_name', 'Argon')}}">
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

		<a class="c-sidebar__logo" href="/dashboard">
			<img alt="logo" src="/argon/images/e.png">
		</a>
	</div>

</div>