<form action="{{ route('index-kategori.update', $kategori->id) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input
                type="text"
                class="form-control"
                id="nama"
                name="nama"
                placeholder="Masukkan nama Kategori"
                value="{{ old('nama', $kategori->nama) }}"
                required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
