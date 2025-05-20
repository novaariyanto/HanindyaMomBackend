<!-- Modal Tambah Pembagian Klaim -->
<div class="modal fade" id="createPembagianKlaimModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembagian Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createPembagianKlaimForm" method="POST" action="{{ route('pembagian-klaim.store') }}">
                @csrf
                <input type="hidden" name="id_detail_source" value="{{ $detail->id }}">
                <input type="hidden" name="sep" value="{{ $detail->no_sep }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelompok</label>
                                <select class="form-select" name="groups" required>
                                    <option value="">Pilih Kelompok</option>
                                    <option value="RITL">RITL</option>
                                    <option value="RJTL">RJTL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="form-select" name="jenis" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="PISAU">PISAU</option>
                                    <option value="NONPISAU">NONPISAU</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select class="form-select" name="grade" required>
                                    <option value="">Pilih Grade</option>
                                    <option value="GRADE1">GRADE1</option>
                                    <option value="GRADE2">GRADE2</option>
                                    <option value="GRADE3">GRADE3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PPA</label>
                                <input type="text" class="form-control" name="ppa" required maxlength="50" placeholder="Contoh: DPJP, PERAWAT">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Value</label>
                                <input type="number" step="0.0001" class="form-control" name="value" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sumber</label>
                                <input type="text" class="form-control" name="sumber" maxlength="50" placeholder="Contoh: VERIFIKASITOTAL">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Flag</label>
                                <select class="form-select" name="flag">
                                    <option value="NONE">NONE</option>
                                    <option value="KONSUL">KONSUL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cluster</label>
                                <select class="form-select" name="cluster">
                                    <option value="">Pilih Cluster</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Idxdaftar</label>
                                <input type="number" class="form-control" name="idxdaftar" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomr</label>
                                <input type="number" class="form-control" name="nomr" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle Create Form Submit
    $('#createPembagianKlaimForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#createPembagianKlaimModal').modal('hide');
                    form[0].reset();
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