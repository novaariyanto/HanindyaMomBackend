<form action="{{ route('role.store') }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Buat Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Role</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                placeholder="Masukkan nama role" 
                required>
        </div>
     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
