@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Manajemen Anggota</h1>
        <button onclick="openUserModal()" class="bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg active:scale-[0.98]">
            <i class="fas fa-user-plus"></i> Tambah Anggota
        </button>
    </div>

    <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm card-hover">
        <table id="manage-user-table" class="w-full text-left">
            <thead>
                <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                    <th class="px-4 py-3">Anggota</th>
                    <th class="px-4 py-3">NIM</th>
                    <th class="px-4 py-3">Program Studi</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- User Modal -->
<div id="user-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('user-modal')">
    <div class="bg-linear-surface-1 border border-linear-hairline rounded-xl w-full max-w-lg overflow-hidden shadow-[rgba(0,55,112,0.12)_0_16px_48px] animate-scaleIn max-h-[90vh] overflow-y-auto">
        <div class="bg-linear-surface-2 px-6 py-4 text-linear-ink flex justify-between items-center border-b border-linear-hairline sticky top-0 bg-linear-surface-2 z-10">
            <h3 class="font-bold tracking-tight text-sm uppercase" id="user-modal-title">Tambah Anggota</h3>
            <button onclick="closeModal('user-modal')" class="w-8 h-8 flex items-center justify-center text-linear-ink-subtle hover:text-linear-ink hover:bg-linear-surface-3 rounded-lg transition duration-150"><i class="fas fa-times"></i></button>
        </div>
        <form id="user-form" class="p-6 space-y-4">
            <input type="hidden" id="user-id">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" id="name" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">NIM</label>
                    <input type="text" id="nim" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Email</label>
                <input type="email" id="email" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div id="password-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Password</label>
                    <input type="password" id="password" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">No. WhatsApp</label>
                    <input type="text" id="phone_number" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Program Studi</label>
                    <input type="text" id="study_program" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Role</label>
                <select id="role" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                    <option value="user">User (Mahasiswa)</option>
                    <option value="admin">Admin (Petugas)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Alamat</label>
                <textarea id="address" rows="2" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-3 mt-2 border-t border-linear-hairline pt-4">
                <button type="button" onclick="closeModal('user-modal')" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-sm font-semibold transition duration-150">Batal</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="reset-password-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('reset-password-modal')">
    <div class="bg-linear-surface-1 border border-linear-hairline rounded-xl w-full max-w-md overflow-hidden shadow-[rgba(0,55,112,0.12)_0_16px_48px] animate-scaleIn">
        <div class="bg-linear-surface-2 px-6 py-4 text-linear-ink flex justify-between items-center border-b border-linear-hairline">
            <h3 class="font-bold tracking-tight text-sm uppercase">Reset Password</h3>
            <button onclick="closeModal('reset-password-modal')" class="w-8 h-8 flex items-center justify-center text-linear-ink-subtle hover:text-linear-ink hover:bg-linear-surface-3 rounded-lg transition duration-150"><i class="fas fa-times"></i></button>
        </div>
        <form id="reset-password-form" class="p-6 space-y-4">
            <input type="hidden" id="reset-user-id">
            <p class="text-sm text-linear-ink-subtle" id="reset-user-name">Reset password untuk pengguna</p>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Password Baru</label>
                <input type="password" id="reset-password" required minlength="8" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Konfirmasi Password Baru</label>
                <input type="password" id="reset-password-confirmation" required minlength="8" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div class="flex justify-end gap-3 border-t border-linear-hairline pt-4">
                <button type="button" onclick="closeModal('reset-password-modal')" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-sm font-semibold transition duration-150">Batal</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let userTable;

    $(document).ready(function() {
        userTable = $('#manage-user-table').DataTable({
            ajax: { url: `${API_URL}/users`, dataSrc: 'data' },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        const phone = data.phone_number ? `<p class="text-xs text-linear-ink-subtle mt-0.5"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>${data.phone_number}</p>` : '';
                        return `
                            <div>
                                <p class="font-bold text-linear-ink text-sm">${data.name}</p>
                                <p class="text-xs text-linear-ink-subtle">${data.email}</p>
                                ${phone}
                            </div>
                        `;
                    }
                },
                { data: 'nim', defaultContent: '-', className: 'font-mono text-xs font-medium' },
                { data: 'study_program', defaultContent: '-', className: 'text-sm' },
                {
                    data: 'role',
                    render: function(role) {
                        const color = role === 'admin' ? 'bg-linear-primary/10 text-linear-primary border border-linear-primary/20' : 'bg-slate-50 text-slate-700 border border-slate-200';
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider ${color}">${role}</span>`;
                    }
                },
                {
                    data: 'is_active',
                    render: function(active) {
                        if (active) return '<span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">Aktif</span>';
                        return '<span class="px-2.5 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-semibold">Nonaktif</span>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        const activeIcon = data.is_active ? 'fa-ban' : 'fa-check';
                        const activeColor = data.is_active ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-emerald-50 text-emerald-600 border border-emerald-200';
                        const activeTitle = data.is_active ? 'Nonaktifkan' : 'Aktifkan';
                        return `
                            <div class="flex gap-1.5 justify-center table-actions flex-wrap">
                                <button onclick='openUserModal(${JSON.stringify(data)})' class="p-2 bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100 rounded-lg transition duration-150" title="Edit"><i class="fas fa-edit"></i></button>
                                <button onclick="resetPasswordModal(${data.id}, '${data.name.replace(/'/g, "\\'")}')" class="p-2 bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 rounded-lg transition duration-150" title="Reset Password"><i class="fas fa-key"></i></button>
                                <button onclick="toggleActive(${data.id})" class="p-2 ${activeColor} hover:opacity-80 rounded-lg transition duration-150" title="${activeTitle}"><i class="fas ${activeIcon}"></i></button>
                                <button onclick="deleteUser(${data.id})" class="p-2 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 rounded-lg transition duration-150" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada data anggota"
            },
            responsive: true
        });

        $('#user-form').submit(function(e) {
            e.preventDefault();
            const id = $('#user-id').val();
            const url = id ? `${API_URL}/users/${id}` : `${API_URL}/users`;
            const method = id ? 'PUT' : 'POST';
            const data = {
                name: $('#name').val(),
                email: $('#email').val(),
                nim: $('#nim').val(),
                phone_number: $('#phone_number').val(),
                study_program: $('#study_program').val(),
                address: $('#address').val(),
                role: $('#role').val(),
            };
            if (!id) {
                data.password = $('#password').val();
                data.password_confirmation = $('#password_confirmation').val();
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function() {
                    closeModal('user-modal');
                    Swal.fire({ title: 'Berhasil!', text: 'Data anggota berhasil disimpan.', icon: 'success', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    userTable.ajax.reload();
                },
                error: function(xhr) {
                    let msg = 'Terjadi kesalahan';
                    if (xhr.responseJSON?.errors) msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    else if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                    Swal.fire({ title: 'Gagal!', html: msg, icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                }
            });
        });

        $('#reset-password-form').submit(function(e) {
            e.preventDefault();
            const id = $('#reset-user-id').val();
            const pw = $('#reset-password').val();
            const pw2 = $('#reset-password-confirmation').val();

            if (pw !== pw2) {
                Swal.fire({ title: 'Error', text: 'Password tidak cocok!', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                return;
            }

            $.ajax({
                url: `${API_URL}/users/${id}/reset-password`,
                method: 'PUT',
                data: { password: pw, password_confirmation: pw2 },
                success: function() {
                    closeModal('reset-password-modal');
                    Swal.fire({ title: 'Berhasil!', text: 'Password berhasil direset.', icon: 'success', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                },
                error: function(xhr) {
                    Swal.fire({ title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                }
            });
        });
    });

    function openUserModal(user = null) {
        $('#user-form')[0].reset();
        $('#user-id').val('');

        if (user) {
            $('#user-modal-title').text('Edit Anggota');
            $('#user-id').val(user.id);
            $('#name').val(user.name);
            $('#email').val(user.email);
            $('#nim').val(user.nim);
            $('#phone_number').val(user.phone_number);
            $('#study_program').val(user.study_program);
            $('#address').val(user.address);
            $('#role').val(user.role);
            $('#password-fields').hide();
        } else {
            $('#user-modal-title').text('Tambah Anggota');
            $('#password-fields').show();
            $('#role').val('user');
        }
        $('#user-modal').removeClass('hidden');
    }

    function resetPasswordModal(id, name) {
        $('#reset-user-id').val(id);
        $('#reset-user-name').text('Reset password untuk: ' + name);
        $('#reset-password').val('');
        $('#reset-password-confirmation').val('');
        $('#reset-password-modal').removeClass('hidden');
    }

    function toggleActive(id) {
        $.ajax({
            url: `${API_URL}/users/${id}/toggle-active`,
            method: 'PUT',
            success: function() {
                userTable.ajax.reload();
                Swal.fire({ title: 'Berhasil!', text: 'Status anggota diperbarui.', icon: 'success', timer: 1500, showConfirmButton: false, background: '#ffffff', color: '#0d253d' });
            }
        });
    }

    function deleteUser(id) {
        Swal.fire({
            title: 'Hapus Anggota?',
            text: 'Anggota akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#0d253d',
            confirmButtonColor: '#533afd',
            cancelButtonColor: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/users/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire({ title: 'Terhapus!', text: 'Anggota telah dihapus.', icon: 'success', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                        userTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ title: 'Gagal!', text: xhr.responseJSON?.message || 'Anggota memiliki peminjaman aktif', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    }
                });
            }
        });
    }

    function closeModal(id) {
        $(`#${id}`).addClass('hidden');
    }
</script>
@endpush
