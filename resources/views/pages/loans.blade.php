@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Peminjaman</h1>
        <select id="filter-status" class="px-4 py-2 bg-white border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            <option value="">Semua Status</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="dikembalikan">Dikembalikan</option>
            <option value="terlambat">Terlambat</option>
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
        <table id="manage-loan-table" class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-4 py-3">Kode / Peminjam</th>
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Tgl Pinjam / Batas</th>
                    <th class="px-4 py-3">Status</th>
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
    let loanTable;

    $(document).ready(function() {
        loanTable = $('#manage-loan-table').DataTable({
            ajax: { 
                url: `${API_URL}/loans`, 
                data: function(d) {
                    d.status = $('#filter-status').val();
                },
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: null,
                    render: data => `
                        <div>
                            <p class="font-mono text-xs font-bold text-indigo-600">${data.loan_code}</p>
                            <p class="font-bold text-gray-900">${data.user.name}</p>
                            <p class="text-xs text-gray-500">${data.user.nim || '-'}</p>
                        </div>
                    `
                },
                { 
                    data: 'book',
                    render: book => `<p class="font-medium text-gray-700">${book.title}</p>`
                },
                { 
                    data: null,
                    render: data => `
                        <div>
                            <p class="text-sm">${data.loan_date}</p>
                            <p class="text-xs text-red-500 font-medium">Batas: ${data.return_date}</p>
                        </div>
                    `
                },
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
                    data: null,
                    orderable: false,
                    render: function(data) {
                        if (data.status === 'dipinjam') {
                            return `<button onclick="returnBook(${data.id})" class="px-4 py-1 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition">Kembalikan</button>`;
                        }
                        return '-';
                    }
                }
            ]
        });

        $('#filter-status').change(function() {
            loanTable.ajax.reload();
        });
    });

    function returnBook(id) {
        Swal.fire({
            title: 'Proses Pengembalian?',
            text: "Pastikan buku sudah diterima dalam kondisi baik.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            confirmButtonText: 'Ya, Kembalikan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/loans/${id}/return`,
                    method: 'PUT',
                    data: { status: 'dikembalikan' },
                    success: function() {
                        Swal.fire('Berhasil!', 'Buku telah dikembalikan.', 'success');
                        loanTable.ajax.reload();
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
