<form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
	@csrf
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Nama</label>
			<input type="text" name="name" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Username</label>
			<input type="text" name="username" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Email</label>
			<input type="email" name="email" class="form-control">
		</div>
		<div class="col-md-6">
			<label class="form-label">Password</label>
			<input type="password" name="password" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Foto (opsional)</label>
			<input type="file" name="photo_file" accept="image/*" class="form-control">
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="role" value="admin" id="roleAdmin">
				<label class="form-check-label" for="roleAdmin">Jadikan Admin</label>
			</div>
		</div>
	</div>
</form>


