<form action="{{ route('shift.update_jam', $shift->uuid) }}" method="POST" id="form">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Edit Jam Kerja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th> <!-- Kolom baru untuk tombol reset -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Massal</b></td>
                    <td>
                        <input type="time" id="mass_jam_mulai" class="form-control" onchange="fillMassJamMulai()">
                    </td>
                    <td>
                        <input type="time" id="mass_jam_selesai" class="form-control" onchange="fillMassJamSelesai()">
                    </td>
                    <td></td> <!-- Tidak ada aksi untuk baris massal -->
                </tr>
                @php
                    // Mapping nama hari ke angka
                    $hariMapping = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu',
                    ];
                @endphp
                @foreach ($hariMapping as $hariValue => $hariLabel)
                    <tr>
                        <td>{{ $hariLabel }}</td>
                        <td>
                            <input type="time" name="jam_mulai[{{ $hariValue }}]" class="form-control jam_mulai" value="{{ old('jam_mulai.' . $hariValue, $formattedJamKerja[$hariValue]['jam_mulai'] ?? '') }}">
                            @error('jam_mulai.' . $hariValue)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <input type="time" name="jam_selesai[{{ $hariValue }}]" class="form-control jam_selesai" value="{{ old('jam_selesai.' . $hariValue, $formattedJamKerja[$hariValue]['jam_selesai'] ?? '') }}">
                            @error('jam_selesai.' . $hariValue)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </td>
                        <td>
                            <!-- Tombol Reset -->
                            <button type="button" class="btn btn-sm btn-danger" onclick="resetHari({{ $hariValue }})">
                                Reset
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script>
    // Fungsi untuk mengisi semua input "Jam Mulai" secara massal
function fillMassJamMulai() {
    const massJamMulai = document.getElementById('mass_jam_mulai').value;
    const jamMulaiInputs = document.querySelectorAll('.jam_mulai');
    jamMulaiInputs.forEach(input => {
        input.value = massJamMulai;
    });
}

// Fungsi untuk mengisi semua input "Jam Selesai" secara massal
function fillMassJamSelesai() {
    const massJamSelesai = document.getElementById('mass_jam_selesai').value;
    const jamSelesaiInputs = document.querySelectorAll('.jam_selesai');
    jamSelesaiInputs.forEach(input => {
        input.value = massJamSelesai;
    });
}

// Fungsi untuk mereset nilai jam mulai dan selesai untuk hari tertentu
function resetHari(hariValue) {
    const jamMulaiInput = document.querySelector(`input[name="jam_mulai[${hariValue}]"]`);
    const jamSelesaiInput = document.querySelector(`input[name="jam_selesai[${hariValue}]"]`);
    if (jamMulaiInput && jamSelesaiInput) {
        jamMulaiInput.value = ''; // Kosongkan jam mulai
        jamSelesaiInput.value = ''; // Kosongkan jam selesai
    }
}

</script>