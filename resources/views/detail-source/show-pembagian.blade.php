@extends('root')

@section('title', 'Detail Source - ' . $detail->id)

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Source - ' . $detail->id,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-source.index'), 'label' => 'Remunerasi Source'],
            ['url' => route('detail-source.listBySource', $detail->id), 'label' => 'Detail Source'],
        ],
        'current' => 'Detail'
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Detail</h5>
                    <div>
                        <a href="{{ route('detail-source.listBySource', $detail->id) }}" class="btn btn-secondary">
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
                                    <td>{{ $detail->nama_source ?? '-' }}</td>
                                </tr>
                              
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $detail->keterangan ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Batch</th>
                                    <td>{{ $detail->batch->nama_batch ?? '-'}}</td>
                                </tr>   
                              
                                <tr>
                                    <th>Status Pembagian</th>
                                    <td>
                                        @if($detail->status == "aktif")
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non Aktif</span>
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
                                                <td class="text-end">Rp {{ number_format($result->biaya_riil_rs ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                           
                                            <tr>
                                                <th>Biaya di Setujui</th>
                                                <td class="text-end">Rp {{ number_format($result->biaya_disetujui ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                           
                                            <tr class="table-info">
                                                <th>Total Remunerasi</th>
                                                <td class="text-end">Rp {{ number_format($result->total ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr class="table-primary">
                                                <th>Persentase</th>
                                                <td class="text-end">
                                                    @if($result->biaya_disetujui > 0)
                                                        {{ number_format(($result->total / $result->biaya_disetujui) * 100, 2) }}%
                                                    @else
                                                        0,00%
                                                    @endif
                                                </td>
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
                 
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="filter_nama_ppa" class="form-label">Filter PPA</label>
                            <select class="form-select" id="filter_nama_ppa">
                                <option value="">Semua PPA</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter_sumber" class="form-label">Filter Sumber</label>
                            <select class="form-select" id="filter_sumber">
                                <option value="">Semua Sumber</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter_cluster" class="form-label">Filter Cluster</label>
                            <select class="form-select" id="filter_cluster">
                                <option value="">Semua Cluster</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter_ppa" class="form-label">Filter Jenis PPA</label>
                            <select class="form-select" id="filter_ppa">
                                <option value="">Semua Jenis PPA</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter_grade" class="form-label">Filter Grade</label>
                            <select class="form-select" id="filter_grade">
                                <option value="">Semua Grade</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filter_jenis" class="form-label">Filter Jenis</label>
                            <select class="form-select" id="filter_jenis">
                                <option value="">Semua Jenis</option>
                            </select>
                        </div>
                           <div class="col-md-2">
                            <label for="filter_groups" class="form-label">Filter Groups</label>
                            <select class="form-select" id="filter_group">
                                <option value="">Semua Group</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-secondary btn-sm" id="resetFilters">
                                <i class="ti ti-refresh"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped" id="pembagianKlaimTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sep</th>
                                    <th>PPA</th>
                                    <th>Sumber</th>
                                    <th>Cluster</th>
                                    <th>Jenis PPA</th>
                                    <th>Grade</th>
                                    <th>Jenis</th>
                                    <th>Group</th>
                                    <th>Nilai Remunerasi</th>
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
        ajax: {
            url: "{{ route('pembagian-klaim.getByDetailSourcebySource', $detail->id) }}",
            data: function (d) {
                d.filter_nama_ppa = $('#filter_nama_ppa').val();
                d.filter_sumber = $('#filter_sumber').val();
                d.filter_cluster = $('#filter_cluster').val();
                d.filter_ppa = $('#filter_ppa').val();
                d.filter_grade = $('#filter_grade').val();
                d.filter_jenis = $('#filter_jenis').val();
                d.filter_group = $('#filter_group').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
             { data: 'sep', name: 'sep' },
            { data: 'nama_ppa', name: 'nama_ppa' },
            { data: 'sumber', name: 'sumber' },
            { data: 'cluster', name: 'cluster' },
            { data: 'ppa', name: 'ppa' },
            { data: 'grade', name: 'grade' },
            { data: 'jenis', name: 'jenis' },
            { data: 'groups', name: 'groups' },
            {
                data: 'nilai_remunerasi',
                name: 'nilai_remunerasi',
                className: 'text-end'
            },

           
           
        ],
        order: [[1, 'desc']],
        scrollX: true
    });

    // Load filter data initially to populate filters
    $.ajax({
        url: "{{ route('pembagian-klaim.getFilterDataBySource', $detail->id) }}",
        success: function(response) {
            
            if (response.status === 'success') {
                var filters = response.data;
                console.log(filters);

                // Populate initial filter dropdowns
                Object.keys(filters).forEach(function(filterKey) {
                    var select = $('#filter_' + filterKey);
                    filters[filterKey].forEach(function(value) {
                        if (value ) {
                            select.append(new Option(value, value));
                        }
                    });
                });
            }
        }
    });

    // Handle filter changes
    $('#filter_nama_ppa, #filter_sumber, #filter_cluster, #filter_ppa, #filter_grade, #filter_jenis,#filter_group').on('change', function() {
        pembagianKlaimTable.draw();
    });

    // Handle reset filters
    $('#resetFilters').on('click', function() {
        $('#filter_nama_ppa, #filter_sumber, #filter_cluster, #filter_ppa, #filter_grade, #filter_jenis,#filter_group').val('');
        pembagianKlaimTable.draw();
    });

    // Handle Delete Button Click
  
});
</script>
@endpush 