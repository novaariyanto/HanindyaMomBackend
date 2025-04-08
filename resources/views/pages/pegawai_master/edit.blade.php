<form action="{{ route('pegawai-master.update', $pegawai->uuid) }}" method="POST" id="form">
    @csrf
    @method('PUT') <!-- Untuk update data -->
    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Edit Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="pegawai_id" class="form-label">Pegawai </label>
            <select 
                class="form-control select2 pegawai_id" 
                id="nik" 
                name="nik" 
                required>
                <option value="{{ $pegawai->nik }}" selected>{{ $pegawai->nama }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="jabatan_id" class="form-label">Jabatan</label>
            <select 
                class="form-control select2" 
                id="jabatan_id" 
                name="jabatan_id" 
                required>
                <option value="{{ $pegawai->jabatan_id }}" selected>{{ $pegawai->jabatan->nama }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="divisi_id" class="form-label">Divisi</label>
            <select 
                class="form-control select2" 
                id="divisi_id" 
                name="divisi_id" 
                required>
                <option value="{{ $pegawai->divisi_id }}" selected>{{ $pegawai->divisi->nama }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select 
                class="form-control" 
                id="status" 
                name="status" 
                required>
                <option value="aktif" {{ $pegawai->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $pegawai->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <!-- Input untuk Nomor HP -->
        <div class="mb-3">
            <label for="nomor_hp" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP" value="{{$pegawai->user->username??''}}">
        </div>


          <div class="mb-3">
            <label for="status" class="form-label">Token</label>
            
            <div class="input-group mb-3">
                <input readonly type="text" class="form-control" id="tokenInput" placeholder="" name="token"  value="{{$pegawai->user->key??''}}">
                <button class="btn btn-outline-secondary" type="button" id="clearToken"><i class="ti ti-trash"></i></button>
            </div>
            <p id="warningMessage" class="text-danger" style="display: none;">Menghapus token berarti menghapus hak akses HP yang tersambung sekarang!</p>

            
            

              

        </div>



        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>


<script>
    $(document).ready(function () {
        // Inisialisasi Select2 untuk Pegawai (Nama & NIP)
        $('.pegawai_id').select2({
            dropdownParent: $("#createModal"),
            ajax: {
                url: '{{ route("select2.pegawai") }}', // Endpoint API untuk pegawai
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Query pencarian
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                id: item.nik,
                                text: `${item.nama}`, // Format: "Nama Pegawai (NIP)"
                                nomor_hp: item.nohp // Menyertakan nomor HP dalam hasil

                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Cari Pegawai...',
            width: '100%'
        });



        $('.pegawai_id').on('change', function () {
            const selectedOption = $(this).select2('data')[0]; // Ambil data pegawai yang dipilih
            if (selectedOption && selectedOption.nomor_hp) {
                $('#nomor_hp').val(selectedOption.nomor_hp); // Isi input Nomor HP
            } else {
                $('#nomor_hp').val(''); // Kosongkan jika tidak ada nomor HP
            }
        });


        // Inisialisasi Select2 untuk Jabatan
        $('#jabatan_id').select2({
            dropdownParent: $("#createModal"),
            ajax: {
                url: '{{ route("select2.jabatan") }}', // Endpoint API untuk jabatan
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Query pencarian
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                id: item.id,
                                text: item.nama
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Cari Jabatan...',
            width: '100%'
        });

        // Inisialisasi Select2 untuk Divisi
        $('#divisi_id').select2({
            dropdownParent: $("#createModal"),

            ajax: {
                url: '{{ route("select2.divisi") }}', // Endpoint API untuk divisi
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Query pencarian
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                id: item.id,
                                text: item.nama
                            };
                        }),
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Cari Divisi...',
            width: '100%'
        });


        $("#clearToken").click(function () {
            if (confirm("Apakah Anda yakin ingin menghapus token? Ini akan menghapus hak akses HP yang tersambung sekarang!")) {
                $("#tokenInput").val(""); // Mengosongkan token
                $("#warningMessage").show(); // Menampilkan peringatan
            }
        });

    });
</script>