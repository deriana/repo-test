@extends('layouts.app')

@section('title', 'Agenda Surat')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Agenda Surat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Transaksi</a></div>
                    <div class="breadcrumb-item">Agenda Surat</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <h2 class="section-title">Daftar Surat</h2>
                <p class="section-lead">
                    Anda dapat melihat dan mengelola semua surat yang terdaftar di agenda.
                </p>

                <div class="row mt-4 mb-3">
                    <div class="col-md-8">
                        <form method="GET" action="{{ url()->current() }}" class="form-inline d-flex align-items-center">
                            <label for="tanggal_a" class="me-2 mb-0 mr-2">Tanggal dari:</label>
                            <input type="date" id="tanggal_a" name="tanggal_a" value="{{ request('tanggal_a') }}"
                                class="form-control me-3">

                            <label for="tanggal_b" class="me-2 mb-0 ml-2 mr-2">Sampai:</label>
                            <input type="date" id="tanggal_b" name="tanggal_b" value="{{ request('tanggal_b') }}"
                                class="form-control me-3">

                            <button type="submit" class="btn btn-primary me-3 ml-2 mr-2">Filter</button>
                            <a href="{{ route('agenda.incoming.print', ['tanggal_a' => request('tanggal_a'), 'tanggal_b' => request('tanggal_b')]) }}"
                                target="_blank" class="btn btn-secondary">
                                Print
                            </a>
                        </form>
                    </div>
                </div>

                <div class="table-responsive" id="table-to-print">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Surat</th>
                                <th>Nomor Agenda</th>
                                <th>Pengirim</th>
                                <th>Tanggal Surat</th>
                                <th>Klasifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($letters as $letter)
                                <tr>
                                    <td>{{ $letter->reference_number }}</td>
                                    <td>{{ $letter->agenda_number }}</td>
                                    <td>{{ $letter->from }}</td>
                                    <td>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $letter->classification_code ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada surat ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
