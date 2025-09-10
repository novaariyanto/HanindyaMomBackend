@extends('root')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-4">Dashboard</h1>
	<div class="row g-3 mb-4">
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Total Users</h6>
					<h3 class="mb-0">{{ $summary['total_users'] }}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Total Babies</h6>
					<h3 class="mb-0">{{ $summary['total_babies'] }}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Feeding Hari Ini</h6>
					<h3 class="mb-0">{{ $summary['feeding_today'] }}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Diaper Hari Ini</h6>
					<h3 class="mb-0">{{ $summary['diaper_today'] }}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Sleep Hari Ini</h6>
					<h3 class="mb-0">{{ $summary['sleep_today'] }}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-light shadow-sm">
				<div class="card-body">
					<h6 class="card-title mb-2">Vaksin Terdekat</h6>
					<p class="mb-0">{{ optional($summary['next_vaccine'])->vaccine_name }}<br>{{ optional(optional($summary['next_vaccine'])->schedule_date)->toDateString() }}</p>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4 shadow-sm">
		<div class="card-header">Grafik Pertumbuhan (Berat & Tinggi)</div>
		<div class="card-body">
			<canvas id="growthChart" height="100"></canvas>
		</div>
	</div>

	<div class="card shadow-sm">
		<div class="card-header">Aktivitas Terbaru</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="table-light"><tr><th>Waktu</th><th>Tipe</th><th>Catatan</th></tr></thead>
					<tbody>
					@foreach($latestTimeline as $i)
						<tr>
							<td>{{ optional($i['time'])->toDateTimeString() }}</td>
							<td><span class="badge text-bg-secondary">{{ $i['type'] }}</span></td>
							<td>{{ $i['notes'] }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	const growth = @json($growth);
	const labels = growth.map(g => g.date);
	const weight = growth.map(g => parseFloat(g.weight));
	const height = growth.map(g => parseFloat(g.height));
	new Chart(document.getElementById('growthChart').getContext('2d'), {
		type: 'line',
		data: {
			labels,
			datasets: [
				{ label: 'Berat (kg)', data: weight, borderColor: '#2563eb', fill: false },
				{ label: 'Tinggi (cm)', data: height, borderColor: '#16a34a', fill: false },
			]
		}
	});
</script>
@endpush


