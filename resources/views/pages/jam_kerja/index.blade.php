@extends('root')
@section('title', 'Data Jam Kerja')
@section('content')
    <div class="p-2">
        @include('components.breadcrumb', [
            'title' => 'Data Jam Kerja',
            'links' => [['url' => route('dashboard'), 'label' => 'Dashboard']],
            'current' => 'Jam Kerja',
        ])
        <div class="widget-content searchable-container list">
            <!-- Notifikasi Sukses -->



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
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn">
                            <a href="javascript:void(0)"
                                class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center ">
                                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
                            </a>
                        </div>
                       
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <div class="card card-body">
               
                    <div class="wrap-table">

                    </div>
            </div>
        </div>

        <!-- Modal Import -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Jam Kerja</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('jam-kerja.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File Excel</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".xlsx, .xls, .csv" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>



load_table(); // Panggil saat halaman pertama kali dimuat

            function load_table() {
                if (window.isLoading) return; // Cegah request berulang sebelum selesai

                window.isLoading = true;

                var divisi = $('#filter-divisi').val();

                $.ajax({
                    data:{
                        divisi:divisi
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

            

            // Auto-refresh tabel setiap 5 detik
            $('#successToast').on('shown.bs.toast', function () {
load_table();
});


        $(document).on('change','#filter-divisi',function () {
            var val = $(this).val();
            load_table();
        })
        
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
