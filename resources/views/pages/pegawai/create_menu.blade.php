<form action="{{ route('role.menu.store',$id) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Menu </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="check-all">
            <label class="form-check-label" for="check-all">Pilih Semua</label>
        </div>

        

        <ul class="menu-list sortable" id="menu-sortable">
            @foreach ($menuss as $menu)
                <li class="menu-item" data-uuid="{{ $menu->uuid }}">
                    <div class="menu-content">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="menus[]" value="{{ $menu->uuid }}" id="checkbox-{{ $menu->uuid }}">
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
                                            <input class="form-check-input" type="checkbox" name="menus[]" value="{{ $child->uuid }}" id="checkbox-{{ $child->uuid }}">
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
                                                        <input class="form-check-input" type="checkbox" name="menus[]" value="{{ $grandchild->uuid }}" id="checkbox-{{ $grandchild->uuid }}">
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

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

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
    }
    .menu-content {
        display: flex;
        align-items: center;
    }
    .menu-content i {
        margin-right: 10px;
    }
    .form-check {
        display: flex;
        align-items: center;
    }
    .form-check .form-check-input {
        margin-right: 10px;
    }
</style>

<script>
    $(document).ready(function() {
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
});

$(document).ready(function() {
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