@extends('root')
@section('title', 'Tambah Vaccine')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Tambah Vaccine</h1>
	<div class="card shadow-sm">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.vaccines.store') }}">
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
					<div class="col-md-6">
						<label class="form-label">Vaccine Name</label>
						<input type="text" name="vaccine_name" class="form-control" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Schedule Date</label>
						<input type="date" name="schedule_date" class="form-control" required>
					</div>
					<div class="col-md-4">
						<label class="form-label">Status</label>
						<select name="status" class="form-select" required>
							<option value="scheduled">scheduled</option>
							<option value="done">done</option>
						</select>
					</div>
					<div class="col-12">
						<label class="form-label">Catatan</label>
						<textarea name="notes" class="form-control"></textarea>
					</div>
				</div>
				<div class="mt-3">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<a href="{{ route('admin.vaccines.index') }}" class="btn btn-outline-secondary">Batal</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


