<form action="{{ route('shift.update', $shift->uuid) }}" method="POST" id="form">
    <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Shift</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')

        <!-- Kode Shift -->
        <div class="mb-3">
            <label for="kode_shift" class="form-label">Kode Shift</label>
            <input 
                type="text" 
                class="form-control" 
                id="kode_shift" 
                name="kode_shift" 
                placeholder="Masukkan kode shift (contoh: SPG)" 
                value="{{ old('kode_shift', $shift->kode_shift) }}">
        </div>

        <!-- Nama Shift -->
        <div class="mb-3">
            <label for="nama_shift" class="form-label">Nama Shift</label>
            <input 
                type="text" 
                class="form-control" 
                id="nama_shift" 
                name="nama_shift" 
                placeholder="Masukkan nama shift (contoh: Shift Pagi)" 
                value="{{ old('nama_shift', $shift->nama_shift) }}" 
                required>
        </div>

        <!-- Toleransi Terlambat -->
        <div class="mb-3">
            <label for="toleransi_terlambat" class="form-label">Toleransi Terlambat (Menit)</label>
            <input 
                type="number" 
                class="form-control" 
                id="toleransi_terlambat" 
                name="toleransi_terlambat" 
                placeholder="Masukkan toleransi terlambat dalam menit (contoh: 15)" 
                value="{{ old('toleransi_terlambat', $shift->toleransi_terlambat) }}">
        </div>


            <!-- Waktu Mulai Masuk & Akhir Masuk -->
            <div class="mb-3">
                <label class="form-label">Waktu Absen Masuk (Dalam Menit)</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control waktu-mulai-masuk" id="waktu_mulai_masuk" name="waktu_mulai_masuk" placeholder="Mulai dalam menit (cth: -10)" required value="{{$shift->waktu_mulai_masuk}}">
                    <span class="input-group-text">-</span>
                    <input type="number" class="form-control waktu-akhir-masuk" id="waktu_akhir_masuk" name="waktu_akhir_masuk" placeholder="Akhir dalam menit (cth: 10)" required value="{{$shift->waktu_akhir_masuk}}">
                </div>
                <p class="text-muted small info-masuk">Rentang absen masuk: -</p>
            </div>
            <!-- Waktu Mulai Keluar & Akhir Keluar -->
            <div class="mb-3">
                <label class="form-label">Waktu Absen Keluar (Dalam Menit)</label>
                <div class="input-group mb-3">
                    <input type="number" class="form-control waktu-mulai-keluar" id="waktu_mulai_keluar" name="waktu_mulai_keluar" placeholder="Mulai dalam menit (cth: -10)" required value="{{$shift->waktu_mulai_keluar}}">
                    <span class="input-group-text">-</span>
                    <input type="number" class="form-control waktu-akhir-keluar" id="waktu_akhir_keluar" name="waktu_akhir_keluar" placeholder="Akhir dalam menit (cth: 10)" required value="{{$shift->waktu_akhir_keluar}}">
                </div>
                <p class="text-muted small info-keluar">Rentang absen keluar: -</p>
            </div>
            

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" disabled {{ old('status', $shift->status) ? '' : 'selected' }}>Pilih status</option>
                <option value="1" {{ old('status', $shift->status) == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="2" {{ old('status', $shift->status) == '2' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea 
                class="form-control" 
                id="keterangan" 
                name="keterangan" 
                rows="3" 
                placeholder="Masukkan keterangan (opsional)">
                {{ old('keterangan', $shift->keterangan) }}
            </textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>



<script>
    $(document).ready(function () {
        // Jam masuk dan keluar statis
        const jamMasuk = "07:00";
        const jamKeluar = "15:00";

        // Fungsi untuk mengonversi waktu HH:mm menjadi objek Date
        function parseTime(timeString) {
            const [hours, minutes] = timeString.split(":").map(Number);
            const date = new Date();
            date.setHours(hours, minutes, 0, 0); // Set waktu tanpa tanggal
            return date;
        }

        // Fungsi untuk menambah/mengurangi menit dari waktu
        function adjustTime(baseTime, minutes) {
            const adjustedTime = new Date(baseTime.getTime() + minutes * 60000);
            return adjustedTime;
        }

        // Fungsi untuk memformat waktu sebagai HH:mm
        function formatTime(date) {
            const hours = String(date.getHours()).padStart(2, "0");
            const minutes = String(date.getMinutes()).padStart(2, "0");
            return `${hours}:${minutes}`;
        }

        // Simulasi rentang absen saat input berubah
        function updateAbsenRange(baseTime, mulaiInput, akhirInput, infoElement) {
            const base = parseTime(baseTime);

            // Update rentang waktu
            const startTime = adjustTime(base, parseInt(mulaiInput.val()) || 0);
            const endTime = adjustTime(base, parseInt(akhirInput.val()) || 0);

            // Tampilkan informasi rentang absen
            infoElement.html(`Contoh Rentang Absen Jika Mulai jam ${baseTime} = <b> ${formatTime(startTime)} - ${formatTime(endTime)} </b>`);
        }

        // Event listener untuk absen masuk
        $("#waktu_mulai_masuk, #waktu_akhir_masuk").on("change", function () {
            updateAbsenRange(
                jamMasuk,
                $("#waktu_mulai_masuk"),
                $("#waktu_akhir_masuk"),
                $(".info-masuk")
            );
        });

        // Event listener untuk absen keluar
        $("#waktu_mulai_keluar, #waktu_akhir_keluar").on("change", function () {
            updateAbsenRange(
                jamKeluar,
                $("#waktu_mulai_keluar"),
                $("#waktu_akhir_keluar"),
                $(".info-keluar")
            );
        });
    });
</script>
