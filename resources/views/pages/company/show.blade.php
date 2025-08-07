@extends('layouts.app')

@section('title', 'Profil Perusahaan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profil Perusahaan</h1>
        </div>

        <div class="section-body">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Informasi Perusahaan</h4>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('company.edit') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-edit mr-1"></i> Perbarui Data
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-dark">Nama Perusahaan</div>
                        <div class="col-md-8">{{ $company->name ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-dark">Alamat Lengkap</div>
                        <div class="col-md-8">{{ $company->address ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-dark">No.Tlp Perusahaan</div>
                        <div class="col-md-8">{{ $company->email ?? 'Belum diisi' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-dark">Jam Masuk Kerja</div>
                        <div class="col-md-8">{{ $company->time_in ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold text-dark">Jam Pulang Kerja</div>
                        <div class="col-md-8">{{ $company->time_out ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
