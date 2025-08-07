@extends('layouts.app')

@section('title', 'Ajukan Izin')

@section('main')
    <div class="main-content">
        <section class="section px-0 pt-5 pb-5"> {{-- tambah pt-5 dan pb-5 untuk jarak atas-bawah --}}
            <div class="container-fluid px-3">

                <div class="section-header mt-3">
                    <h1>Ajukan Izin</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ route('attendances.index') }}">Absensi</a></div>
                        <div class="breadcrumb-item">Ajukan Izin</div>
                    </div>
                </div>


                {{-- Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Cek apakah sudah izin hari ini --}}
                @php
                    $sudahIzin = \App\Models\Permission::where('user_id', auth()->id())
                        ->where('date_permission', date('Y-m-d'))
                        ->exists();
                @endphp

                @if ($sudahIzin)
                    <div class="alert alert-warning">
                        Kamu sudah mengajukan izin hari ini.
                    </div>
                @else
                    <form method="POST" action="{{ route('rekap.izin.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="date_permission" class="form-label fw-semibold">Tanggal Izin</label>
                            <input type="date" name="date_permission" id="date_permission"
                                class="form-control border-0 border-bottom rounded-0" value="{{ date('Y-m-d') }}" readonly
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label fw-semibold">Alasan</label>
                            <textarea name="reason" id="reason" class="form-control border-0 border-bottom rounded-0" style="height: 150px"
                                rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">Upload Bukti (opsional)</label>
                            <input type="file" name="image" id="image"
                                class="form-control border-0 border-bottom rounded-0" accept="image/*"
                                onchange="previewImage(event)">
                        </div>

                        <div class="mb-3">
                            <img id="preview" src="#" alt="Preview Gambar"
                                style="display: none; max-height: 200px;" class="img-fluid rounded border p-1" />
                        </div>

                        <button type="submit" class="btn btn-warning text-white fw-bold">
                            <i class="fas fa-paper-plane me-1"></i> Ajukan Izin
                        </button>
                    </form>
                @endif
            </div>

    </div>
    </section>
    </div>
@endsection

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
