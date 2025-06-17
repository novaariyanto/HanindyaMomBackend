@extends('root')
@section('title', 'Data Sub Cluster')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Sub Cluster',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Sub Cluster'
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
          <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Sub Cluster
            </a>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama PPA</th>
                        <th>Cluster</th>
                        <th>Jenis</th>
                        <th>Nilai</th>
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

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sub Cluster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('sub-cluster.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama PPA</label>
                        <input type="text" class="form-control" name="nama_ppa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cluster</label>
                        <input type="text" class="form-control" name="cluster" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-select" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="fix">Fix</option>
                            <option value="dinamis">Dinamis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" class="form-control" name="nilai"  step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sub Cluster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama PPA</label>
                        <input type="text" class="form-control" name="nama_ppa" id="edit_nama_ppa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cluster</label>
                        <input type="text" class="form-control" name="cluster" id="edit_cluster" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-select" name="jenis" id="edit_jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="fix">fix</option>
                            <option value="dinamis">dinamis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" class="form-control" name="nilai" id="edit_nilai" required step="0.01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('sub-cluster.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_ppa',
                name: 'nama_ppa'
            },
            {
                data: 'cluster',
                name: 'cluster'
            },
            {
                data: 'jenis',
                name: 'jenis',
                render: function(data) {
                    return data.charAt(0).toUpperCase() + data.slice(1);
                }
            },
            {
                data: 'nilai_',
                name: 'nilai_'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

    // Handle Create Form Submit
  

    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
          
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_nama_ppa').val(data.nama_ppa);
                $('#edit_cluster').val(data.cluster);
                $('#edit_jenis').val(data.jenis);
                $('#edit_nilai').val(data.nilai);
                $('#editModal').modal('show');
           
        }).fail(function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Terjadi kesalahan');
        });
    });

  

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });
});
</script>
@endpush 