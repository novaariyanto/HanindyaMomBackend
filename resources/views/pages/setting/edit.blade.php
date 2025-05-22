<form action="{{ route('jabatan.update', $jabatan->uuid) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Jabatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input 
                type="text" 
                class="form-control" 
                id="nama_jabatan" 
                name="nama_jabatan" 
                placeholder="Masukkan nama jabatan" 
                value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" 
                required>
        </div>
        
        <div class="mb-3">
            <label for="deskripsi_jabatan" class="form-label">Deskripsi Jabatan</label>
            <textarea 
                class="form-control" 
                id="deskripsi_jabatan" 
                name="deskripsi_jabatan" 
                placeholder="Masukkan deskripsi jabatan" 
                rows="4">{{ old('deskripsi_jabatan', $jabatan->deskripsi_jabatan) }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
