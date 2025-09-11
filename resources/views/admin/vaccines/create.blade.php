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
			<label class="form-label">Nama Vaksin</label>
			<input type="text" name="vaccine_name" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Tanggal</label>
			<input type="date" name="schedule_date" class="form-control" required>
		</div>
		<div class="col-md-6">
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
</form>


