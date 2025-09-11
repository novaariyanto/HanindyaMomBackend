<form method="POST" action="{{ route('admin.vaccines.update',$log) }}">
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
			<label class="form-label">Nama Vaksin</label>
			<input type="text" name="vaccine_name" class="form-control" value="{{ $log->vaccine_name }}" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Tanggal</label>
			<input type="date" name="schedule_date" class="form-control" value="{{ $log->schedule_date->toDateString() }}" required>
		</div>
		<div class="col-md-6">
			<label class="form-label">Status</label>
			<select name="status" class="form-select" required>
				@foreach(['scheduled','done'] as $s)
					<option value="{{ $s }}" {{ $log->status===$s?'selected':'' }}>{{ $s }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-12">
			<label class="form-label">Catatan</label>
			<textarea name="notes" class="form-control">{{ $log->notes }}</textarea>
		</div>
	</div>
</form>