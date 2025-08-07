@extends('layouts.app')

@section('title', 'Detail Izin')

@section('main')
<div class="container mt-4">
    <h2>Detail Izin</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $izin->user->name }}</p>
            <p><strong>Tanggal Izin:</strong> {{ $izin->tanggal }}</p>
            <p><strong>Alasan:</strong> {{ $izin->alasan }}</p>
            <a href="{{ route('rekap.izin') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

    
</div>
@endsection
