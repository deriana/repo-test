@extends('layouts.app')

@section('title', 'Edit User')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
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
                        <h4>Form Edit User</h4>
                    </div>
                    <div class="card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password (optional) --}}
                        <div class="form-group">
                            <label>Password (kosongkan jika tidak ingin mengganti)</label>
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
                                        {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                                    <span class="selectgroup-button">Admin</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="role" value="staff" class="selectgroup-input"
                                        {{ old('role', $user->role) === 'staff' ? 'checked' : '' }}>
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
                                        {{ old('sekolah_id', $user->sekolah_id) == $s->id ? 'selected' : '' }}>
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
                                {{-- Akan diisi otomatis lewat JS --}}
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="form-group">
                            <label for="image_url">Gambar</label>
                            <input type="file" name="image_url"
                                class="form-control @error('image_url') is-invalid @enderror">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user->image_url)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->image_url) }}" alt="Foto User" width="120">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Simpan Perubahan</button>
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

        const selectedJurusan = "{{ old('jurusan_id', $user->jurusan_id) }}";

        $('#sekolah_id').change(function() {
            const sekolahId = $(this).val();
            $('#jurusan_id').empty().append('<option value="">Pilih Jurusan</option>');

            if (sekolahId) {
                fetch(`/get-jurusan-by-sekolah/${sekolahId}`)
                    .then(res => res.json())
                    .then(data => {
                        for (const [id, nama] of Object.entries(data)) {
                            const selected = id === selectedJurusan ? 'selected' : '';
                            $('#jurusan_id').append(`<option value="${id}" ${selected}>${nama}</option>`);
                        }
                    });
            }
        });

        // Trigger untuk load jurusan saat buka form
        $('#sekolah_id').trigger('change');
    });
</script>
@endpush
