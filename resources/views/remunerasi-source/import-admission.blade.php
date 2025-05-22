@extends('layouts.app')

@section('title', 'Import Data Admission')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Import Data Admission</h3>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select class="form-control" name="tahun" id="tahun">
                                            @php
                                                $currentYear = date('Y');
                                                $startYear = $currentYear - 5;
                                            @endphp
                                            @for($year = $currentYear; $year >= $startYear; $year--)
                                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <select class="form-control" name="bulan" id="bulan">
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{ $month }}" {{ $month == date('n') ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Batch</label>
                                        <select class="form-control" name="batch_id" id="batch_id" required>
                                            <option value="">Pilih Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search"></i> Cari Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="admissionTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="check-all">
                                        </th>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Kelas</th>
                                        <th>Total Biaya</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" id="importButton" class="btn btn-success" disabled>
                                <i class="fas fa-file-import"></i> Import Data Terpilih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let table = $('#admissionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('remunerasi-source.import-admission') }}",
            data: function(d) {
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
            }
        },
        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },
            {data: 'norm', name: 'norm'},
            {data: 'pasien.NAMA', name: 'pasien.NAMA'},
            {
                data: 'masukrs',
                name: 'masukrs',
                render: function(data) {
                    return moment(data).format('DD/MM/YYYY');
                }
            },
            {
                data: 'keluarrs',
                name: 'keluarrs',
                render: function(data) {
                    return moment(data).format('DD/MM/YYYY');
                }
            },
            {data: 'kelas', name: 'kelas'},
            {
                data: 'total_tarif_rs',
                name: 'total_tarif_rs',
                render: function(data) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data);
                }
            }
        ],
        order: [[3, 'desc']]
    });

    // Handle filter form submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });

    // Handle check all
    $('#check-all').on('click', function() {
        $('.admission-checkbox').prop('checked', $(this).prop('checked'));
        toggleImportButton();
    });

    // Handle individual checkbox
    $(document).on('change', '.admission-checkbox', function() {
        toggleImportButton();
    });

    function toggleImportButton() {
        let checkedCount = $('.admission-checkbox:checked').length;
        $('#importButton').prop('disabled', checkedCount === 0);
    }

    // Handle import button
    $('#importButton').on('click', function() {
        let selectedIds = [];
        $('.admission-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire('Error', 'Pilih minimal satu data untuk diimport', 'error');
            return;
        }

        let batchId = $('#batch_id').val();
        if (!batchId) {
            Swal.fire('Error', 'Pilih batch terlebih dahulu', 'error');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin akan mengimport data yang dipilih?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Import',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('remunerasi-source.store-from-admission') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        admission_ids: selectedIds,
                        batch_id: batchId
                    },
                    success: function(response) {
                        Swal.fire('Sukses', response.message, 'success')
                        .then(() => {
                            window.location.href = "{{ route('remunerasi-source.index') }}";
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON.message || 'Terjadi kesalahan', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
