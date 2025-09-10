@extends('root')
@section('title', 'Edit Bayi')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Edit Bayi</h1>
	<div class="card shadow-sm">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.babies.update',$baby) }}">
				@csrf
				@method('PUT')
				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label">User</label>
						<select name="user_uuid" class="form-select" required>
							@foreach($users as $u)
								<option value="{{ $u->uuid }}" {{ $baby->user_uuid===$u->uuid?'selected':'' }}>{{ $u->name }} ({{ $u->uuid }})</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<label class="form-label">Nama</label>
						<input type="text" name="name" class="form-control" value="{{ $baby->name }}" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Tanggal Lahir</label>
						<input type="date" name="birth_date" class="form-control" value="{{ optional($baby->birth_date)->toDateString() }}" required>
					</div>
					<div class="col-md-8">
						<label class="form-label">Photo URL</label>
						<input type="text" name="photo" class="form-control" value="{{ $baby->photo }}">
					</div>
					<div class="col-md-6">
						<label class="form-label">Berat Lahir (kg)</label>
						<input type="number" step="0.01" name="birth_weight" class="form-control" value="{{ $baby->birth_weight }}">
					</div>
					<div class="col-md-6">
						<label class="form-label">Tinggi Lahir (cm)</label>
						<input type="number" step="0.01" name="birth_height" class="form-control" value="{{ $baby->birth_height }}">
					</div>
				</div>
				<div class="mt-3">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<a href="{{ route('admin.babies.index') }}" class="btn btn-outline-secondary">Batal</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


