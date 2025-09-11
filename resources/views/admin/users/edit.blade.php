@extends('root')
@section('title', 'Edit User')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Edit User</h1>
	<div class="card shadow-sm">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.users.update',$user) }}">
				@csrf
				@method('PUT')
				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label">Nama</label>
						<input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
					</div>
					<div class="col-md-6">
						<label class="form-label">Username</label>
						<input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
					</div>
					<div class="col-md-6">
						<label class="form-label">Email</label>
						<input type="email" name="email" class="form-control" value="{{ $user->email }}">
					</div>
					<div class="col-md-6">
						<label class="form-label">Password (opsional)</label>
						<input type="password" name="password" class="form-control">
					</div>
					<div class="col-12">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="role" value="admin" id="roleAdmin" {{ $user->hasRole('admin') ? 'checked' : '' }}>
							<label class="form-check-label" for="roleAdmin">Jadikan Admin</label>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


