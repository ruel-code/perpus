@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-xl font-semibold text-linear-ink tracking-tight">Manajemen Kategori</h1>
        <button onclick="openCategoryModal()" class="bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg active:scale-[0.98]">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <div class="bg-linear-surface-1 rounded-xl border border-linear-hairline p-4 md:p-6 overflow-x-auto shadow-sm card-hover">
        <table id="manage-category-table" class="w-full text-left">
            <thead>
                <tr class="text-linear-ink-subtle uppercase text-[11px] font-semibold tracking-wider border-b border-linear-hairline">
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="category-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-overlay" onclick="if(event.target===this)closeModal('category-modal')">
    <div class="bg-linear-surface-1 border border-linear-hairline rounded-xl w-full max-w-lg overflow-hidden shadow-[rgba(0,55,112,0.12)_0_16px_48px] animate-scaleIn">
        <div class="bg-linear-surface-2 px-6 py-4 text-linear-ink flex justify-between items-center border-b border-linear-hairline">
            <h3 class="font-bold tracking-tight text-sm uppercase" id="modal-title">Tambah Kategori</h3>
            <button onclick="closeModal('category-modal')" class="w-8 h-8 flex items-center justify-center text-linear-ink-subtle hover:text-linear-ink hover:bg-linear-surface-3 rounded-lg transition duration-150"><i class="fas fa-times"></i></button>
        </div>
        <form id="category-form" class="p-6 space-y-4">
            <input type="hidden" id="category-id">
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Nama Kategori</label>
                <input type="text" id="name" required class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Slug</label>
                <input type="text" id="slug" class="block w-full px-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg outline-none focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 transition text-sm" placeholder="otomatis akan diisi jika dikosongkan">
            </div>
            <div class="flex justify-end gap-3 mt-2 border-t border-linear-hairline pt-4">
                <button type="button" onclick="closeModal('category-modal')" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-full text-sm font-semibold transition duration-150">Batal</button>
                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white rounded-full text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let categoryTable;

    $(document).ready(function() {
        categoryTable = $('#manage-category-table').DataTable({
            ajax: { url: `${API_URL}/categories`, dataSrc: 'data' },
            columns: [
                { data: 'name' },
                { data: 'slug', defaultContent: '-' },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        return `
                            <div class="flex gap-1.5 justify-center table-actions">
                                <button onclick='openCategoryModal(${JSON.stringify(data)})' class="p-2 bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100 rounded-lg transition duration-150" title="Edit"><i class="fas fa-edit"></i></button>
                                <button onclick="deleteCategory(${data.id})" class="p-2 bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 rounded-lg transition duration-150" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_-_END_ dari _TOTAL_",
                emptyTable: "Belum ada data kategori"
            },
            responsive: true
        });

        $('#category-form').submit(function(e) {
            e.preventDefault();
            const id = $('#category-id').val();
            const url = id ? `${API_URL}/categories/${id}` : `${API_URL}/categories`;
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    name: $('#name').val(),
                    slug: $('#slug').val()
                },
                success: function() {
                    closeModal('category-modal');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Kategori berhasil disimpan.',
                        icon: 'success',
                        background: '#ffffff',
                        color: '#0d253d',
                        confirmButtonColor: '#533afd'
                    });
                    categoryTable.ajax.reload();
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

    function openCategoryModal(category = null) {
        if (category) {
            $('#modal-title').text('Edit Kategori');
            $('#category-id').val(category.id);
            $('#name').val(category.name);
            $('#slug').val(category.slug);
        } else {
            $('#modal-title').text('Tambah Kategori');
            $('#category-form')[0].reset();
            $('#category-id').val('');
        }
        $('#category-modal').removeClass('hidden');
    }

    function deleteCategory(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: 'Kategori akan dihapus permanen!',
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
                    url: `${API_URL}/categories/${id}`,
                    method: 'DELETE',
                    success: function() {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Kategori telah dihapus.',
                            icon: 'success',
                            background: '#ffffff',
                            color: '#0d253d',
                            confirmButtonColor: '#533afd'
                        });
                        categoryTable.ajax.reload();
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