@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Buku</h1>
        <button onclick="openBookModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Buku
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">
        <table id="manage-book-table" class="w-full text-left">
            <thead>
                <tr class="text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stok (Tersedia)</th>
                    <th class="px-4 py-3">ISBN</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Book Modal (Add/Edit) -->
<div id="book-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4 text-white flex justify-between items-center">
            <h3 class="font-bold" id="modal-title">Tambah Buku</h3>
            <button onclick="closeModal('book-modal')" class="hover:text-indigo-200"><i class="fas fa-times"></i></button>
        </div>
        <form id="book-form" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="book-id">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <input type="text" id="title" required class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                <input type="text" id="author" required class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                <input type="text" id="publisher" required class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="category_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                <input type="text" id="isbn" class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Stok</label>
                <input type="number" id="stock" required min="0" class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-indigo-600 transition"></textarea>
            </div>
            <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeModal('book-modal')" class="px-6 py-2 border border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Simpan Buku</button>
            </div>
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
                $('#category_id').append(`<option value="${c.id}">${c.name}</option>`);
            });
        });

        table = $('#manage-book-table').DataTable({
            ajax: { url: `${API_URL}/books`, dataSrc: 'data' },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">
                                    <i class="fas fa-book"></i>
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
                    data: null,
                    render: data => `<b>${data.stock}</b> (${data.available_stock})`
                },
                { data: 'isbn', defaultContent: '-' },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                            <div class="flex gap-2">
                                <button onclick='openBookModal(${JSON.stringify(data)})' class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition"><i class="fas fa-edit"></i></button>
                                <button onclick="deleteBook(${data.id})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"><i class="fas fa-trash"></i></button>
                            </div>
                        `;
                    }
                }
            ]
        });

        $('#book-form').submit(function(e) {
            e.preventDefault();
            const id = $('#book-id').val();
            const url = id ? `${API_URL}/books/${id}` : `${API_URL}/books`;
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    category_id: $('#category_id').val(),
                    title: $('#title').val(),
                    author: $('#author').val(),
                    publisher: $('#publisher').val(),
                    isbn: $('#isbn').val(),
                    stock: $('#stock').val(),
                    description: $('#description').val()
                },
                success: function() {
                    closeModal('book-modal');
                    Swal.fire('Berhasil!', 'Data buku berhasil disimpan.', 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
                }
            });
        });
    });

    function openBookModal(book = null) {
        if (book) {
            $('#modal-title').text('Edit Buku');
            $('#book-id').val(book.id);
            $('#title').val(book.title);
            $('#author').val(book.author);
            $('#publisher').val(book.publisher);
            $('#category_id').val(book.category_id);
            $('#isbn').val(book.isbn);
            $('#stock').val(book.stock);
            $('#description').val(book.description);
        } else {
            $('#modal-title').text('Tambah Buku');
            $('#book-form')[0].reset();
            $('#book-id').val('');
        }
        $('#book-modal').removeClass('hidden');
    }

    function deleteBook(id) {
        Swal.fire({
            title: 'Hapus Buku?',
            text: "Data buku akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${API_URL}/books/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire('Terhapus!', 'Buku telah dihapus.', 'success');
                        table.ajax.reload();
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
