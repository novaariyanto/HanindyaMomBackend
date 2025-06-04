@extends('root')
@section('title', 'Pegawai Jasa Tidak Langsung')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Pegawai Jasa Tidak Langsung',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Pegawai Jasa Tidak Langsung'
    ])
    
    <div class="row">
        <div class="col-12">
            <div class="card">  
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Data Pegawai Jasa Tidak Langsung</h5>
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
                                    <th>Jasa Tidak Langsung</th>
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
                <h5 class="modal-title">Tambah Pegawai Jasa Tidak Langsung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('pegawai-jasa-tidak-langsung.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" name="unit_id" id="create_unit_id" required>
                            <option value="">Pilih Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select class="form-select" name="pegawai_id" id="create_pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Jasa Tidak Langsung</label>
                        <select class="form-select" name="kategori_jasa_id" id="create_kategori_jasa_id" required>
                            <option value="">Pilih Kategori Jasa</option>
                            @foreach($kategoriJasa as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jasa Tidak Langsung</label>
                        <select class="form-select" name="jasa_id" id="create_jasa_id" required>
                            <option value="">Pilih Jasa Tidak Langsung</option>
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
                <h5 class="modal-title">Edit Pegawai Jasa Tidak Langsung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Unit</label>
                        <select class="form-select" name="unit_id" id="edit_unit_id" required>
                            <option value="">Pilih Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select class="form-select" name="pegawai_id" id="edit_pegawai_id" required>
                            <option value="">Pilih Pegawai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Jasa Tidak Langsung</label>
                        <select class="form-select" name="kategori_jasa_id" id="edit_kategori_jasa_id" required>
                            <option value="">Pilih Kategori Jasa</option>
                            @foreach($kategoriJasa as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jasa Tidak Langsung</label>
                        <select class="form-select" name="jasa_id" id="edit_jasa_id" required>
                            <option value="">Pilih Jasa Tidak Langsung</option>
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
            url: '{{ route('pegawai-jasa-tidak-langsung.index') }}',
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

    // Fungsi untuk memuat data pegawai berdasarkan unit
    function loadPegawai(unitId, targetSelect) {
        if (!unitId) {
            targetSelect.html('<option value="">Pilih Pegawai</option>');
            return;
        }

        $.get('/api/pegawai-by-unit/' + unitId, function(response) {
            var options = '<option value="">Pilih Pegawai</option>';
            $.each(response.data, function(index, item) {
                options += '<option value="' + item.id + '">' + item.nama + ' - ' + item.nik + '</option>';
            });
            targetSelect.html(options);
        });
    }

    // Fungsi untuk memuat data jasa berdasarkan kategori
    function loadJasa(kategoriId, targetSelect) {
        if (!kategoriId) {
            targetSelect.html('<option value="">Pilih Jasa Tidak Langsung</option>');
            return;
        }

        $.get('/api/jasa-by-kategori/' + kategoriId, function(response) {
            var options = '<option value="">Pilih Jasa Tidak Langsung</option>';
            $.each(response.data, function(index, item) {
                options += '<option value="' + item.id + '">' + item.nama_indeks + ' (' + item.nilai + ')</option>';
            });
            targetSelect.html(options);
        });
    }

    // Event handler untuk perubahan unit pada form tambah
    $('#create_unit_id').on('change', function() {
        loadPegawai($(this).val(), $('#create_pegawai_id'));
    });

    // Event handler untuk perubahan kategori jasa pada form tambah
    $('#create_kategori_jasa_id').on('change', function() {
        loadJasa($(this).val(), $('#create_jasa_id'));
    });

    // Event handler untuk perubahan unit pada form edit
    $('#edit_unit_id').on('change', function() {
        loadPegawai($(this).val(), $('#edit_pegawai_id'));
    });

    // Event handler untuk perubahan kategori jasa pada form edit
    $('#edit_kategori_jasa_id').on('change', function() {
        loadJasa($(this).val(), $('#edit_jasa_id'));
    });

    // Auto-fill nilai untuk form create
    $('#create_jasa_id').on('change', function() {
        var jasaId = $(this).val();
        var nilaiInput = $(this).closest('form').find('input[name="nilai"]');
        
        if (jasaId && jasaData[jasaId]) {
            nilaiInput.addClass('bg-light').prop('readonly', true);
            setTimeout(function() {
                nilaiInput.val(jasaData[jasaId]);
                nilaiInput.removeClass('bg-light').prop('readonly', false);
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
            $('#edit_nilai').addClass('bg-light').prop('readonly', true);
            setTimeout(function() {
                $('#edit_nilai').val(jasaData[jasaId]);
                $('#edit_nilai').removeClass('bg-light').prop('readonly', false);
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
                $('#edit_unit_id').val(data.unit_id).trigger('change');
                $('#edit_kategori_jasa_id').val(data.kategori_jasa_id).trigger('change');
                
                // Tunggu sebentar untuk memastikan data pegawai dan jasa sudah dimuat
                setTimeout(function() {
                    $('#edit_pegawai_id').val(data.pegawai_id);
                    $('#edit_jasa_id').val(data.jasa_id);
                    $('#edit_nilai').val(data.nilai);
                }, 500);
                
                $('#editModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit
   

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
        $('#create_pegawai_id').html('<option value="">Pilih Pegawai</option>');
        $('#create_jasa_id').html('<option value="">Pilih Jasa Tidak Langsung</option>');
        $('input[name="nilai"]').removeClass('bg-light border-success').prop('readonly', false);
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
        $('#edit_pegawai_id').html('<option value="">Pilih Pegawai</option>');
        $('#edit_jasa_id').html('<option value="">Pilih Jasa Tidak Langsung</option>');
        $('#edit_nilai').removeClass('bg-light border-success').prop('readonly', false);
    });
});
</script>
@endpush 