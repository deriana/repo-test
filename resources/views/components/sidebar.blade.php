<style>
    .nav-header {
        font-weight: bold;
        font-size: 0.9rem;
        margin-top: 1rem;
        padding-left: 1rem;
        color: #6c757d;
        text-transform: uppercase;
    }
</style>
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
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @if (auth()->user() && auth()->user()->role == 'admin')
                <li class="nav-header">SURAT</li>
                <li class="nav-item {{ request()->routeIs('transaction.incoming.*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.incoming.index') }}" class="nav-link"><i
                            class="fas fa-inbox"></i><span>Surat Masuk</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('transaction.outgoing.*') ? 'active' : '' }}">
                    <a href="{{ route('transaction.outgoing.index') }}" class="nav-link"><i
                            class="fas fa-paper-plane"></i><span>Surat Keluar</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('classification.*') ? 'active' : '' }}">
                    <a href="{{ route('classification.index') }}" class="nav-link"><i
                            class="fas fa-folder-tree"></i><span>Klasifikasi Surat</span></a>
                </li>
                {{-- <li class="nav-item {{ request()->routeIs('letter-status.*') ? 'active' : '' }}">
                    <a href="{{ route('letter-status.index') }}" class="nav-link"><i
                            class="fas fa-envelope-open-text"></i><span>Status Surat</span></a>
                </li> --}}
                <li class="nav-item {{ request()->routeIs('agenda.incoming') ? 'active' : '' }}">
                    <a href="{{ route('agenda.incoming') }}" class="nav-link"><i
                            class="fas fa-folder-open"></i><span>Agenda Surat Masuk</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('agenda.outgoing') ? 'active' : '' }}">
                    <a href="{{ route('agenda.outgoing') }}" class="nav-link"><i class="fas fa-share"></i><span>Agenda
                            Surat Keluar</span></a>
                </li>

                <li class="nav-header">ADMINISTRASI</li>
                <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="nav-link"><i
                            class="fas fa-users"></i><span>Users</span></a>
                </li>
            @endif

            <li class="nav-header">PERUSAHAAN</li>
            <li class="nav-item {{ request()->routeIs('companies.show') ? 'active' : '' }}">
                <a href="{{ route('companies.show', 1) }}" class="nav-link"><i
                        class="fas fa-building"></i><span>Company</span></a>
            </li>

            <li class="nav-header">ABSENSI</li>
            <li class="nav-item {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <a href="{{ route('attendances.index') }}" class="nav-link"><i
                        class="fas fa-check"></i><span>Absensi</span></a>
            </li>

            @if (auth()->user() && auth()->user()->role == 'admin')
                {{-- <li class="nav-item {{ request()->routeIs('sekolah.*') ? 'active' : '' }}">
                    <a href="{{ route('sekolah.index') }}" class="nav-link"><i class="fas fa-columns"></i><span>Sekolah
                            </span></a>
                </li> --}}
                <li class="nav-item {{ request()->routeIs('rekap.*') ? 'active' : '' }}">
                    <a href="{{ route('rekap.index') }}" class="nav-link"><i class="fas fa-columns"></i><span>Rekap
                            Absensi</span></a>
                </li>
                {{-- <li class="nav-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="nav-link"><i
                            class="fas fa-columns"></i><span>Ijin</span></a>
                </li> --}}
            @endif



    </aside>
</div>
