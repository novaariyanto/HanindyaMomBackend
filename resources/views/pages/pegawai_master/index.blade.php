@extends('root')
@section('title', 'Data '.$title)

@section('content')
<div class="">
    @include('components.breadcrumb', [
        'title' => $title,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => $title
    ])
    
    <style>
        #datatable_wrapper{
            max-width: 100% !important;
        }
    </style>
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-4 col-xl-3">
            <div class="me-3">
                <label for="filter-divisi" class="form-label visually-hidden">Filter Divisi</label>
                <select class="form-select" id="filter-divisi">
                    <option value="">Semua Divisi</option>

                </select>
            </div>
        </div>
          <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <div class="action-btn show-btn">
              <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center ">
                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
              </a>
            </div>
            <a data-url="{{route('pegawai-master.create')}}" href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center btn-create">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Pegawai
            </a>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
              <thead>
                <tr>
                    <th>NIK</th>

                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                    <th>User/No HP</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>


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
            ajax: {
                url: '{{ route("pegawai-master.index") }}',
                data: function (d) {
                    d.divisi_id = $('#filter-divisi').val(); // Kirim nilai filter divisi_id
                }
            },
            columns: [
                { data: 'nik', name: 'nik' },

                { data: 'nama_pegawai', name: 'nama' },
                { data: 'jabatan', name: 'jabatan.nama' },
                { data: 'divisi', name: 'divisi.nama' },
                { data: 'user', name: 'user' },
                { data: 'foto_url', name: 'foto_url' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
    });

    $('#input-search').on('keyup', function () {
        datatable
            .search(this.value)
            .draw();
    });

    $(document).on('change','#filter-divisi',function () {
            var val = $(this).val();
            $('#datatable').DataTable().ajax.reload();

        })

});

$(document).ready(function () {
    $('#filter-divisi').select2({
        placeholder: 'Pilih Divisi',
        allowClear: true,
        ajax: {
            url: '{{ route('select2.divisi') }}', // Endpoint untuk memuat data divisi
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // Query pencarian
                    page: params.page || 1 // Halaman saat ini
                };
            },
            processResults: function (data, params) {
                // Tambahkan opsi "Tampilkan Semua" di awal hasil
                let results = data.data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.nama
                    };
                });

                // Pastikan opsi "Tampilkan Semua" selalu ada
                results.unshift({ id: '', text: 'Tampilkan Semua' });

                return {
                    results: results,
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0, // Izinkan pencarian tanpa input karakter
    });
});


</script>
@endpush
