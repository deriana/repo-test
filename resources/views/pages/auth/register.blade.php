@extends('layouts.auth-register')

@section('title', 'Register')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .card::before,
        .card-header::before {
            display: none !important;
        }

        .card {
            border-top: none !important;
            box-shadow: none !important;
        }

        .custom-card {
            border-color: transparent !important;
        }

        /* Tombol oranye khusus untuk tombol "Daftar" di bawah */
        .btn-orange {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: white;
        }

        .btn-orange:hover {
            background-color: #e96b0a;
            border-color: #e96b0a;
            color: white;
        }
    </style>
@endpush

@section('main')

    {{-- Inline style untuk menghapus garis oranye dari komponen card dan atur tombol oranye --}}

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card rounded custom-card">
                    <div class="card-header text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-plus mr-2"></i> Daftar Akun Baru
                        </h4>
                    </div>

                    <div class="card-body px-5 py-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Oops!</strong> Ada kesalahan input:
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required>
                            </div>

                            {{-- Sekolah --}}
                            <div class="form-group">
                                <label for="sekolah">Sekolah</label>
                                <input type="text" name="sekolah" id="sekolah" value="{{ old('sekolah') }}"
                                    class="form-control @error('sekolah') is-invalid @enderror" required>
                                @error('sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan') }}"
                                    class="form-control @error('jurusan') is-invalid @enderror" required>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Konfirmasi Kata Sandi</label>
                                <input type="password" id="password-confirm" name="password_confirmation"
                                    class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-orange btn-block">
                                <i class="fas fa-user-check mr-1"></i> Daftar
                            </button>

                            <div class="text-center mt-3">
                                <div>Sudah Punya Akun? <a href="{{ route('login') }}">Login aja</a></div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
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
                            $('#jurusan_id').trigger('change');
                        });
                }
            });

            @if (old('sekolah_id'))
                fetch(`/get-jurusan-by-sekolah/{{ old('sekolah_id') }}`)
                    .then(res => res.json())
                    .then(data => {
                        for (const [id, nama] of Object.entries(data)) {
                            $('#jurusan_id').append(`<option value="${id}">${nama}</option>`);
                        }
                        $('#jurusan_id').val('{{ old('jurusan_id') }}').trigger('change');
                    });
            @endif
        });
    </script>
@endpush
