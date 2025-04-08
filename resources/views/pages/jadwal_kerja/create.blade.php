<form action="{{ route('jadwal-kerja.set') }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Buat Jadwal Kerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf

        <!-- Select2 Divisi dari Server -->
        <div class="mb-3">
            <label for="divisi" class="form-label">Pilih Divisi</label>
            <select class="form-select" id="divisi" name="divisi" required></select>
        </div>

        <!-- Opsi Semua Pegawai -->
        <div class="mb-3">
            <label class="form-label">Apakah untuk Semua Pegawai?</label>
            <div>
                <input type="radio" id="semuaPegawaiYa" name="semua_pegawai" value="ya" checked>
                <label for="semuaPegawaiYa">Ya</label>

                <input type="radio" id="semuaPegawaiTidak" name="semua_pegawai" value="tidak">
                <label for="semuaPegawaiTidak">Tidak</label>
            </div>
        </div>

        <!-- Select Pegawai (Muncul jika Tidak Memilih Semua Pegawai) -->
        <div class="mb-3 d-none" id="pegawaiSelectContainer">
            <label for="pegawai" class="form-label">Pilih Pegawai</label>
            <select class="form-select" id="pegawai" name="pegawai[]" multiple></select>
        </div>

        <!-- Range Tanggal -->
        <div class="mb-3">
            <label for="tanggal_awal" class="form-label">Pilih Rentang Tanggal</label>
            <div class="d-flex gap-2">
                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
                <span class="align-self-center">s/d</span>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
            </div>
        </div>

        <!-- Select2 Shift dari Server -->
        <div class="mb-3">
            <label for="shift" class="form-label">Pilih Shift</label>
            <select class="form-select" id="shifts" name="shift" required></select>
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
            placeholder: 'Pilih Divisi',
            dropdownParent: $("#createModal"),
            allowClear: true,
            ajax: {
                url: '{{ route("select2.divisi") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    let results = data.data.map(item => ({ id: item.id, text: item.nama }));
                    results.unshift({ id: '', text: 'Tampilkan Semua' });
                    return { results, pagination: { more: data.current_page < data.last_page } };
                },
                cache: true
            },
            minimumInputLength: 0,
        });

        // Inisialisasi Select2 untuk Pegawai
        $('#pegawai').select2({
            dropdownParent: $("#createModal"),
            placeholder: "Pilih Pegawai",
            allowClear: true,
            ajax: {
                url: '{{ route("select2.pegawai") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        divisi_id: $('#divisi').val(),
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    let results = data.data.map(item => ({ id: item.id, text: item.nama }));
                    return { results, pagination: { more: data.current_page < data.last_page } };
                },
                cache: true
            },
            minimumInputLength: 0,
        });

        // Inisialisasi Select2 untuk Shift dengan parameter divisi_id
        $('#shifts').select2({
            dropdownParent: $("#createModal"),
            placeholder: "Pilih Shift",
            allowClear: true,
            ajax: {
                url: '{{ route("select2.shift") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        divisi_id: $('#divisi').val(), // Kirim divisi_id sebagai parameter
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    let results = data.data.map(item => ({
                        id: item.id,
                        text: `(${item.kode_shift}) ${item.nama_shift}`
                    }));
                    return { results, pagination: { more: data.current_page < data.last_page } };
                },
                cache: true
            },
            minimumInputLength: 0,
        });

        // Event listener untuk reset Pegawai saat Divisi berubah
        $('#divisi').on('change', function () {
            $("#pegawai").val(null).trigger("change");
            $("#shifts").val(null).trigger("change"); // Reset Shift saat Divisi berubah
        });

        // Toggle Select Pegawai berdasarkan pilihan "Semua Pegawai"
        $('input[name="semua_pegawai"]').on('change', function () {
            if ($(this).val() === "tidak") {
                $('#pegawaiSelectContainer').removeClass("d-none");
            } else {
                $('#pegawaiSelectContainer').addClass("d-none");
            }
        });
    });
</script>
