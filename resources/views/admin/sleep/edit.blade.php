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
			<label>Baby
				<select name="baby_id" required>
					@foreach($babies as $b)
						<option value="{{ $b->id }}" {{ $log->baby_id===$b->id?'selected':'' }}>{{ $b->name }} ({{ $b->id }})</option>
					@endforeach
				</select>
			</label>
			<label>Start Time<input type="datetime-local" name="start_time" value="{{ $log->start_time->format('Y-m-d\TH:i') }}" required></label>
			<label>End Time<input type="datetime-local" name="end_time" value="{{ $log->end_time->format('Y-m-d\TH:i') }}" required></label>
			<label>Catatan<textarea name="notes">{{ $log->notes }}</textarea></label>
			<button type="submit">Simpan</button>
		</form>
	</main>
</body>
</html>


