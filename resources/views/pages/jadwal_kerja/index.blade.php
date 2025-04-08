@extends('root')
@section('title', 'Jadwal Kerja')
@section('content')
    <div class="p-2">
        @include('components.breadcrumb', [
            'title' => 'Jadwal Kerja',
            'links' => [['url' => route('dashboard'), 'label' => 'Dashboard']],
            'current' => 'Jadwal Kerja',
        ])
        <div class="widget-content searchable-container list">
            <!-- Notifikasi Sukses -->
            <div class="card card-body">
                <div class="row">

                    @if (!@auth()->user()->pegawai->divisi_id)
                    {{-- $divisiId = Auth::user()->pegawai->divisi_id --}}
                    <div class="col-md-3 col-xl-3">
                        <div class="me-3">
                            <label for="filter-divisi" class="form-label visually-hidden">Filter Divisi</label>
                            <select class="form-select" id="filter-divisi">
                                <option value="">Semua Divisi</option>
                            </select>
                        </div>
                    </div>           
                    @endif
             
                    <div class="col-md-3 col-xl-3">
                        <div class="me-3">
                            <label for="filter-bulan" class="form-label visually-hidden">Filter Bulan</label>
                            <select class="form-select" id="filter-bulan">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3">
                        <div class="me-3">
                            <label for="filter-tahun" class="form-label visually-hidden">Filter Tahun</label>
                            <select class="form-select" id="filter-tahun">
                                <option value="">Semua Tahun</option>
                                @for ($i = now()->year - 5; $i <= now()->year + 5; $i++)
                                    <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center btn-create" data-url="{{route('jadwal-kerja.create')}}" id="addBtn">
                            <i class="ti ti-plus me-1 fs-5"></i> Jadwal
                        </a>
                        <a href="javascript:void(0)" class="btn btn-success d-flex align-items-center btn-create" id="importBtn" data-url="{{route('jadwal-kerja.import')}}">
                            <i class="ti ti-upload me-1 fs-5"></i> Import
                        </a>
                        <a href="javascript:void(0)" class="btn btn-info d-flex align-items-center" id="exportBtn">
                            <i class="ti ti-download me-1 fs-5"></i> Export
                        </a>
                    </div>
                    
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Tabel Jadwal Kerja -->
            <div class="alert alert-info">

                <strong>Info!</strong> Klik dan seret untuk memilih jadwal kerja.

            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="jadwal-kerja-table">
                        <thead>
                            <tr>
                                <th rowspan="2" data-nama-pegawai="Nama Pegawai">Nama Pegawai</th>
                                <!-- Kolom tanggal akan dimuat melalui JavaScript -->
                            </tr>
                            <tr id="hari-header">
                                <!-- Inisial hari akan dimuat melalui JavaScript -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
                        </tbody>
                    </table>
                    <div class="jadwal-kerja-keterangan">

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Pilihan Tanggal dan Pegawai -->
        <div class="modal fade" id="tanggalSelectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Shift</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-jadwal">
                            <input type="hidden" id="hiddenTanggal" name="tanggal">
                                <input type="hidden" id="hiddenPegawaiId" name="pegawai_id">


                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" id="namaPegawaiInput" name="nama_pegawai" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="tanggalInput" name="tanggal" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilih Shift</label>
                                <select class="form-select" name="shift" id="shift">
                                  
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger submitJadwal" data-type="delete">Hapus</button>
                        <button type="submit" class="btn btn-primary submitJadwal" data-type="store">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <style>
        /* Atur agar tabel menggunakan layout tetap */
#jadwal-kerja-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

/* Atur lebar kolom pertama (Nama Pegawai) */
#jadwal-kerja-table th:first-child,
#jadwal-kerja-table td:first-child {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    text-align: left;
    padding: 8px;
}

/* Atur lebar kolom tanggal secara proporsional */
#jadwal-kerja-table th,
#jadwal-kerja-table td {
    text-align: center;
    padding: 8px;
    border: 1px solid #ddd;
    word-wrap: break-word;
}

/* Gaya untuk hari Minggu */
#jadwal-kerja-table th.sunday,
#jadwal-kerja-table td.sunday {
    background-color: #ffdddd;
    color: #d9534f;
    font-weight: bold;
}

