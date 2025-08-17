@extends('layouts.app')

@section('title', 'Surat Masuk')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Surat Masuk</h1>
                <div class="section-header-button">
                    <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary">Tambah Surat</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Transaksi</a></div>
                    <div class="breadcrumb-item">Surat Masuk</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <h2 class="section-title">Daftar Surat Masuk</h2>
                <p class="section-lead">
                    Anda dapat mengelola semua surat masuk, seperti mengedit, menghapus, dan melihat detailnya.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Semua Surat Masuk</h4>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>

                                <div class="row">
                                    @forelse($data as $letter)
                                        <div class="col-12">
                                            <div class="card mb-4">
                                                <div class="card-header pb-0">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center w-100 flex-wrap">
                                                        <!-- Bagian Kiri -->
                                                        <div class="mb-2 mb-sm-0">
                                                            <h5 class="text-nowrap mb-0 fw-bold">
                                                                {{ $letter->reference_number }}
                                                            </h5>
                                                            <small class="text-black">
                                                                {{ $letter->from ?? '-' }} |
                                                                Agenda: {{ $letter->agenda_number ?? '-' }} |
                                                                {{ $letter->classification_code ?? '-' }}
                                                            </small>
                                                        </div>

                                                        <!-- Bagian Kanan -->
                                                        <div class="d-flex align-items-center text-end">
                                                            <div class="me-3 mr-3">
                                                                <small class="d-block text-secondary">Tanggal Surat</small>
                                                                {{ $letter->letter_date ? $letter->letter_date->format('d/m/Y') : '-' }}
                                                            </div>
                                                            {{-- <a href="{{ route('transaction.disposition.index', $letter->id) }}"
                                                                class="btn btn-sm btn-primary me-2 mr-3">
                                                                <i class="fas fa-paper-plane"></i> Disposisi Surat
                                                                ({{ $letter->dispositions->count() }})
                                                            </a> --}}

                                                            <div class="dropdown">
                                                                <button class="btn p-0" type="button"
                                                                    id="dropdown-{{ $letter->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="dropdown-{{ $letter->id }}">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('transaction.incoming.show', $letter->id) }}">
                                                                            <i class="fas fa-eye"></i> Lihat
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('transaction.incoming.edit', $letter->id) }}">
                                                                            <i class="fas fa-edit"></i> Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('transaction.incoming.destroy', $letter->id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fas fa-trash"></i> Hapus
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="card-body">
                                                    <hr>
                                                    <p>{{ $letter->description ?? 'Tidak ada deskripsi' }}</p>
                                                    <div class="d-flex justify-content-between flex-column flex-sm-row">
                                                        <small class="text-secondary">{{ $letter->note ?? '' }}</small>
                                                        @if ($letter->attachments && count($letter->attachments))
                                                            <div>
                                                                @foreach ($letter->attachments as $attachment)
                                                                    <a href="{{ asset('storage/attachments/' . $attachment->filename) }}"
                                                                        target="_blank">
                                                                        @if ($attachment->extension == 'pdf')
                                                                            <i
                                                                                class="fas fa-file-pdf fa-2x text-danger"></i>
                                                                        @elseif(in_array($attachment->extension, ['jpg', 'jpeg']))
                                                                            <i
                                                                                class="fas fa-file-image fa-2x text-primary"></i>
                                                                        @elseif($attachment->extension == 'png')
                                                                            <i
                                                                                class="fas fa-file-image fa-2x text-info"></i>
                                                                        @endif
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p class="text-muted">Tidak ada data surat masuk</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
