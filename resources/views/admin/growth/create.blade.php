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
		<div class="col-md-6">
			<label class="form-label">Tanggal</label>
			<input type="date" name="date" class="form-control" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Berat</label>
			<input type="number" step="0.01" name="weight" class="form-control" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Tinggi</label>
			<input type="number" step="0.01" name="height" class="form-control" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Lingkar Kepala</label>
			<input type="number" step="0.01" name="head_circumference" class="form-control">
		</div>
	</div>
</form>

