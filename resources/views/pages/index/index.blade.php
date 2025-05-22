@extends('root')
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
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari ">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <div class="action-btn show-btn">
              <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center ">
                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
              </a>
            </div>
            <a data-url="{{route('index.create')}}" href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center btn-create">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Index
            </a>
          </div>
        </div>
      </div>

      <div class="card card-body">
       <div class="col-lg-4">
            <h5>Import Data dari Excel</h5>
            <form action="{{ route('index.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center gap-2">
                    <div class="flex-grow-1">
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
       </div>
       <br>
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Index</th>
                      <th>Grup</th>
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
            url: '{{ route('index.index') }}',
        },
        columns: [
            {
                data: null, // Tidak terkait dengan kolom tertentu
                name: 'no', // Nama kolom untuk nomor urut
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; // Menghitung nomor urut
                },
                searchable: false,
                orderable: false,
                className: 'text-center fit-column',
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'index',
                name: 'index',
            },
            {
                data: 'kategori_nama',
                name: 'kategori.nama',
            },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                className: 'text-center fit-column',
            },
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable
            .search(this.value)
            .draw();
    });
});
</script>
@endpush
