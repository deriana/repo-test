@extends('layouts.app')

@section('title', 'Edit Disposisi Surat')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Disposisi Surat: {{ $letter->reference_number }}</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('transaction.disposition.update', [$letter->id, $data->id]) }}" method="POST">
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
                            <h4>Form Edit Disposisi</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label>Tujuan Disposisi (To)</label>
                                    <input type="text" name="to" value="{{ old('to', $data->to) }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Jatuh Tempo</label>
                                    <input type="date" name="due_date"
                                        value="{{ old('due_date', $data->due_date ? \Carbon\Carbon::parse($data->due_date)->format('Y-m-d') : '') }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Isi Disposisi</label>
                                <textarea name="content" class="form-control" rows="3" required>{{ old('content', $data->content) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label>Catatan (Opsional)</label>
                                <textarea name="note" class="form-control" rows="2">{{ old('note', $data->note) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label>Status Surat</label>
                                <select name="letter_status" class="form-control select2" required>
                                    <option value="">Pilih Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('letter_status', $data->letter_status) == $status->id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('transaction.disposition.index', $letter->id) }}"
                                class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Disposisi</button>
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
        });
    </script>
@endpush