/* Tambahkan efek hover untuk baris */
#jadwal-kerja-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Header tabel */
#jadwal-kerja-table thead th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    #jadwal-kerja-table {
        font-size: 12px;
    }
    #jadwal-kerja-table th:first-child,
    #jadwal-kerja-table td:first-child {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
    }
}


        #jadwal-kerja-table th,
#jadwal-kerja-table td {
    user-select: none; /* Mencegah pemilihan teks */
    -webkit-user-select: none; /* Untuk browser berbasis WebKit (Chrome, Safari) */
    -moz-user-select: none; /* Untuk Firefox */
    -ms-user-select: none; /* Untuk Edge */
}


    .sunday {
        background-color: #f8d7da !important; /* Merah muda */
        color: #721c24 !important; /* Warna teks gelap untuk kontras */
    }

    .selected {
        background-color: lightblue !important;
        color: white !important;
}


.selecteds {
        background-color: lightblue !important;
        color: white !important;
}




    </style>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragselect/3.1.1/DragSelect.min.js" integrity="sha512-H/g7nMGt62T/f21m0R6KSym/PiHM+EdqPb8tpq9r2G/G8OIaMM4tLwM/M7hCIbEI9r+nBZIbLKAzwaQEHnALeQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>


$(document).ready(function () {

    $('.submitJadwal').click(function(e) {
        e.preventDefault();
        var type = $(this).attr('data-type');

        let formData = {
            type: type,
            tanggal: $('#hiddenTanggal').val(),
            pegawai_id: $('#hiddenPegawaiId').val(),
            shift: $('#shift').val(),
        };

        $.ajax({
            url: '{{route('jadwal-kerja.store')}}', // Ganti dengan URL endpoint Laravel kamu
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pastikan ada meta CSRF di <head>
            },
            dataType:"JSON",
            success: function(response) {
                
                if (response.meta.code === 200) {

                    // alert('Jadwal berhasil disimpan!');
                    $('#tanggalSelectionModal').modal('hide'); // Tutup modal

                    $('#successToast .msg-box').text(response.meta.message);
    
                    $('#successToast').toast('show');  // Menampilkan toast
                    loadJadwalKerja()   ;

                    // location.reload(); // Refresh halaman atau update tampilan


                }
                // alert('Jadwal berhasil disimpan!');
                // $('#tanggalSelectionModal').modal('hide'); // Tutup modal
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });

    $('#shift').select2({
        width: '100%',
        dropdownParent: $('#tanggalSelectionModal'),
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


    // Inisialisasi Select2 untuk filter divisi
    $('#filter-divisi').select2({
        placeholder: 'Pilih Divisi',
        allowClear: true,
        ajax: {
            url: '{{ route('select2.divisi') }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                let results = data.data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.nama
                    };
                });
                results.unshift({ id: '', text: 'Tampilkan Semua' });
                return {
                    results: results,
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0,
    });

    // Fungsi untuk memuat data jadwal kerja melalui AJAX
    function loadJadwalKerja() {
    const divisiId = $('#filter-divisi').val();
    const bulan = $('#filter-bulan').val() || new Date().getMonth() + 1; // Default ke bulan saat ini
    const tahun = $('#filter-tahun').val() || new Date().getFullYear(); // Default ke tahun saat ini

    $.ajax({
        url: '{{ route('jadwal-kerja.index') }}',
        type: 'GET',
        data: {
            divisi_id: divisiId,
            bulan: bulan,
            tahun: tahun
        },
        dataType: 'json',
        success: function (response) {
            console.log('Response from server:', response); // Debugging
            
            const tableBody = $('#jadwal-kerja-table tbody');
            const tableHead = $('#jadwal-kerja-table thead tr:first-child');
            const hariHeader = $('#hari-header');
            tableBody.empty(); // Kosongkan isi tabel sebelumnya
            tableHead.empty(); // Kosongkan header tabel sebelumnya
            hariHeader.empty(); // Kosongkan baris inisial hari

            // Jika tidak ada data pegawai, tampilkan pesan
            if (!response || response.length === 0) {
                tableBody.append('<tr><td colspan="100%" class="text-center">Tidak ada data pegawai</td></tr>');
                return;
            }

            // Ambil semua tanggal unik dari data JSON
            const allDates = new Set();
            response.pegawai.forEach(pegawai => {
                Object.keys(pegawai.jadwal).forEach(date => {
                    allDates.add(parseInt(date));
                });
            });

            // Urutkan tanggal secara ascending
            const sortedDates = Array.from(allDates).sort((a, b) => a - b);

            // Tambahkan kolom "Nama Pegawai" ke header
            tableHead.append('<th rowspan="2" data-nama-pegawai="Nama Pegawai">Nama Pegawai</th>');

            // Tambahkan kolom untuk setiap tanggal
            sortedDates.forEach(date => {
                const fullDate = `${tahun}-${String(bulan).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                const parsedDate = new Date(fullDate);
                const isSunday = parsedDate.getDay() === 0; // 0 = Minggu

                // Tambahkan kelas .sunday jika hari Minggu
                const thClass = isSunday ? 'class="sunday"' : '';
                tableHead.append(`<th ${thClass} data-date="${fullDate}">${date}</th>`);
            });

            // Tambahkan inisial hari
            sortedDates.forEach(date => {
                const fullDate = `${tahun}-${String(bulan).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                const parsedDate = new Date(fullDate);
                const dayIndex = parsedDate.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
                const dayName = ['MG', 'SN', 'SL', 'RB', 'KM', 'JM', 'SB'][dayIndex];
                const isSunday = dayIndex === 0;

                // Tambahkan kelas .sunday jika hari Minggu
                const thClass = isSunday ? 'class="sunday"' : '';
                hariHeader.append(`<th ${thClass}>${dayName}</th>`);
            });

            // Loop melalui data pegawai
            response.pegawai.forEach(pegawai => {
                let row = `<tr><td data-pegawai-id="${pegawai.id}" data-nama-pegawai="${pegawai.nama_pegawai}">${pegawai.nama_pegawai}</td>`;
                sortedDates.forEach(date => {
                    const fullDate = `${tahun}-${String(bulan).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                    const parsedDate = new Date(fullDate);
                    const isSunday = parsedDate.getDay() === 0;

                    // Tambahkan kelas .sunday jika hari Minggu
                    const tdClass = isSunday ? 'class="sunday"' : '';
                    row += `<td ${tdClass} data-date="${fullDate}" data-pegawai-id="${pegawai.id}">
                                ${pegawai.jadwal[date] || '-'}
                            </td>`;
                });
                row += '</tr>';
                tableBody.append(row);
            });

            var shifts_in_divisi = response.shifts_in_divisi;
if (shifts_in_divisi) {
    console.log(shifts_in_divisi);
    var html = ''; // Inisialisasi string HTML kosong
    html += '<b>KETERANGAN:</b> <br>';
    $.each(shifts_in_divisi, function (kodeShift, namaShift) {
        console.log(kodeShift + ': ' + namaShift);

        // Tambahkan data ke dalam satu baris dengan pemisah " | "
        html += '<span>' + kodeShift + '</span> : <span>' + namaShift + '</span> | ';
    });

    // Hapus pemisah terakhir (" | ") agar tidak ada ekstra di akhir
    if (html.length > 0) {
        html = html.slice(0, -3); // Menghapus 3 karakter terakhir (" | ")
    }

    // Masukkan HTML ke elemen dengan class "jadwal-kerja-keterangan"
    $(".jadwal-kerja-keterangan").html(html);
}

            // Inisialisasi DragSelect setelah tabel dimuat
            initializeDragSelect(sortedDates);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

    // Muat data saat halaman dimuat
    loadJadwalKerja();

    // Event listener untuk filter divisi, bulan, dan tahun
    // $('#filter-divisi, #filter-bulan, #filter-tahun').on('change', function () {
    //     loadJadwalKerja();
    // });

    $(document).on('change','#filter-divisi, #filter-bulan, #filter-tahun',function () {
        loadJadwalKerja();
    })

    // Fungsi untuk inisialisasi DragSelect
    
    function initializeDragSelect(sortedDates) {
        if (window.ds) {
        window.ds.stop(); // Hentikan DragSelect sebelumnya
    }

    let selectedData = [];

    let isDragging = false;

    
        window.ds = new DragSelect({
        selectables: document.querySelectorAll('#jadwal-kerja-table td'), // Hanya <td>
        area: document.querySelector('#jadwal-kerja-table'),
        multiSelectMode: true,
        hoverClass: 'selecteds',

    });

    // Saat mulai drag, reset semua seleksi sebelumnya
      // Saat mulai drag, reset semua seleksi sebelumnya
      window.ds.subscribe('DS:start', () => {
        selectedData = [];
        document.querySelectorAll('#jadwal-kerja-table td.selected, #jadwal-kerja-table td.dragging').forEach(item => {
            item.classList.remove('selected', 'dragging');
        });
    });
    // Saat sedang drag (belum lepas mouse), ubah warna td
     // Saat sedang drag (belum lepas mouse), ubah warna td
    

    // Saat drag selesai (mouse dilepas)
    window.ds.subscribe('DS:end', ({ items }) => {
        document.querySelectorAll('#jadwal-kerja-table td.dragging').forEach(item => {
            item.classList.remove('dragging');
        });

        let selectedPegawai = new Set();
        let selectedDates = new Set();
        let selectedPegawaiId = new Set();


        items.forEach(item => {
            console.log(item);
            item.classList.add('selected');
            const date = item.dataset.date;
            const pegawaiId = item.dataset.pegawaiId;
            const namaPegawai = item.closest('tr').querySelector('td[data-nama-pegawai]')?.dataset.namaPegawai || '';

            if (date) selectedDates.add(date);
            if (namaPegawai) selectedPegawai.add(namaPegawai);

        if (date) selectedDates.add(date);
        if (pegawaiId) selectedPegawaiId.add(pegawaiId);
        // if (namaPegawai) selectedPegawai.add(namaPegawai);


        });

        console.log('Data Terpilih:', selectedPegawai, selectedDates);

        // Format tanggal agar lebih rapi
        function formatDate(dateString) {
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            let [year, month, day] = dateString.split("-");
            return `${day} ${months[parseInt(month) - 1]}`;
        }

        // Gabungkan data pegawai dan tanggal ke dalam input form
        $('#namaPegawaiInput').val([...selectedPegawai].join(", "));
        $('#tanggalInput').val(formatDateRange([...selectedDates]));

function formatDateRange(dates) {
    if (dates.length === 0) return '';

    // Urutkan tanggal
    dates.sort((a, b) => new Date(a) - new Date(b));

    const firstDate = formatDate(dates[0]);
    const lastDate = formatDate(dates[dates.length - 1]);

    return firstDate === lastDate ? firstDate : `${firstDate} - ${lastDate}`;
}

        $('#hiddenTanggal').val([...selectedDates].join(","));
        $('#hiddenPegawaiId').val([...selectedPegawaiId].join(","));
    

        // Tampilkan modal jika ada data yang dipilih
        if (selectedPegawai.size > 0 && selectedDates.size > 0) {
            $('#tanggalSelectionModal').modal('show');
        }
        // selectedData = [];

    });

    // Reset seleksi ketika modal ditutup
    $('#tanggalSelectionModal').one('hidden.bs.modal', function () {
        document.querySelectorAll('#jadwal-kerja-table td.selected').forEach(item => {
            item.classList.remove('selected');
        });

        // alert('Data berhasil disimpan');    

        ds.clearSelection();
        selectedData = [];
        $('#selected-data-list').empty();
    });
}



});

document.getElementById('exportBtn').addEventListener('click', function() {
    var divisiId = document.getElementById('filter-divisi').value;
    var bulan = document.getElementById('filter-bulan').value;
    var tahun = document.getElementById('filter-tahun').value;

    var url = new URL("{{ route('jadwal-kerja.export') }}", window.location.origin);
    var params = new URLSearchParams();

    if (divisiId) params.append('divisi_id', divisiId);
    if (bulan) params.append('bulan', bulan);
    if (tahun) params.append('tahun', tahun);

    window.location.href = url + '?' + params.toString();
});

    </script>
@endpush