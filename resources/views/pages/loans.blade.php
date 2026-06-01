@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Manajemen Peminjaman</h1>
        <select id="filter-status" class="px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            <option value="">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="dikembalikan">Dikembalikan</option>
            <option value="terlambat">Terlambat</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>

    <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm card-hover">
        <table id="manage-loan-table" class="w-full text-left">
            <thead>
                <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                    <th class="px-4 py-3">Kode / Peminjam</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Tgl Pinjam / Batas</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let loanTable;

    $(document).ready(function() {
        loanTable = $('#manage-loan-table').DataTable({
            ajax: { 
                url: `${API_URL}/loans`, 
                data: function(d) { d.status = $('#filter-status').val(); },
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: null,
                    render: function(data) {
                        const studyProgram = data.user.study_program ? ` • ${data.user.study_program}` : '';
                        const phone = data.user.phone_number ? `<p class="text-xs text-linear-ink-subtle mt-1"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>${data.user.phone_number}</p>` : '';
                        return `
                            <div>
                                <p class="font-mono text-xs font-semibold text-linear-primary mb-0.5">${data.loan_code}</p>
                                <p class="font-bold text-linear-ink text-sm">${data.user.name}</p>
                                <p class="text-xs text-linear-ink-subtle mt-0.5">${data.user.nim || '-'}${studyProgram}</p>
                                ${phone}
                            </div>
                        `;
                    }
                },
                { 
                    data: null,
                    render: function(data) {
                        const author = data.book.author ? `<p class="text-xs text-linear-ink-subtle mt-0.5">Penulis: ${data.book.author}</p>` : '';
                        const processedBy = data.processed_by_user ? `<p class="text-[11px] text-linear-ink-subtle mt-1"><i class="fas fa-user-shield mr-1"></i>Petugas: ${data.processed_by_user.name}</p>` : '';
                        const notes = data.condition_notes ? `<p class="text-[11px] text-amber-600 mt-1 italic"><i class="fas fa-comment-alt mr-1"></i>Catatan: ${data.condition_notes}</p>` : '';
                        return `
                            <div class="min-w-0">
                                <p class="font-medium text-linear-ink-muted text-sm">${data.book.title}</p>
                                ${author}
                                <p class="text-xs text-linear-ink-subtle mt-0.5">Rak: ${data.book.shelf_location || '-'}</p>
                                ${processedBy}${notes}
                            </div>
                        `;
                    }
                },
                { 
                    data: null,
                    render: data => `
                        <div>
                            <p class="text-sm text-linear-ink-muted font-medium">${data.loan_date || '-'}</p>
                            <p class="text-xs text-red-600 mt-1 font-semibold">Batas: ${data.return_date || '-'}</p>
                        </div>
                    `
                },
                { 
                    data: 'status',
                    render: function(status) {
                        let color = 'bg-blue-50 text-blue-700 border border-blue-200';
                        if (status === 'dikembalikan') color = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                        if (status === 'terlambat') color = 'bg-red-50 text-red-700 border border-red-200';
                        if (status === 'menunggu') color = 'bg-amber-50 text-amber-700 border border-amber-200';
                        if (status === 'ditolak') color = 'bg-slate-50 text-slate-700 border border-slate-200';
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider ${color}">${status}</span>`;
                    }
                },
                { 
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        if (data.status === 'menunggu') {
                            return `
                                <div class="flex gap-1.5 justify-center">
                                    <button onclick="approveLoan(${data.id})" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 rounded-full text-xs font-semibold transition-all duration-150 active:scale-[0.97]" title="Setujui"><i class="fas fa-check"></i></button>
                                    <button onclick="rejectLoan(${data.id})" class="px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 rounded-full text-xs font-semibold transition-all duration-150 active:scale-[0.97]" title="Tolak"><i class="fas fa-times"></i></button>
                                </div>
                            `;
                        }
                        if (data.status === 'dipinjam') {
                            return `<button onclick="returnBook(${data.id})" class="px-4 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 rounded-full text-xs font-semibold transition-all duration-150 active:scale-[0.97]">Kembalikan</button>`;
                        }
                        return '<span class="text-linear-ink-tertiary text-xs">-</span>';
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada data peminjaman"
            },
            responsive: true
        });

        $('#filter-status').change(function() {
            loanTable.ajax.reload();
        });
    });

    function approveLoan(id) {
        Swal.fire({
            title: 'Setujui Peminjaman?',
            text: 'Buku akan segera dipinjamkan ke anggota.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal',
            background: '#ffffff',
            color: '#0d253d',
            confirmButtonColor: '#533afd',
            cancelButtonColor: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/loans/${id}/approve`,
                    method: 'PUT',
                    success: function() {
                        Swal.fire({ title: 'Disetujui!', text: 'Peminjaman telah disetujui.', icon: 'success', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                        loanTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    }
                });
            }
        });
    }

    function rejectLoan(id) {
        Swal.fire({
            title: 'Tolak Peminjaman?',
            text: 'Peminjaman akan ditolak dan stok buku dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#ffffff',
            background: '#ffffff',
            color: '#0d253d'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/loans/${id}/reject`,
                    method: 'PUT',
                    success: function() {
                        Swal.fire({ title: 'Ditolak!', text: 'Peminjaman telah ditolak.', icon: 'info', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                        loanTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    }
                });
            }
        });
    }

    function returnBook(id) {
        Swal.fire({
            title: 'Proses Pengembalian',
            html: `
                <div class="text-left space-y-3">
                    <p class="text-sm text-slate-500 mb-3">Pilih kondisi buku saat dikembalikan:</p>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2.5 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="swal-condition" value="baik" checked class="accent-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-slate-800">Baik</p>
                                <p class="text-xs text-slate-400">Tidak ada denda tambahan</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50">
                            <input type="radio" name="swal-condition" value="rusak" class="accent-orange-500">
                            <div>
                                <p class="text-sm font-medium text-slate-800">Rusak</p>
                                <p class="text-xs text-slate-400">Denda 50% dari harga buku</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-red-400 has-[:checked]:bg-red-50">
                            <input type="radio" name="swal-condition" value="hilang" class="accent-red-500">
                            <div>
                                <p class="text-sm font-medium text-slate-800">Hilang</p>
                                <p class="text-xs text-slate-400">Denda 100% dari harga buku</p>
                            </div>
                        </label>
                    </div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mt-2">Catatan (opsional)</label>
                    <textarea id="swal-return-notes" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none focus:border-[#533afd] focus:ring-1 focus:ring-[#533afd] text-slate-800 transition" placeholder="Contoh: Sampul sedikit robek."></textarea>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                return {
                    condition: document.querySelector('input[name="swal-condition"]:checked')?.value || 'baik',
                    notes: $('#swal-return-notes').val()
                };
            },
            background: '#ffffff',
            color: '#0d253d',
            confirmButtonColor: '#533afd',
            cancelButtonColor: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                const data = result.value;
                $.ajax({
                    url: `${API_URL}/loans/${id}/return`,
                    method: 'PUT',
                    data: { 
                        status: 'dikembalikan',
                        condition: data.condition,
                        condition_notes: data.notes
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Buku telah dikembalikan.',
                            icon: 'success',
                            background: '#ffffff',
                            color: '#0d253d',
                            confirmButtonColor: '#533afd'
                        });
                        loanTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan',
                            icon: 'error',
                            background: '#ffffff',
                            color: '#0d253d',
                            confirmButtonColor: '#533afd'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush