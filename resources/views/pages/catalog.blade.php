@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Katalog Buku</h1>
            <p class="text-sm text-slate-400 mt-0.5">Temukan dan pinjam buku koleksi perpustakaan</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <input type="text" id="search-title" placeholder="Cari judul..." class="px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/20 transition text-sm w-40 lg:w-48 placeholder:text-slate-400">
            <input type="text" id="search-author" placeholder="Cari penulis..." class="px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/20 transition text-sm w-40 lg:w-48 placeholder:text-slate-400">
            <select id="filter-category" class="px-3.5 py-2.5 bg-white text-slate-800 border border-slate-200 rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/20 transition text-sm">
                <option value="">Semua Kategori</option>
            </select>
        </div>
    </div>

    <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm card-hover">
        <table id="book-table" class="w-full text-left">
            <thead>
                <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                    <th class="px-4 py-3">Buku</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Lokasi Rak</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Detail Modal -->
<div id="detail-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('detail-modal')">
    <div class="bg-white border border-slate-100 rounded-2xl w-full max-w-lg overflow-hidden shadow-xl animate-scaleIn">
        <div class="p-6">
            <div class="flex gap-5">
                <div class="w-28 h-36 bg-slate-100 rounded-xl flex-shrink-0 overflow-hidden" id="detail-cover">
                    <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fas fa-book text-3xl"></i></div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-bold text-slate-800 text-lg leading-tight" id="detail-title">Judul</h3>
                        <button onclick="closeModal('detail-modal')" class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition shrink-0"><i class="fas fa-times"></i></button>
                    </div>
                    <p class="text-sm text-slate-500 mt-1" id="detail-author">Penulis</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-[11px] bg-linear-primary/5 text-linear-primary px-2.5 py-0.5 rounded-full font-medium" id="detail-category">Kategori</span>
                        <span class="text-[11px] bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full font-medium" id="detail-type">Jenis</span>
                        <span class="text-[11px] bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full font-medium" id="detail-year">Tahun</span>
                    </div>
                    <div class="mt-4 space-y-1.5 text-sm">
                        <p><span class="text-slate-400">Penerbit:</span> <span class="text-slate-700" id="detail-publisher">-</span></p>
                        <p><span class="text-slate-400">ISBN:</span> <span class="text-slate-700 font-mono" id="detail-isbn">-</span></p>
                        <p><span class="text-slate-400">Lokasi:</span> <span class="text-slate-700" id="detail-location">-</span></p>
                        <p><span class="text-slate-400">Stok:</span> <span class="font-semibold" id="detail-stock">-</span></p>
                    </div>
                    <p class="text-sm text-slate-600 mt-4 leading-relaxed" id="detail-desc">-</p>
                    <div class="flex gap-2 mt-4" id="detail-actions"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Borrow Modal -->
