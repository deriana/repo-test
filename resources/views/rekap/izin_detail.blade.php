@extends('layouts.app')

@section('title', 'Izin Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Izin Detail</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Izin Detail</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Izin Detail</h2>
                <p class="section-lead">
                    Informasi tentang detail izin karyawan.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama Sisw</label>
                                        <p>{{ $izin->user->name }}</p>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Telpon Siswa</label>
                                        <p>{{ $izin->user->phone }}</p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Sekolah</label>
                                        <p>{{ $izin->user->sekolah->nama ?? '-' }}</p>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Jurusan</label>
                                        <p>{{ $izin->user->jurusan->nama ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Date Izin</label>
                                        <p>{{ $izin->date_permission }}</p>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Reason</label>
                                        <p>{{ $izin->reason }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Bukti Dukung</label>
                                        @if ($izin->image)
                                            <!-- Jika image tersedia, tampilkan gambar -->
                                            <div>
                                                <img src="{{ asset('storage/' . $izin->image) }}"
                                                    alt="Bukti Dukung" class="img-thumbnail mb-3" style="max-width: 200px;">
                                            </div>
                                        @else
                                            <!-- Jika image kosong, tampilkan teks -->
                                            <p>Tidak ada bukti dukung</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Status</label>
                                        <p>
                                            @if ($izin->is_approved == 1)
                                                Dizinkan
                                            @else
                                                Tidak di izinkan
                                            @endif
                                        </p>
                                    </div>

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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
