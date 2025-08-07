@extends('layouts.app')

@section('title', 'Tambah Sekolah')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Sekolah</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('sekolah.store') }}" method="POST">
                        @csrf

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
                            <h4>Form Tambah Sekolah</h4>
                        </div>
                        <div class="card-body">

                            {{-- Nama Sekolah --}}
                            <div class="form-group">
                                <label for="nama">Nama Sekolah</label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="form-control @error('nama') is-invalid @enderror">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat Sekolah --}}
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}"
                                    class="form-control @error('alamat') is-invalid @enderror">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Daftar Jurusan --}}
                            <div class="form-group">
                                <label>Jurusan</label>
                                <div id="jurusan-wrapper">
                                    @if (old('jurusan'))
                                        @foreach (old('jurusan') as $index => $nama)
                                            <div class="input-group mb-2 jurusan-item">
                                                <input type="text" name="jurusan[]" value="{{ $nama }}"
                                                    class="form-control" placeholder="Nama Jurusan">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger btn-remove-jurusan">&times;</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 jurusan-item">
                                            <input type="text" name="jurusan[]" class="form-control"
                                                placeholder="Nama Jurusan">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger btn-remove-jurusan">&times;</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-success" id="add-jurusan">
                                    <i class="fas fa-plus"></i> Tambah Jurusan
                                </button>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Simpan</button>
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

            $('#add-jurusan').click(function() {
                $('#jurusan-wrapper').append(`
                    <div class="input-group mb-2 jurusan-item">
                        <input type="text" name="jurusan[]" class="form-control" placeholder="Nama Jurusan">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-remove-jurusan">&times;</button>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.btn-remove-jurusan', function() {
                $(this).closest('.jurusan-item').remove();
            });
        });
    </script>
@endpush
