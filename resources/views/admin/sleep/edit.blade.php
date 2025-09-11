<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Sleep</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>
<body>
	<main class="container">
		<h1>Edit Sleep</h1>
		<form method="POST" action="{{ route('admin.sleep.update',$log) }}">
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
					<label class="form-label">Start Time</label>
					<input type="datetime-local" name="start_time" value="{{ $log->start_time->format('Y-m-d\\TH:i') }}" class="form-control" required>
				</div>
				<div class="col-md-6">
					<label class="form-label">End Time</label>
					<input type="datetime-local" name="end_time" value="{{ $log->end_time->format('Y-m-d\\TH:i') }}" class="form-control" required>
				</div>
				<div class="col-12">
					<label class="form-label">Catatan</label>
					<textarea name="notes" class="form-control">{{ $log->notes }}</textarea>
				</div>
			</div>
		</form>
	</main>
</body>
</html>


