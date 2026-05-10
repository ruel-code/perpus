@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Katalog Buku</h1>
        <div class="flex gap-2">
            <select id="filter-category" class="px-4 py-2 bg-white border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
                <option value="">Semua Kategori</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
        <table id="book-table" class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Borrow Modal -->
<div id="borrow-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4 text-white flex justify-between items-center">
            <h3 class="font-bold">Konfirmasi Peminjaman</h3>
            <button onclick="closeModal('borrow-modal')" class="hover:text-indigo-200"><i class="fas fa-times"></i></button>
        </div>
        <form id="borrow-form" class="p-6 space-y-4">
            <input type="hidden" id="borrow-book-id">
            <div class="flex items-start gap-4 p-4 bg-indigo-50 rounded-xl">
                <div class="w-12 h-16 bg-gray-200 rounded-lg flex-shrink-0" id="borrow-book-cover"></div>
                <div>
                    <p class="font-bold text-gray-900" id="borrow-book-title">Judul Buku</p>
                    <p class="text-xs text-gray-500" id="borrow-book-author">Penulis</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian</label>
                <input type="date" id="borrow-return-date" required class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
                <p class="text-xs text-gray-500 mt-1">* Maksimal peminjaman adalah 7 hari.</p>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl transition">Pinjam Sekarang</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table;

    $(document).ready(function() {
        // Load categories
        $.get(`${API_URL}/categories`, function(res) {
            res.data.forEach(c => {
                $('#filter-category').append(`<option value="${c.id}">${c.name}</option>`);
            });
        });

        table = $('#book-table').DataTable({
            processing: true,
            serverSide: false, // Using simple AJAX fetch for this small demo
            ajax: {
                url: `${API_URL}/books`,
                dataSrc: 'data'
            },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center p-1 overflow-hidden">
                                    ${data.cover_image ? `<img src="${data.cover_image}" class="w-full h-full object-cover">` : '<i class="fas fa-book"></i>'}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 leading-tight">${data.title}</p>
                                    <p class="text-xs text-gray-500">${data.publisher || '-'}</p>
                                </div>
                            </div>
                        `;
                    }
                },
                { data: 'author' },
                { data: 'category.name', defaultContent: '-' },
                { 
                    data: 'available_stock',
                    render: function(data) {
                        const color = data > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
                        return `<span class="px-3 py-1 rounded-full text-xs font-bold ${color}">${data} Tersedia</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        if (user.role === 'mahasiswa') {
                            const disabled = data.available_stock <= 0 ? 'disabled opacity-50 cursor-not-allowed' : '';
                            return `<button onclick='openBorrowModal(${JSON.stringify(data)})' class="px-4 py-1 bg-indigo-600 text-white rounded-lg text-xs font-bold hover:bg-indigo-700 transition ${disabled}">Pinjam</button>`;
                        }
                        return '-';
                    }
                }
            ],
            language: {
                search: "Cari Buku:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ buku",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            }
        });

        $('#filter-category').change(function() {
            const val = $(this).val();
            table.column(2).search(val ? $('#filter-category option:selected').text() : '').draw();
        });

        $('#borrow-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            btn.prop('disabled', true).text('Memproses...');

            $.ajax({
                url: `${API_URL}/loans`,
                method: 'POST',
                data: {
                    user_id: user.id,
                    book_id: $('#borrow-book-id').val(),
                    return_date: $('#borrow-return-date').val()
                },
                success: function(res) {
                    closeModal('borrow-modal');
                    Swal.fire('Berhasil!', 'Buku berhasil dipinjam. Silakan ambil di petugas.', 'success');
                    table.ajax.reload();
                    btn.prop('disabled', false).text('Pinjam Sekarang');
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Pinjam Sekarang');
                    Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
                }
            });
        });
    });

    function openBorrowModal(book) {
        if (book.available_stock <= 0) return;
        
        $('#borrow-book-id').val(book.id);
        $('#borrow-book-title').text(book.title);
        $('#borrow-book-author').text(book.author);
        $('#borrow-book-cover').html(book.cover_image ? `<img src="${book.cover_image}" class="w-full h-full object-cover rounded-lg">` : '<i class="fas fa-book text-gray-400"></i>');
        
        // Set default return date to 7 days from now
        const date = new Date();
        date.setDate(date.getDate() + 7);
        $('#borrow-return-date').val(date.toISOString().split('T')[0]);
        
        $('#borrow-modal').removeClass('hidden');
    }

    function closeModal(id) {
        $(`#${id}`).addClass('hidden');
    }
</script>
@endpush
