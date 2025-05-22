@extends('root')
@section('title', 'Detail Absensi')
@section('content')
<div class="p-2">
    @include('components.breadcrumb', [
        'title' => 'Detail Absensi',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('absensi.index'), 'label' => 'Data Absensi'],
        ],
        'current' => 'Detail Absensi',
    ])
    <div class="widget-content searchable-container list">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-body">
            <h4 class="mb-3">Detail Absensi</h4>
            <div class="wrap-table">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $data['nik'] }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pegawai</th>
                            <td>{{ $data['nama'] }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $data['tanggal'] }}</td>
                        </tr>
                        <tr>
                            <th>Jam Masuk Jadwal</th>
                            <td>{{ $data['jam_masuk_jadwal'] }}</td>
                        </tr>
                        <tr>
                            <th>Jam Masuk</th>
                            <td>{{ $data['jam_masuk'] }}</td>
                        </tr>
                        <tr>
                            <th>Jam Keluar Jadwal</th>
                            <td>{{ $data['jam_keluar_jadwal'] }}</td>
                        </tr>
                        <tr>
                            <th>Jam Keluar</th>
                            <td>{{ $data['jam_keluar'] }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $data['status'] }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $data['keterangan'] }}</td>
                        </tr>
                        <tr>
                            <td><b>Masuk</b></td>
                            <td>
                                @if ($data['face_landmarks_in'])
                                    
                                <img style="max-width: 200px; height: auto; display: block;" 
                                src="{{ url('landmarks?uuid='.$data['uuid'].'&type=in') }}" 
                                alt="Foto Masuk">
                                @endif
                            </td>
                            
                        </tr>


                        <tr>
                            <td><b>Keluar</b></td>
                            <td>
                                @if ($data['face_landmarks_out'])

                                <img style="max-width: 200px; height: auto; display: block;" 
                                     src="{{ url('landmarks?uuid='.$data['uuid'].'&type=out') }}" 
                                     alt="Foto Masuk">
                                     @endif
                            </td>
                            
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Peta Lokasi Masuk dan Keluar -->
            <h5 class="mt-4 mb-3">Lokasi Masuk dan Keluar</h5>
            <div id="map" style="height: 700px; width: 100%;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Fungsi untuk inisialisasi peta dengan dua marker berbeda warna
    function initMap() {
        const latitudeMasuk = parseFloat('{{ $data["latitude_masuk"] }}');
        const longitudeMasuk = parseFloat('{{ $data["longitude_masuk"] }}');
        const latitudeKeluar = parseFloat('{{ $data["latitude_keluar"] }}');
        const longitudeKeluar = parseFloat('{{ $data["longitude_keluar"] }}');

        // Validasi koordinat masuk
        if (!latitudeMasuk || !longitudeMasuk) {
            console.warn('Koordinat masuk tidak tersedia untuk menampilkan peta.');
            return;
        }

        // Tentukan pusat peta berdasarkan koordinat masuk
        let centerLat = latitudeMasuk;
        let centerLng = longitudeMasuk;

        // Inisialisasi peta
        const map = L.map('map').setView([centerLat, centerLng], 15); // Zoom level 15

        // Tambahkan layer OpenStreetMap (default)
        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        });

        // Tambahkan layer satelit dari ESRI
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

        // Tambahkan kontrol layer untuk memilih antara OSM dan Satelit
        const baseLayers = {
            "Peta Jalan": osmLayer,
            "Satelit": satelliteLayer
        };

        // Tambahkan layer satelit sebagai default
        satelliteLayer.addTo(map);

        // Tambahkan kontrol layer ke peta
        L.control.layers(baseLayers).addTo(map);

        // Marker untuk lokasi masuk (warna hijau)
        L.marker([latitudeMasuk, longitudeMasuk], { icon: greenIcon })
            .addTo(map)
            .bindPopup("Lokasi Masuk")
            .openPopup();

        // Marker untuk lokasi keluar (warna merah), jika koordinat tersedia
        if (latitudeKeluar && longitudeKeluar) {
            L.marker([latitudeKeluar, longitudeKeluar], { icon: redIcon })
                .addTo(map)
                .bindPopup("Lokasi Keluar");

            // Gambar garis antara lokasi masuk dan keluar
            const points = [
                [latitudeMasuk, longitudeMasuk],
                [latitudeKeluar, longitudeKeluar]
            ];
            L.polyline(points, { color: 'blue' }).addTo(map);

            // Update pusat peta ke tengah antara masuk dan keluar
            centerLat = (latitudeMasuk + latitudeKeluar) / 2;
            centerLng = (longitudeMasuk + longitudeKeluar) / 2;
            map.setView([centerLat, centerLng], 15);
        }
    }

    // Definisikan ikon kustom untuk marker
    const greenIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Inisialisasi peta saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        initMap();
    });
</script>
@endpush