@if ($menu->children->count() > 0)
    <ul class="submenu-list">
        @foreach ($menu->children as $child)
            <li class="menu-item">
                <div class="menu-content">
                    @if ($child->icon)
                        <i class="{{ $child->icon }}"></i>
                    @endif
                    <span>{{ $child->nama_menu }}</span>
                    <div class="actions">
                        <a  href="{{ route('menu.create', ['parent'=>$child->uuid]) }}"  class="btn btn-info btn-sm"><i class="ti ti-plus"></i></a>
                        <a href="{{ route('menu.edit', $child->uuid) }}" class="btn btn-warning btn-sm"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="{{ route('menu.destroy', $child->uuid) }}"><i class="ti ti-trash"></i></button>
                    </div>
                </div>

                {{-- Rekursi untuk anaknya --}}
                @include('menu.render-menu', ['menu' => $child])
            </li>
        @endforeach
    </ul>
@endif
