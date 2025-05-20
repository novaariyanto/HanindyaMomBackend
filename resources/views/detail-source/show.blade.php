@extends('root')

@section('title', 'Detail Source - ' . $detail->no_sep)

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Source - ' . $detail->no_sep,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-source.index'), 'label' => 'Remunerasi Source'],
            ['url' => route('detail-source.listBySource', $detail->id_remunerasi_source), 'label' => 'Detail Source'],
        ],
        'current' => 'Detail'
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Detail</h5>
                    <div>
                        <a href="{{ route('detail-source.listBySource', $detail->id_remunerasi_source) }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-warning btn-edit" data-url="{{ route('detail-source.show', $detail->id) }}">
                            <i class="ti ti-pencil"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-delete" data-url="{{ route('detail-source.destroy', $detail->id) }}">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Remunerasi Source</th>
                                    <td>{{json_encode($detail->remunerasiSource2)}}</td>
                                </tr>
                                <tr>
                                    <th>No SEP</th>
                                    <td>{{ $detail->no_sep }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Verifikasi</th>
                                    <td>{{ $detail->tgl_verifikasi }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td>{{ $detail->jenis }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($detail->status == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Biaya</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Biaya Riil RS</th>
                                                <td class="text-end">{{ number_format($detail->biaya_riil_rs, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Diajukan</th>
                                                <td class="text-end">{{ number_format($detail->biaya_diajukan, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="table-info">
                                                <th>Biaya Disetujui</th>
                                                <td class="text-end">{{ number_format($detail->biaya_disetujui, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Timestamp</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tr>
                                                <th>Dibuat</th>
                                                <td>{{ $detail->created_at->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Diupdate</th>
                                                <td>{{ $detail->updated_at->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pembagian Klaim -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pembagian Klaim</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPembagianKlaimModal">
                        <i class="ti ti-plus"></i> Tambah Pembagian Klaim
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="pembagianKlaimTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>PPA</th>
                                    <th>Sumber</th>
                                    <th>Cluster</th>
                                    <th>Jenis PPA</th>
                                    <th>Nilai Remunerasi</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated via DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
{{-- @include('detail-source.modals.edit') --}}

<!-- Modal Pembagian Klaim -->
@include('pembagian-klaim.modals.create')
@include('pembagian-klaim.modals.edit')

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle Edit Button Click
    $('.btn-edit').on('click', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.status === 'success') {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_no_sep').val(data.no_sep);
                $('#edit_tgl_verifikasi').val(data.tgl_verifikasi);
                $('#edit_jenis').val(data.jenis);
                $('#edit_status').val(data.status);
                $('#edit_biaya_riil_rs').val(data.biaya_riil_rs);
                $('#edit_biaya_diajukan').val(data.biaya_diajukan);
                $('#edit_biaya_disetujui').val(data.biaya_disetujui);
                $('#editModal').modal('show');
            }
        });
    });

    // Initialize DataTable for Pembagian Klaim
    var pembagianKlaimTable = $('#pembagianKlaimTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pembagian-klaim.getByDetailSource', $detail->id) }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_ppa', name: 'nama_ppa' },
            { data: 'sumber', name: 'sumber' },
            { data: 'cluster', name: 'cluster' },
            { data: 'ppa', name: 'ppa' },
            {
                data: 'nilai_remunerasi',
                name: 'nilai_remunerasi',
                className: 'text-end',
                render: function(data) {
                    if (isNaN(data) || data === null) return 'Rp 0';

                    let number = parseFloat(data);
                    return 'Rp ' + number.toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                }
            },

           
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        language: {
            url: "{{ asset('assets/js/id.json') }}"
        },
        scrollX: true
    });

    // Handle Delete Button Click
    $(document).on('click', '.btn-delete', function() {
        var url = $(this).data('url');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.meta.status === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                response.meta.message,
                                'success'
                            ).then(() => {
                                pembagianKlaimTable.ajax.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.meta.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endpush 