@extends('root')
@section('title', 'Data JTL Pegawai Hasil')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data JTL Pegawai Hasil',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'JTL Pegawai Hasil'
    ])
    
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-3 col-xl-2">
            <form class="position-relative">
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari NIK/Nama">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-3 col-xl-2">
            <select class="form-select" id="filter-remunerasi-source">
              <option value="">Semua Remunerasi Source</option>
              @foreach($remunerasiSources as $source)
                <option value="{{ $source->id }}">{{ $source->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 col-xl-2">
            <select class="form-select" id="filter-unit-kerja">
              <option value="">Semua Unit Kerja</option>
              @foreach($unitKerja as $unit)
                <option value="{{ $unit }}">{{ $unit }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 col-xl-6 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <a href="javascript:void(0)" class="btn btn-success d-flex align-items-center me-2" id="btn-export">
              <i class="ti ti-file-export text-white me-1 fs-5"></i> Export Excel
            </a>
            
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah JTL Pegawai Hasil
            </a>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Pegawai</th>
                        <th>Unit Kerja</th>
                        <th>Remunerasi Source</th>
                        <th>Dasar</th>
                        <th>Kompetensi</th>
                        <th>Resiko</th>
                        <th>Emergensi</th>
                        <th>Posisi</th>
                        <th>Kinerja</th>
                        <th>Jumlah</th>
                        <th>Nilai Indeks</th>
                        <th>JTL Bruto</th>
                        <th>Pajak</th>
                        <th>Potongan Pajak</th>
                        <th>JTL Net</th>
                        <th>Rekening</th>
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

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah JTL Pegawai Hasil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('jtl-pegawai-hasil.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="id_pegawai" id="create_id_pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}" data-unit="{{ $p->unit_kerja_id }}">{{ $p->nama }} - {{ $p->nik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Remunerasi Source</label>
                                <select class="form-select" name="remunerasi_source" required>
                                    <option value="">Pilih Remunerasi Source</option>
                                    @foreach($remunerasiSources as $source)
                                        <option value="{{ $source->id }}">{{ $source->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" id="create_nik" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" id="create_nama_pegawai" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <select class="form-select" name="unit_kerja_id" id="create_unit_kerja_id" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach($unitKerja as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks</label>
                                <input type="number" class="form-control" name="nilai_indeks" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" class="form-control indeks-input" name="dasar" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" class="form-control indeks-input" name="kompetensi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" class="form-control indeks-input" name="resiko" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" class="form-control indeks-input" name="emergensi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" class="form-control indeks-input" name="posisi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" class="form-control indeks-input" name="kinerja" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" placeholder="Nomor rekening (opsional)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak (%)</label>
                                <input type="number" class="form-control" name="pajak" step="0.01" min="0" max="100" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Informasi:</strong> Jumlah akan dihitung otomatis dari penjumlahan Dasar + Kompetensi + Resiko + Emergensi + Posisi + Kinerja. JTL Bruto, Potongan Pajak, dan JTL Net juga akan dihitung otomatis oleh sistem.
                            </div>
                        </div>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit JTL Pegawai Hasil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="id_pegawai" id="edit_id_pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}" data-unit="{{ $p->unit_kerja_id }}">{{ $p->nama }} - {{ $p->nik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Remunerasi Source</label>
                                <select class="form-select" name="remunerasi_source" id="edit_remunerasi_source" required>
                                    <option value="">Pilih Remunerasi Source</option>
                                    @foreach($remunerasiSources as $source)
                                        <option value="{{ $source->id }}">{{ $source->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" id="edit_nik" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" id="edit_nama_pegawai" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <select class="form-select" name="unit_kerja_id" id="edit_unit_kerja_id" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach($unitKerja as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks</label>
                                <input type="number" class="form-control" name="nilai_indeks" id="edit_nilai_indeks" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" class="form-control indeks-input" name="dasar" id="edit_dasar" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" class="form-control indeks-input" name="kompetensi" id="edit_kompetensi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" class="form-control indeks-input" name="resiko" id="edit_resiko" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" class="form-control indeks-input" name="emergensi" id="edit_emergensi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" class="form-control indeks-input" name="posisi" id="edit_posisi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" class="form-control indeks-input" name="kinerja" id="edit_kinerja" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" id="edit_rekening" placeholder="Nomor rekening (opsional)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak (%)</label>
                                <input type="number" class="form-control" name="pajak" id="edit_pajak" step="0.01" min="0" max="100" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Informasi:</strong> Jumlah akan dihitung otomatis dari penjumlahan Dasar + Kompetensi + Resiko + Emergensi + Posisi + Kinerja. JTL Bruto, Potongan Pajak, dan JTL Net juga akan dihitung otomatis oleh sistem.
                            </div>
                        </div>
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
        scrollX: true,
        ajax: {
            url: '{{ route('jtl-pegawai-hasil.index') }}',
            data: function (d) {
                d.remunerasi_source_id = $('#filter-remunerasi-source').val();
                d.unit_kerja_id = $('#filter-unit-kerja').val();
                d.search = $('#input-search').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '50px'
            },
            {
                data: 'nik',
                name: 'nik'
            },
            {
                data: 'nama_pegawai',
                name: 'nama_pegawai'
            },
            {
                data: 'unit_kerja',
                name: 'unit_kerja',
                orderable: false,
                searchable: false
            },
            {
                data: 'remunerasi_source_name',
                name: 'remunerasi_source_name',
                orderable: false,
                searchable: false
            },
            {
                data: 'dasar',
                name: 'dasar',
                className: 'text-center'
            },
            {
                data: 'kompetensi',
                name: 'kompetensi',
                className: 'text-center'
            },
            {
                data: 'resiko',
                name: 'resiko',
                className: 'text-center'
            },
            {
                data: 'emergensi',
                name: 'emergensi',
                className: 'text-center'
            },
            {
                data: 'posisi',
                name: 'posisi',
                className: 'text-center'
            },
            {
                data: 'kinerja',
                name: 'kinerja',
                className: 'text-center'
            },
            {
                data: 'jumlah',
                name: 'jumlah',
                className: 'text-center'
            },
            {
                data: 'nilai_indeks',
                name: 'nilai_indeks',
                className: 'text-center'
            },
            {
                data: 'jtl_bruto',
                name: 'jtl_bruto',
                className: 'text-end'
            },
            {
                data: 'pajak',
                name: 'pajak',
                className: 'text-center'
            },
            {
                data: 'potongan_pajak',
                name: 'potongan_pajak',
                className: 'text-end'
            },
            {
                data: 'jtl_net',
                name: 'jtl_net',
                className: 'text-end'
            },
            {
                data: 'rekening',
                name: 'rekening'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '100px'
            }
        ]
    });

    // Handle search input
    $('#input-search').on('keyup', function () {
        datatable.ajax.reload();
    });

    // Handle filters
    $('#filter-remunerasi-source, #filter-unit-kerja').on('change', function () {
        datatable.ajax.reload();
    });

    // Auto fill data when pegawai is selected
    $('#create_id_pegawai, #edit_id_pegawai').on('change', function() {
        var selectedOption = $(this).find(':selected');
        var nik = selectedOption.data('nik');
        var nama = selectedOption.data('nama');
        var unitKerja = selectedOption.data('unit');
        
        var modalType = $(this).attr('id').includes('create') ? 'create' : 'edit';
        
        $('#' + modalType + '_nik').val(nik || '');
        $('#' + modalType + '_nama_pegawai').val(nama || '');
        $('#' + modalType + '_unit_kerja_id').val(unitKerja || '');
    });

    // Calculate jumlah automatically
    $('.indeks-input').on('input', function() {
        var modalType = $(this).closest('.modal').find('form').attr('id').includes('create') ? 'create' : 'edit';
        var prefix = modalType === 'create' ? '' : 'edit_';
        
        var dasar = parseFloat($('[name="dasar"]').val()) || 0;
        var kompetensi = parseFloat($('[name="kompetensi"]').val()) || 0;
        var resiko = parseFloat($('[name="resiko"]').val()) || 0;
        var emergensi = parseFloat($('[name="emergensi"]').val()) || 0;
        var posisi = parseFloat($('[name="posisi"]').val()) || 0;
        var kinerja = parseFloat($('[name="kinerja"]').val()) || 0;
        
        var jumlah = dasar + kompetensi + resiko + emergensi + posisi + kinerja;
        
        // Update display (optional, you can add a readonly input to show the calculated total)
        console.log('Jumlah calculated:', jumlah.toFixed(2));
    });

    // Handle Create Form Submit
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#createModal').modal('hide');
                    datatable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.meta.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.meta && xhr.responseJSON.meta.message) {
                    errorMessage = xhr.responseJSON.meta.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    var errors = xhr.responseJSON.data;
                    var errorDetails = '';
                    
                    $.each(errors, function(key, value) {
                        if (Array.isArray(value)) {
                            errorDetails += value.join(', ') + '\n';
                        } else {
                            errorDetails += value + '\n';
                        }
                    });
                    
                    if (errorDetails) {
                        errorMessage += '\n\nDetail:\n' + errorDetails;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan!',
                    text: errorMessage
                });
            }
        });
    });

    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(data) {
            var data = data.data;
            var updateUrl = url.replace('/show/', '/update/').replace('jtl-pegawai-hasil.show', 'jtl-pegawai-hasil.update');
            $('#editForm').attr('action', updateUrl);
            $('#edit_id_pegawai').val(data.id_pegawai);
            $('#edit_remunerasi_source').val(data.remunerasi_source);
            $('#edit_nik').val(data.nik);
            $('#edit_nama_pegawai').val(data.nama_pegawai);
            $('#edit_unit_kerja_id').val(data.unit_kerja_id);
            $('#edit_dasar').val(data.dasar);
            $('#edit_kompetensi').val(data.kompetensi);
            $('#edit_resiko').val(data.resiko);
            $('#edit_emergensi').val(data.emergensi);
            $('#edit_posisi').val(data.posisi);
            $('#edit_kinerja').val(data.kinerja);
            $('#edit_nilai_indeks').val(data.nilai_indeks);
            $('#edit_rekening').val(data.rekening);
            $('#edit_pajak').val(data.pajak);
            $('#editModal').modal('show');
        });
    });

    // Handle Edit Form Submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#editModal').modal('hide');
                    datatable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.meta.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.meta && xhr.responseJSON.meta.message) {
                    errorMessage = xhr.responseJSON.meta.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    var errors = xhr.responseJSON.data;
                    var errorDetails = '';
                    
                    $.each(errors, function(key, value) {
                        if (Array.isArray(value)) {
                            errorDetails += value.join(', ') + '\n';
                        } else {
                            errorDetails += value + '\n';
                        }
                    });
                    
                    if (errorDetails) {
                        errorMessage += '\n\nDetail:\n' + errorDetails;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengupdate!',
                    text: errorMessage
                });
            }
        });
    });

    // Handle Delete Button Click
    $(document).on('click', '.btn-delete', function() {
        var url = $(this).data('url');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.meta.status === 'success') {
                            datatable.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.meta.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.meta && xhr.responseJSON.meta.message) {
                            errorMessage = xhr.responseJSON.meta.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menghapus!',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    });

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });

    // Handle Export Button Click
    $('#btn-export').on('click', function() {
        var remunerasiSourceId = $('#filter-remunerasi-source').val();
        var unitKerja = $('#filter-unit-kerja').val();
        var search = $('#input-search').val();
        
        // Build URL with current filters
        var exportUrl = '{{ route('jtl-pegawai-hasil.export') }}';
        var params = [];
        
        if (remunerasiSourceId) {
            params.push('remunerasi_source_id=' + encodeURIComponent(remunerasiSourceId));
        }
        
        if (unitKerja) {
            params.push('unit_kerja=' + encodeURIComponent(unitKerja));
        }
        
        if (search) {
            params.push('search=' + encodeURIComponent(search));
        }
        
        if (params.length > 0) {
            exportUrl += '?' + params.join('&');
        }
        
        // Show loading indicator
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<i class="ti ti-loader-2 animate-spin me-1"></i> Mengunduh...');
        $btn.prop('disabled', true);
        
        // Create temporary link to trigger download
        var link = document.createElement('a');
        link.href = exportUrl;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Reset button after a short delay
        setTimeout(function() {
            $btn.html(originalText);
            $btn.prop('disabled', false);
        }, 2000);
    });
});
</script>
@endpush 