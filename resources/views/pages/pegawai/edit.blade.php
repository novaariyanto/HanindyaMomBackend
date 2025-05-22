<form action="{{ route('role.update', $role->id) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Role</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                placeholder="Masukkan nama role" 
                value="{{ old('name', $role->name) }}" 
                required>
        </div>
        {{-- <div class="mb-3">
            <label for="guard_name" class="form-label">Guard Name</label>
            <input 
                type="text" 
                class="form-control" 
                id="guard_name" 
                name="guard_name" 
                placeholder="Masukkan guard name" 
                value="{{ old('guard_name', $role->guard_name) }}" 
                required>
        </div> --}}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
