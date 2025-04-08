@extends('root')
@section('title',$divisi->nama)

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => $divisi->nama,
        'links' => [['url' => route('divisi.index'), 'label' => 'Divisi']],
        'current' => $divisi->nama,
    ])

    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <!-- Informasi Divisi -->
                <div class="col-md-6">
                    <h5 class="card-title">Informasi </h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Nama Divisi</th>
                                <td>{{ $divisi->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Pegawai</th>
                                <td>{{$divisi->pegawaiMasters->count()}}</td>

                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $divisi->keterangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-underline p-3 mb-3 rounded align-items-center card flex-row" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#shift-tab" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 active" data-bs-toggle="tab" aria-selected="true" role="tab">
                    <i class="ti ti-list fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Shift</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#pegawai-tab" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                    <i class="ti ti-users fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Pegawai</span>
                </a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content">
            <!-- Tab Shift -->
            <div class="tab-pane fade active show" id="shift-tab" role="tabpanel">
                <div class="card card-body">
                    <h5>Daftar Shift</h5>
                    <div class="wrap-table">

                    </div>
                </div>
            </div>

            <!-- Tab Pegawai -->
            <div class="tab-pane fade" id="pegawai-tab" role="tabpanel">
                <div class="card card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Daftar Pegawai</h5>
                        <!-- Tombol ditambahkan di sini -->
                        <button class="btn btn-primary btn-create" data-url="{{route('pegawai-master.create',['divisi_id'=>$divisi->uuid])}}"  id="tambah-pegawai-btn">Tambah Pegawai</button>
                    </div>
                    <table id="pegawai-table" class="table table-bordered" style="width: 100%;">

                        <thead>
                            <tr>
                                <th>NIK</th>

                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
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
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        // DataTable for Shift
        // $('#shift-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('shift.index') }}",
        //     columns: [
        //         { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        //         { data: 'nama_shift', name: 'nama_shift' },
        //         { data: 'kode_shift', name: 'kode_shift' },
        //         { data: 'status', name: 'status' },
        //         { data: 'action', name: 'action', orderable: false, searchable: false },
        //     ],
        // });

        // DataTable for Pegawai
        // $('#pegawai-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ route('pegawai.index') }}",
        //     columns: [
        //         { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        //         { data: 'nama', name: 'nama' },
        //         { data: 'jabatan', name: 'jabatan' },
        //         { data: 'status', name: 'status' },
        //         { data: 'action', name: 'action', orderable: false, searchable: false },
        //     ],
        // });
    });



    $(document).ready(function () {
        let table = $('#pegawai-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("pegawai-master.index") }}',
                data: function (d) {
                    d.divisi_id = "{{$divisi->id}}"
                }
            },
            columns: [
                { data: 'nik', name: 'nik' },

                { data: 'nama_pegawai', name: 'nama' },
                { data: 'jabatan', name: 'jabatan.nama' },
                { data: 'divisi', name: 'divisi.nama' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Refresh DataTable saat dropdown filter berubah
        $('#divisi_filter').on('change', function () {
            table.ajax.reload();
        });

        $('#successToast').on('shown.bs.toast', function () {
table.ajax.reload();
});

    });


    $(document).ready(function() {
    var datatable = $('#table-shift').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('shift.index') }}',
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



load_table(); // Panggil saat halaman pertama kali dimuat

            function load_table() {
                if (window.isLoading) return; // Cegah request berulang sebelum selesai

                window.isLoading = true;

                var divisi ="{{$divisi->id}}";

                $.ajax({
                    data:{
                        divisi:divisi,
                        action:false
                    },
                    type: "GET",
                    url: "{{route('jam-kerja.table')}}",
                    success: function(response) {
                        $('.wrap-table').html(response);
                    },
                    complete: function() {
                        window.isLoading = false; // Reset status loading
                    }
                });
            }




</script>
@endpush