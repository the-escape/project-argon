<li @if($menu->data->id) id="{{ $menu->data->id }}" @endif @if($menu->data->class) class="{{ $menu->data->class }}" @endif >

    <a href="{{ $menu->data->url }}" @if($menu->data->target) target="{{ $menu->data->target }}" @endif>
        {{ $menu->data->label }}
    </a>

    @if($menu->children)

        <ul>

            @foreach($menu->children as $child)

                @include("agron_menus::frontend.menu-items", ["menu" => $child])

            @endforeach

        </ul>

    @endif

</li>
