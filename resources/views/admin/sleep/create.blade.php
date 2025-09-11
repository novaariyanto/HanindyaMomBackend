<form method="POST" action="{{ route('admin.sleep.store') }}">
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
			<label class="form-label">Start Time</label>
			<input type="datetime-local" name="start_time" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">End Time</label>
			<input type="datetime-local" name="end_time" class="form-control" required>
		</div>
		<div class="col-12">
			<label class="form-label">Catatan</label>
			<textarea name="notes" class="form-control"></textarea>
		</div>
	</div>
</form>


