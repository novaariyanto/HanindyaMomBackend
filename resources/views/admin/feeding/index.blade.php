@extends('root')
@section('title', 'Feeding Logs')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Feeding Logs</h1>
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	<div class="mb-3">
		<a href="{{ route('admin.feeding.create') }}" class="btn btn-primary">Tambah</a>
		<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
	</div>
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="table-light"><tr><th>Baby</th><th>Type</th><th>Start</th><th>Durasi</th><th>Notes</th><th style="width:160px">Aksi</th></tr></thead>
					<tbody>
					@foreach($logs as $log)
						<tr>
							<td>{{ $log->baby_id }}</td>
							<td>{{ $log->type }}</td>
							<td>{{ $log->start_time }}</td>
							<td>{{ $log->duration_minutes }} m</td>
							<td>{{ $log->notes }}</td>
							<td>
								<a href="{{ route('admin.feeding.edit',$log) }}" class="btn btn-sm btn-warning">Edit</a>
								<form method="POST" action="{{ route('admin.feeding.destroy',$log) }}" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item?')">Hapus</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">{{ $logs->links() }}</div>
	</div>
</div>
@endsection


