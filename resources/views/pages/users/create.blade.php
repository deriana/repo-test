@extends('layouts.app')

@section('title', 'Tambah User')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah User</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">

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

                        @csrf
                        <div class="card-header">
                            <h4>Form Tambah User</h4>
                        </div>
                        <div class="card-body">

                            {{-- Name --}}
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Role --}}
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="role" value="admin" class="selectgroup-input"
                                            {{ old('role', 'admin') == 'admin' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Admin</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="role" value="staff" class="selectgroup-input"
                                            {{ old('role') == 'staff' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Pelajar</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Sekolah --}}
                            <div class="form-group">
                                <label for="sekolah_id">Sekolah</label>
                                <select name="sekolah_id" id="sekolah_id"
                                    class="form-control select2 @error('sekolah_id') is-invalid @enderror" required>
                                    <option value="">Pilih Sekolah</option>
                                    @foreach ($sekolah as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('sekolah_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sekolah_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="form-group">
                                <label for="jurusan_id">Jurusan</label>
                                <select name="jurusan_id" id="jurusan_id"
                                    class="form-control select2 @error('jurusan_id') is-invalid @enderror" required>
                                    <option value="">Pilih Jurusan</option>
                                    {{-- Akan diisi otomatis lewat AJAX --}}
                                </select>
                                @error('jurusan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input File -->
                            <div class="mb-3">
                                <label for="image_url" class="form-label">Gambar</label>
                                <input type="file" name="image_url" class="form-control">
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

            $('#sekolah_id').change(function() {
                var sekolahId = $(this).val();
                $('#jurusan_id').empty().append('<option value="">Pilih Jurusan</option>');

                if (sekolahId) {
                    fetch(`/get-jurusan-by-sekolah/${sekolahId}`)
                        .then(res => res.json())
                        .then(data => {
                            for (const [id, nama] of Object.entries(data)) {
                                $('#jurusan_id').append(`<option value="${id}">${nama}</option>`);
                            }
                        });
                }
            });

            // Jika user kembali dari validasi gagal
            @if (old('sekolah_id'))
                $('#sekolah_id').trigger('change');
            @endif
        });
    </script>
@endpush
