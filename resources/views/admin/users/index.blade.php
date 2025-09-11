@extends('root')
@section('title', 'Users')

@section('content')
<div class="container">
	@include('components.breadcrumb', [
		'title' => 'Data ' . ($title ?? 'Users'),
		'links' => [
			['url' => route('admin.users.index'), 'label' => 'Users'],
		],
		'current' => ($title ?? 'Users')
	])
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0" id="users-table" style="width:100%">
					<thead class="table-light"><tr><th>Nama</th><th>Username</th><th>Email</th><th style="width:160px">Aksi</th></tr></thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Form User</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="modal-body-content"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.index') }}",
            type: 'GET'
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email', defaultContent: '-' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    const modalEl = document.getElementById('userModal');
    const bsModal = new bootstrap.Modal(modalEl);
    const modalBody = document.getElementById('modal-body-content');

    function openForm(url, title){
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
            .then(r => { if(!r.ok) throw new Error('Gagal memuat form'); return r.text(); })
            .then(html => {
                modalEl.querySelector('.modal-title').textContent = title || 'Form User';
                modalBody.innerHTML = html;
                bsModal.show();
            })
            .catch(err => alert(err.message));
    }

    // create button
    const createBtn = document.createElement('button');
    createBtn.className = 'btn btn-primary mb-2 btnn-create';
    createBtn.dataset.url = "{{ route('admin.users.create') }}";
    createBtn.textContent = 'Tambah User';
    document.querySelector('.container .card').insertAdjacentElement('beforebegin', createBtn);

    $(document).on('click', '.btnn-create', function(e){
        e.preventDefault();
        const url = $(this).data('url') || $(this).attr('href');
        openForm(url, 'Tambah/Update User');
    });

    $('#btn-save').on('click', function(){
        const form = modalBody.querySelector('form');
        if(!form) return;
        const action = form.getAttribute('action');
        const methodInput = form.querySelector('input[name="_method"]');
        const method = methodInput ? methodInput.value : 'POST';
        const formData = new FormData(form);
        if(csrfToken && !formData.has('_token')) formData.append('_token', csrfToken);
        if(method && method.toUpperCase() !== 'POST') formData.append('_method', method);

        fetch(action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(async (r) => {
            const data = await r.json().catch(() => ({}));
            if(!r.ok || data?.meta?.status !== 'success'){
                throw new Error(data?.meta?.message || 'Gagal menyimpan data');
            }
        })
        .then(() => { bsModal.hide(); table.ajax.reload(null, false); })
        .catch(err => alert(err.message));
    });

    $(document).on('click', '.btnn-delete', function(){
        const url = $(this).data('url');
        if(!confirm('Hapus user ini?')) return;
        const formData = new FormData();
        if(csrfToken) formData.append('_token', csrfToken);
        formData.append('_method', 'DELETE');
        fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData })
        .then(async (r) => {
            const data = await r.json().catch(() => ({}));
            if(!r.ok || data?.meta?.status !== 'success'){
                throw new Error(data?.meta?.message || 'Gagal menghapus data');
            }
        })
        .then(() => table.ajax.reload(null, false))
        .catch(err => alert(err.message));
    });
});
</script>
@endpush


