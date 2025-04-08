@extends('root')
@section('title', 'Data '.$title)
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data '.$title,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => $title
    ])
    
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row align-items-center">
          <!-- Filter Unit Kerja -->
          <div class="col-md-3 col-xl-3">
            <select id="unit_kerja_id" class="form-select select2" multiple>
                <option value="">Semua Unit Kerja</option>
                @foreach ($unitKerjas as $unitKerja)
                    <option value="{{ $unitKerja->id }}">{{ $unitKerja->nama }}</option>
                @endforeach
            </select>
          </div>

          <!-- Tombol Export -->
          <div class="col-md-2 col-xl-2 ms-auto">
            <button id="btn-export" class="btn btn-success w-100">
              <i class="ti ti-download me-1"></i> Export
            </button>
          </div>
        </div>
      </div>
      <div class="card card-body">
        <div class="table-responsive">
          <table class="table table-striped" id="datatable">
            <thead>
              <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Profesi</th>
                  <th>Unit Kerja</th>
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
</div>
@endsection

@push('scripts')
<!-- Include Select2 CSS and JS -->

<script>
$(document).ready(function() {
    // Inisialisasi Select2 untuk dropdown unit kerja
    $('#unit_kerja_id').select2({
        placeholder: 'Pilih Unit Kerja',
        allowClear: true,
        width: '100%',
    });

    // DataTable initialization
    var datatable = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: {
        url: '{{ route($slug.'.index') }}',
        data: function (d) {
            // Ambil semua nilai yang dipilih dari filter unit kerja
            const selectedOptions = $('#unit_kerja_id').val();
            if (selectedOptions && Array.isArray(selectedOptions)) {
                d.unit_kerja_id = selectedOptions.join(','); // Gabungkan nilai menjadi string dipisah koma
            } else {
                d.unit_kerja_id = ''; // Kosongkan jika tidak ada yang dipilih
            }
        }
    },
    columns: [
        { data: 'nik', name: 'nik' },
        { data: 'nama', name: 'nama' },
        { data: 'alamat', name: 'alamat' },
        { data: 'profesi', name: 'profesi' },
        { data: 'unit_kerja', name: 'unit_kerja' },
    ]
});


    // Filter by Unit Kerja
    $('#unit_kerja_id').on('change', function () {
        datatable.ajax.reload();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Tombol Export
    const btnExport = document.getElementById('btn-export');

    // Event listener untuk tombol Export
    btnExport.addEventListener('click', function () {
        // Ambil semua nilai yang dipilih dari filter unit kerja
        const unitKerjaSelect = document.getElementById('unit_kerja_id');
        const selectedOptions = Array.from(unitKerjaSelect.selectedOptions).map(option => option.value);

        // console.log(selectedOptions); // Debugging: Cek nilai yang dipilih

        // return;
        // Buat URL untuk endpoint export dengan parameter filter
        let url = '/pegawai/export'; // Endpoint export
        if (selectedOptions.length > 0) {
            // Gabungkan semua nilai yang dipilih menjadi string dengan koma sebagai pemisah
            const unitKerjaIds = selectedOptions.join(',');
            url += `?unit_kerja_id=${encodeURIComponent(unitKerjaIds)}`;
        }

        // Redirect ke URL export untuk memulai download
        window.location.href = url;
    });
});


</script>
@endpush