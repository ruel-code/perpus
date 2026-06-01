@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fadeIn">
    <!-- Profile Header -->
    <div class="bg-gradient-to-br from-linear-primary via-[#7a64ff] to-[#ea2261] rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-5 -left-5 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="relative">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-4 border-white/30 overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center" id="profile-photo-container">
                    <span class="text-3xl font-bold text-white" id="profile-photo-text">U</span>
                    <img id="profile-photo-img" class="w-full h-full object-cover hidden" src="" alt="">
                </div>
                <label for="photo-upload" class="absolute -bottom-1 -right-1 w-8 h-8 bg-white text-linear-primary rounded-full flex items-center justify-center shadow-md cursor-pointer hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-camera text-sm"></i>
                    <input type="file" id="photo-upload" accept="image/jpeg,image/png,image/jpg" class="hidden">
                </label>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-2xl font-bold tracking-tight" id="profile-name">Loading...</h1>
                <p class="text-white/70 text-sm mt-1" id="profile-role">-</p>
                <p class="text-white/50 text-xs mt-0.5" id="profile-email">-</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Cards -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Biodata Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-id-card text-linear-primary"></i>
                        Biodata
                    </h3>
                    <button id="btn-edit-biodata" class="text-xs text-linear-primary hover:text-linear-primary-hover font-semibold flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-linear-primary/5 transition">
                        <i class="fas fa-pen"></i> Edit
                    </button>
                </div>
                <div id="biodata-view" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Nama Lengkap</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-name">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Email</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-email">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">NIM</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-nim">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">No. Telepon</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-phone">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Program Studi</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-study">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Role</p>
                        <p class="text-sm font-medium text-slate-800 mt-1 capitalize" id="pv-role">-</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Alamat</p>
                        <p class="text-sm font-medium text-slate-800 mt-1" id="pv-address">-</p>
                    </div>
                </div>
                <!-- Edit Form -->
                <form id="biodata-form" class="hidden space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Nama Lengkap</label>
                            <input type="text" id="pf-name" required class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Email</label>
                            <input type="email" id="pf-email" required class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">NIM</label>
                            <input type="text" id="pf-nim" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">No. Telepon</label>
                            <input type="text" id="pf-phone" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Program Studi</label>
                            <input type="text" id="pf-study" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Role</label>
                            <input type="text" id="pf-role" disabled class="block w-full px-3.5 py-2.5 bg-slate-50 text-slate-400 border border-slate-200 rounded-lg text-sm capitalize cursor-not-allowed">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Alamat</label>
                            <textarea id="pf-address" rows="2" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm resize-none"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-linear-primary to-[#7a64ff] text-white rounded-full text-sm font-semibold shadow-sm hover:shadow-md active:scale-[0.97] transition-all duration-200">
                            Simpan Perubahan
                        </button>
                        <button type="button" id="btn-cancel-biodata" class="px-5 py-2.5 bg-white text-slate-600 border border-slate-200 rounded-full text-sm font-semibold hover:bg-slate-50 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-5">
                    <i class="fas fa-lock text-linear-primary"></i>
                    Ubah Kata Sandi
                </h3>
                <form id="password-form" class="space-y-4 max-w-md">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input type="password" id="cp-current" required class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm pr-10">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-pw" data-target="cp-current">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="cp-new" required minlength="8" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm pr-10">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-pw" data-target="cp-new">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Minimal 8 karakter</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="cp-confirm" required minlength="8" class="block w-full px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm pr-10">
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-pw" data-target="cp-confirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-linear-primary to-[#7a64ff] text-white rounded-full text-sm font-semibold shadow-sm hover:shadow-md active:scale-[0.97] transition-all duration-200">
                        Ubah Kata Sandi
                    </button>
                </form>
            </div>
        </div>

        <!-- Activity Summary -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-simple text-linear-primary"></i>
                    Ringkasan Aktivitas
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 text-xs">
                                <i class="fas fa-book"></i>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500">Total Dipinjam</p>
                                <p class="text-lg font-bold text-slate-800" id="stats-loaned">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 text-xs">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500">Dikembalikan</p>
                                <p class="text-lg font-bold text-slate-800" id="stats-returned">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 text-xs">
                                <i class="fas fa-clock"></i>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500">Aktif / Menunggu</p>
                                <p class="text-lg font-bold text-slate-800" id="stats-active">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center text-red-500 text-xs">
                                <i class="fas fa-exclamation"></i>
                            </span>
                            <div>
                                <p class="text-xs text-slate-500">Denda Belum Bayar</p>
                                <p class="text-lg font-bold text-red-500" id="stats-fines">Rp 0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-link text-linear-primary"></i>
                    Tautan Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 group">
                        <span class="w-8 h-8 bg-linear-primary/10 rounded-lg flex items-center justify-center text-linear-primary text-xs group-hover:scale-110 transition-transform"><i class="fas fa-search"></i></span>
                        Cari Buku
                    </a>
                    <a href="{{ route('my-loans') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 group">
                        <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 text-xs group-hover:scale-110 transition-transform"><i class="fas fa-history"></i></span>
                        Riwayat Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let profileData = {};

        function loadProfile() {
            $.get(`${API_URL}/profile`, function(res) {
                profileData = res.data;
                renderProfile(profileData);
            });
        }

        function renderProfile(d) {
            $('#profile-name').text(d.name);
            $('#profile-role').text(d.role.charAt(0).toUpperCase() + d.role.slice(1));
            $('#profile-email').text(d.email);
            $('#profile-photo-text').text(d.name.charAt(0));

            if (d.photo) {
                const photoUrl = `/storage/${d.photo}`;
                $('#profile-photo-img').attr('src', photoUrl).removeClass('hidden');
                $('#profile-photo-text').addClass('hidden');
            } else {
                $('#profile-photo-img').addClass('hidden');
                $('#profile-photo-text').removeClass('hidden');
            }

            // Biodata view
            $('#pv-name').text(d.name);
            $('#pv-email').text(d.email);
            $('#pv-nim').text(d.nim || '-');
            $('#pv-phone').text(d.phone_number || '-');
            $('#pv-study').text(d.study_program || '-');
            $('#pv-role').text(d.role);
            $('#pv-address').text(d.address || '-');

            // Edit form
            $('#pf-name').val(d.name);
            $('#pf-email').val(d.email);
            $('#pf-nim').val(d.nim || '');
            $('#pf-phone').val(d.phone_number || '');
            $('#pf-study').val(d.study_program || '');
            $('#pf-role').val(d.role);
            $('#pf-address').val(d.address || '');

            // Stats
            const loans = d.loans || [];
            $('#stats-loaned').text(loans.length);
            $('#stats-returned').text(loans.filter(l => l.status === 'dikembalikan').length);
            $('#stats-active').text(loans.filter(l => l.status === 'dipinjam' || l.status === 'menunggu' || l.status === 'terlambat').length);
            const fines = d.fines || [];
            const unpaid = fines.filter(f => f.payment_status === 'unpaid').reduce((sum, f) => sum + parseInt(f.amount), 0);
            $('#stats-fines').text('Rp ' + unpaid.toLocaleString('id-ID'));
        }

        loadProfile();

        // Toggle biodata edit
        $('#btn-edit-biodata').click(function() {
            $('#biodata-view').addClass('hidden');
            $('#biodata-form').removeClass('hidden');
            $(this).addClass('hidden');
        });

        $('#btn-cancel-biodata').click(function() {
            $('#biodata-view').removeClass('hidden');
            $('#biodata-form').addClass('hidden');
            $('#btn-edit-biodata').removeClass('hidden');
            renderProfile(profileData);
        });

        // Save biodata
        $('#biodata-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

            $.ajax({
                url: `${API_URL}/profile`,
                method: 'PUT',
                data: {
                    name: $('#pf-name').val(),
                    email: $('#pf-email').val(),
                    nim: $('#pf-nim').val(),
                    phone_number: $('#pf-phone').val(),
                    study_program: $('#pf-study').val(),
                    address: $('#pf-address').val(),
                },
                success: function(res) {
                    profileData = res.data;
                    const u = JSON.parse(localStorage.getItem('user'));
                    u.name = res.data.name;
                    u.email = res.data.email;
                    localStorage.setItem('user', JSON.stringify(u));
                    $('#user-name').text(res.data.name);
                    $('#user-initial-text').text(res.data.name.charAt(0));

                    renderProfile(profileData);
                    $('#biodata-view').removeClass('hidden');
                    $('#biodata-form').addClass('hidden');
                    $('#btn-edit-biodata').removeClass('hidden');
                    btn.prop('disabled', false).html('Simpan Perubahan');
                    Swal.fire({ title: 'Berhasil!', text: 'Profil berhasil diperbarui', icon: 'success', confirmButtonColor: '#533afd' });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Simpan Perubahan');
                    const msg = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    const errors = xhr.responseJSON?.errors;
                    let detail = msg;
                    if (errors) {
                        detail = Object.values(errors).flat().join('<br>');
                    }
                    Swal.fire({ title: 'Gagal!', html: detail, icon: 'error', confirmButtonColor: '#533afd' });
                }
            });
        });

        // Change password
        $('#password-form').submit(function(e) {
            e.preventDefault();
            const pw = $('#cp-new').val();
            const confirm = $('#cp-confirm').val();
            if (pw !== confirm) {
                Swal.fire({ title: 'Error', text: 'Konfirmasi kata sandi tidak cocok', icon: 'error', confirmButtonColor: '#533afd' });
                return;
            }
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

            $.ajax({
                url: `${API_URL}/profile/password`,
                method: 'PUT',
                data: {
                    current_password: $('#cp-current').val(),
                    password: pw,
                    password_confirmation: confirm,
                },
                success: function() {
                    $('#password-form')[0].reset();
                    btn.prop('disabled', false).html('Ubah Kata Sandi');
                    Swal.fire({ title: 'Berhasil!', text: 'Kata sandi berhasil diubah', icon: 'success', confirmButtonColor: '#533afd' });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Ubah Kata Sandi');
                    const msg = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    Swal.fire({ title: 'Gagal!', html: msg, icon: 'error', confirmButtonColor: '#533afd' });
                }
            });
        });

        // Photo upload
        $('#photo-upload').change(function() {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('photo', file);

            $.ajax({
                url: `${API_URL}/profile/photo`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    const photoUrl = `/storage/${res.data.photo}`;
                    $('#profile-photo-img').attr('src', photoUrl).removeClass('hidden');
                    $('#profile-photo-text').addClass('hidden');
                    $('#user-avatar-img').attr('src', photoUrl).removeClass('hidden');
                    $('#user-initial').addClass('hidden');
                    profileData.photo = res.data.photo;
                    const u = JSON.parse(localStorage.getItem('user'));
                    u.photo = res.data.photo;
                    localStorage.setItem('user', JSON.stringify(u));
                    Swal.fire({ title: 'Berhasil!', text: 'Foto profil berhasil diubah', icon: 'success', confirmButtonColor: '#533afd' });
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Gagal mengupload foto';
                    Swal.fire({ title: 'Gagal!', text: msg, icon: 'error', confirmButtonColor: '#533afd' });
                }
            });
        });

        // Toggle password visibility
        $('.toggle-pw').click(function() {
            const target = $(this).data('target');
            const input = $('#' + target);
            const icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
@endpush