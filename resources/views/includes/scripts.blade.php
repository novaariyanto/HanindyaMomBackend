<style>.Toastify {
    position: absolute;
    z-index: 999999;
}
#failedToast {
    z-index: 1061; /* Lebih tinggi dari modal (1050) */
}

.dataTables_empty{
    text-align: center;
}

.sunday{
    background-color: #f8d7da !important;
    color: #721c24 !important;
    
}

</style>

<!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="createModal" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            
        </div>
    </div>
</div>



<div id="successToast" class="toast toast-onload align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-check fs-6"></i>
      <div>
        <h6 class="text-white fs-2 mb-0 msg-box"></h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <div id="failedToast" class="toast toast-onload align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      {{-- <i class="ti ti-alert-square fs-6"></i> --}}
<i class="ti ti-alert-circle fs-6"></i>

      <div>
        <h6 class="text-white fs-2 mb-0 msg-box"></h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

<div class="position-fixed top-0 end-0 toast align-items-center m-3 text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
  <div class="d-flex">
    <div class="toast-body bg-success">
      <span class="success-response"></span>
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>




<div class="position-fixed top-0 end-0 toast align-items-center m-3 text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast" style="z-index: 9999">
    <div class="d-flex">
      <div class="toast-body bg-danger">
        <span class="error-response"></span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


  <script>
    // $(document).ready(function () {
        
    // });
    $(document).on('click', '.btn-create', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var modal = $(this).data('modal');
    
        console.log(modal);
        // Memuat konten modal melalui AJAX
        if (modal == "large") {
            $("#createModal .modal-dialog").css('max-width', '80%');

        }
        else{
            $("#createModal .modal-dialog").css('max-width', '500px');

        }
    
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#createModal .modal-content').html(response);
                $('#createModal').modal('show');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
    
    $(document).on('submit', '#form', function(e) {
        e.preventDefault(); // Stop the default form submission
        var reload = $(this).attr('data-reload');
        var formData = new FormData(this); // Create FormData object from the form
    
        $.ajax({
            url: $(this).attr('action'), // Get the form action URL
            type: 'POST',
            data: formData, // Send the FormData object
            dataType: 'json', // Expect a JSON response
            processData: false, // Prevent jQuery from automatically processing the data
            contentType: false, // Prevent jQuery from automatically setting content type
            success: function(response) {
                // Handle success
                console.log(response);
    
                if (response.meta.code === 200) {
                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();
               
                    // Hide the modal
                    $('#createModal').modal('hide');
                    $('#successToast .msg-box').text(response.meta.message);
    
                    $('#successToast').toast('show');  // Menampilkan toast


                    @if (Route::currentRouteName()=='transaksi.create')
                        var data = response.data;
                        $("#namaPembeli").val(data.kode);
                        $("#namaPelanggan").text(data.nama);
                    @endif
                    if (reload) {
                        location.reload();
                    }
                
                } else {
                    // Handle unexpected response
                    alert('Gagal menyimpan data. Silakan coba lagi.');
                }
            },
            error: function(xhr) {
                    // $('#createModal').modal('hide');

    console.log(xhr);
               

                $('#failedToast .msg-box').text(xhr.responseJSON.meta.message);
    
    $('#failedToast').toast('show');  // Menampilkan toast

            }
        });
    });
    
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault(); // Menghentikan default submit form
    
        var formData = $(this).serialize(); // Mengambil data form dalam bentuk serialized
    
        $.ajax({
            url: $(this).attr('action'), // Mengambil URL action dari form
            type: 'POST',
            data: formData, // Mengirimkan data form
            dataType: 'json', // Mengharapkan respons dalam format JSON
            success: function(response) {
                // Handle jika request sukses
                console.log(response);
    
                if (response.meta.code === 200) {
                    // Reload DataTable
                    $('#datatable').DataTable().ajax.reload();
    
                    // Sembunyikan modal
                    $('#createModal').modal('hide');
    
                    // Tampilkan notifikasi sukses
                    $('#successToast .msg-box').text(response.meta.message);
    
    $('#successToast').toast('show');  // Menampilkan toast

                } else {
                    // Handle jika respons tidak sesuai dengan yang diharapkan
                    alert('Gagal memperbarui data. Silakan coba lagi.');
                }
            },
            error: function(xhr) {
                // Handle jika terjadi error
    
                // Tampilkan notifikasi error
                // $.notify({
                //     icon: 'fas fa-exclamation-circle',
                //     message: xhr.responseJSON.meta.message // Pesan error
                // }, {
                //     type: "danger",
                //     placement: {
                //         from: 'top',
                //         align: 'right'
                //     },
                //     delay: 1000, // Durasi dalam milidetik sebelum notifikasi menghilang
                //     timer: 1000, // Mengatur timer untuk noti
                // });
                // alert("X");

                $('#failedToast .msg-box').text(xhr.responseJson.meta.message);
    
    $('#failedToast').toast('show');  // Menampilkan toast

            }
        });
    });
    
    // Handle klik tombol hapus
    $(document).on('click', '.btn-delete', function() {
        var url = $(this).data('url'); // Ambil URL dari atribut data-url
        $('#confirmDelete').data('url', url); // Set URL di tombol konfirmasi hapus
        $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi hapus
    });
    
    // Handle konfirmasi hapus
    $('#confirmDelete').on('click', function() {
        var url = $(this).data('url'); // Ambil URL dari tombol konfirmasi hapus
    
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Reload DataTable
                $('#datatable').DataTable().ajax.reload();
    
                $(".success-response").text(response.meta.message);
    
                // Sembunyikan modal
                $('#deleteModal').modal('hide');
    
                // Tampilkan notifikasi sukses
                $('#successToast .msg-box').text(response.meta.message);
    
                $('#successToast').toast('show');  // Menampilkan toast

            },
            error: function(xhr) {
                // Handle jika terjadi error
                console.log(xhr.responseText);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
    
    $(document).ready(function() {
        // Initialization code if needed
    });
    </script>
    