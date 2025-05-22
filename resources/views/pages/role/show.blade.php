@extends('root')
@section('title', 'Detail Role')
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Role',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('role.index'), 'label' => 'Roles'],
        ],
        'current' => 'Detail Role'
    ])
    
    <div class="card card-body">
        <h3 class="mb-3">Detail Role: {{ $role->name }}</h3>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <p>{{ $role->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Guard Name</label>
                    <p>{{ $role->guard_name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tanggal Dibuat</label>
                    <p>{{ $role->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Diperbarui</label>
                    <p>{{ $role->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
       
    </div>

    <div class="card card-body">
        
<form action="{{ route('role.menu.store',$id) }}" method="POST" id="form">
        


        <!-- Tampilkan daftar menu yang sudah ditetapkan ke role -->
        <h4 class="mt-4 mb-3">Menu</h4>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check-all">
            <label class="form-check-label" for="check-all">Pilih Semua</label>
        </div>

        
        <ul class="menu-list sortable" id="menu-sortable">
            @foreach ($menuss as $menu)
                <li class="menu-item" data-uuid="{{ $menu->uuid }}">
                    <div class="menu-content">
                        <div class="form-check">
                            <input {{in_array($menu->id,$menuse)?'checked':''}} class="form-check-input" type="checkbox" name="menus[]" value="{{ $menu->uuid }}" id="checkbox-{{ $menu->uuid }}">
                            <label class="form-check-label" for="checkbox-{{ $menu->uuid }}">
                                @if ($menu->icon)
                                    <i class="{{ $menu->icon }}"></i>
                                @endif
                                <span>{{ $menu->nama_menu }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Tampilkan submenu jika ada -->
                    @if ($menu->children->count() > 0)
                        <ul class="submenu-list sortable">
                            @foreach ($menu->children as $child)
                                <li class="menu-item" data-uuid="{{ $child->uuid }}">
                                    <div class="menu-content">
                                        <div class="form-check">
                                            <input {{in_array($child->id,$menuse)?'checked':''}} class="form-check-input" type="checkbox" name="menus[]" value="{{ $child->uuid }}" id="checkbox-{{ $child->uuid }}">
                                            <label class="form-check-label" for="checkbox-{{ $child->uuid }}">
                                                @if ($child->icon)
                                                    <i class="{{ $child->icon }}"></i>
                                                @endif
                                                <span>{{ $child->nama_menu }}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Panggil kembali untuk children-nya -->
                                    @if ($child->children->count() > 0)
                                    <ul class="submenu-list">
                                        @foreach ($child->children as $grandchild)
                                            <li class="menu-item">
                                                <div class="menu-content">
                                                    <div class="form-check">
                                                        <input {{in_array($grandchild->id,$menuse)?'checked':''}} class="form-check-input" type="checkbox" name="menus[]" value="{{ $grandchild->uuid }}" id="checkbox-{{ $grandchild->uuid }}">
                                                        <label class="form-check-label" for="checkbox-{{ $grandchild->uuid }}">
                                                            @if ($grandchild->icon)
                                                                <i class="{{ $grandchild->icon }}"></i>
                                                            @endif
                                                            <span>{{ $grandchild->nama_menu }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary">Simpan</button>

</form>


    </div>
</div>


<style>
    .menu-list, .submenu-list {
        list-style-type: none;
        padding-left: 20px;
    }
    .menu-item {
        margin: 5px 0;
        background-color: #f9f9f9;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: move;
    }
    .menu-content {
        display: flex;
        align-items: center;
    }
    .menu-content i {
        margin-right: 10px;
        font-size: 16px;
        width: 20px;
        text-align: center;
        vertical-align: middle;
    }
    .form-check {
        display: flex;
        align-items: center;
    }
    .form-check .form-check-input {
        margin-right: 10px;
    }
    .menu-placeholder {
        border: 2px dashed #ccc;
        background-color: #f0f0f0;
        margin: 5px 0;
        height: 40px;
        border-radius: 5px;
    }
    .ui-sortable-helper {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .submenu-list .menu-content i {
        font-size: 16px;
    }
    .form-check-label {
        display: flex;
        align-items: center;
        font-size: 14px;
    }
    .form-check-label i {
        margin-right: 8px;
    }
</style>

@endsection
@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
<script>
    $(document).ready(function() {
        // Inisialisasi sortable untuk menu utama dan submenu
        $('.sortable').sortable({
            handle: '.menu-content',
            placeholder: 'menu-placeholder',
            connectWith: '.sortable',
            update: function(event, ui) {
                // Mengumpulkan urutan menu
                var menuOrder = [];
                $('.menu-item').each(function() {
                    menuOrder.push($(this).data('uuid'));
                });
                
                // Kirim urutan menu ke server
                $.ajax({
                    url: '{{ route("menu.reorder") }}',
                    method: 'POST',
                    data: {
                        order: menuOrder,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Urutan menu berhasil diperbarui');
                    },
                    error: function(xhr) {
                        console.error('Gagal memperbarui urutan menu');
                    }
                });
            }
        }).disableSelection();

        // Ketika checkbox anak dicentang, centang juga parent-nya
        $('.submenu-list .form-check-input').on('change', function() {
            var parentCheckbox = $(this).closest('.menu-item').parents('ul').closest('.menu-item').find('.form-check-input');

            // Jika checkbox anak dicentang, centang parent
            if ($(this).prop('checked')) {
                parentCheckbox.prop('checked', true);
            }
            // Jika checkbox anak tidak dicentang, periksa apakah harus mencentang parent
            else {
                var anyChildChecked = $(this).closest('.submenu-list').find('.form-check-input:checked').length > 0;
                if (!anyChildChecked) {
                    parentCheckbox.prop('checked', false);
                }
            }
        });

        // Ketika checkbox parent dicentang, centang semua children-nya
        $('.menu-list .form-check-input').on('change', function() {
            var childrenCheckboxes = $(this).closest('.menu-item').find('.submenu-list .form-check-input');

            // Jika checkbox parent dicentang, centang semua children
            if ($(this).prop('checked')) {
                childrenCheckboxes.prop('checked', true);
            }
            // Jika checkbox parent tidak dicentang, hilangkan centang pada semua children
            else {
                childrenCheckboxes.prop('checked', false);
            }
        });

        // Ketika checkbox "Pilih Semua" dicentang, centang semua checkbox di dalam menu
        $('#check-all').on('change', function() {
            var isChecked = $(this).prop('checked');
            // Centang atau hilangkan centang semua checkbox
            $('.form-check-input').prop('checked', isChecked);
        });
    });
</script>
@endpush