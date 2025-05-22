<li class="sidebar-item">
    <a class="sidebar-link {{ $menu->children->count() > 0 ? 'has-arrow' : '' }}" href="{{ $menu->route!='#' ? route($menu->route) : 'javascript:void(0)' }}" aria-expanded="false">
        @if ($menu->icon)
            <span><i class="{{ $menu->icon }}"></i></span>
        @endif
        <span class="hide-menu">{{ $menu->nama_menu }}</span>
    </a>
    @if ($menu->children->count() > 0)
        <ul class="collapse first-level">
            @foreach ($menu->children as $child)
                @include('menu.menu-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>