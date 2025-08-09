@extends('layouts.app')

@section('title', 'Tambah Surat keluar')

@push('style')
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Surat keluar</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('transaction.outgoing.store') }}" method="POST" enctype="multipart/form-data">
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
                        <h4>Form Surat Keluar</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nomor Surat</label>
                                <input type="text" name="reference_number" value="{{ old('reference_number') }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nomor Agenda</label>
                                <input type="text" name="agenda_number" value="{{ old('agenda_number') }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Penerima</label>
                                <input type="text" name="to" value="{{ old('to') }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Tanggal Surat</label>
                                <input type="date" name="letter_date" value="{{ old('letter_date') }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Klasifikasi</label>
                            <select name="classification_code" class="form-control select2">
                                <option value="">Pilih Klasifikasi</option>
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->code }}" {{ old('classification_code') == $classification->code ? 'selected' : '' }}>
                                        {{ $classification->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="type" value="outgoing">

                        {{-- Upload Lampiran --}}
                        <div class="form-group">
                            <label>Lampiran (Foto/Dokumen)</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                            <small class="text-muted">Bisa unggah lebih dari satu file (png, jpg, jpeg, pdf) max 2MB per file</small>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
    $(document).ready(function(){
        $('.select2').select2();
    });
</script>
@endpush
