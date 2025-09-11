@extends('root')
@section('title', 'Edit Feeding')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Edit Feeding</h1>
	<div class="card shadow-sm">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.feeding.update',$log) }}">
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
						<label class="form-label">Type</label>
						<select name="type" class="form-select" required>
							@foreach(['asi_left','asi_right','formula','pump'] as $t)
								<option value="{{ $t }}" {{ $log->type===$t?'selected':'' }}>{{ $t }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<label class="form-label">Start Time</label>
						<input type="datetime-local" name="start_time" value="{{ $log->start_time->format('Y-m-d\\TH:i') }}" class="form-control" required>
					</div>
					<div class="col-md-6">
						<label class="form-label">Durasi (menit)</label>
						<input type="number" name="duration_minutes" class="form-control" min="1" value="{{ $log->duration_minutes }}" required>
					</div>
					<div class="col-12">
						<label class="form-label">Catatan</label>
						<textarea name="notes" class="form-control">{{ $log->notes }}</textarea>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


