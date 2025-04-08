<div class="modal-header">
    <h5 class="modal-title">Detail Absensi</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" id="detail-content">
    <div class="p-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
            <div>
                <h5 class="fw-bold mb-1">{{ $data['nama'] }}</h5>
                <span class="text-secondary">NIK: {{ $data['nik'] }}</span>
            </div>
            <!-- Foto Wajah -->
            <div class="ms-3">
                <img 
                    src="{{ url($data['foto_wajah'] )?? 'https://via.placeholder.com/100' }}" 
                    alt="Foto Pegawai" 
                    class="rounded-circle" 
                    style="width: 50px; height: 50px; object-fit: cover;" 
                />
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="row g-3">
            <div class="col-6">
                <small class="text-muted d-block">Tanggal</small>
                <span class="fw-semibold">{{ $data['tanggal'] }}</span>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Divisi</small>
                <span class="fw-semibold">{{ $data['divisi'] ?? '-' }}</span>
            </div>
        </div>

        <!-- Jam Masuk -->
        <div class="mt-3 border-bottom pb-2">
            <small class="text-muted d-block mb-1">Jam Masuk</small>
            <div class="row">
                <div class="col-6">
                    <small class="text-muted d-block">Jadwal</small>
                    <span class="fw-semibold">{{ $data['jam_masuk_jadwal'] }}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Aktual</small>
                    <span class="fw-semibold">{{ $data['jam_masuk'] }}</span>
                </div>
            </div>
        </div>

        <!-- Jam Keluar -->
        <div class="mt-3 border-bottom pb-2">
            <small class="text-muted d-block mb-1">Jam Keluar</small>
            <div class="row">
                <div class="col-6">
                    <small class="text-muted d-block">Jadwal</small>
                    <span class="fw-semibold">{{ $data['jam_keluar_jadwal'] }}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Aktual</small>
                    <span class="fw-semibold">{{ $data['jam_keluar'] }}</span>
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        <div class="mt-3">
            <small class="text-muted d-block">Keterangan</small>
            <span class="fw-semibold">{{ $data['keterangan'] }}</span>
        </div>


        <!-- Keterangan -->
        <div class="mt-3">
            <small class="text-muted d-block">Catatan</small>
            <span class="fw-semibold">{{ $data['catatan'] }}</span>
        </div>
    </div>
</div>