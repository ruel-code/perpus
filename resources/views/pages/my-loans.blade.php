@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Riwayat Peminjaman</h1>
            <p class="text-sm text-slate-400 mt-0.5">Daftar peminjaman dan pengembalian buku anda</p>
        </div>
        <a href="{{ route('catalog') }}" class="px-4 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] text-white rounded-full text-xs font-semibold shadow-sm hover:shadow-md active:scale-[0.97] transition-all duration-200 flex items-center gap-1.5">
            <i class="fas fa-plus"></i> Pinjam Buku
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-6 shadow-sm">
        <table id="my-loan-table" class="w-full text-left">
            <thead>
                <tr class="text-slate-500 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-100">
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Tgl Pinjam</th>
                    <th class="px-4 py-3">Batas Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const table = $('#my-loan-table').DataTable({
            ajax: { 
                url: `${API_URL}/loans`, 
                dataSrc: function(json) {
                    return json.data.filter(l => l.user.id === user.id);
                }
            },
            columns: [
                { 
                    data: 'loan_code',
                    className: 'font-mono text-xs font-semibold text-linear-primary',
                    render: d => `<span class="bg-linear-primary/5 px-2 py-0.5 rounded text-[11px]">${d}</span>`
                },
                { 
                    data: null,
                    render: function(data) {
                        const cover = data.book.cover_image 
                            ? `<img src="${data.book.cover_image}" class="w-8 h-10 object-cover rounded" onerror="this.onerror=null;this.outerHTML='<div class=\\'w-8 h-10 bg-slate-100 rounded flex items-center justify-center text-slate-400\\'><i class=\\'fas fa-book text-xs\\'></i></div>'">`
                            : `<div class="w-8 h-10 bg-slate-100 rounded flex items-center justify-center text-slate-400"><i class="fas fa-book text-xs"></i></div>`;
                        const staff = data.processed_by_user ? `<span class="text-[11px] text-slate-400 block mt-0.5"><i class="fas fa-user-shield mr-1"></i>${data.processed_by_user.name}</span>` : '';
                        const notes = data.condition_notes ? `<span class="text-[11px] text-amber-600 block mt-0.5 italic">${data.condition_notes}</span>` : '';
                        return `<div class="flex items-center gap-3">
                            ${cover}
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 text-sm leading-tight">${data.book.title}</p>
                                <p class="text-xs text-slate-400">${data.book.author}</p>
                                ${staff}${notes}
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: 'loan_date', 
                    className: 'text-sm text-slate-500',
                    render: d => d || '-'
                },
                { 
                    data: 'return_date', 
                    className: 'text-sm text-slate-500',
                    render: function(d, type, row) {
                        if (!d) return '-';
                        const isLate = row.status === 'terlambat';
                        return `<span class="${isLate ? 'text-red-500 font-medium' : ''}">${d}</span>`;
                    }
                },
                { 
                    data: 'status',
                    render: function(status) {
                        const map = {
                            'dipinjam': { bg: 'bg-blue-50', text: 'text-blue-700', label: 'Dipinjam' },
                            'dikembalikan': { bg: 'bg-emerald-50', text: 'text-emerald-700', label: 'Dikembalikan' },
                            'terlambat': { bg: 'bg-red-50', text: 'text-red-700', label: 'Terlambat' },
                            'menunggu': { bg: 'bg-amber-50', text: 'text-amber-700', label: 'Menunggu' },
                            'ditolak': { bg: 'bg-slate-50', text: 'text-slate-500', label: 'Ditolak' },
                        };
                        const s = map[status] || { bg: 'bg-slate-50', text: 'text-slate-500', label: status };
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${s.bg} ${s.text}">${s.label}</span>`;
                    }
                },
                { 
                    data: 'fine',
                    render: function(fine) {
                        if (!fine) return '<span class="text-slate-400 text-xs">-</span>';
                        const statusColor = fine.payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600';
                        const statusText = fine.payment_status === 'paid' ? 'Lunas' : 'Belum Bayar';
                        return `<div>
                            <p class="text-red-500 font-semibold text-sm">Rp ${parseInt(fine.amount).toLocaleString('id-ID')}</p>
                            <p class="text-[11px] ${statusColor}">${statusText}</p>
                        </div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        if (data.status === 'menunggu') {
                            return `<button onclick="cancelLoan(${data.id})" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded-lg text-xs font-semibold transition">
                                <i class="fas fa-times mr-1"></i>Batalkan
                            </button>`;
                        }
                        return '<span class="text-slate-300 text-xs">-</span>';
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada riwayat peminjaman",
                paginate: { previous: "<i class='fas fa-chevron-left'></i>", next: "<i class='fas fa-chevron-right'></i>" }
            },
            responsive: true,
            order: [[0, 'desc']]
        });

        window.cancelLoan = function(loanId) {
            Swal.fire({
                title: 'Batalkan Peminjaman?',
                text: 'Peminjaman yang dibatalkan tidak dapat dipulihkan kembali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tutup',
                background: '#ffffff',
                color: '#0d253d',
                buttonsStyling: true,
                customClass: { confirmButton: 'swal2-confirm', cancelButton: 'swal2-cancel' }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${API_URL}/loans/${loanId}/cancel`,
                        method: 'PUT',
                        success: function() {
                            Swal.fire({
                                title: 'Berhasil!', text: 'Peminjaman berhasil dibatalkan', icon: 'success',
                                confirmButtonColor: '#533afd', background: '#ffffff', color: '#0d253d'
                            });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', icon: 'error',
                                confirmButtonColor: '#533afd', background: '#ffffff', color: '#0d253d'
                            });
                        }
                    });
                }
            });
        };
    });
</script>
@endpush