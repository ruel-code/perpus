@extends('layouts.app')

@section('title', 'Manajemen Denda')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Manajemen Denda</h1>
            <p class="text-sm text-slate-400 mt-0.5">Kelola denda peminjaman anggota perpustakaan</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-6 shadow-sm">
        <table id="manage-fine-table" class="w-full text-left">
            <thead>
                <tr class="text-slate-500 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-100">
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Keterlambatan</th>
                    <th class="px-4 py-3">Jumlah Denda</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Pembayaran</th>
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
    let fineTable;

    $(document).ready(function() {
        fineTable = $('#manage-fine-table').DataTable({
            ajax: { url: `${API_URL}/fines`, dataSrc: 'data' },
            columns: [
                { 
                    data: null,
                    render: function(data) {
                        const borrower = data.user;
                        const loanCode = data.loan && data.loan.loan_code;
                        if (borrower) {
                            return `
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-gradient-to-br from-linear-primary/10 to-[#7a64ff]/10 rounded-full flex items-center justify-center text-linear-primary text-xs font-bold flex-shrink-0">
                                        ${borrower.name.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">${borrower.name}</p>
                                        <p class="font-mono text-[11px] text-linear-primary font-medium">${loanCode || '-'}</p>
                                    </div>
                                </div>
                            `;
                        }
                        return '<span class="text-slate-400 text-xs">-</span>';
                    }
                },
                { 
                    data: 'loan',
                    render: function(loan) {
                        if (loan && loan.book) {
                            return `
                                <div>
                                    <p class="font-medium text-slate-700 text-sm">${loan.book.title}</p>
                                    <p class="text-[11px] text-slate-400">${loan.book.author || ''}</p>
                                </div>
                            `;
                        }
                        return '<span class="text-slate-400 text-xs">-</span>';
                    }
                },
                {
                    data: 'category',
                    render: function(cat) {
                        const map = {
                            'terlambat': { bg: 'bg-red-50', text: 'text-red-600', label: 'Terlambat' },
                            'rusak': { bg: 'bg-orange-50', text: 'text-orange-600', label: 'Kerusakan' },
                            'hilang': { bg: 'bg-rose-50', text: 'text-rose-600', label: 'Kehilangan' },
                        };
                        const s = map[cat] || { bg: 'bg-slate-50', text: 'text-slate-500', label: cat };
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${s.bg} ${s.text}">${s.label}</span>`;
                    }
                },
                {
                    data: 'days_late',
                    render: data => `<span class="text-slate-700 font-semibold">${data || 0} hari</span>`
                },
                { 
                    data: 'amount',
                    render: data => `<span class="font-bold text-red-500 text-sm">Rp ${parseInt(data).toLocaleString('id-ID')}</span>`
                },
                { 
                    data: 'payment_status',
                    render: function(status) {
                        const color = status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700';
                        const label = status === 'paid' ? 'Lunas' : 'Belum Bayar';
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${color}">${label}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        if (data.payment_status === 'paid') {
                            return `<div><p class="text-xs text-slate-700 font-medium">${data.payment_method || '-'}</p><p class="text-[11px] text-slate-400">${data.payment_date || '-'}</p></div>`;
                        }
                        return '<span class="text-slate-400 text-xs">-</span>';
                    }
                },
                { 
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        if (data.payment_status === 'unpaid' && user.role === 'admin') {
                            return `<button onclick="payFine(${data.id})" class="px-4 py-1.5 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.97]">Konfirmasi Bayar</button>`;
                        }
                        return '<span class="text-slate-300 text-xs">-</span>';
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada data denda",
                paginate: { previous: "<i class='fas fa-chevron-left'></i>", next: "<i class='fas fa-chevron-right'></i>" }
            },
            responsive: true,
            order: [[4, 'desc']]
        });
    });

    function payFine(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            html: `
                <div class="text-left space-y-3">
                    <p class="text-sm text-slate-500 mb-3">Pilih metode pembayaran denda yang digunakan:</p>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Metode Pembayaran</label>
                    <select id="swal-payment-method" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none focus:border-[#533afd] focus:ring-1 focus:ring-[#533afd] text-slate-800 transition">
                        <option value="Cash">Cash (Tunai)</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="E-Wallet">E-Wallet (GoPay/OVO/Dana)</option>
                    </select>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi Bayar',
            cancelButtonText: 'Batal',
            preConfirm: () => $('#swal-payment-method').val(),
            background: '#ffffff',
            color: '#0d253d',
            confirmButtonColor: '#533afd',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/fines/${id}/status`,
                    method: 'PUT',
                    data: { 
                        payment_status: 'paid',
                        payment_method: result.value
                    },
                    success: function() {
                        Swal.fire({ title: 'Berhasil!', text: 'Pembayaran denda telah dikonfirmasi.', icon: 'success', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                        fineTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ title: 'Gagal!', text: xhr.responseJSON?.message || 'Terjadi kesalahan', icon: 'error', background: '#ffffff', color: '#0d253d', confirmButtonColor: '#533afd' });
                    }
                });
            }
        });
    }
</script>
@endpush