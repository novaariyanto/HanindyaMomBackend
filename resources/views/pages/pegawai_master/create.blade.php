<form action="{{ route('pegawai-master.store') }}" method="POST" enctype="multipart/form-data" id="form">
    @csrf
    <input type="hidden" name="form_type" id="form_type" value="manual">

    <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Tambah Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="true">Form Manual</button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="massal-tab" data-bs-toggle="tab" data-bs-target="#massal" type="button" role="tab" aria-controls="massal" aria-selected="false">Form Text Massal</button>
            </li> --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="import-tab" data-bs-toggle="tab" data-bs-target="#import" type="button" role="tab" aria-controls="import" aria-selected="false">Import</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="myTabContent">
            <!-- Tab 1: Form Manual -->
            <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                <div class="mb-3">
                    <label for="divisi_id" class="form-label">Divisi</label>
                    <select 
                        class="form-control select2 divisi_id" 
                        id="divisi_id" 
                        name="divisi_id" 
                        >
                        <option value="">Pilih Divisi</option>
                        @if ($divisi)

                        <option selected value="{{$divisi->id}}">{{$divisi->nama}}</option>
                    @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pegawai_id" class="form-label">Pegawai</label>
                    <select 
                        class="form-control select2" 
                        id="pegawai_id" 
                        name="nik" 
                        >
                        <option value="">Pilih Pegawai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jabatan_id" class="form-label">Jabatan</label>
                    <select 
                        class="form-control select2 jabatan_id" 
                        id="jabatan_id" 
                        name="jabatan_id" 
                        >
                        <option value="">Pilih Jabatan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select 
                        class="form-control" 
                        id="status" 
                        name="status" 
                        >
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                 <!-- Input untuk Nomor HP -->
        <div class="mb-3">
            <label for="nomor_hp" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP">
        </div>


            </div>

            <!-- Tab 2: Form Text Massal -->
            <div class="tab-pane fade" id="massal" role="tabpanel" aria-labelledby="massal-tab">
                <div class="mb-3">
                    <label for="nik_list" class="form-label">Masukkan NIK (satu per baris)</label>
                    <textarea 
                        class="form-control" 
                        id="nik_list" 
                        name="nik_list" 
                        rows="10" 
                        placeholder="Contoh:\n12345\n67890\n..." 
                        ></textarea>
                </div>

                <div class="mb-3">
                    <label for="divisi_massal" class="form-label">Divisi</label>
                    <select 
                        class="form-control select2 divisis" 
                        id="divisi_massal" 
                        name="divisi_massal" 
                        >
                        <option value="">Pilih Divisi</option>
                        @if ($divisi)
                        <option selected value="{{$divisi->id}}">{{$divisi->nama}}</option>
                            
                        @endif

                    </select>
                </div>

                <div class="mb-3">
                    <label for="jabatan_id_massal" class="form-label">Jabatan</label>
                    <select 
                        class="form-control select2 jabatan_id" 
                        id="jabatan_id_massal" 
                        name="jabatan_massal" 
                        >
                        <option value="">Pilih Jabatan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status_massal" class="form-label">Status</label>
                    <select 
                        class="form-control" 
                        id="status_massal" 
                        name="status" 
                        >
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Tab 3: Import -->
            <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                {{-- <div class="alert alert-warning">
                    <center>Fitur Masih Dalam Pengembangan</center>
                </div> --}}

                <div class="mb-3">
                    <label for="file_import" class="form-label">Unggah File Excel</label> (<a href="{{route('pegawai_master.export')}}" class="text-primary">Export Template</a>)
                    <input 
                        type="file" 
                        class="form-control" 
                        id="file_import" 
                        name="file_import" 
                        accept=".xlsx, .xls, .csv" 
                        >
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>


<script>

document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tab) => {
        tab.addEventListener('shown.bs.tab', (event) => {
            const target = event.target.getAttribute('data-bs-target'); // Target tab (e.g., #manual, #massal, #import)
            console.log("Target tab:", target);

            if (target === '#manual') {
                document.getElementById('form_type').value = 'manual';
            } else if (target === '#massal') {
                document.getElementById('form_type').value = 'massal';
            } else if (target === '#import') {
                document.getElementById('form_type').value = 'import';
            }
        });
    });

    
    $(document).ready(function () {

//          // Set form_type berdasarkan tab yang aktif
//         $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
//     console.log("Tab changed"); // Pastikan ini muncul di console browser
//     const target = $(e.target).attr('href'); // Target tab (e.g., #manual, #massal, #import)
//     console.log("Target tab:", target); // Periksa nilai target

//     if (target === '#manual') {
//         $('#form_type').val('manual');
//     } else if (target === '#massal') {
//         $('#form_type').val('massal');
//     } else if (target === '#import') {
//         $('#form_type').val('import');
//     }
// });
        
        // Inisialisasi Select2 untuk Pegawai (Nama & NIP)
        $('#pegawai_id').select2({
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
                                text: `${item.nama} (${item.nik})`, // Format: "Nama Pegawai (NIP)"
                                nohp: item.nohp // Menyertakan nomor HP dalam hasil

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

        // Event listener untuk mengisi Nomor HP secara otomatis
       


        // Inisialisasi Select2 untuk Jabatan
        $('.jabatan_id').select2({

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
        $('.divisis').select2({

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

        $('.divisi_id').select2({

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

    });


    $(document).on('change','#pegawai_id',function(){
        console.log("XXX");
            const selectedOption = $(this).select2('data')[0]; // Ambil data pegawai yang dipilih
            if (selectedOption && selectedOption.nohp) {
                $('#nomor_hp').val(selectedOption.nohp); // Isi input Nomor HP
            } else {
                $('#nomor_hp').val(''); // Kosongkan jika tidak ada nomor HP
            }
            
    })
</script>