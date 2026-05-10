@extends('layouts.app')

@section('title', 'Manajemen Denda')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Manajemen Denda</h1>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
        <table id="manage-fine-table" class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Jumlah Denda</th>
                    <th class="px-4 py-3">Status Bayar</th>
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
    let fineTable;

    $(document).ready(function() {
        fineTable = $('#manage-fine-table').DataTable({
            ajax: { url: `${API_URL}/fines`, dataSrc: 'data' },
            columns: [
                { 
                    data: null,
                    render: function(data) {
                        // We need to eager load or fetch extra data. 
                        // For now I'll assume we might need a small adjustment in the API to show user info in fines.
                        // But I'll show placeholder if not available.
                        return `<p class="font-bold text-gray-900">Loan ID: ${data.loan_id}</p>`;
                    }
                },
                { data: 'loan_id', render: id => `Buku dari Pinjaman #${id}` },
                { 
                    data: 'amount',
                    render: data => `<span class="font-bold text-red-600">Rp ${parseInt(data).toLocaleString('id-ID')}</span>`
                },
                { 
                    data: 'payment_status',
                    render: function(status) {
                        const color = status === 'paid' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600';
                        return `<span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide ${color}">${status}</span>`;
                    }
                },
                { 
                    data: null,
                    orderable: false,
                    render: function(data) {
                        if (data.payment_status === 'unpaid' && user.role === 'admin') {
                            return `<button onclick="payFine(${data.id})" class="px-4 py-1 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition">Konfirmasi Bayar</button>`;
                        }
                        return '-';
                    }
                }
            ]
        });
    });

    function payFine(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran?',
            text: "Pastikan denda sudah dibayar lunas.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            confirmButtonText: 'Ya, Sudah Bayar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/fines/${id}/status`,
                    method: 'PUT',
                    data: { payment_status: 'paid' },
                    success: function() {
                        Swal.fire('Berhasil!', 'Pembayaran denda telah dikonfirmasi.', 'success');
                        fineTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
