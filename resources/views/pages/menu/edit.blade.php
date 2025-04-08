@extends('root')
@section('title', 'Edit Menu')
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Edit Menu',
        'links' => [
            ['url' => route('menu.index'), 'label' => 'Menu'],
        ],
        'current' => 'Edit'
    ])

    <div class="card card-body">
        {{-- Tampilkan error alert jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menu.update', $menu->uuid) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                @error('nama_menu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="route" class="form-label">Route</label>
                <input type="text" class="form-control @error('route') is-invalid @enderror" id="route" name="route" value="{{ old('route', $menu->route) }}">
                @error('route')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icon</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $menu->icon) }}">
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Menu</label>
                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">Tidak ada parent</option>
                    @foreach ($menuss as $item)
                        <option value="{{ $item->id }}" {{ $menu->parent_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_menu }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
