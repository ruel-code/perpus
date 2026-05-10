@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman Saya</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
        <table id="my-loan-table" class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-4 py-3">Kode Pinjam</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Tgl Pinjam</th>
                    <th class="px-4 py-3">Batas Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Denda</th>
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
        $('#my-loan-table').DataTable({
            ajax: { 
                url: `${API_URL}/loans`, 
                dataSrc: function(json) {
                    // Filter loans for current user on client side for simplicity
                    return json.data.filter(l => l.user.id === user.id);
                }
            },
            columns: [
                { data: 'loan_code', className: 'font-mono text-xs font-bold text-indigo-600' },
                { 
                    data: 'book',
                    render: book => `<p class="font-bold text-gray-900">${book.title}</p>`
                },
                { data: 'loan_date' },
                { data: 'return_date' },
                { 
                    data: 'status',
                    render: function(status) {
                        let color = 'bg-blue-100 text-blue-600';
                        if (status === 'dikembalikan') color = 'bg-green-100 text-green-600';
                        if (status === 'terlambat') color = 'bg-red-100 text-red-600';
                        return `<span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide ${color}">${status}</span>`;
                    }
                },
                { 
                    data: 'fine',
                    render: function(fine) {
                        if (!fine) return '-';
                        return `<span class="text-red-600 font-bold">Rp ${parseInt(fine.amount).toLocaleString('id-ID')}</span>`;
                    }
                }
            ]
        });
    });
</script>
@endpush
