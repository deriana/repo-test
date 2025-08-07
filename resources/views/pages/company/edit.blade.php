@extends('layouts.app')

@section('title', 'Edit Profil Perusahaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profil Perusahaan</h1>
        </div>

        <div class="section-body">
            {{-- Pesan Success --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Pesan Error --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form --}}
            <form action="{{ route('company.update') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Alamat</label>
                            <input type="text" name="address" value="{{ old('address', $company->address ?? '') }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>No.Tlp</label>
                            <input type="text" name="email" value="{{ old('email', $company->email ?? '') }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Jam Masuk</label>
                            <input type="time" name="time_in" value="{{ old('time_in', $company->time_in ?? '') }}" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Jam Pulang</label>
                            <input type="time" name="time_out" value="{{ old('time_out', $company->time_out ?? '') }}" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-center mt-4 gap-2">
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