<div id="borrow-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('borrow-modal')">
    <div class="bg-linear-surface-1 border border-linear-hairline rounded-xl w-full max-w-md overflow-hidden shadow-[rgba(0,55,112,0.12)_0_16px_48px] animate-scaleIn">
        <div class="bg-linear-surface-2 px-6 py-4 text-linear-ink flex justify-between items-center border-b border-linear-hairline">
            <h3 class="font-bold tracking-tight text-sm uppercase">Konfirmasi Peminjaman</h3>
            <button onclick="closeModal('borrow-modal')" class="w-8 h-8 flex items-center justify-center text-linear-ink-subtle hover:text-linear-ink hover:bg-linear-surface-3 rounded-lg transition duration-150"><i class="fas fa-times"></i></button>
        </div>
        <form id="borrow-form" class="p-6 space-y-4">
            <input type="hidden" id="borrow-book-id">
            <div class="flex items-start gap-4 p-4 bg-linear-canvas border border-linear-hairline rounded-lg">
                <div class="w-12 h-16 bg-white rounded border border-linear-hairline flex-shrink-0 flex items-center justify-center overflow-hidden" id="borrow-book-cover"></div>
                <div class="min-w-0">
                    <p class="font-bold text-linear-ink text-sm leading-tight" id="borrow-book-title">Judul Buku</p>
                    <p class="text-xs text-linear-ink-subtle mt-1" id="borrow-book-author">Penulis</p>
                    <p class="text-[11px] text-linear-primary font-medium mt-1" id="borrow-book-location">Lokasi</p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Tanggal Pengembalian</label>
                <input type="date" id="borrow-return-date" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
                <p class="text-[11px] text-linear-ink-subtle mt-1.5">* Maksimal peminjaman adalah 7 hari.</p>
            </div>
            <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white text-sm font-semibold py-2.5 rounded-full transition-all duration-200 shadow-md hover:shadow-lg active:scale-[0.98]" style="position:relative;overflow:hidden;">
                Pinjam Sekarang
            </button>
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

    $(document).ready(function() {
        $.get(`${API_URL}/categories`, function(res) {
            res.data.forEach(c => {
                $('#filter-category').append(`<option value="${c.id}">${c.name}</option>`);
            });
        });

        table = $('#book-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: { url: `${API_URL}/books`, dataSrc: 'data' },
            columns: [
                {
                    data: null,
                    render: function(data) {
                        return `
                            <div class="flex items-center gap-3 cursor-pointer" onclick='openDetailModal(${JSON.stringify(data)})'>
                                <div class="w-10 h-14 bg-linear-surface-2 border border-linear-hairline rounded flex items-center justify-center text-linear-ink-subtle text-xs text-center p-0.5 overflow-hidden flex-shrink-0">
                                    ${data.cover_image ? `<img src="${data.cover_image}" class="w-full h-full object-cover rounded" onerror="imgFallback(this)">` : '<i class="fas fa-book text-sm"></i>'}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-linear-ink leading-tight text-sm truncate max-w-[200px] hover:text-linear-primary transition-colors">${data.title}</p>
                                    <p class="text-xs text-linear-ink-subtle mt-0.5">${data.publisher || '-'} ${data.publish_year ? `(${data.publish_year})` : ''}</p>
                                </div>
                            </div>
                        `;
                    }
                },
                { data: 'author' },
                { data: 'category.name', defaultContent: '-' },
                { data: 'type', defaultContent: '-' },
                { data: 'shelf_location', defaultContent: '-' },
                { 
                    data: 'available_stock',
                    render: function(data) {
                        const color = data > 0 ? 'text-emerald-700 bg-emerald-50 border border-emerald-200' : 'text-red-700 bg-red-50 border border-red-200';
                        return `<span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${color}">${data > 0 ? `${data} Tersedia` : 'Stok Habis'}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        const ebookBtn = data.file_ebook 
                            ? `<a href="${API_URL}/books/${data.id}/ebook" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 rounded-full text-xs font-semibold transition-all duration-200 inline-flex items-center gap-1">
                                <i class="fas fa-book-open"></i> Baca
                               </a>`
                            : '';
                        if (user.role === 'user') {
                            const disabled = data.available_stock <= 0 ? 'disabled opacity-40 cursor-not-allowed' : '';
                            return `<div class="flex items-center gap-1.5">
                                <button onclick='openBorrowModal(${JSON.stringify(data)})' class="px-3 py-1.5 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.97] ${disabled}">Pinjam</button>
                                ${ebookBtn}
                            </div>`;
                        }
                        return ebookBtn || '<span class="text-slate-400 text-xs">-</span>';
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
                },
                emptyTable: "Belum ada data buku"
            },
            responsive: true
        });

        // Search filters
        $('#search-title, #search-author, #filter-category').on('change keyup', function() {
            const title = $('#search-title').val().toLowerCase();
            const author = $('#search-author').val().toLowerCase();
            const cat = $('#filter-category').val();
            table.rows().every(function() {
                const d = this.data();
                let show = true;
                if (title && !d.title.toLowerCase().includes(title)) show = false;
                if (author && !d.author.toLowerCase().includes(author)) show = false;
                if (cat && d.category_id != cat) show = false;
                this.nodes().to$().toggle(show);
            });
        });

        $('#borrow-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');

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
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Buku berhasil dipinjam. Silakan ambil di petugas.',
                        icon: 'success',
                        background: '#ffffff',
                        color: '#0d253d',
                        confirmButtonColor: '#533afd'
                    });
                    table.ajax.reload();
                    btn.prop('disabled', false).html('Pinjam Sekarang');
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Pinjam Sekarang');
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

    function openDetailModal(book) {
        $('#detail-title').text(book.title);
        $('#detail-author').text(book.author);
        $('#detail-category').text(book.category?.name || '-');
        $('#detail-type').text(book.type || '-');
        $('#detail-year').text(book.publish_year || '-');
        $('#detail-publisher').text(book.publisher || '-');
        $('#detail-isbn').text(book.isbn || '-');
        $('#detail-location').text(book.shelf_location || '-');
        $('#detail-stock').html(`${book.available_stock} / ${book.stock} <span class="text-xs text-slate-400 font-normal">tersedia</span>`);
        $('#detail-desc').text(book.description || 'Tidak ada deskripsi.');
        if (book.cover_image) {
            $('#detail-cover').html(`<img src="${book.cover_image}" class="w-full h-full object-cover" onerror="imgFallback(this)">`);
        } else {
            $('#detail-cover').html(`<div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fas fa-book text-3xl"></i></div>`);
        }
        let actions = '';
        if (user.role === 'user' && book.available_stock > 0) {
            actions += `<button onclick='closeModal("detail-modal"); openBorrowModal(${JSON.stringify(book)})' class="px-4 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] text-white rounded-full text-xs font-semibold shadow-sm hover:shadow-md active:scale-[0.97] transition-all duration-200">Pinjam Buku</button>`;
        }
        if (book.file_ebook) {
            actions += `<a href="${API_URL}/books/${book.id}/ebook" target="_blank" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 rounded-full text-xs font-semibold transition inline-flex items-center gap-1"><i class="fas fa-book-open"></i> Baca E-book</a>`;
        }
        $('#detail-actions').html(actions);
        $('#detail-modal').removeClass('hidden');
    }

    function openBorrowModal(book) {
        if (book.available_stock <= 0) return;
        $('#borrow-book-id').val(book.id);
        $('#borrow-book-title').text(book.title);
        $('#borrow-book-author').text(book.author);
        $('#borrow-book-location').text(book.shelf_location ? `Lokasi: ${book.shelf_location}` : 'Lokasi: -');
        $('#borrow-book-cover').html(book.cover_image ? `<img src="${book.cover_image}" class="w-full h-full object-cover rounded" onerror="imgFallback(this)">` : '<i class="fas fa-book text-linear-ink-subtle text-lg"></i>');
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