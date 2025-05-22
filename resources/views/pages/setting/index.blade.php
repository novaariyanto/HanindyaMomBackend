@extends('table')
@section('title', 'Data '.$title)

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data '.$title,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => $title
    ])
    
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                        <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Jabatan">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <a data-url="{{route('jabatan.create')}}" href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center btn-create">
                        <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Jabatan
                    </a>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Nama Jabatan</th>
                            <th>Deskripsi Jabatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated via DataTables AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('jabatan.index') }}',
        },
        columns: [
            { data: 'nama_jabatan', name: 'nama_jabatan' },
            { data: 'deskripsi_jabatan', name: 'deskripsi_jabatan' },
            { 
                data: 'action', 
                name: 'action', 
                searchable: false, 
                className: 'text-center fit-column' 
            },
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });
});
</script>
@endpush
