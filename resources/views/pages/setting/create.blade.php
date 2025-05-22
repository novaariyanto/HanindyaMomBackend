@extends('root')
@section('title', 'Edit Profil Website')
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Edit Profil Website',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Edit Profil Website'
    ])
    
    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <ul class="nav nav-underline" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="active" aria-expanded="true" aria-selected="true">
                    <span>Profile</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content tabcontent-border p-3" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade active show" id="profile" aria-labelledby="active-tab">
                 

            <form id="edit-profile-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="website_name">Nama Website</label>
                    <input type="text" class="form-control" id="website_name" name="website_name" value="{{ $setting->website_name ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="website_description">Deskripsi Website</label>
                    <textarea class="form-control" id="website_description" name="website_description" rows="3">{{ $setting->website_description ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control-file form-control" id="logo" name="logo">
                    @if ($setting && $setting->logo)
                        <img src="{{ asset($setting->logo) }}" alt="Logo Website" class="mt-2" style="max-width: 200px;">
                    @endif
                </div>
                <div class="form-group">
                    <label for="favicon">Favicon</label>
                    <input type="file" class="form-control-file form-control" id="favicon" name="favicon">
                    @if ($setting && $setting->favicon)
                        <img src="{{ asset($setting->favicon) }}" alt="Favicon Website" class="mt-2" style="max-width: 50px;">
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $setting->email ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $setting->phone ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ $setting->address ?? '' }}</textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
                </div>
              </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Submit form dengan AJAX
    $('#edit-profile-form').on('submit', function(e) {
        e.preventDefault();
        // Buat FormData object untuk mengirim file
        var formData = new FormData(this);
        $.ajax({
            url: '{{ route("settings.save-or-update") }}',
            type: 'POST',
            data: formData,
            processData: false, // Jangan proses data
            contentType: false, // Jangan set content type
            success: function(response) {
                if (response.meta.code === 200) {
                    
                    // Tampilkan notifikasi sukses
                    $('#successToast .msg-box').text(response.meta.message);
    
    $('#successToast').toast('show');  // Menampilkan toast

                } else {
                    // alert(response.message); // Tampilkan pesan error

                    // Tampilkan notifikasi sukses
                    $('#failedToast .msg-box').text(xhr.responseJson.meta.message);
    
    $('#failedToast').toast('show');  // Menampilkan toast
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data.';
                   // Tampilkan notifikasi sukses
                   $('#failedToast .msg-box').text(xhr.responseJson.meta.message);
    
    $('#failedToast').toast('show');  // Menampilkan toast
            }
        });
    });

});
</script>
@endpush