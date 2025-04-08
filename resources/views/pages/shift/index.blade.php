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
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Shift...">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <div class="action-btn show-btn">
              <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center ">
                <i class="ti ti-trash me-1 fs-5"></i> Hapus Semua Terpilih
              </a>
            </div>
            <a href="{{ route('shift.export') }}" class="btn btn-success d-flex align-items-center me-2">
              <i class="ti ti-download text-white me-1 fs-5"></i> Export
          </a>
          <!-- Tombol Import -->
          <button type="button" class="btn btn-warning d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#importModal">
              <i class="ti ti-upload text-white me-2 fs-5"></i> Import
          </button>


          <button data-url="{{ route($slug.'.create') }}"  type="button" class="btn btn-info d-flex align-items-center btn-create"  style="margin-left: 5px;">
            <i class="ti ti-upload text-white me-2 fs-5"></i> Tambah {{$title}}
        </button>


    
          </div>
        </div>
      </div>

      <!-- Filter Divisi -->
      <div class="card card-body">
        <div class="row mb-3">
         
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                      <th>Kode Shift</th>
                      <th>Nama Shift</th>
                      <th>Status</th>
                      <th>Keterangan</th>
                      <th>Opsi</th>
                  </tr>
              </thead>
              <tbody>
                  <!-- Data akan diisi melalui DataTables AJAX -->
              </tbody>
            </table>
        </div>
      </div>
    </div>
</div>


<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="importModalLabel">Import Data Shift</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('shift.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="file" class="form-label">Pilih File Excel</label>
                      <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.csv" required>
                      <small class="text-muted">File harus berformat Excel (.xlsx) atau CSV.</small>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Import</button>
              </div>
          </form>
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
            url: '{{ route($slug.'.index') }}',
            data: function (d) {
                // Kirim nilai filter divisi ke backend
                d.divisi_id = $('#filter-divisi').val();
            }
        },
        columns: [
            {
                data: 'kode_shift',
                name: 'kode_shift',
            },
            {
                data: 'nama_shift',
                name: 'nama_shift',
            },
            {
                data: 'status_raw',
                name: 'status_raw',
                searchable: false,
                className: 'text-center',
            },
            {
                data: 'keterangan',
                name: 'keterangan',
                searchable: true,
            },
            {
                data: 'action',
                name: 'action',
                searchable: false,
                className: 'text-center fit-column',
            },
        ]
    });

    // Fungsi pencarian
    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

    // Fungsi filter divisi
    $('#filter-divisi').on('change', function () {
        datatable.ajax.reload(); // Reload DataTable saat filter divisi berubah
    });
});
</script>
@endpush