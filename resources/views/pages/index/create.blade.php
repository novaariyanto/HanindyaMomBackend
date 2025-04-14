<form action="{{ route('index.store') }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Buat Index</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input
                type="text"
                class="form-control"
                id="nama"
                name="nama"
                placeholder="Masukkan nama"
                required>
        </div>
        <div class="mb-3">
            <label for="index" class="form-label">Index</label>
            <input
                type="number"
                step="0.01"
                class="form-control"
                id="index"
                name="index"
                placeholder="Masukkan nilai index"
                required>
        </div>
        <div class="mb-3">
            <label for="index_kategori_id" class="form-label">Grup</label>
            <select class="form-select" id="index_kategori_id" name="index_kategori_id">
                <option value="">Pilih Grup</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
