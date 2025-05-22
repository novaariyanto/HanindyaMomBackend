@extends('root')
@section('title', 'Setting Radius')
@section('content')
<div class="container">
    @include('components.breadcrumb', [
        'title' => 'Setting Radius',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Setting Radius'
    ])
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div id="map" style="height: 700px;"></div>
            <div class="mt-3">
                <p id="info"></p>
                @if(isset($radius))
                    <button id="btn-delete-radius" class="btn btn-danger">Hapus Radius</button>
                @endif
                <button id="btn-check-location" class="btn btn-primary ms-2">Cek Lokasi Saya</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
<!-- Load Leaflet and Leaflet Draw JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

<script>
    // Koordinat default
    var defaultCenter = [-6.7384033, 111.0442266]; // Latitude dan Longitude
    var defaultZoom = 30; // Zoom level default

    // Inisialisasi peta Leaflet
    var map = L.map('map').setView(defaultCenter, defaultZoom);

    // Tambahkan dua layer: Standar (OSM) dan Satelit
    var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    // Tambahkan layer kontrol untuk beralih antara mode
    var baseLayers = {
        "Standar": osmLayer,
        "Satelit": satelliteLayer
    };

    // Tambahkan layer default (satelit)
    satelliteLayer.addTo(map);

    // Tambahkan kontrol layer ke peta
    L.control.layers(baseLayers).addTo(map);

    // Variable untuk menyimpan objek yang digambar
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Tambahkan kontrol untuk menggambar di peta
    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            polygon: true, // Aktifkan menggambar polygon
            polyline: false, // Nonaktifkan menggambar polyline
            marker: false, // Nonaktifkan menggambar marker
            rectangle: false, // Nonaktifkan menggambar kotak otomatis
            circle: false // Nonaktifkan menggambar lingkaran
        }
    });
    map.addControl(drawControl);

    // Event listener untuk menangani objek yang digambar
    map.on('draw:created', function (e) {
        var layer = e.layer;
        drawnItems.addLayer(layer);

        // Cek apakah objek yang digambar adalah poligon
        if (layer instanceof L.Polygon) {
            var latlngs = layer.getLatLngs()[0]; // Mendapatkan koordinat titik-titik poligon
            // if (latlngs.length === 16) { // Poligon seharusnya memiliki 5 titik (termasuk titik penutup)
                // Hitung lebar dan tinggi kotak dalam meter
                var northEast = latlngs[2]; // Titik kanan atas
                var southWest = latlngs[0]; // Titik kiri bawah
                var width = northEast.distanceTo([southWest.lat, northEast.lng]); // Lebar horizontal
                var height = northEast.distanceTo([northEast.lat, southWest.lng]); // Tinggi vertikal

                // Format koordinat untuk disimpan
                var coordinates = latlngs.map(function (point) {
                    return [point.lat, point.lng];
                });

                // Tampilkan informasi
                document.getElementById('info').innerText = `Lebar: ${width.toFixed(2)} meter, Tinggi: ${height.toFixed(2)} meter`;

                // Kirim data ke backend
                fetch('/save-radius', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        coordinates: coordinates,
                        width: width,
                        height: height
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.meta.code == 200) {
                        alert('Radius berhasil disimpan!');
                    } else {
                        alert('Gagal menyimpan radius.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan radius.');
                });
            // } else {
            //     alert('Harap gambar kotak dengan 4 titik.');
            //     drawnItems.removeLayer(layer); // Hapus poligon jika tidak sesuai
            // }
        }
    });

    // Gambar polygon jika data radius tersedia
    @if(isset($radius))
        var savedCoordinates = {!! json_encode(json_decode($radius->coordinates)) !!};
        var polygon = L.polygon(savedCoordinates).addTo(map);
        map.fitBounds(polygon.getBounds()); // Sesuaikan tampilan peta dengan polygon
    @else
        // Jika tidak ada data radius, gunakan default lokasi
        map.setView(defaultCenter, defaultZoom);
    @endif

    // Handle tombol hapus radius
    document.getElementById('btn-delete-radius')?.addEventListener('click', function () {
        if (confirm('Apakah Anda yakin ingin menghapus radius?')) {
            fetch('/delete-radius', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.meta.code == 200) {
                    alert('Radius berhasil dihapus!');
                    location.reload(); // Refresh halaman setelah penghapusan
                } else {
                    alert('Gagal menghapus radius.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus radius.');
            });
        }
    });

    // Handle tombol cek lokasi
    document.getElementById('btn-check-location')?.addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('Geolocation tidak didukung di browser ini.');
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;

            // Tambahkan marker untuk lokasi pengguna
            var userMarker = L.marker([userLat, userLng]).addTo(map).bindPopup('Lokasi Anda').openPopup();

            // Kirim permintaan ke server untuk mengecek lokasi
            fetch('/check-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: userLat,
                    longitude: userLng
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.inside) {
                        alert('Anda berada di dalam radius.');
                    } else {
                        alert('Anda berada di luar radius.');
                    }
                } else {
                    alert('Gagal memeriksa lokasi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memeriksa lokasi.');
            });
        }, function (error) {
            alert('Geolocation tidak tersedia atau izin akses ditolak.');
        });
    });
</script>
@endpush