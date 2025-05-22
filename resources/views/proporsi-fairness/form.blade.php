@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($proporsi) ? 'Edit' : 'Tambah' }} Proporsi Fairness</h3>
                </div>
                <div class="card-body">
                    <form id="formProporsiFairness" method="POST" action="{{ isset($proporsi) ? route('proporsi-fairness.update', $proporsi->id) : route('proporsi-fairness.store') }}">
                        @csrf
                        @if(isset($proporsi))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label>Groups</label>
                            <div class="d-flex">
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="groups" value="RJTL" {{ isset($proporsi) && $proporsi->groups == 'RJTL' ? 'checked' : '' }} required>
                                    <label class="form-check-label">RJTL</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="groups" value="RITL" {{ isset($proporsi) && $proporsi->groups == 'RITL' ? 'checked' : '' }}>
                                    <label class="form-check-label">RITL</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis</label>
                            <div class="d-flex">
                                <div class="form-check mr-4">
                                    <input class="form-check-input" type="radio" name="jenis" value="PISAU" {{ isset($proporsi) && $proporsi->jenis == 'Pisau' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Pisau</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis" value="NONPISAU" {{ isset($proporsi) && $proporsi->jenis == 'NONPISAU' ? 'checked' : '' }}>
                                    <label class="form-check-label">NONPISAU</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nilai</label>
                            <input type="number" step="0.01" class="form-control" name="nilai" value="{{ isset($proporsi) ? $proporsi->nilai : old('nilai') }}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('proporsi-fairness.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#formProporsiFairness').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message
                }).then((result) => {
                    window.location.href = "{{ route('proporsi-fairness.index') }}";
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });
});
</script>
@endpush
@endsection 