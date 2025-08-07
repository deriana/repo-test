@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Absensi</h1>
        </div>

        <div class="section-body">
            <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Data User (readonly) --}}
                <div class="form-group">
                    <label>Nama User</label>
                    <input type="text" class="form-control" value="{{ $attendance->user->name }}" readonly>
                </div>

                {{-- Data Umum --}}
                <div class="form-group">
                    <label>Nama Sekolah</label>
                    <input type="text" class="form-control" value="{{ $attendance->user->sekolah->nama }}" readonly>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <input type="text" class="form-control" value="{{ $attendance->user->jurusan->nama }}" readonly>
                </div>

                {{-- Absen Masuk --}}
                <div class="border p-4 mb-3 rounded">
                    <h6 class="mb-3">🕒 Absen Masuk</h6>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ $attendance->date }}">
                    </div>

                    <div class="form-group">
                        <label>Jam Masuk</label>
                        <input type="time" name="time_in" class="form-control" value="{{ $attendance->time_in }}">
                    </div>
                </div>

                {{-- Absen Keluar --}}
                <div class="border p-4 rounded">
                    <h6 class="mb-3">🕔 Absen Keluar</h6>

                    <div class="form-group">
                        <label>Jam Keluar</label>
                        <input type="time" name="time_out" class="form-control" value="{{ $attendance->time_out }}">
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
