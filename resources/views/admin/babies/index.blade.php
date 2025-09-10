@extends('root')
@section('title', 'Babies')

@section('content')
<div class="container">
	<h1 class="mt-4 mb-3">Babies</h1>
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	<div class="mb-3">
		<a href="{{ route('admin.babies.create') }}" class="btn btn-primary">Tambah Bayi</a>
		<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
	</div>
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0">
					<thead class="table-light"><tr><th>Nama</th><th>User UUID</th><th>Tgl Lahir</th><th style="width:160px">Aksi</th></tr></thead>
					<tbody>
					@foreach($babies as $baby)
						<tr>
							<td><a href="{{ route('admin.babies.show',$baby) }}">{{ $baby->name }}</a></td>
							<td>{{ $baby->user_uuid }}</td>
							<td>{{ optional($baby->birth_date)->toDateString() }}</td>
							<td>
								<a href="{{ route('admin.babies.edit',$baby) }}" class="btn btn-sm btn-warning">Edit</a>
								<form method="POST" action="{{ route('admin.babies.destroy',$baby) }}" class="d-inline">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus bayi?')">Hapus</button>
								</form>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">{{ $babies->links() }}</div>
	</div>
</div>
@endsection


