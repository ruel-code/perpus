@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Manajemen Buku</h1>
        <button onclick="openBookModal()" class="bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg active:scale-[0.98]">
            <i class="fas fa-plus"></i> Tambah Buku
        </button>
    </div>

    <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm card-hover">
        <table id="manage-book-table" class="w-full text-left">
            <thead>
                <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Lokasi Rak</th>
                    <th class="px-4 py-3">Stok (Tersedia)</th>
                    <th class="px-4 py-3">ISBN</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Book Modal (Add/Edit) -->
<div id="book-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('book-modal')">
    <div class="bg-linear-surface-1 border border-linear-hairline rounded-xl w-full max-w-2xl overflow-hidden shadow-[rgba(0,55,112,0.12)_0_16px_48px] animate-scaleIn max-h-[90vh] overflow-y-auto">
        <div class="bg-linear-surface-2 px-6 py-4 text-linear-ink flex justify-between items-center border-b border-linear-hairline sticky top-0 bg-linear-surface-2 z-10">
            <h3 class="font-bold tracking-tight text-sm uppercase" id="modal-title">Tambah Buku</h3>
            <button onclick="closeModal('book-modal')" class="w-8 h-8 flex items-center justify-center text-linear-ink-subtle hover:text-linear-ink hover:bg-linear-surface-3 rounded-lg transition duration-150"><i class="fas fa-times"></i></button>
        </div>
        <form id="book-form" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="book-id">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Judul Buku</label>
                <input type="text" id="title" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Penulis</label>
                <input type="text" id="author" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Penerbit</label>
                <input type="text" id="publisher" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Kategori</label>
                <select id="category_id" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Jenis Benda</label>
                <select id="type" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                    <option value="Buku">Buku</option>
                    <option value="Majalah">Majalah</option>
                    <option value="Skripsi">Skripsi</option>
                    <option value="CD/DVD">CD/DVD</option>
                    <option value="Jurnal">Jurnal</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">ISBN</label>
                <div class="flex gap-2">
                    <input type="text" id="isbn" class="flex-1 px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                    <button type="button" onclick="fetchCoverByIsbn()" class="px-3 py-2 bg-linear-surface-2 hover:bg-linear-surface-3 text-linear-ink-muted border border-linear-hairline rounded-lg text-xs font-semibold transition duration-150 whitespace-nowrap">
                        <i class="fas fa-image mr-1"></i>Cari Cover
                    </button>
                </div>
                <div id="isbn-result" class="mt-1.5 text-xs hidden"></div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Tahun Terbit</label>
                <input type="number" id="publish_year" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="Contoh: 2024">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Lokasi Rak</label>
                <input type="text" id="shelf_location" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="Contoh: Rak Fiksi-A1">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Harga Buku (Rp)</label>
                <input type="number" id="price" min="0" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="Rp 0">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Total Stok</label>
                <input type="number" id="stock" required min="0" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Gambar Cover</label>
                <div class="flex gap-3 items-start">
                    <div class="flex-1 space-y-2">
                        <input type="file" id="cover_file" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="block w-full text-sm text-linear-ink file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-linear-primary file:text-white hover:file:bg-linear-primary-hover transition cursor-pointer">
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] text-linear-ink-subtle uppercase font-semibold">atau URL:</span>
                            <input type="text" id="cover_image" class="flex-1 px-3.5 py-2 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="https://contoh.com/sampul.jpg">
                        </div>
                    </div>
                    <div id="cover-preview" class="w-14 h-20 bg-linear-surface-2 border border-linear-hairline rounded-lg flex items-center justify-center text-linear-ink-subtle text-xs flex-shrink-0 overflow-hidden">
                        <i class="fas fa-book text-sm"></i>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">File E-Book (PDF)</label>
                <input type="file" id="file_ebook" accept="application/pdf" class="block w-full text-sm text-linear-ink file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-linear-primary file:text-white hover:file:bg-linear-primary-hover transition cursor-pointer">
                <div id="ebook-info" class="mt-1.5 text-xs text-linear-ink-subtle hidden"></div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Deskripsi</label>
                <textarea id="description" rows="3" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm"></textarea>
            </div>
            <div class="md:col-span-2 flex justify-end gap-3 mt-2 border-t border-linear-hairline pt-4">
                <button type="button" onclick="closeModal('book-modal')" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-sm font-semibold transition duration-150">Batal</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let table;

    function imgFallback(el) {
        el.onerror = null;
        el.outerHTML = '<i class="fas fa-book text-sm"></i>';
    }

    function coverImg(url) {
        if (!url) return '<i class="fas fa-book text-sm"></i>';
        return '<img src="' + url.replace(/"/g, '&quot;') + '" class="w-full h-full object-cover rounded" onerror="imgFallback(this)">';
    }

    $(document).ready(function() {
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
                                <div class="w-10 h-14 bg-linear-surface-2 border border-linear-hairline rounded flex items-center justify-center text-linear-ink-subtle text-xs text-center p-0.5 overflow-hidden flex-shrink-0">
                                    ${coverImg(data.cover_image)}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-linear-ink leading-tight text-sm truncate max-w-[200px]">${data.title}</p>
                                    <p class="text-xs text-linear-ink-subtle mt-0.5">${data.publisher || '-'} ${data.publish_year ? `(${data.publish_year})` : ''}</p>
                                </div>
                            </div>
                        `;
                    }
                },
                { data: 'author' },
                { data: 'category.name', defaultContent: '-' },
                { data: 'type', defaultContent: '-' },
                { 
                    data: 'price',
                    render: data => data ? `<span class="font-medium text-slate-700">Rp ${parseInt(data).toLocaleString('id-ID')}</span>` : '<span class="text-slate-400">-</span>'
                },
                { data: 'shelf_location', defaultContent: '-' },
                { 
                    data: null,
                    render: data => `<span class="text-linear-ink font-semibold">${data.stock}</span> <span class="text-linear-ink-subtle">(${data.available_stock})</span>`
                },
                { data: 'isbn', defaultContent: '-' },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        return `
                            <div class="flex gap-1.5 justify-center table-actions">
                                <button onclick='openBookModal(${JSON.stringify(data)})' class="p-2 bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100 rounded-lg transition duration-150" title="Edit"><i class="fas fa-edit"></i></button>
                                <button onclick="deleteBook(${data.id})" class="p-2 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 rounded-lg transition duration-150" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada data buku"
            },
            responsive: true
        });

        $('#book-form').submit(function(e) {
            e.preventDefault();
            const id = $('#book-id').val();
            const url = id ? `${API_URL}/books/${id}` : `${API_URL}/books`;
            const fd = new FormData();
            fd.append('category_id', $('#category_id').val());
            fd.append('type', $('#type').val());
            fd.append('title', $('#title').val());
            fd.append('author', $('#author').val());
            fd.append('publisher', $('#publisher').val());
            fd.append('isbn', $('#isbn').val());
            fd.append('publish_year', $('#publish_year').val());
            fd.append('shelf_location', $('#shelf_location').val());
            fd.append('stock', $('#stock').val());
            fd.append('price', $('#price').val() || 0);
            fd.append('description', $('#description').val());
            fd.append('cover_image', $('#cover_image').val());
            fd.append('file_ebook', $('#file_ebook')[0]?.files[0] || '');

            const fileInput = $('#cover_file')[0];
            if (fileInput && fileInput.files[0]) {
                fd.append('cover_file', fileInput.files[0]);
            }

            if (id) fd.append('_method', 'PUT');

            $.ajax({
                url: url,
                method: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function() {
                    closeModal('book-modal');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data buku berhasil disimpan.',
                        icon: 'success',
                        background: '#ffffff',
                        color: '#0d253d',
                        confirmButtonColor: '#533afd'
                    });
                    table.ajax.reload();
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
        });
    });

    function openBookModal(book = null) {
        $('#book-form')[0].reset();
        $('#file_ebook').val('');
        $('#book-id').val('');
        $('#isbn-result').addClass('hidden');

        if (book) {
            $('#modal-title').text('Edit Buku');
            $('#book-id').val(book.id);
            $('#title').val(book.title);
            $('#author').val(book.author);
            $('#publisher').val(book.publisher);
            $('#category_id').val(book.category_id);
            $('#type').val(book.type || 'Buku');
            $('#isbn').val(book.isbn);
            $('#publish_year').val(book.publish_year);
            $('#shelf_location').val(book.shelf_location);
            $('#stock').val(book.stock);
            $('#price').val(book.price || '');
            $('#description').val(book.description);
            $('#cover_image').val(book.cover_image || '');
            if (book.file_ebook) {
                $('#ebook-info').removeClass('hidden').html('<i class="fas fa-file-pdf text-red-500 mr-1"></i>File e-book: <a href="' + book.file_ebook + '" target="_blank" class="text-linear-primary underline">Lihat File</a>');
            } else {
                $('#ebook-info').addClass('hidden');
            }

            if (book.cover_image) {
                const img = new Image();
                img.className = 'w-full h-full object-cover rounded';
                img.onload = function() { $('#cover-preview').empty().append(img); };
                img.onerror = function() { $('#cover-preview').html('<i class="fas fa-book text-sm"></i>'); };
                img.src = book.cover_image;
            }
        } else {
            $('#modal-title').text('Tambah Buku');
            $('#type').val('Buku');
            $('#cover-preview').html('<i class="fas fa-book text-sm"></i>');
            $('#ebook-info').addClass('hidden');
        }
        $('#book-modal').removeClass('hidden');
    }

    function deleteBook(id) {
        Swal.fire({
            title: 'Hapus Buku?',
            text: "Data buku akan dihapus permanen!",
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
                    url: `${API_URL}/books/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Buku telah dihapus.',
                            icon: 'success',
                            background: '#ffffff',
                            color: '#0d253d',
                            confirmButtonColor: '#533afd'
                        });
                        table.ajax.reload();
                    }
                });
            }
        });
    }

    $('#cover_image').on('input', function() {
        const url = $(this).val().trim();
        const preview = $('#cover-preview');
        if (url) {
            const img = new Image();
            img.className = 'w-full h-full object-cover rounded';
            img.onload = function() { preview.empty().append(img); };
            img.onerror = function() { preview.html('<i class="fas fa-book text-sm"></i>'); };
            img.src = url;
        } else if (!$('#cover_file')[0]?.files[0]) {
            preview.html('<i class="fas fa-book text-sm"></i>');
        }
    });

    $('#cover_file').on('change', function() {
        const file = this.files[0];
        const preview = $('#cover-preview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.className = 'w-full h-full object-cover rounded';
                img.onload = function() { preview.empty().append(img); };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            $('#cover_image').trigger('input');
        }
    });

    function fetchCoverByIsbn() {
        const isbn = $('#isbn').val().trim().replace(/-/g, '');
        const resultDiv = $('#isbn-result');
        const title = $('#title').val().trim().toLowerCase();

        if (!isbn) {
            resultDiv.removeClass('hidden').addClass('text-red-500').html('<i class="fas fa-exclamation-circle mr-1"></i>Masukkan ISBN terlebih dahulu.');
            return;
        }

        resultDiv.removeClass('hidden').html('<i class="fas fa-spinner fa-spin mr-1"></i>Mencari cover...');

        $.getJSON(`https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&jscmd=data&format=json`, function(res) {
            const key = `ISBN:${isbn}`;
            const data = res[key];

            if (!data || !data.cover) {
                resultDiv.removeClass('text-green-600 text-red-500').addClass('text-amber-600').html('<i class="fas fa-search mr-1"></i>Cover tidak ditemukan untuk ISBN ini. Coba cari manual.');
                return;
            }

            const apiTitle = (data.title || '').toLowerCase();
            const titleMatch = title && apiTitle && (apiTitle.includes(title) || title.includes(apiTitle));
            const coverUrl = data.cover.large || data.cover.medium || data.cover.small;

            if (!title || titleMatch) {
                $('#cover_image').val(coverUrl).trigger('input');
                resultDiv.removeClass('text-amber-600 text-red-500').addClass('text-green-600')
                    .html(`<i class="fas fa-check-circle mr-1"></i>Cover ditemukan! <span class="font-medium">${data.title}</span>`);
            } else {
                resultDiv.removeClass('text-green-600 text-red-500').addClass('text-amber-600')
                    .html(`<i class="fas fa-exclamation-triangle mr-1"></i>Judul dari Open Library: "<span class="font-medium">${data.title}</span>". Cover tetap diisi? 
                        <button onclick="$('#cover_image').val('${coverUrl}').trigger('input'); $('#isbn-result').addClass('hidden')" class="underline font-semibold ml-1">Ya, pakai</button>`);
            }
        }).fail(function() {
            resultDiv.removeClass('text-green-600 text-amber-600').addClass('text-red-500')
                .html('<i class="fas fa-times-circle mr-1"></i>Gagal mengambil data. Coba beberapa saat lagi.');
        });
    }

    function closeModal(id) {
        $(`#${id}`).addClass('hidden');
    }
</script>
@endpush