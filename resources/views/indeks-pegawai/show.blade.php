@extends('root')

@section('title', 'Detail Indeks Pegawai')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Indeks Pegawai',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('indeks-pegawai.index'), 'label' => 'Indeks Pegawai'],
        ],
        'current' => 'Detail'
    ])
    
    <!-- Informasi Pegawai -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0 text-white">
                <i class="ti ti-user me-2 "></i>Informasi Pegawai
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%" class="fw-bold">Nama</td>
                            <td width="5%">:</td>
                            <td>{{ $data->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">NIP</td>
                            <td>:</td>
                            <td>{{ $data->nip }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Profesi</td>
                            <td>:</td>
                            <td>{{ $data->profesi ? $data->profesi->nama : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Unit Kerja</td>
                            <td>:</td>
                            <td>{{ $data->unitKerja ? $data->unitKerja->nama : ($data->unit ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td width="35%" class="fw-bold">Jenis Pegawai</td>
                            <td width="5%">:</td>
                            <td>{{ $data->jenisPegawai ? $data->jenisPegawai->nama : $data->jenis_pegawai_label }}</td>
                        </tr>
                      
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold">NIK</td>
                            <td>:</td>
                            <td>{{ $data->nik }}</td>
                        </tr>
                     
                        <tr>
                            <td class="fw-bold">Cluster 1</td>
                            <td>:</td>
                            <td>{{ number_format($data->cluster_1 ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Cluster 2</td>
                            <td>:</td>
                            <td>{{ number_format($data->cluster_2 ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td width="35%" class="fw-bold">Cluster 3</td>
                            <td width="5%">:</td>
                            <td>{{ number_format($data->cluster_3 ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td width="35%" class="fw-bold">Cluster 4</td>
                            <td width="5%">:</td>
                            <td>{{ number_format($data->cluster_4 ?? 0, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="card mt-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="indeksTab" role="tablist">
                
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="jasa-tidak-langsung-tab" data-bs-toggle="tab" data-bs-target="#jasa-tidak-langsung" type="button" role="tab">
                        <i class="ti ti-clipboard-list me-1"></i>Jasa Tidak Langsung
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jasa-langsung-non-medis-tab" data-bs-toggle="tab" data-bs-target="#jasa-langsung-non-medis" type="button" role="tab">
                        <i class="ti ti-medical-cross me-1"></i>Jasa Langsung Non Medis
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="struktural-tab" data-bs-toggle="tab" data-bs-target="#struktural" type="button" role="tab">
                        <i class="ti ti-building me-1"></i>Indeks Struktural
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3 " id="indeksTabContent">
                <!-- Tab Indeks Struktural -->
                <div class="tab-pane fade " id="struktural" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Indeks Struktural</h6>
                        <div>
                            <span class="badge bg-primary me-2" id="count-struktural">0 Data</span>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStruktural" onclick="openModalStruktural('add')">
                                <i class="ti ti-plus me-1"></i>Tambah Data
                            </button>
                        </div>
                    </div>
                    
                    <div id="table-struktural">
                        <!-- Table akan di-load via JavaScript -->
                    </div>
                </div>

                <!-- Tab Jasa Tidak Langsung -->
                <div class="tab-pane fade show active" id="jasa-tidak-langsung" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Indeks Jasa Tidak Langsung</h6>
                        <div>
                            <span class="badge bg-primary me-2" id="count-jasa-tidak-langsung">0 Data</span>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalJasaTidakLangsung" onclick="openModalJasaTidakLangsung('add')">
                                <i class="ti ti-plus me-1"></i>Tambah Data
                            </button>
                        </div>
                    </div>
                    
                    <div id="table-jasa-tidak-langsung">
                        <!-- Table akan di-load via JavaScript -->
                    </div>
                </div>

                <!-- Tab Jasa Langsung Non Medis -->
                <div class="tab-pane fade" id="jasa-langsung-non-medis" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Daftar Indeks Jasa Langsung Non Medis</h6>
                        <div>
                            <span class="badge bg-primary me-2" id="count-jasa-non-medis">0 Data</span>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalJasaLangsungNonMedis" onclick="openModalJasaLangsungNonMedis('add')">
                                <i class="ti ti-plus me-1"></i>Tambah Data
                            </button>
                        </div>
                    </div>
                    
                    <div id="table-jasa-non-medis">
                        <!-- Table akan di-load via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('indeks-pegawai.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<!-- Modal Indeks Struktural -->
<div class="modal fade" id="modalStruktural" tabindex="-1" aria-labelledby="modalStrukturalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStrukturalLabel">Tambah Indeks Struktural</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formStruktural">
                <div class="modal-body">
                    <input type="hidden" id="struktural_id" name="id">
                    <input type="hidden" name="pegawai_id" value="{{ $data->id }}">
                    
                    <div class="mb-3">
                        <label for="struktural_jasa_id" class="form-label">Pilih Indeks Struktural <span class="text-danger">*</span></label>
                        <select class="form-select" id="struktural_jasa_id" name="jasa_id" required>
                            <option value="">Pilih Indeks Struktural</option>
                            <!-- Options akan di-load via AJAX -->
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="struktural_nilai" class="form-label">Nilai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="struktural_nilai" name="nilai" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Jasa Tidak Langsung -->
<div class="modal fade" id="modalJasaTidakLangsung" tabindex="-1" aria-labelledby="modalJasaTidakLangsungLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJasaTidakLangsungLabel">Tambah Indeks Jasa Tidak Langsung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJasaTidakLangsung">
                <div class="modal-body">
                    <input type="hidden" id="jasa_tidak_langsung_id" name="id">
                    <input type="hidden" name="pegawai_id" value="{{ $data->id }}">
                    
                    <div class="mb-3">
                        <label for="jasa_tidak_langsung_kategori_id" class="form-label">Pilih Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="jasa_tidak_langsung_kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <!-- Options akan di-load via AJAX -->
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jasa_tidak_langsung_jasa_id" class="form-label">Pilih Indeks Jasa Tidak Langsung <span class="text-danger">*</span></label>
                        <select class="form-select" id="jasa_tidak_langsung_jasa_id" name="jasa_id" required disabled>
                            <option value="">Pilih Kategori Terlebih Dahulu</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jasa_tidak_langsung_nilai" class="form-label">Nilai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jasa_tidak_langsung_nilai" name="nilai" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Jasa Langsung Non Medis -->
<div class="modal fade" id="modalJasaLangsungNonMedis" tabindex="-1" aria-labelledby="modalJasaLangsungNonMedisLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJasaLangsungNonMedisLabel">Tambah Indeks Jasa Langsung Non Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJasaLangsungNonMedis">
                <div class="modal-body">
                    <input type="hidden" id="jasa_langsung_non_medis_id" name="id">
                    <input type="hidden" name="pegawai_id" value="{{ $data->id }}">
                    
                    <div class="mb-3">
                        <label for="jasa_langsung_non_medis_kategori_id" class="form-label">Pilih Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="jasa_langsung_non_medis_kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <!-- Options akan di-load via AJAX -->
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jasa_langsung_non_medis_jasa_id" class="form-label">Pilih Indeks Jasa Langsung Non Medis <span class="text-danger">*</span></label>
                        <select class="form-select" id="jasa_langsung_non_medis_jasa_id" name="jasa_id" required disabled>
                            <option value="">Pilih Kategori Terlebih Dahulu</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jasa_langsung_non_medis_nilai" class="form-label">Nilai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="jasa_langsung_non_medis_nilai" name="nilai" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Load data dan options saat halaman dimuat
        loadAllData();
        loadAllOptions();
        
        // Handle form submit untuk Indeks Struktural
        $('#formStruktural').on('submit', function(e) {
            e.preventDefault();
            saveStruktural();
        });
        
        // Handle form submit untuk Jasa Tidak Langsung
        $('#formJasaTidakLangsung').on('submit', function(e) {
            e.preventDefault();
            saveJasaTidakLangsung();
        });
        
        // Handle form submit untuk Jasa Langsung Non Medis
        $('#formJasaLangsungNonMedis').on('submit', function(e) {
            e.preventDefault();
            saveJasaLangsungNonMedis();
        });

        // Load data saat tab diklik
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            loadAllData();
        });
    });

    // Load semua data
    function loadAllData() {
        loadStrukturalData();
        loadJasaTidakLangsungData();
        loadJasaNonMedisData();
    }

    // Load semua options
    function loadAllOptions() {
        loadStrukturalOptions();
        loadJasaTidakLangsungKategoriOptions();
        loadJasaNonMedisKategoriOptions();
    }

    // Load data Struktural
    function loadStrukturalData() {
        $.get('/api/pegawai-struktural?pegawai_id={{ $data->id }}', function(response) {
            if (response.success) {
                $('#count-struktural').text(response.data.length + ' Data');
                renderStrukturalTable(response.data);
            }
        });
    }

    // Load data Jasa Tidak Langsung
    function loadJasaTidakLangsungData() {
        $.get('/api/pegawai-jasa-tidak-langsung?pegawai_id={{ $data->id }}', function(response) {
            if (response.success) {
                $('#count-jasa-tidak-langsung').text(response.data.length + ' Data');
                renderJasaTidakLangsungTable(response.data);
            }
        });
    }

    // Load data Jasa Non Medis
    function loadJasaNonMedisData() {
        $.get('/api/pegawai-jasa-non-medis?pegawai_id={{ $data->id }}', function(response) {
            if (response.success) {
                $('#count-jasa-non-medis').text(response.data.length + ' Data');
                renderJasaNonMedisTable(response.data);
            }
        });
    }

    // Load options Struktural
    function loadStrukturalOptions() {
        $.get('/api/indeks-struktural-options', function(data) {
            let options = '<option value="">Pilih Indeks Struktural</option>';
            data.forEach(function(item) {
                options += `<option value="${item.id}" data-nilai="${item.nilai}">${item.nama_jabatan} (${item.nilai})</option>`;
            });
            $('#struktural_jasa_id').html(options);
        });
    }

    // Load options Kategori Jasa Tidak Langsung
    function loadJasaTidakLangsungKategoriOptions() {
        $.get('/api/kategori-jasa-tidak-langsung-options', function(data) {
            let options = '<option value="">Pilih Kategori</option>';
            data.forEach(function(item) {
                options += `<option value="${item.id}">${item.nama_kategori}</option>`;
            });
            $('#jasa_tidak_langsung_kategori_id').html(options);
        });
    }

    // Load options Jasa Tidak Langsung berdasarkan kategori
    function loadJasaTidakLangsungOptions(kategoriId = null) {
        let url = '/api/indeks-jasa-tidak-langsung-options';
        if (kategoriId) {
            url += `?kategori_id=${kategoriId}`;
        }
        
        $.get(url, function(data) {
            let options = '<option value="">Pilih Indeks Jasa Tidak Langsung</option>';
            data.forEach(function(item) {
                let kategori = item.kategori ? ` (${item.kategori.nama_kategori})` : '';
                options += `<option value="${item.id}" data-nilai="${item.nilai}">${item.nama_indeks}${kategori} - ${item.nilai}</option>`;
            });
            $('#jasa_tidak_langsung_jasa_id').html(options);
        });
    }

    // Load options Kategori Jasa Non Medis
    function loadJasaNonMedisKategoriOptions() {
        $.get('/api/kategori-jasa-non-medis-options', function(data) {
            let options = '<option value="">Pilih Kategori</option>';
            data.forEach(function(item) {
                options += `<option value="${item.id}">${item.nama_kategori}</option>`;
            });
            $('#jasa_langsung_non_medis_kategori_id').html(options);
        });
    }

    // Load options Jasa Non Medis berdasarkan kategori
    function loadJasaNonMedisOptions(kategoriId = null) {
        let url = '/api/indeks-jasa-non-medis-options';
        if (kategoriId) {
            url += `?kategori_id=${kategoriId}`;
        }
        
        $.get(url, function(data) {
            let options = '<option value="">Pilih Indeks Jasa Langsung Non Medis</option>';
            data.forEach(function(item) {
                let kategori = item.kategori ? ` (${item.kategori.nama_kategori})` : '';
                options += `<option value="${item.id}" data-nilai="${item.nilai}">${item.nama_indeks}${kategori} - ${item.nilai}</option>`;
            });
            $('#jasa_langsung_non_medis_jasa_id').html(options);
        });
    }

    // Render table Struktural
    function renderStrukturalTable(data) {
        let html = '';
        if (data.length > 0) {
            html = `
                <div class="table-responsive ">
                    <table class="table table-striped table-hover">
                        <thead class="text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Nilai</th>
                                <th>Tanggal Dibuat</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>`;
            
            data.forEach(function(item, index) {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jasa ? item.jasa.nama_jabatan : '-'}</td>
                        <td>${parseFloat(item.nilai).toLocaleString('id-ID', {minimumFractionDigits: 2})}</td>
                        <td>${new Date(item.created_at).toLocaleDateString('id-ID')} ${new Date(item.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editStruktural(${item.id})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteStruktural(${item.id})" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>`;
        } else {
            html = `
                <div class="text-center py-4">
                    <i class="ti ti-inbox-off display-6 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada data indeks struktural</p>
                </div>`;
        }
        $('#table-struktural').html(html);
    }

    // Render table Jasa Tidak Langsung
    function renderJasaTidakLangsungTable(data) {
        let html = '';
        if (data.length > 0) {
            html = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Indeks</th>
                                <th>Kategori</th>
                                <th>Nilai</th>
                                <th>Tanggal Dibuat</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>`;
            
            data.forEach(function(item, index) {
                let kategori = '-';
                if (item.jasa && item.jasa.kategori) {
                    kategori = `<span class="badge bg-info">${item.jasa.kategori.nama_kategori}</span>`;
                }
                
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jasa ? item.jasa.nama_indeks : '-'}</td>
                        <td>${kategori}</td>
                        <td>${parseFloat(item.nilai).toLocaleString('id-ID', {minimumFractionDigits: 2})}</td>
                        <td>${new Date(item.created_at).toLocaleDateString('id-ID')} ${new Date(item.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editJasaTidakLangsung(${item.id})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteJasaTidakLangsung(${item.id})" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>`;
        } else {
            html = `
                <div class="text-center py-4">
                    <i class="ti ti-inbox-off display-6 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada data indeks jasa tidak langsung</p>
                </div>`;
        }
        $('#table-jasa-tidak-langsung').html(html);
    }

    // Render table Jasa Non Medis
    function renderJasaNonMedisTable(data) {
        let html = '';
        if (data.length > 0) {
            html = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Indeks</th>
                                <th>Kategori</th>
                                <th>Nilai</th>
                                <th>Tanggal Dibuat</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>`;
            
            data.forEach(function(item, index) {
                let kategori = '-';
                if (item.jasa && item.jasa.kategori) {
                    kategori = `<span class="badge bg-success">${item.jasa.kategori.nama_kategori}</span>`;
                }
                
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jasa ? item.jasa.nama_indeks : '-'}</td>
                        <td>${kategori}</td>
                        <td>${parseFloat(item.nilai).toLocaleString('id-ID', {minimumFractionDigits: 2})}</td>
                        <td>${new Date(item.created_at).toLocaleDateString('id-ID')} ${new Date(item.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" onclick="editJasaNonMedis(${item.id})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteJasaNonMedis(${item.id})" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>`;
        } else {
            html = `
                <div class="text-center py-4">
                    <i class="ti ti-inbox-off display-6 text-muted"></i>
                    <p class="text-muted mt-2">Belum ada data indeks jasa langsung non medis</p>
                </div>`;
        }
        $('#table-jasa-non-medis').html(html);
    }

    // Modal functions untuk Indeks Struktural
    function openModalStruktural(action, id = null) {
        const modal = $('#modalStruktural');
        const title = action === 'add' ? 'Tambah Indeks Struktural' : 'Edit Indeks Struktural';
        
        modal.find('.modal-title').text(title);
        modal.find('form')[0].reset();
        
        if (action === 'edit' && id) {
            // Load data untuk edit
            $.get(`/api/pegawai-struktural/${id}`, function(response) {
                if (response.success) {
                    const data = response.data;
                    $('#struktural_id').val(data.id);
                    $('#struktural_jasa_id').val(data.jasa_id);
                    $('#struktural_nilai').val(data.nilai);
                }
            });
        } else {
            $('#struktural_id').val('');
        }
        
        // Event listener untuk auto-fill nilai ketika select struktural berubah
        $('#struktural_jasa_id').off('change').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const nilai = selectedOption.data('nilai');
            
            if (nilai) {
                $('#struktural_nilai').val(nilai);
            } else {
                $('#struktural_nilai').val('');
            }
        });
    }

    function editStruktural(id) {
        openModalStruktural('edit', id);
        $('#modalStruktural').modal('show');
    }

    function saveStruktural() {
        const formData = $('#formStruktural').serialize();
        const id = $('#struktural_id').val();
        const url = id ? `/api/pegawai-struktural/${id}` : '/api/pegawai-struktural';
        const method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        $('#modalStruktural').modal('hide');
                        loadStrukturalData();
                        loadPegawaiInfo();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat menyimpan data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire('Error!', message, 'error');
            }
        });
    }

    function deleteStruktural(id) {
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
                    url: `/api/pegawai-struktural/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                loadStrukturalData();
                                loadPegawaiInfo();
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', message, 'error');
                    }
                });
            }
        });
    }

    // Modal functions untuk Jasa Tidak Langsung
    function openModalJasaTidakLangsung(action, id = null) {
        const modal = $('#modalJasaTidakLangsung');
        const title = action === 'add' ? 'Tambah Indeks Jasa Tidak Langsung' : 'Edit Indeks Jasa Tidak Langsung';
        
        modal.find('.modal-title').text(title);
        modal.find('form')[0].reset();
        
        // Reset dan disable select indeks
        $('#jasa_tidak_langsung_jasa_id').prop('disabled', true).html('<option value="">Pilih Kategori Terlebih Dahulu</option>');
        
        if (action === 'edit' && id) {
            // Load data untuk edit
            $.get(`/api/pegawai-jasa-tidak-langsung/${id}`, function(response) {
                if (response.success) {
                    const data = response.data;
                    $('#jasa_tidak_langsung_id').val(data.id);
                    
                    // Set kategori terlebih dahulu
                    if (data.jasa && data.jasa.kategori_id) {
                        $('#jasa_tidak_langsung_kategori_id').val(data.jasa.kategori_id);
                        // Load indeks berdasarkan kategori
                        loadJasaTidakLangsungOptions(data.jasa.kategori_id);
                        // Enable select indeks dan set nilai setelah options loaded
                        setTimeout(() => {
                            $('#jasa_tidak_langsung_jasa_id').prop('disabled', false).val(data.jasa_id);
                            $('#jasa_tidak_langsung_nilai').val(data.nilai);
                        }, 500);
                    }
                }
            });
        } else {
            $('#jasa_tidak_langsung_id').val('');
        }
        
        // Event listener untuk filter kategori
        $('#jasa_tidak_langsung_kategori_id').off('change').on('change', function() {
            const kategoriId = $(this).val();
            
            if (kategoriId) {
                // Enable select indeks dan load options berdasarkan kategori
                $('#jasa_tidak_langsung_jasa_id').prop('disabled', false);
                loadJasaTidakLangsungOptions(kategoriId);
            } else {
                // Disable select indeks dan reset
                $('#jasa_tidak_langsung_jasa_id').prop('disabled', true).html('<option value="">Pilih Kategori Terlebih Dahulu</option>');
                $('#jasa_tidak_langsung_nilai').val('');
            }
        });
        
        // Event listener untuk auto-fill nilai ketika select jasa tidak langsung berubah
        $('#jasa_tidak_langsung_jasa_id').off('change').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const nilai = selectedOption.data('nilai');
            
            if (nilai) {
                $('#jasa_tidak_langsung_nilai').val(nilai);
            } else {
                $('#jasa_tidak_langsung_nilai').val('');
            }
        });
    }

    function editJasaTidakLangsung(id) {
        openModalJasaTidakLangsung('edit', id);
        $('#modalJasaTidakLangsung').modal('show');
    }

    function saveJasaTidakLangsung() {
        const formData = $('#formJasaTidakLangsung').serialize();
        const id = $('#jasa_tidak_langsung_id').val();
        const url = id ? `/api/pegawai-jasa-tidak-langsung/${id}` : '/api/pegawai-jasa-tidak-langsung';
        const method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        $('#modalJasaTidakLangsung').modal('hide');
                        loadJasaTidakLangsungData();
                        loadPegawaiInfo();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat menyimpan data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire('Error!', message, 'error');
            }
        });
    }

    function deleteJasaTidakLangsung(id) {
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
                    url: `/api/pegawai-jasa-tidak-langsung/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                loadJasaTidakLangsungData();
                                loadPegawaiInfo();
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', message, 'error');
                    }
                });
            }
        });
    }

    // Modal functions untuk Jasa Langsung Non Medis
    function openModalJasaLangsungNonMedis(action, id = null) {
        const modal = $('#modalJasaLangsungNonMedis');
        const title = action === 'add' ? 'Tambah Indeks Jasa Langsung Non Medis' : 'Edit Indeks Jasa Langsung Non Medis';
        
        modal.find('.modal-title').text(title);
        modal.find('form')[0].reset();
        
        // Reset dan disable select indeks
        $('#jasa_langsung_non_medis_jasa_id').prop('disabled', true).html('<option value="">Pilih Kategori Terlebih Dahulu</option>');
        
        if (action === 'edit' && id) {
            // Load data untuk edit
            $.get(`/api/pegawai-jasa-non-medis/${id}`, function(response) {
                if (response.success) {
                    const data = response.data;
                    $('#jasa_langsung_non_medis_id').val(data.id);
                    
                    // Set kategori terlebih dahulu
                    if (data.jasa && data.jasa.kategori_id) {
                        $('#jasa_langsung_non_medis_kategori_id').val(data.jasa.kategori_id);
                        // Load indeks berdasarkan kategori
                        loadJasaNonMedisOptions(data.jasa.kategori_id);
                        // Enable select indeks dan set nilai setelah options loaded
                        setTimeout(() => {
                            $('#jasa_langsung_non_medis_jasa_id').prop('disabled', false).val(data.jasa_id);
                            $('#jasa_langsung_non_medis_nilai').val(data.nilai);
                        }, 500);
                    }
                }
            });
        } else {
            $('#jasa_langsung_non_medis_id').val('');
        }
        
        // Event listener untuk filter kategori
        $('#jasa_langsung_non_medis_kategori_id').off('change').on('change', function() {
            const kategoriId = $(this).val();
            
            if (kategoriId) {
                // Enable select indeks dan load options berdasarkan kategori
                $('#jasa_langsung_non_medis_jasa_id').prop('disabled', false);
                loadJasaNonMedisOptions(kategoriId);
            } else {
                // Disable select indeks dan reset
                $('#jasa_langsung_non_medis_jasa_id').prop('disabled', true).html('<option value="">Pilih Kategori Terlebih Dahulu</option>');
                $('#jasa_langsung_non_medis_nilai').val('');
            }
        });
        
        // Event listener untuk auto-fill nilai ketika select jasa langsung non medis berubah
        $('#jasa_langsung_non_medis_jasa_id').off('change').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const nilai = selectedOption.data('nilai');
            
            if (nilai) {
                $('#jasa_langsung_non_medis_nilai').val(nilai);
            } else {
                $('#jasa_langsung_non_medis_nilai').val('');
            }
        });
    }

    function editJasaNonMedis(id) {
        openModalJasaLangsungNonMedis('edit', id);
        $('#modalJasaLangsungNonMedis').modal('show');
    }

    function saveJasaLangsungNonMedis() {
        const formData = $('#formJasaLangsungNonMedis').serialize();
        const id = $('#jasa_langsung_non_medis_id').val();
        const url = id ? `/api/pegawai-jasa-non-medis/${id}` : '/api/pegawai-jasa-non-medis';
        const method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        $('#modalJasaLangsungNonMedis').modal('hide');
                        loadJasaNonMedisData();
                        loadPegawaiInfo();
                    });
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat menyimpan data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire('Error!', message, 'error');
            }
        });
    }

    function deleteJasaNonMedis(id) {
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
                    url: `/api/pegawai-jasa-non-medis/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                loadJasaNonMedisData();
                                loadPegawaiInfo();
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menghapus data';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error!', message, 'error');
                    }
                });
            }
        });
    }

    // Load informasi pegawai dengan AJAX
    function loadPegawaiInfo() {
        // Tampilkan loading indicator
        $('.card-body table tr').each(function() {
            const $row = $(this);
            const $firstTd = $row.find('td:first');
            const $lastTd = $row.find('td:last');
            
            if ($firstTd.text().includes('Cluster')) {
                $lastTd.html('<i class="ti ti-loader-2 fa-spin"></i> Loading...');
            }
        });
        
        $.get('/api/pegawai-info/{{ $data->id }}', function(response) {
            if (response.success) {
                const data = response.data;
                
                // Update informasi cluster dengan selektor yang lebih spesifik
                $('.card-body table tr').each(function() {
                    const $row = $(this);
                    const $firstTd = $row.find('td:first');
                    const $lastTd = $row.find('td:last');
                    
                    if ($firstTd.text().includes('Cluster 1')) {
                        $lastTd.text(parseFloat(data.cluster_1 || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    } else if ($firstTd.text().includes('Cluster 2')) {
                        $lastTd.text(parseFloat(data.cluster_2 || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    } else if ($firstTd.text().includes('Cluster 3')) {
                        $lastTd.text(parseFloat(data.cluster_3 || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    } else if ($firstTd.text().includes('Cluster 4')) {
                        $lastTd.text(parseFloat(data.cluster_4 || 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    }
                });
                
                // Tambahkan efek visual untuk menunjukkan data telah diupdate
                $('.card-body table tr').each(function() {
                    const $row = $(this);
                    const $firstTd = $row.find('td:first');
                    const $lastTd = $row.find('td:last');
                    
                    if ($firstTd.text().includes('Cluster')) {
                        $lastTd.addClass('bg-success text-white rounded');
                        setTimeout(() => {
                            $lastTd.removeClass('bg-success text-white rounded');
                        }, 1500);
                    }
                });
                
                // Tampilkan notifikasi sukses kecil
                const toast = $(`
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                        <div class="toast show" role="alert">
                            <div class="toast-header">
                                <i class="ti ti-check text-success me-2"></i>
                                <strong class="me-auto">Info</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                            </div>
                            <div class="toast-body">
                                Data cluster berhasil diperbarui
                            </div>
                        </div>
                    </div>
                `);
                
                $('body').append(toast);
                setTimeout(() => {
                    toast.remove();
                }, 3000);
                
                console.log('Informasi pegawai berhasil diupdate');
            }
        }).fail(function() {
            // Kembalikan nilai asli jika gagal
            $('.card-body table tr').each(function() {
                const $row = $(this);
                const $firstTd = $row.find('td:first');
                const $lastTd = $row.find('td:last');
                
                if ($firstTd.text().includes('Cluster')) {
                    $lastTd.text('Error loading data');
                    $lastTd.addClass('text-danger');
                    setTimeout(() => {
                        $lastTd.removeClass('text-danger');
                        // Reload halaman jika gagal
                        location.reload();
                    }, 2000);
                }
            });
            
            console.error('Gagal memuat informasi pegawai');
        });
    }
</script>
@endpush 