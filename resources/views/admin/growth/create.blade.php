@extends('root')
@section('title', 'Tambah Growth')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Tambah Growth</h1>
	<div class="card shadow-sm">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.growth.store') }}">
				@csrf
				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label">Baby</label>
						<select name="baby_id" class="form-select" required>
							@foreach($babies as $b)
								<option value="{{ $b->id }}">{{ $b->name }} ({{ $b->id }})</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<label class="form-label">Date</label>
						<input type="date" name="date" class="form-control" required>
					</div>
					<div class="col-md-3">
						<label class="form-label">Weight (kg)</label>
						<input type="number" step="0.01" name="weight" class="form-control" required>
					</div>
					<div class="col-md-3">
						<label class="form-label">Height (cm)</label>
						<input type="number" step="0.01" name="height" class="form-control" required>
					</div>
					<div class="col-md-3">
						<label class="form-label">Head Circumference (cm)</label>
						<input type="number" step="0.01" name="head_circumference" class="form-control">
					</div>
				</div>
				<div class="mt-3">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<a href="{{ route('admin.growth.index') }}" class="btn btn-outline-secondary">Batal</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


