<form action="{{ route('jam-kerja.store') }}" method="POST" id="form" >
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Tambah Jam Kerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        
        <!-- Input Nama Divisi -->
        <div class="mb-3">
            <label for="divisi" class="form-label">Nama Divisi</label>
            <select class="form-select select2" id="divisi" name="divisi" required>
                @if(isset($divisi_id))
                    <option value="{{ $divisi->id }}" selected>{{ $divisi->nama }}</option>
                @endif
            </select>
        </div>

        <!-- Input Nama Shift -->
        <div class="mb-3">
            <label for="shift" class="form-label">Nama Shift</label>
            <select class="form-select select2" id="shift" name="shift" required></select>
        </div>


       
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>

$(document).ready(function () {
    // Inisialisasi Select2 untuk Divisi
    $('#divisi').select2({
        width: '100%',
        dropdownParent: $('#form').closest('.modal'),
        ajax: {
            url: '{{ route("select2.divisi") }}', // Endpoint untuk Divisi
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // Istilah pencarian
                    page: params.page || 1 // Halaman saat ini
                };
            },
            processResults: function (data) {
                return {
                    results: data.data.map(item => ({
                        id: item.id,
                        text: item.nama // Gunakan kolom "nama" untuk Divisi
                    })),
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        }
    });

    // Inisialisasi Select2 untuk Shift
    $('#shift').select2({
        width: '100%',
        dropdownParent: $('#form').closest('.modal'),
        ajax: {
            url: '{{ route("select2.shift") }}', // Endpoint untuk Shift
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // Istilah pencarian
                    page: params.page || 1 // Halaman saat ini
                };
            },
            processResults: function (data) {
                return {
                    results: data.data.map(item => ({
                        id: item.id,
                        text: item.nama_shift // Gunakan kolom "nama_shift" untuk Shift
                    })),
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        }
    });
});

</script>
