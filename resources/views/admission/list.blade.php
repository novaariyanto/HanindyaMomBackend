@extends('root')
@section('title', 'Data Admission')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Admission',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Admission'
    ])
    
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-4 col-xl-3">
            <form class="position-relative">
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Data">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-2 col-xl-3">
            <select class="form-select" id="filter-penjamin">
             <option value="">Pilih Penjamin</option>
             <option value="1">BPJS Kesehatan</option>
             <option value="2">Umum</option>
            </select>
          </div>
          <div class="col-md-4 col-xl-3">
            <select class="form-select" id="filter-tahun">
              <option value="">Pilih Tahun</option>
              @php
                $tahunSekarang = date('Y');
                for($tahun = 2020; $tahun <= $tahunSekarang; $tahun++) {
                  echo "<option value='".$tahun."'>".$tahun."</option>";
                }
              @endphp
            </select>
          </div>

          <div class="col-md-4 col-xl-3">
            <select class="form-select" id="filter-bulan">
              <option value="">Pilih Bulan</option>
              @php
                $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                foreach($namaBulan as $index => $bulan) {
                  echo "<option value='".($index + 1)."'>".$bulan."</option>";
                }
              @endphp
            </select>
          </div>
          <div class="col-md-2 col-xl-3">
            <button type="button" class="btn btn-success" id="btn-export-excel">
              <i class="ti ti-file-export me-1"></i> Export Excel
            </button>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Admission</th>
                        <th>Tanggal Verifikasi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Biaya Diajukan</th>
                        <th>Biaya Disetujui</th>
                        <th>Biaya Riil RS</th>
                        <th>Nomr</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via DataTables AJAX -->
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Fungsi untuk mengatur opsi bulan berdasarkan tahun yang dipilih
    function updateBulanOptions(selectedTahun) {
        var bulanSekarang = new Date().getMonth() + 1; // Januari = 1
        var tahunSekarang = new Date().getFullYear();
        var $filterBulan = $('#filter-bulan');
        var selectedBulan = $filterBulan.val();
        
        // Simpan opsi "Pilih Bulan"
        var defaultOption = $filterBulan.find('option[value=""]');
        
        $filterBulan.empty().append(defaultOption);
        
        var namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        // Jika tahun sekarang, tampilkan bulan sampai bulan sekarang
        // Jika tahun sebelumnya, tampilkan semua bulan
        var maxBulan = (selectedTahun == tahunSekarang) ? bulanSekarang : 12;
        
        for(var i = 0; i < maxBulan; i++) {
            var bulanValue = i + 1;
            var option = new Option(namaBulan[i], bulanValue);
            $filterBulan.append(option);
        }
        
        // Kembalikan nilai yang dipilih sebelumnya jika masih valid
        if (selectedBulan && selectedBulan <= maxBulan) {
            $filterBulan.val(selectedBulan);
        }
    }

    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('admission.list') }}',
            data: function(d) {
                d.bulan = $('#filter-bulan').val();
                d.tahun = $('#filter-tahun').val();
                d.penjamin = $('#filter-penjamin').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'id_admission',
                name: 'id_admission'
            },
         
            {
                data: 'keluarrs',
                name: 'keluarrs',
                render: function(data) {
                    return data ? moment(data).format('DD-MM-YYYY') : '-';
                }
            },
            {
                data: 'jenis',
                name: 'jenis'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'biaya_diajukan',
                name: 'biaya_diajukan'
            },
            {
                data: 'biaya_disetujui',
                name: 'biaya_disetujui'
            },
            {
                data: 'biaya_riil_rs',
                name: 'biaya_riil_rs'
            },
            {
                data: 'nomr',
                name: 'nomr'
            },
           
            {
                data: 'action',
                name: 'action'
            }
           
            
            


        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

    // Event handler untuk perubahan tahun
    $('#filter-tahun').on('change', function() {
        var selectedTahun = $(this).val();
        if (selectedTahun) {
            updateBulanOptions(parseInt(selectedTahun));
        }
        datatable.ajax.reload();
    });

    $('#filter-penjamin').on('change', function() {
        datatable.ajax.reload();
    });

    // Event handler untuk perubahan bulan
    $('#filter-bulan').on('change', function() {
        datatable.ajax.reload();
    });

    // Set default value untuk tahun dan bulan sekarang
    var defaultTahun = {{ date('Y') }};
    var defaultBulan = {{ date('n') }};
    var defaultPenjamin = '';

    $('#filter-tahun').val(defaultTahun);
    updateBulanOptions(defaultTahun);
    $('#filter-bulan').val(defaultBulan);
    datatable.ajax.reload();

    // Fungsi untuk export Excel
    $('#btn-export-excel').on('click', function() {
        var bulan = $('#filter-bulan').val();
        var tahun = $('#filter-tahun').val();
        var penjamin = $('#filter-penjamin').val();

        // Buat URL dengan parameter
        var url = '{{ route('admission.export-excel') }}';
        url += '?bulan=' + (bulan || '') + '&tahun=' + (tahun || '') + '&penjamin=' + (penjamin || '');
        
        // Redirect ke URL export
        window.location.href = url;
    });
});
</script>
@endpush