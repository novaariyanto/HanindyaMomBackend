@extends('root')
@section('title', 'Users')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Users</h1>
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	<div class="mb-3">
		<a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah User</a>
		<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
	</div>
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="table-light"><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th style="width:160px">Aksi</th></tr></thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->name }}</td>
							<td>{{ $user->username }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->roles->pluck('name')->join(', ') }}</td>
							<td>
								<a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-warning">Edit</a>
								<form method="POST" action="{{ route('admin.users.destroy',$user) }}" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user?')">Hapus</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">{{ $users->links() }}</div>
	</div>
</div>
@endsection


