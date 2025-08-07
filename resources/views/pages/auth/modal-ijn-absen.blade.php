    <div class="modal fade" id="absenModal" tabindex="-1" role="dialog" aria-labelledby="absenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('absen') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Absensi Manual</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">Nama User</label>
                            <select class="form-control" name="user_id" id="user_id" required>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" data-sekolah="{{ $u->sekolah->nama ?? '' }}"
                                        data-jurusan="{{ $u->jurusan->nama ?? '' }}">
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="school_name">Sekolah</label>
                            <input type="text" class="form-control" name="school_name" id="school_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" id="jurusan" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ now()->toDateString() }}" required>
                        </div>
                        <div class="form-group">
                            <label for="time_in">Jam Masuk</label>
                            <input type="time" class="form-control" name="time_in" id="time_in"
                                value="{{ now()->format('H:i') }}" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="time_out">Jam Keluar</label>
                            <input type="time" class="form-control" name="time_out" id="time_out">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="izinModal" tabindex="-1" role="dialog" aria-labelledby="izinModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('permissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Izin</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{-- Nama User --}}
                        <div class="form-group">
                            <label for="user_id_izin">Nama User</label>
                            <select class="form-control" name="user_id" id="user_id_izin" required>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" data-sekolah="{{ $u->sekolah->nama ?? '' }}"
                                        data-jurusan="{{ $u->jurusan->nama ?? '' }}">
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sekolah --}}
                        <div class="form-group">
                            <label for="school_name_izin">Sekolah</label>
                            <input type="text" class="form-control" name="school_name" id="school_name_izin"
                                readonly>
                        </div>

                        {{-- Jurusan --}}
                        <div class="form-group">
                            <label for="jurusan_izin">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" id="jurusan_izin" readonly>
                        </div>

                        {{-- Tanggal Izin --}}
                        <div class="form-group">
                            <label for="date_permission">Tanggal</label>
                            <input type="date" class="form-control" name="date_permission" id="date_permission"
                                value="{{ now()->toDateString() }}" required>
                        </div>

                        {{-- Alasan --}}
                        <div class="form-group">
                            <label for="reason">Alasan</label>
                            <textarea name="reason" id="reason" class="form-control" rows="3" style="height: 100px;" required></textarea>
                        </div>

                        {{-- Upload Gambar (optional) --}}
                        <div class="form-group">
                            <label for="image">Upload Bukti (Opsional)</label>
                            <input type="file" class="form-control" name="image" id="image"
                                accept="image/*">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kirim Izin</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- script modal absen --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const sekolahInput = document.getElementById('school_name');
            const jurusanInput = document.getElementById('jurusan');

            userSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const sekolah = selectedOption.getAttribute('data-sekolah');
                const jurusan = selectedOption.getAttribute('data-jurusan');

                sekolahInput.value = sekolah || '';
                jurusanInput.value = jurusan || '';
            });

            // Trigger change event on modal open to autofill first user
            $('#absenModal').on('show.bs.modal', function() {
                const now = new Date();
                document.getElementById('date').value = now.toISOString().substring(0, 10);
                document.getElementById('time_in').value = now.toTimeString().substring(0, 5);

                // Trigger change to fill sekolah & jurusan
                userSelect.dispatchEvent(new Event('change'));
            });
        });
    </script>

    {{-- script modal ijin --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelectIzin = document.getElementById('user_id_izin');
            const sekolahInputIzin = document.getElementById('school_name_izin');
            const jurusanInputIzin = document.getElementById('jurusan_izin');

            userSelectIzin.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const sekolah = selectedOption.getAttribute('data-sekolah');
                const jurusan = selectedOption.getAttribute('data-jurusan');

                sekolahInputIzin.value = sekolah || '';
                jurusanInputIzin.value = jurusan || '';
            });

            // Auto trigger saat modal dibuka
            $('#izinModal').on('show.bs.modal', function() {
                document.getElementById('date_permission').value = new Date().toISOString().substring(0,
                    10);
                userSelectIzin.dispatchEvent(new Event('change'));
            });
        });
    </script>
