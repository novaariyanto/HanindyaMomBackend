@extends('root')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
		<div>
			<h1 class="h3 mb-1">Dashboard</h1>
			<p class="text-muted mb-0">Ringkasan data utama dan aktivitas terbaru</p>
		</div>
		<div class="d-none d-md-flex gap-2">
			<a href="{{ route('admin.babies.index') }}" class="btn btn-primary btn-sm"><i class="ti ti-baby-carriage me-1"></i>Kelola Bayi</a>
			<a href="{{ route('admin.feeding.index') }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-bottle me-1"></i>Feeding</a>
			<a href="{{ route('admin.diapers.index') }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-diaper me-1"></i>Diaper</a>
			<a href="{{ route('admin.vaccines.index') }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-vaccine me-1"></i>Vaksin</a>
		</div>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e8f1ff;color:#2563eb;">
						<i class="ti ti-users"></i>
					</div>
					<div>
						<div class="text-muted small">Total Users</div>
						<div class="fs-4 fw-semibold">{{ $summary['total_users'] }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e8fff3;color:#16a34a;">
						<i class="ti ti-baby-carriage"></i>
					</div>
					<div>
						<div class="text-muted small">Total Babies</div>
						<div class="fs-4 fw-semibold">{{ $summary['total_babies'] }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#fff6e6;color:#f59e0b;">
						<i class="ti ti-bottle"></i>
					</div>
					<div>
						<div class="text-muted small">Feeding Hari Ini</div>
						<div class="fs-4 fw-semibold">{{ $summary['feeding_today'] }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#f3e8ff;color:#7c3aed;">
						<i class="ti ti-diaper"></i>
					</div>
					<div>
						<div class="text-muted small">Diaper Hari Ini</div>
						<div class="fs-4 fw-semibold">{{ $summary['diaper_today'] }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e7f9ff;color:#0891b2;">
						<i class="ti ti-moon"></i>
					</div>
					<div>
						<div class="text-muted small">Sleep Hari Ini</div>
						<div class="fs-4 fw-semibold">{{ $summary['sleep_today'] }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 col-md-3 col-xxl-2">
			<div class="card shadow-sm border-0 h-100">
				<div class="card-body d-flex align-items-center">
					<div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#ffeef0;color:#e11d48;">
						<i class="ti ti-vaccine"></i>
					</div>
					<div>
						<div class="text-muted small">Vaksin Terdekat</div>
						<div class="fw-semibold">{{ optional($summary['next_vaccine'])->vaccine_name ?? '-' }}</div>
						<div class="small text-muted">{{ optional(optional($summary['next_vaccine'])->schedule_date)->toDateString() }}</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-3 mb-4">
		<div class="col-12 col-xxl-8">
			<div class="card shadow-sm">
				<div class="card-header d-flex justify-content-between align-items-center">
					<span>Grafik Pertumbuhan (Berat & Tinggi)</span>
					<div class="text-muted small">Per waktu</div>
				</div>
				<div class="card-body">
					<canvas id="growthChart" height="120"></canvas>
				</div>
			</div>
		</div>
		<div class="col-12 col-xxl-4">
			<div class="card shadow-sm h-100">
				<div class="card-header">Aktivitas Hari Ini</div>
				<div class="card-body">
					<canvas id="todayDoughnut" height="180"></canvas>
					<div class="d-flex justify-content-around mt-3 small text-muted">
						<div><span class="legend-dot me-1" style="background:#f59e0b"></span>Feeding</div>
						<div><span class="legend-dot me-1" style="background:#7c3aed"></span>Diaper</div>
						<div><span class="legend-dot me-1" style="background:#0891b2"></span>Sleep</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card shadow-sm">
		<div class="card-header">Aktivitas Terbaru</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-borderless align-middle mb-0">
					<thead class="table-light"><tr><th>Waktu</th><th>Tipe</th><th>Catatan</th></tr></thead>
					<tbody>
					@foreach($latestTimeline as $i)
						<tr>
							<td class="text-nowrap">{{ optional($i['time'])->toDateTimeString() }}</td>
							<td>
								@php
									$map = [
										'feeding' => ['cls' => 'text-bg-warning', 'icon' => 'ti-bottle'],
										'diaper' => ['cls' => 'text-bg-purple', 'icon' => 'ti-diaper'],
										'sleep' => ['cls' => 'text-bg-info', 'icon' => 'ti-moon'],
										'growth' => ['cls' => 'text-bg-success', 'icon' => 'ti-arrow-up-right'],
										'vaccine' => ['cls' => 'text-bg-danger', 'icon' => 'ti-vaccine'],
									];
									$cfg = $map[$i['type']] ?? ['cls' => 'text-bg-secondary', 'icon' => 'ti-dots'];
								@endphp
								<span class="badge {{ $cfg['cls'] }}"><i class="ti {{ $cfg['icon'] }} me-1"></i>{{ ucfirst($i['type']) }}</span>
							</td>
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

	const ctx = document.getElementById('growthChart').getContext('2d');
	const gradientBlue = ctx.createLinearGradient(0, 0, 0, 180);
	gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
	gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0.0)');
	const gradientGreen = ctx.createLinearGradient(0, 0, 0, 180);
	gradientGreen.addColorStop(0, 'rgba(22, 163, 74, 0.35)');
	gradientGreen.addColorStop(1, 'rgba(22, 163, 74, 0.0)');

	new Chart(ctx, {
		type: 'line',
		data: {
			labels,
			datasets: [
				{ label: 'Berat (kg)', data: weight, borderColor: '#2563eb', backgroundColor: gradientBlue, fill: true, tension: .35, pointRadius: 2, pointHoverRadius: 4 },
				{ label: 'Tinggi (cm)', data: height, borderColor: '#16a34a', backgroundColor: gradientGreen, fill: true, tension: .35, pointRadius: 2, pointHoverRadius: 4 },
			]
		},
		options: {
			maintainAspectRatio: false,
			plugins: {
				legend: { display: true },
				tooltip: { mode: 'index', intersect: false }
			},
			scales: {
				x: { grid: { display: false } },
				y: { grid: { color: 'rgba(0,0,0,.05)' }, beginAtZero: true }
			}
		}
	});

	// Doughnut today
	const todayCtx = document.getElementById('todayDoughnut').getContext('2d');
	new Chart(todayCtx, {
		type: 'doughnut',
		data: {
			labels: ['Feeding', 'Diaper', 'Sleep'],
			datasets: [{
				data: [{{ (int) $summary['feeding_today'] }}, {{ (int) $summary['diaper_today'] }}, {{ (int) $summary['sleep_today'] }}],
				backgroundColor: ['#f59e0b', '#7c3aed', '#0891b2'],
				borderWidth: 0
			}]
		},
		options: {
			plugins: { legend: { display: false } },
			cutout: '65%'
		}
	});
</script>
@endpush


