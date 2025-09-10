@extends('root')
@section('title', 'Vaccine Schedules')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Vaccine Schedules</h1>
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	<div class="mb-3">
		<a href="{{ route('admin.vaccines.create') }}" class="btn btn-primary">Tambah</a>
		<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
	</div>
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="table-light"><tr><th>Baby</th><th>Name</th><th>Date</th><th>Status</th><th>Notes</th><th style="width:160px">Aksi</th></tr></thead>
					<tbody>
					@foreach($logs as $log)
						<tr>
							<td>{{ $log->baby_id }}</td>
							<td>{{ $log->vaccine_name }}</td>
							<td>{{ $log->schedule_date }}</td>
							<td>{{ $log->status }}</td>
							<td>{{ $log->notes }}</td>
							<td>
								<a href="{{ route('admin.vaccines.edit',$log) }}" class="btn btn-sm btn-warning">Edit</a>
								<form method="POST" action="{{ route('admin.vaccines.destroy',$log) }}" class="d-inline">
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


