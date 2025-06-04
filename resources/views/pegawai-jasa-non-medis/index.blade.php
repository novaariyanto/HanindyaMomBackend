@extends('root')
@section('title', 'Pegawai Jasa Non Medis')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Pegawai Jasa Non Medis',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Pegawai Jasa Non Medis'
    ])
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Data Pegawai Jasa Non Medis</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="col-md-4">
                            <form class="position-relative">
                                <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Data">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                        </div>
                        <div>
                            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Data
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jasa Non Medis</th>
                                    <th>Nilai</th>
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
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pegawai Jasa Non Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('pegawai-jasa-non-medis.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select class="form-select" name="pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jasa Non Medis</label>
                        <select class="form-select" name="jasa_id" required>
                            <option value="">Pilih Jasa Non Medis</option>
                            @foreach($jasa as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_indeks }} ({{ $j->nilai }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" required min="0" placeholder="Akan terisi otomatis saat jasa dipilih">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pegawai Jasa Non Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select class="form-select" name="pegawai_id" id="edit_pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nip }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jasa Non Medis</label>
                        <select class="form-select" name="jasa_id" id="edit_jasa_id" required>
                            <option value="">Pilih Jasa Non Medis</option>
                            @foreach($jasa as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_indeks }} ({{ $j->nilai }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" id="edit_nilai" required min="0" placeholder="Akan terisi otomatis saat jasa dipilih">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
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
            url: '{{ route('pegawai-jasa-non-medis.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'pegawai_nama',
                name: 'pegawai_nama'
            },
            {
                data: 'jasa_nama',
                name: 'jasa_nama'
            },
            {
                data: 'nilai',
                name: 'nilai',
                render: function(data) {
                    return parseFloat(data).toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

    // Data jasa untuk auto-fill nilai
    var jasaData = {
        @foreach($jasa as $j)
            {{ $j->id }}: {{ $j->nilai }},
        @endforeach
    };

    // Auto-fill nilai untuk form create
    $('select[name="jasa_id"]').on('change', function() {
        var jasaId = $(this).val();
        var nilaiInput = $(this).closest('form').find('input[name="nilai"]');
        
        if (jasaId && jasaData[jasaId]) {
            // Animasi loading
            nilaiInput.addClass('bg-light').prop('readonly', true);
            setTimeout(function() {
                nilaiInput.val(jasaData[jasaId]);
                nilaiInput.removeClass('bg-light').prop('readonly', false);
                // Highlight untuk menunjukkan nilai telah terisi
                nilaiInput.addClass('border-success');
                setTimeout(function() {
                    nilaiInput.removeClass('border-success');
                }, 1500);
            }, 300);
        } else {
            nilaiInput.val('').removeClass('bg-light border-success').prop('readonly', false);
        }
    });

    // Auto-fill nilai untuk form edit
    $('#edit_jasa_id').on('change', function() {
        var jasaId = $(this).val();
        
        if (jasaId && jasaData[jasaId]) {
            // Animasi loading
            $('#edit_nilai').addClass('bg-light').prop('readonly', true);
            setTimeout(function() {
                $('#edit_nilai').val(jasaData[jasaId]);
                $('#edit_nilai').removeClass('bg-light').prop('readonly', false);
                // Highlight untuk menunjukkan nilai telah terisi
                $('#edit_nilai').addClass('border-success');
                setTimeout(function() {
                    $('#edit_nilai').removeClass('border-success');
                }, 1500);
            }, 300);
        } else {
            $('#edit_nilai').val('').removeClass('bg-light border-success').prop('readonly', false);
        }
    });

    // Handle Create Form Submit
 
    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.code === 200) {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_pegawai_id').val(data.pegawai_id);
                $('#edit_jasa_id').val(data.jasa_id);
                $('#edit_nilai').val(data.nilai);
                $('#editModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit
  
    // Handle Delete Button Click
  

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
        // Reset styling pada field nilai
        $('#createForm input[name="nilai"]').removeClass('bg-light border-success').prop('readonly', false);
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
        // Reset styling pada field nilai
        $('#edit_nilai').removeClass('bg-light border-success').prop('readonly', false);
    });
});
</script>
@endpush 