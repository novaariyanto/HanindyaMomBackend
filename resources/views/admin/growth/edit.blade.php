<form method="POST" action="{{ route('admin.growth.update',$log) }}">
	@csrf
	@method('PUT')
	<div class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Baby</label>
			<select name="baby_id" class="form-select" required>
				@foreach($babies as $b)
					<option value="{{ $b->id }}" {{ $log->baby_id===$b->id?'selected':'' }}>{{ $b->name }} ({{ $b->id }})</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-6">
			<label class="form-label">Tanggal</label>
			<input type="date" name="date" value="{{ $log->date->toDateString() }}" class="form-control" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Berat</label>
			<input type="number" step="0.01" name="weight" class="form-control" value="{{ $log->weight }}" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Tinggi</label>
			<input type="number" step="0.01" name="height" class="form-control" value="{{ $log->height }}" required>
		</div>
		<div class="col-md-4">
			<label class="form-label">Lingkar Kepala</label>
			<input type="number" step="0.01" name="head_circumference" class="form-control" value="{{ $log->head_circumference }}">
		</div>
	</div>
</form>