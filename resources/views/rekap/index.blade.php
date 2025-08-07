@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('main')
<div class="main-content">
    <section class="section px-0" style="padding-top: 20px; padding-bottom: 40px;">
        <div class="container-fluid px-0">

            <div class="card shadow-sm">
                <div class="card-body px-4 py-4">

                    {{-- HEADER --}}
                    <div class="section-header mb-4">
                        <h1 class="h4 fw-bold text-dark mb-1">Rekap Absensi</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </div>
                            <div class="breadcrumb-item active">
                                <a href="{{ route('attendances.index') }}">Absensi</a>
                            </div>
                            <div class="breadcrumb-item">Rekap Absensi</div>
                        </div>
                    </div>

                    {{-- FORM FILTER --}}
                    <form action="{{ route('rekap.tampil') }}" method="POST" class="row g-3 mb-4">
                        @csrf
                        @if (auth()->user()->role === 'admin')
                            <div class="col-md-4 col-12">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Cari berdasarkan nama" value="{{ old('nama', $nama_input ?? '') }}">
                            </div>
                        @endif
                        <div class="col-md-4 col-12">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $tanggal_mulai ?? '') }}" required>
                        </div>
                        <div class="col-md-4 col-12">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $tanggal_selesai ?? '') }}" required>
                        </div>
                        <div class="col-md-2 col-12 d-grid">
                            <button type="submit" class="btn btn-warning mt-2">Tampilkan</button>
                        </div>
                    </form>

                    {{-- HASIL REKAP --}}
                    @if (isset($data))
                        <div class="text-center mb-3">
                            <h5 class="mb-2 fw-semibold">
                                Hasil Rekap:
                                <span class="text-primary">{{ $tanggal_mulai }}</span> s/d
                                <span class="text-primary">{{ $tanggal_selesai }}</span>
                            </h5>
                        </div>

                        <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
                            <span class="badge bg-success text-white p-2 fs-6 mx-1">Hadir: {{ $summary['hadir'] ?? 0 }}</span>
                            <span class="badge bg-warning text-white p-2 fs-6 mx-1">Terlambat: {{ $summary['terlambat'] ?? 0 }}</span>
                            <a href="{{ route('rekap.izin') }}" class="text-decoration-none mx-1">
                                <span class="badge bg-info text-white p-2 fs-6">Data Izin</span>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" style="min-width: 900px;">
                                <thead class="text-center fs-6" style="background-color: #ff9900;">
                                    <tr>
                                        <th class="text-dark fw-bold" style="width: 5%;">No</th>
                                        @if(auth()->user()->role === 'admin')
                                            <th class="text-dark fw-bold" style="width: 20%;">Nama</th>
                                        @endif
                                        <th class="text-dark fw-bold" style="width: 15%;">Tanggal</th>
                                        <th class="text-dark fw-bold" style="width: 15%;">Masuk</th>
                                        <th class="text-dark fw-bold" style="width: 15%;">Pulang</th>
                                        <th class="text-dark fw-bold" style="width: 20%;">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $lastDate = null; @endphp
                                    @forelse ($data as $item)
                                        @if ($lastDate !== $item->date)
                                            <tr style="background-color: #f2f2f2;">
                                                <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="fw-bold text-dark">
                                                    📅 {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}
                                                </td>
                                            </tr>
                                            @php $lastDate = $item->date; @endphp
                                        @endif

                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            @if(auth()->user()->role === 'admin')
                                                <td>{{ $item->user->name ?? '-' }}</td>
                                            @endif
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->time_in ?? '-' }}</td>
                                            <td>{{ $item->time_out ?? '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $status = $item->status_terhitung ?? '-';
                                                @endphp

                                                @if($status === 'Hadir')
                                                    <span class="badge bg-success text-white rounded-pill px-3">Hadir</span>
                                                @elseif($status === 'Terlambat')
                                                    <span class="badge bg-warning text-white">Terlambat</span>
                                                @elseif($status === 'Izin')
                                                    <span class="badge bg-info text-dark">Data Izin</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}" class="text-center">Tidak ada data absen</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div> {{-- end card-body --}}
            </div> {{-- end card --}}

        </div>
    </section>
</div>
@endsection
