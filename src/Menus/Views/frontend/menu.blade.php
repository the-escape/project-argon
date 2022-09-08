@if(isset($menu))

    <ul id="menu-{{ $menu->id }}" class="{{ $menu->slug }}">

        @foreach($menu->menu as $m)

            @include("argon_menus::frontend.menu-items", ["menu" => $m])

        @endforeach

    </ul>

@endif
