@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500" id="current-date"></p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Buku</p>
                <h3 class="text-2xl font-bold" id="stat-total-books">0</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Buku Tersedia</p>
                <h3 class="text-2xl font-bold" id="stat-available-books">0</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pinjaman Aktif</p>
                <h3 class="text-2xl font-bold" id="stat-active-loans">0</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Denda Belum Bayar</p>
                <h3 class="text-2xl font-bold" id="stat-unpaid-fines">0</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Halo, <span class="user-display-name">...</span>!</h2>
                <p class="text-indigo-100 mb-6">Siap untuk menjelajahi dunia pengetahuan hari ini? Koleksi buku kami selalu siap menantimu.</p>
                <a href="{{ route('catalog') }}" class="bg-white text-indigo-600 px-6 py-2 rounded-xl font-bold hover:bg-indigo-50 transition">
                    Lihat Katalog
                </a>
            </div>
            <i class="fas fa-graduation-cap absolute -bottom-10 -right-10 text-9xl text-indigo-500 opacity-20"></i>
        </div>

        <!-- Role Info -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-900 mb-4">Informasi Akun</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                    <span class="text-gray-500">Status Akun</span>
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold uppercase tracking-wide">Aktif</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                    <span class="text-gray-500">Role</span>
                    <span class="font-bold text-gray-700" id="display-role">...</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Email Terdaftar</span>
                    <span class="font-medium text-gray-700" id="display-email">...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#current-date').text(new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
        $('.user-display-name').text(user.name);
        $('#display-role').text(user.role.charAt(0).toUpperCase() + user.role.slice(1));
        $('#display-email').text(user.email);

        // Fetch stats (Mock for now since we don't have a stats endpoint, but I'll fetch from resources)
        $.get(`${API_URL}/books`, function(res) {
            $('#stat-total-books').text(res.data.length);
            let available = 0;
            res.data.forEach(b => available += b.available_stock);
            $('#stat-available-books').text(available);
        });

        $.get(`${API_URL}/loans?status=dipinjam`, function(res) {
            $('#stat-active-loans').text(res.data.length);
        });

        $.get(`${API_URL}/fines`, function(res) {
            let unpaid = res.data.filter(f => f.payment_status === 'unpaid').length;
            $('#stat-unpaid-fines').text(unpaid);
        });
    });
</script>
@endpush
