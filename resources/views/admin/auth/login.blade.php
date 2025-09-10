@extends('root')
@section('title', 'Login')

@section('content')
<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white">Login</div>
				<div class="card-body">
					@if ($errors->any())
						<div class="alert alert-danger" role="alert">
							{{ $errors->first() }}
						</div>
					@endif
					<form method="POST" action="{{ route('login') }}">
						@csrf
						<div class="mb-3">
							<label class="form-label">Username atau Email</label>
							<input type="text" name="username" class="form-control" required value="{{ old('username') }}">
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<input type="password" name="password" class="form-control" required>
						</div>
						<button type="submit" class="btn btn-primary">Masuk</button>
						<a href="{{ route('register') }}" class="btn btn-link">Daftar</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


