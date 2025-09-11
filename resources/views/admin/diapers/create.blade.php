<form method="POST" action="{{ route('admin.diapers.store') }}">
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
				<option value="pipis">pipis</option>
				<option value="pup">pup</option>
				<option value="campuran">campuran</option>
			</select>
		</div>
		<div class="col-md-6">
			<label class="form-label">Time</label>
			<input type="datetime-local" name="time" class="form-control" required>
		</div>
		<div class="col-md-3">
			<label class="form-label">Color</label>
			<input type="text" name="color" class="form-control">
		</div>
		<div class="col-md-3">
			<label class="form-label">Texture</label>
			<input type="text" name="texture" class="form-control">
		</div>
		<div class="col-12">
			<label class="form-label">Catatan</label>
			<textarea name="notes" class="form-control"></textarea>
		</div>
	</div>
</form>


