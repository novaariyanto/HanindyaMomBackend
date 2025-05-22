
<form action="{{ route('jadwal-absensi.importExcel') }}" method="POST" enctype="multipart/form-data" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Import Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
      
        <div class="alert alert-info">
            File Excel didapatkan ketika export jadwal
        </div>
        <div class="mb-3">
            <label for="file">Unggah File Excel</label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls" required class="form-control">
        </div>

        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

