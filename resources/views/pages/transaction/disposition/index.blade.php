@extends('layouts.app')

@section('title', 'Disposition')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Disposition untuk Surat: {{ $letter->reference_number }}</h1>
                <div class="section-header-button">
                    <a href="{{ route('transaction.disposition.create', $letter->id) }}" class="btn btn-primary">Tambah Disposisi</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Transaksi</a></div>
                    <div class="breadcrumb-item">Disposition</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Daftar Disposisi Surat</h2>
                <p class="section-lead">
                    Kelola semua disposisi terkait surat ini, seperti mengedit atau menghapus.
                </p>

                @include('layouts.alert')

                <div class="row mt-4">
                    <div class="col-12">
                        @if($data->count())
                            @foreach($data as $disposition)
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h5 class="fw-bold mb-0">{{ $disposition->to }}</h5>
                                            <small class="text-muted">Status: {{ $disposition->status?->type ?? '-' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-secondary">Jatuh Tempo:</small><br>
                                            <strong>{{ $disposition->formatted_due_date }}</strong>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p><strong>Isi Disposisi:</strong> {{ $disposition->content }}</p>
                                        @if($disposition->note)
                                            <p><strong>Catatan:</strong> {{ $disposition->note }}</p>
                                        @endif
                                        <p><small>Dibuat oleh: {{ $disposition->user?->name ?? 'Tidak diketahui' }}</small></p>
                                    </div>

                                    <div class="card-footer text-end">
                                        <a href="{{ route('transaction.disposition.edit', [$letter->id, $disposition->id]) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('transaction.disposition.destroy', [$letter->id, $disposition->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus disposisi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Pagination jika menggunakan paginate --}}
                            {{-- {{ $data->links() }} --}}
                        @else
                            <p class="text-center text-muted">Belum ada disposisi untuk surat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
