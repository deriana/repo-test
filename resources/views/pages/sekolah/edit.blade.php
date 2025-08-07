@extends('layouts.app')

@section('title', 'Edit Sekolah')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Sekolah</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('sekolah.update', $sekolah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terjadi kesalahan!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card-header">
                            <h4>Form Edit Sekolah</h4>
                        </div>
                        <div class="card-body">

                            {{-- Nama Sekolah --}}
                            <div class="form-group">
                                <label for="nama">Nama Sekolah</label>
                                <input type="text" name="nama" value="{{ old('nama', $sekolah->nama) }}"
                                    class="form-control @error('nama') is-invalid @enderror">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat Sekolah --}}
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat', $sekolah->alamat) }}"
                                    class="form-control @error('alamat') is-invalid @enderror">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Daftar Jurusan --}}
                            <div class="form-group">
                                <label>Jurusan</label>
                                <div id="jurusan-wrapper">
                                    @php
                                        $jurusanList = old('jurusan', $sekolah->jurusan ?? []);
                                    @endphp

                                    @forelse ($jurusanList as $index => $jurusan)
                                        <div class="input-group mb-2 jurusan-item">
                                            <input type="hidden" name="jurusan[{{ $index }}][id]"
                                                value="{{ $jurusan['id'] ?? '' }}">
                                            <input type="text" name="jurusan[{{ $index }}][nama]"
                                                value="{{ $jurusan['nama'] ?? '' }}" class="form-control"
                                                placeholder="Nama Jurusan">
                                            <div class="input-group-append">
                                                <button type="button"
                                                    class="btn btn-danger btn-remove-jurusan">&times;</button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="input-group mb-2 jurusan-item">
                                            <input type="text" name="jurusan[0][nama]" class="form-control"
                                                placeholder="Nama Jurusan">
                                            <div class="input-group-append">
                                                <button type="button"
                                                    class="btn btn-danger btn-remove-jurusan">&times;</button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-sm btn-success" id="add-jurusan">
                                    <i class="fas fa-plus"></i> Tambah Jurusan
                                </button>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            let jurusanIndex = {{ count($jurusanList) }};

            $('#add-jurusan').click(function() {
                $('#jurusan-wrapper').append(`
        <div class="input-group mb-2 jurusan-item">
            <input type="hidden" name="jurusan[${jurusanIndex}][id]" value="">
            <input type="text" name="jurusan[${jurusanIndex}][nama]" class="form-control" placeholder="Nama Jurusan">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger btn-remove-jurusan">&times;</button>
            </div>
        </div>
    `);
                jurusanIndex++;
            });


            $(document).on('click', '.btn-remove-jurusan', function() {
                $(this).closest('.jurusan-item').remove();
            });
        });
    </script>
@endpush
