@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Pengaturan Sistem</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Library Info -->
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-6 shadow-sm card-hover animate-fadeInUp animate-delay-100">
            <h3 class="font-semibold text-linear-ink mb-4 text-xs uppercase tracking-wider">Informasi Perpustakaan</h3>
            <form id="settings-form" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Nama Perpustakaan</label>
                    <input type="text" id="library_name" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="PerpusDigital">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Alamat Perpustakaan</label>
                    <textarea id="library_address" rows="2" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="Jl. Contoh No. 123"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Telepon</label>
                        <input type="text" id="library_phone" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Email</label>
                        <input type="email" id="library_email" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Logo Perpustakaan</label>
                    <div class="flex items-center gap-4">
                        <input type="file" id="library_logo" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-linear-ink file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-linear-primary file:text-white hover:file:bg-linear-primary-hover transition cursor-pointer">
                        <div id="logo-preview" class="w-14 h-14 bg-linear-surface-2 border border-linear-hairline rounded-lg flex items-center justify-center text-linear-ink-subtle flex-shrink-0 overflow-hidden">
                            <i class="fas fa-image text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="pt-4 border-t border-linear-hairline">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- Database Backup -->
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-6 shadow-sm card-hover animate-fadeInUp animate-delay-200">
            <h3 class="font-semibold text-linear-ink mb-4 text-xs uppercase tracking-wider">Backup Database</h3>
            <p class="text-sm text-linear-ink-subtle mb-6">Buat salinan cadangan database untuk keamanan data perpustakaan.</p>
            <button onclick="backupDatabase()" class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98] flex items-center gap-2">
                <i class="fas fa-database"></i> Backup Database Sekarang
            </button>
            <div id="backup-info" class="mt-4 hidden"></div>
        </div>

        <!-- Account Info -->
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-6 shadow-sm card-hover animate-fadeInUp animate-delay-300">
            <h3 class="font-semibold text-linear-ink mb-4 text-xs uppercase tracking-wider">Informasi Akun Admin</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-linear-hairline">
                    <span class="text-sm text-linear-ink-subtle">Nama Admin</span>
                    <span class="text-sm font-semibold text-linear-ink" id="admin-name">...</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-linear-hairline">
                    <span class="text-sm text-linear-ink-subtle">Email</span>
                    <span class="text-sm font-medium text-linear-ink-muted" id="admin-email">...</span>
                </div>
                <div>
                    <p class="text-xs text-linear-ink-subtle mb-2">Untuk mengubah password, gunakan fitur di halaman Manajemen Anggota.</p>
                    <a href="{{ route('users') }}" class="text-linear-primary text-sm font-medium hover:underline">Kelola Anggota →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#admin-name').text(user.name);
        $('#admin-email').text(user.email);

        // Load settings
        $.get(`${API_URL}/settings`, function(res) {
            if (res.data) {
                if (res.data.library_name) $('#library_name').val(res.data.library_name);
                if (res.data.library_address) $('#library_address').val(res.data.library_address);
                if (res.data.library_phone) $('#library_phone').val(res.data.library_phone);
                if (res.data.library_email) $('#library_email').val(res.data.library_email);
                if (res.data.library_logo) {
                    const img = new Image();
                    img.className = 'w-full h-full object-cover rounded';
                    img.onload = function() { $('#logo-preview').empty().append(img); };
                    img.src = res.data.library_logo;
                }
            }
        });

        $('#settings-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

            const fd = new FormData();
            fd.append('library_name', $('#library_name').val());
            fd.append('library_address', $('#library_address').val());
            fd.append('library_phone', $('#library_phone').val());
            fd.append('library_email', $('#library_email').val());

            const fileInput = $('#library_logo')[0];
            if (fileInput && fileInput.files[0]) {
                fd.append('library_logo', fileInput.files[0]);
            }

            $.ajax({
                url: `${API_URL}/settings`,
                method: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function() {
                    Swal.fire({ title: 'Berhasil!', text: 'Pengaturan berhasil disimpan.', icon: 'success', timer: 1500, showConfirmButton: false, background: '#ffffff', color: '#0d253d' });
                    btn.prop('disabled', false).html('Simpan Pengaturan');
                },
                error: function() {
                    Swal.fire({ title: 'Gagal!', text: 'Terjadi kesalahan.', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    btn.prop('disabled', false).html('Simpan Pengaturan');
                }
            });
        });
    });

    function backupDatabase() {
        const btn = event.currentTarget;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

        $.ajax({
            url: `${API_URL}/settings/backup`,
            method: 'POST',
            success: function(res) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-database"></i> Backup Database Sekarang';
                $('#backup-info').removeClass('hidden').html(`
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800 text-sm">
                        <i class="fas fa-check-circle mr-1"></i> Backup berhasil dibuat!<br>
                        <span class="text-xs">${res.data.path}</span>
                    </div>
                `);
            },
            error: function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-database"></i> Backup Database Sekarang';
                Swal.fire({ title: 'Gagal!', text: 'Gagal membuat backup.', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
            }
        });
    }

    // Logo preview
    $('#library_logo').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.className = 'w-full h-full object-cover rounded';
                img.onload = function() { $('#logo-preview').empty().append(img); };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
