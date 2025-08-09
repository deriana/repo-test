@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Surat Keluar</h1>
            </div>

            <div class="section-body">
                {{-- Form Edit Surat --}}
                <div class="card shadow-sm mb-4">
                    <form action="{{ route('transaction.outgoing.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Surat</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- Reference Number --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Referensi</label>
                                    <input type="text" name="reference_number"
                                        value="{{ old('reference_number', $data->reference_number) }}"
                                        class="form-control @error('reference_number') is-invalid @enderror">
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Agenda Number --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor Agenda</label>
                                    <input type="text" name="agenda_number"
                                        value="{{ old('agenda_number', $data->agenda_number) }}"
                                        class="form-control @error('agenda_number') is-invalid @enderror">
                                    @error('agenda_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- To --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Penerima</label>
                                    <input type="text" name="to" value="{{ old('to', $data->to) }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Letter Date --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Tanggal Surat</label>
                                    <input type="date" name="letter_date"
                                        value="{{ old('letter_date', $data->letter_date ? \Carbon\Carbon::parse($data->letter_date)->format('Y-m-d') : '') }}"
                                        class="form-control">
                                </div>



                            </div>

                            {{-- Classification --}}
                            <div class="mb-3">
                                <label class="form-label">Klasifikasi</label>
                                <select name="classification_code" class="form-control select2">
                                    @foreach ($classifications as $classification)
                                        <option value="{{ $classification->code }}"
                                            {{ old('classification_code', $data->classification_code) == $classification->code ? 'selected' : '' }}>
                                            {{ $classification->name }} ({{ $classification->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                {{-- Description --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $data->description) }}</textarea>
                                </div>

                                {{-- Note --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="note" class="form-control" rows="3">{{ old('note', $data->note) }}</textarea>
                                </div>
                            </div>

                            <input type="hidden" name="type" value="outgoing">

                            {{-- Upload Lampiran Baru --}}
                            <div class="mb-3">
                                <label class="form-label">Tambah Lampiran</label>
                                <input type="file" name="attachments[]" class="form-control" multiple>
                                <small class="form-text text-muted">Bisa upload banyak file (jpg, png, pdf)</small>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                        </div>
                    </form>
                </div>

                {{-- Lampiran Lama --}}
                @if ($data->attachments && count($data->attachments) > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Lampiran Lama</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($data->attachments as $attachment)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body text-center">
                                                @if (in_array($attachment->extension, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/attachments/' . $attachment->filename) }}"
                                                        class="img-fluid rounded mb-2"
                                                        style="max-height: 150px; object-fit: cover;">
                                                @elseif($attachment->extension == 'pdf')
                                                    <a href="{{ asset('storage/attachments/' . $attachment->filename) }}"
                                                        target="_blank" class="btn btn-outline-primary btn-sm mb-2">Lihat
                                                        PDF</a>
                                                @endif
                                                <form action="{{ route('attachments.destroy', $attachment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger w-100"
                                                        onclick="return confirm('Hapus lampiran ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
