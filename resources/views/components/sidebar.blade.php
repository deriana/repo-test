<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img alt="image" src="{{ asset('logo.png') }}" class="mr-1" height="24">
            <a href="/">Ikat Digital</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img alt="image" src="{{ asset('logo.png') }}" class="mr-1" height="24">
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item  ">
                <a href="{{ route('dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (auth()->user() && auth()->user()->role == 'admin')
                <li class="nav-item ">
                    <a href="{{ route('users.index') }}" class="nav-link "><i class="fas fa-users"></i>
                        <span>Users</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('sekolah.index') }}" class="nav-link "><i class="fas fa-school"></i>
                        <span>Sekolah</span></a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('companies.show', 1) }}" class="nav-link">
                    <i class="fas fa-building"></i>
                    <span>Company</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('attendances.index') }}" class="nav-link">
                    <i class="fas fa-check"></i>
                    <span>Absensi</span>
                </a>
            </li>
            @if (auth()->user() && auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('rekap.index') }}" class="nav-link">
                        <i class="fas fa-columns"></i>
                        <span>Rekap Absensi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}" class="nav-link">
                        <i class="fas fa-columns"></i>
                        <span>Ijin</span>
                    </a>
                </li>
            @endif

    </aside>
</div>
