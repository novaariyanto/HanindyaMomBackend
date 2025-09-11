<form method="POST" action="{{ route('admin.feeding.store') }}">
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
			<label class="form-label">Type</label>
			<select name="type" class="form-select" required>
				@foreach(['asi_left','asi_right','formula','pump'] as $t)
					<option value="{{ $t }}">{{ $t }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-6">
			<label class="form-label">Start Time</label>
			<input type="datetime-local" name="start_time" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Durasi (menit)</label>
			<input type="number" name="duration_minutes" class="form-control" min="1" required>
		</div>
		<div class="col-12">
			<label class="form-label">Catatan</label>
			<textarea name="notes" class="form-control"></textarea>
		</div>
	</div>
</form>


