@extends('layouts.app')

@section('title', 'Detail Surat Masuk')

@push('style')
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<style>
    .letter-container {
        background: #fff;
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-width: 900px;
        margin: auto;
        font-family: 'Times New Roman', serif;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .letter-header {
        border-bottom: 2px solid #000;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    .letter-header h2 {
        font-weight: bold;
        margin: 0;
    }
    .letter-body {
        white-space: pre-line;
    }
    .attachments img {
        max-height: 200px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Surat Masuk</h1>
        </div>

        <div class="section-body">
            <div class="letter-container">
                {{-- Header Surat --}}
                <div class="letter-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2>{{ $data->reference_number }}</h2>
                        <small>
                            {{ $data->from ?? '-' }} |
                            Agenda: {{ $data->agenda_number ?? '-' }} |
                            {{ $data->classification_code ?? '-' }}
                        </small>
                    </div>
                    <div class="text-end">
                        <strong>Tanggal Surat:</strong><br>
                        {{ $data->letter_date ? $data->letter_date->format('d/m/Y') : '-' }}
                        <br>
                        <strong>Diterima:</strong><br>
                        {{ $data->received_date ? $data->received_date->format('d/m/Y') : '-' }}
                    </div>
                </div>

                {{-- Isi Surat --}}
                <div class="letter-body mb-4">
                    {{-- <p><strong>Perihal:</strong> {{ $data->subject ?? '-' }}</p> --}}
                    <p>{{ $data->description ?? 'Tidak ada isi surat' }}</p>
                @if ($data->note)
                        <p><em>Catatan:</em> {{ $data->note }}</p>
                    @endif
                </div>

                {{-- Lampiran --}}
                @if ($data->attachments && count($data->attachments) > 0)
                    <div class="attachments mt-4">
                        <h5>Lampiran</h5>
                        <div class="row">
                            @foreach ($data->attachments as $attachment)
                                <div class="col-md-3 col-sm-4 mb-3 text-center">
                                    @if (in_array($attachment->extension, ['jpg', 'jpeg', 'png']))
                                        <a href="{{ asset('storage/attachments/' . $attachment->filename) }}" target="_blank">
                                            <img src="{{ asset('storage/attachments/' . $attachment->filename) }}" class="img-fluid shadow-sm">
                                        </a>
                                    @elseif ($attachment->extension == 'pdf')
                                        <a href="{{ asset('storage/attachments/' . $attachment->filename) }}"
                                           target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                           <i class="fas fa-file-pdf"></i> Lihat PDF
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
