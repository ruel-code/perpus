@extends('layouts.app')

@section('title', 'Laporan Perpustakaan')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Laporan Perpustakaan</h1>

    <!-- Tab Navigation -->
    <div class="flex gap-1 bg-linear-surface-2 p-1 rounded-xl border border-linear-hairline w-fit">
        <button class="tab-btn active px-4 py-2 text-sm font-semibold rounded-lg bg-white text-linear-ink shadow-sm transition" data-tab="books">Laporan Buku</button>
        <button class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg text-linear-ink-subtle hover:text-linear-ink transition" data-tab="members">Laporan Anggota</button>
        <button class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg text-linear-ink-subtle hover:text-linear-ink transition" data-tab="loans">Laporan Peminjaman</button>
        <button class="tab-btn px-4 py-2 text-sm font-semibold rounded-lg text-linear-ink-subtle hover:text-linear-ink transition" data-tab="returns">Laporan Pengembalian</button>
    </div>

    <!-- Books Report -->
    <div id="tab-books" class="tab-content">
        <div class="flex justify-end gap-2 mb-4">
            <button onclick="printTable('report-book-table', 'Laporan Buku')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-pdf mr-1"></i> Cetak PDF</button>
            <button onclick="exportExcel('report-book-table', 'Laporan Buku')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
        </div>
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm">
            <table id="report-book-table" class="w-full text-left">
                <thead>
                    <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Penulis</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Stok Total</th>
                        <th class="px-4 py-3">Stok Tersedia</th>
                        <th class="px-4 py-3">Dipinjam</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Members Report -->
    <div id="tab-members" class="tab-content hidden">
        <div class="flex justify-end gap-2 mb-4">
            <button onclick="printTable('report-member-table', 'Laporan Anggota')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-pdf mr-1"></i> Cetak PDF</button>
            <button onclick="exportExcel('report-member-table', 'Laporan Anggota')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
        </div>
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm">
            <table id="report-member-table" class="w-full text-left">
                <thead>
                    <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">NIM</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Prodi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tgl Daftar</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Loans Report -->
    <div id="tab-loans" class="tab-content hidden">
        <div class="flex justify-end gap-2 mb-4">
            <button onclick="printTable('report-loan-table', 'Laporan Peminjaman')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-pdf mr-1"></i> Cetak PDF</button>
            <button onclick="exportExcel('report-loan-table', 'Laporan Peminjaman')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
        </div>
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm">
            <table id="report-loan-table" class="w-full text-left">
                <thead>
                    <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Tgl Pinjam</th>
                        <th class="px-4 py-3">Batas Kembali</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Returns Report -->
    <div id="tab-returns" class="tab-content hidden">
        <div class="flex justify-end gap-2 mb-4">
            <button onclick="printTable('report-return-table', 'Laporan Pengembalian')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-pdf mr-1"></i> Cetak PDF</button>
            <button onclick="exportExcel('report-return-table', 'Laporan Pengembalian')" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full text-xs font-semibold transition shadow-sm"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
        </div>
        <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm">
            <table id="report-return-table" class="w-full text-left">
                <thead>
                    <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3">Tgl Kembali</th>
                        <th class="px-4 py-3">Denda</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let bookReportTable, memberReportTable, loanReportTable, returnReportTable;

    $(document).ready(function() {
        $('.tab-btn').click(function() {
            $('.tab-btn').removeClass('active bg-white text-linear-ink shadow-sm').addClass('text-linear-ink-subtle');
            $(this).addClass('active bg-white text-linear-ink shadow-sm').removeClass('text-linear-ink-subtle');
            $('.tab-content').addClass('hidden');
            $('#tab-' + $(this).data('tab')).removeClass('hidden');
            $($.fn.dataTable.tables()).each(function() {
                if ($(this).DataTable()) $(this).DataTable().columns.adjust().responsive.recalc();
            });
        });

        bookReportTable = $('#report-book-table').DataTable({
            ajax: { url: `${API_URL}/books`, dataSrc: 'data' },
            columns: [
                { data: 'title', className: 'font-medium' },
                { data: 'author' },
                { data: 'category.name', defaultContent: '-' },
                { data: 'stock', className: 'font-semibold text-center' },
                { data: 'available_stock', className: 'font-semibold text-center' },
                {
                    data: null,
                    className: 'text-center',
                    render: data => `<span class="font-semibold text-amber-600">${data.stock - data.available_stock}</span>`
                }
            ],
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "_START_-_END_ dari _TOTAL_", emptyTable: "Tidak ada data" },
            responsive: true
        });

        memberReportTable = $('#report-member-table').DataTable({
            ajax: { url: `${API_URL}/users`, dataSrc: 'data' },
            columns: [
                { data: 'name', className: 'font-medium' },
                { data: 'nim', defaultContent: '-' },
                { data: 'email' },
                { data: 'study_program', defaultContent: '-' },
                {
                    data: 'is_active',
                    render: v => v ? '<span class="text-emerald-600 font-medium">Aktif</span>' : '<span class="text-red-600 font-medium">Nonaktif</span>'
                },
                {
                    data: 'created_at',
                    render: d => d ? new Date(d).toLocaleDateString('id-ID') : '-'
                }
            ],
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "_START_-_END_ dari _TOTAL_", emptyTable: "Tidak ada data" },
            responsive: true
        });

        loanReportTable = $('#report-loan-table').DataTable({
            ajax: { url: `${API_URL}/loans`, dataSrc: 'data' },
            columns: [
                { data: 'loan_code', className: 'font-mono text-xs font-semibold text-linear-primary' },
                { data: 'user.name', defaultContent: '-', className: 'font-medium' },
                { data: 'book.title', defaultContent: '-' },
                { data: 'loan_date', defaultContent: '-' },
                { data: 'return_date', defaultContent: '-' },
                {
                    data: 'status',
                    render: function(s) {
                        const m = { 'menunggu': 'bg-amber-50 text-amber-700', 'dipinjam': 'bg-blue-50 text-blue-700', 'dikembalikan': 'bg-emerald-50 text-emerald-700', 'terlambat': 'bg-red-50 text-red-700', 'ditolak': 'bg-slate-50 text-slate-700' };
                        return `<span class="px-2 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider ${m[s] || 'bg-slate-50 text-slate-700'} border">${s}</span>`;
                    }
                }
            ],
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "_START_-_END_ dari _TOTAL_", emptyTable: "Tidak ada data" },
            responsive: true
        });

        returnReportTable = $('#report-return-table').DataTable({
            ajax: { url: `${API_URL}/loans?status=dikembalikan,terlambat`, dataSrc: 'data' },
            columns: [
                { data: 'loan_code', className: 'font-mono text-xs font-semibold text-linear-primary' },
                { data: 'user.name', defaultContent: '-', className: 'font-medium' },
                { data: 'book.title', defaultContent: '-' },
                { data: 'actual_return_date', defaultContent: '-' },
                {
                    data: 'fine',
                    render: f => f ? `Rp ${parseInt(f.amount).toLocaleString('id-ID')}` : '-',
                    className: 'font-semibold'
                },
                {
                    data: 'status',
                    render: function(s) {
                        const m = { 'dikembalikan': 'bg-emerald-50 text-emerald-700', 'terlambat': 'bg-red-50 text-red-700' };
                        return `<span class="px-2 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider ${m[s] || 'bg-slate-50 text-slate-700'} border">${s}</span>`;
                    }
                }
            ],
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_", info: "_START_-_END_ dari _TOTAL_", emptyTable: "Tidak ada data" },
            responsive: true
        });
    });

    function printTable(tableId, title) {
        const table = $(`#${tableId}`).DataTable();
        let html = `
            <html><head><title>${title}</title>
            <style>body{font-family:Arial;padding:20px;}h2{text-align:center;margin-bottom:20px;}
            table{width:100%;border-collapse:collapse;}th,td{padding:8px;border:1px solid #ddd;text-align:left;}
            th{background:#533afd;color:white;}</style></head>
            <body><h2>${title}</h2>
            <p>Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
            <table>`;
        html += '<thead><tr>';
        table.columns().every(function() {
            html += '<th>' + $(this.header()).text() + '</th>';
        });
        html += '</tr></thead><tbody>';
        table.rows({ search: 'applied' }).data().each(function(row) {
            html += '<tr>';
            table.columns().every(function() {
                const data = this.data ? row[this.dataSrc()] : '';
                html += '<td>' + (data || '-') + '</td>';
            });
            html += '</tr>';
        });
        html += '</tbody></table></body></html>';

        const win = window.open('', '_blank');
        win.document.write(html);
        win.document.close();
        win.print();
    }

    function exportExcel(tableId, title) {
        const table = $(`#${tableId}`).DataTable();
        let csv = title + '\nTanggal: ' + new Date().toLocaleDateString('id-ID') + '\n\n';
        const headers = [];
        table.columns().every(function() { headers.push($(this.header()).text()); });
        csv += headers.join(',') + '\n';
        table.rows({ search: 'applied' }).data().each(function(row) {
            const rowData = [];
            table.columns().every(function() {
                let val = row[this.dataSrc()] || '';
                if (typeof val === 'object') val = '';
                rowData.push('"' + String(val).replace(/"/g, '""') + '"');
            });
            csv += rowData.join(',') + '\n';
        });

        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = title + '.csv';
        link.click();
    }
</script>
@endpush
