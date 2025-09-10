@extends('root')
@section('title', 'Detail Bayi')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">{{ $baby->name }}</h1>
	<div class="card mb-4 shadow-sm">
		<div class="card-body">
			<div class="row g-3">
				<div class="col-md-3"><strong>User UUID</strong><div>{{ $baby->user_uuid }}</div></div>
				<div class="col-md-3"><strong>Tgl Lahir</strong><div>{{ optional($baby->birth_date)->toDateString() }}</div></div>
				<div class="col-md-3"><strong>Berat Lahir</strong><div>{{ $baby->birth_weight }} kg</div></div>
				<div class="col-md-3"><strong>Tinggi Lahir</strong><div>{{ $baby->birth_height }} cm</div></div>
			</div>
			<div class="mt-3">
				<a href="{{ route('admin.babies.index') }}" class="btn btn-outline-secondary">Kembali</a>
			</div>
		</div>
	</div>

	<div class="row g-3">
		<div class="col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header">Growth</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-sm table-striped mb-0">
							<thead><tr><th>Tanggal</th><th>Berat</th><th>Tinggi</th></tr></thead>
							<tbody>
							@foreach($baby->growthLogs as $g)
								<tr><td>{{ $g->date }}</td><td>{{ $g->weight }} kg</td><td>{{ $g->height }} cm</td></tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header">Feeding</div>
				<div class="card-body">
					<ul class="mb-0">
					@foreach($baby->feedingLogs as $f)
						<li>{{ $f->start_time }} - {{ $f->type }} ({{ $f->duration_minutes }}m)</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-3 mt-1">
		<div class="col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header">Diaper</div>
				<div class="card-body">
					<ul class="mb-0">
					@foreach($baby->diaperLogs as $d)
						<li>{{ $d->time }} - {{ $d->type }} {{ $d->color }} {{ $d->texture }}</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header">Sleep</div>
				<div class="card-body">
					<ul class="mb-0">
					@foreach($baby->sleepLogs as $s)
						<li>{{ $s->start_time }} - {{ $s->end_time }} ({{ $s->duration_minutes }}m)</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="card shadow-sm mt-3">
		<div class="card-header">Vaccines</div>
		<div class="card-body">
			<ul class="mb-0">
			@foreach($baby->vaccineSchedules as $v)
				<li>{{ $v->schedule_date }} - {{ $v->vaccine_name }} ({{ $v->status }})</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection


