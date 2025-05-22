@extends('root')
@section('title', 'Menu Management')
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Menu Management',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Menu'
    ])

 <!-- Menampilkan pesan sukses -->
 @if (session('success'))
 <div class="alert alert-success">
     {{ session('success') }}
 </div>
@endif

 
    <div class="card card-body">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Transaksi">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <a href="{{route('menu.create')}}" href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center ">
                    <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Menu
                </a>
            </div>
        </div>
    </div>



    <div class="card card-body">

        <ul class="menu-list sortable" id="menu-sortable">
            
            @foreach ($menuss as $menu)
                <li class="menu-item" data-uuid="{{ $menu->uuid }}">
                    <div class="menu-content">
                        @if ($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endif
                        <span>{{ $menu->nama_menu }}</span>
                        <div class="actions">
                            <a href="{{ route('menu.create', ['parent'=>$menu->uuid]) }}" class="btn btn-info btn-sm"><i class="ti ti-plus"></i></a>
                            <a href="{{ route('menu.edit', $menu->uuid) }}" class="btn btn-warning btn-sm"><i class="ti ti-pencil"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-url="{{ route('menu.destroy', $menu->uuid) }}"><i class="ti ti-trash"></i></button>
                        </div>
                    </div>
                    <!-- Tampilkan submenu jika ada -->
                    @if ($menu->children->count() > 0)
                    <ul class="submenu-list sortable">
                        @foreach ($menu->children as $child)
                            <li class="menu-item" data-uuid="{{ $child->uuid }}">
                                <div class="menu-content">
                                    @if ($child->icon)
                                        <i class="{{ $child->icon }}"></i>
                                    @endif
                                    <span>{{ $child->nama_menu }}</span>
                                    <div class="actions">
                                        <a href="{{ route('menu.create', ['parent'=>$child->uuid]) }}"   class="btn btn-info btn-sm"><i class="ti ti-plus"></i></a>
                                        <a href="{{ route('menu.edit', $child->uuid) }}" class="btn btn-warning btn-sm"><i class="ti ti-pencil"></i></a>
                                        <button class="btn btn-danger btn-sm btn-delete" data-url="{{ route('menu.destroy', $child->uuid) }}"><i class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                                
                                {{-- Panggil kembali untuk children-nya --}}
                                @include('menu.render-menu', ['menu' => $child])
                            </li>
                        @endforeach
                    </ul>
                @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
    .menu-list, .submenu-list {
        list-style-type: none;
        padding-left: 20px;
    }
    .menu-item {
        margin: 5px 0;
        cursor: move; /* Menunjukkan bahwa item bisa di-drag */
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
    .menu-content .actions {
        margin-left: auto;
    }
    .menu-content .actions a {
        margin-left: 5px;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi SortableJS untuk menu utama
    const menuSortable = new Sortable(document.getElementById('menu-sortable'), {
        animation: 150,
        handle: '.menu-item', // Element yang bisa di-drag
        onEnd: function (evt) {
            updateOrder();
        },
    });

    // Fungsi untuk mengumpulkan urutan menu
    function updateOrder() {
    const order = [];
    $('#menu-sortable > .menu-item').each(function() {
        order.push($(this).data('uuid'));
    });

    $.ajax({
        url: '{{ route("menu.updateOrder") }}',
        type: 'POST',
        data: {
            order: order,
            _token: '{{ csrf_token() }}'
        },
        dataType:"JSON",
        success: function(response) {
                // Handle success
                console.log(response);
    
                if (response.meta.code === 200) {
                    // Reload DataTable
               
                    // Hide the modal
                    $('#successToast .msg-box').text(response.meta.message);
    
                    $('#successToast').toast('show');  // Menampilkan toast


                    if (reload) {
                        location.reload();
                    }
                
                } else {
                    // Handle unexpected response
                    alert('Gagal menyimpan data. Silakan coba lagi.');
                }
            },
            error: function(xhr) {
                    // $('#createModal').modal('hide');

    console.log(xhr);
               

                $('#failedToast .msg-box').text(xhr.responseJSON.meta.message);
    
    $('#failedToast').toast('show');  // Menampilkan toast

            }
    });
}

});
</script>
@endpush