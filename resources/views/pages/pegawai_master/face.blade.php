<form method="POST" enctype="multipart/form-data" id="form" action="{{route('pegawai_master.faceSave')}}">
    @csrf
    <input type="hidden" name="uuid" id="form_type" value="{{$uuid}}">

    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Verifikasi Wajah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- Tabs -->
        <ul class="nav nav-underline" id="photoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="foto-tab" data-bs-toggle="tab" data-bs-target="#foto" type="button" role="tab" aria-controls="foto" aria-selected="true">Foto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tambahkan-foto-tab" data-bs-toggle="tab" data-bs-target="#tambahkan-foto" type="button" role="tab" aria-controls="tambahkan-foto" aria-selected="false">Tambahkan Foto</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="photoTabsContent">
            <!-- Tab Foto -->
            <div class="tab-pane fade show active" id="foto" role="tabpanel" aria-labelledby="foto-tab">
                @if (!empty($photo))
                    <img src="{{ url($photo->path) }}" alt="Foto Profil" class="img-fluid">
                    <br><br>
                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger" id="delete-photo-btn">Hapus Foto</button>
                    <div id="confirmation-container" style="display: none; margin-top: 10px;">
                        <p>Ketik <strong>hapus</strong> untuk mengonfirmasi:</p>
                        <input type="text" id="confirmation-input" class="form-control" placeholder="Ketik 'hapus'">
                        <button type="button" class="btn btn-danger mt-2" id="confirm-delete-btn">Konfirmasi Hapus</button>
                    </div>
                @else
                    <p>Tidak ada foto yang tersedia.</p>
                @endif
            </div>

            <!-- Tab Tambahkan Foto -->
            <div class="tab-pane fade" id="tambahkan-foto" role="tabpanel" aria-labelledby="tambahkan-foto-tab">
                <div class="mb-3">
                    <label for="photo" class="form-label">Unggah Foto Baru</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                </div>
                <!-- Preview Area -->
                <br>
                <div id="preview-container" class="mt-3" style="display: none;">
                    <label class="form-label">Preview Gambar:</label><br>
                    <img id="preview-image" src="#" alt="Preview" class="img-fluid" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<!-- jQuery dan AJAX untuk Konfirmasi Hapus -->
<script>
$(document).ready(function () {

    // Preview gambar saat file dipilih
    $('#photo').on('change', function (event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
                $('#preview-container').show(); // Menampilkan preview
            };
            
            reader.readAsDataURL(input.files[0]); // Membaca file sebagai URL
        }
    });

    
    // Tampilkan container konfirmasi saat tombol hapus diklik
    $('#delete-photo-btn').on('click', function () {
        $('#confirmation-container').show();
    });

    // Handle klik tombol "Konfirmasi Hapus"
    $('#confirm-delete-btn').on('click', function () {
        const confirmationInput = $('#confirmation-input').val().trim();

        // Periksa apakah input sesuai
        if (confirmationInput === 'hapus') {
            const uuid = $('#form_type').val();

            // Kirim permintaan DELETE menggunakan AJAX
            $.ajax({
                url: `/pegawai-master/faceDelete/${uuid}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:"JSON",
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Foto berhasil dihapus.');
                        location.reload(); // Refresh halaman untuk memperbarui tampilan
                    } else {
                        alert('Gagal menghapus foto: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus foto.');
                }
            });
        } else {
            alert('Konfirmasi gagal. Harap ketik "hapus" dengan benar.');
        }
    });
});
</script>