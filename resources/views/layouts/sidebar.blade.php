<li class="nav-item">
    <a class="nav-link {{ request()->is('indeks-struktural*') ? 'active' : '' }}" href="{{ route('indeks-struktural.index') }}">
        <i class="ti ti-building"></i>
        <span>Indeks Struktural</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('indeks-jasa-tidak-langsung*') ? 'active' : '' }}" href="{{ route('indeks-jasa-tidak-langsung.index') }}">
        <i class="ti ti-cash"></i>
        <span>Indeks Jasa Tidak Langsung</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('indeks-jasa-langsung-non-medis*') ? 'active' : '' }}" href="{{ route('indeks-jasa-langsung-non-medis.index') }}">
        <i class="ti ti-cash"></i>
        <span>Indeks Jasa Langsung Non Medis</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('pegawai*') ? 'active' : '' }}" href="{{ route('pegawai.index') }}">
        <i class="ti ti-users"></i>
        <span>Pegawai</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('transaksi-remunerasi-pegawai*') ? 'active' : '' }}" href="{{ route('transaksi-remunerasi-pegawai.index') }}">
        <i class="ti ti-cash"></i>
        <span>Transaksi Remunerasi Pegawai</span>
    </a>
</li> 