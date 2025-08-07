@extends('layouts.app')

@section('title', 'Daftar Izin')

@section('main')
    <div class="main-content">
        <section class="section px-0" style="padding-top: 80px; padding-bottom: 40px;">
            <div class="container-fluid px-0">

                {{-- ALERT --}}
                @if (session('success'))
                    <div class="alert alert-success fs-6 fw-bold">{{ session('success') }}</div>
                @endif

                {{-- FORM CARI --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold text-dark fs-4">Form Pencarian Izin</h5>
                        <form method="GET" action="{{ route('rekap.izin') }}" class="row g-2 align-items-end">
                            <div class="col-md-10 col-12">
                                <label class="form-label fw-bold text-dark fs-6">Cari berdasarkan nama</label>
                                <input type="text" name="search" class="form-control fs-6" placeholder="Nama..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 col-12 d-grid">
                                <button type="submit" class="btn fs-6 fw-bold mt-1"
                                    style="background-color: #FFA500; color: white; border: none;">
                                    Cari
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- TABEL IZIN --}}
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3 fw-bold text-dark fs-4">Daftar Izin</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="text-center fs-6">
                                    <tr>
                                        <th class="text-dark fw-bold">No</th>
                                        <th class="text-dark fw-bold">Nama</th>
                                        <th class="text-dark fw-bold">Tanggal</th>
                                        <th class="text-dark fw-bold">Alasan</th>
                                        <th class="text-dark fw-bold">Status</th>
                                        <th class="text-dark fw-bold">image</th>
                                        <th class="text-dark fw-bold">Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $lastDate = null;
                                        $number = 1;
                                    @endphp

                                    @forelse ($izinList as $izin)
                                        @if ($lastDate !== $izin->tanggal)
                                            <tr>
                                                <td colspan="5" class="fw-bold ps-3 text-dark fs-6"
                                                    style="background-color: #ffbf29;">
                                                    {{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}
                                                </td>
                                            </tr>
                                            @php $lastDate = $izin->tanggal; @endphp
                                        @endif

                                        <tr>
                                            <td class="text-center text-dark fw-bold fs-6">{{ $number++ }}</td>
                                            <td class="text-dark fw-bold fs-6">{{ $izin->user->name }}</td>
                                            <td class="text-dark fw-bold fs-6">{{ $izin->date_permission }}</td>
                                            <td class="text-dark fw-bold fs-6">
                                                {{ \Illuminate\Support\Str::limit($izin->reason, 50) }}</td>
                                            <td class="text-dark fw-bold fs-6">
                                                {{ $izin->is_aproved ? 'Iya' : 'Tidak' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($izin->image)
                                                    <img src="{{ asset('storage/' . $izin->image) }}" alt="Bukti Izin"
                                                        width="80" height="80" class="rounded">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('rekap.izin.show', $izin->id) }}"
                                                    class="btn btn-sm btn-info fw-bold fs-6">Lihat</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-dark fs-6 fw-bold">Belum ada
                                                pengajuan izin.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
