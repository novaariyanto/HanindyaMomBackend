<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach ($links as $link)
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                            </li>
                        @endforeach
                        <li class="breadcrumb-item" aria-current="page">{{ $current }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    {{-- Tambahkan gambar jika diperlukan --}}
                    {{-- <img src="{{ asset('path/to/image.png') }}" alt="{{ $title }}" class="img-fluid mb-n4"> --}}
                </div>
            </div>
        </div>
    </div>
</div>
