<form action="{{ route('divisi.update', $divisi->uuid) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Divisi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Divisi</label>
            <input 
                type="text" 
                class="form-control" 
                id="nama" 
                name="nama" 
                placeholder="Masukkan nama divisi" 
                value="{{ old('nama', $divisi->nama) }}" 
                required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea 
                class="form-control" 
                id="keterangan" 
                name="keterangan" 
                rows="3" 
                placeholder="Masukkan keterangan (opsional)">
                {{ old('keterangan', $divisi->keterangan) }}
            </textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>