<!-- Modal Edit Pembagian Klaim -->
<div class="modal fade" id="editPembagianKlaimModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pembagian Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPembagianKlaimForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_detail_source" value="{{ $detail->id }}">
                <input type="hidden" name="sep" value="{{ $detail->no_sep }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelompok</label>
                                <select class="form-select" name="groups" id="edit_groups" required>
                                    <option value="">Pilih Kelompok</option>
                                    <option value="RITL">RITL</option>
                                    <option value="RJTL">RJTL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="form-select" name="jenis" id="edit_jenis" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="PISAU">PISAU</option>
                                    <option value="NONPISAU">NONPISAU</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select class="form-select" name="grade" id="edit_grade" required>
                                    <option value="">Pilih Grade</option>
                                    <option value="GRADE1">GRADE1</option>
                                    <option value="GRADE2">GRADE2</option>
                                    <option value="GRADE3">GRADE3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PPA</label>
                                <input type="text" class="form-control" name="ppa" id="edit_ppa" required maxlength="50" placeholder="Contoh: DPJP, PERAWAT">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Value</label>
                                <input type="number" step="0.0001" class="form-control" name="value" id="edit_value" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sumber</label>
                                <input type="text" class="form-control" name="sumber" id="edit_sumber" maxlength="50" placeholder="Contoh: VERIFIKASITOTAL">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Flag</label>
                                <select class="form-select" name="flag" id="edit_flag">
                                    <option value="NONE">NONE</option>
                                    <option value="KONSUL">KONSUL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cluster</label>
                                <select class="form-select" name="cluster" id="edit_cluster">
                                    <option value="">Pilih Cluster</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.status === 'success') {
                var data = response.data;
                $('#editPembagianKlaimForm').attr('action', url);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_groups').val(data.groups);
                $('#edit_jenis').val(data.jenis);
                $('#edit_grade').val(data.grade);
                $('#edit_ppa').val(data.ppa);
                $('#edit_value').val(data.value);
                $('#edit_sumber').val(data.sumber);
                $('#edit_flag').val(data.flag);
                $('#edit_cluster').val(data.cluster);
                $('#edit_keterangan').val(data.keterangan);
                $('#editPembagianKlaimModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit
    $('#editPembagianKlaimForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            url: url,
            type: 'PUT',
            data: form.serialize(),
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#editPembagianKlaimModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.meta.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#pembagianKlaimTable').DataTable().ajax.reload();
                    });
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                var errorMessage = '';
                
                if (response.meta.status === 'error') {
                    if (typeof response.data === 'object') {
                        $.each(response.data, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    } else {
                        errorMessage = response.meta.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errorMessage
                    });
                }
            }
        });
    });
});
</script>
@endpush 