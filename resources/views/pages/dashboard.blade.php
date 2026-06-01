@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="relative overflow-hidden bg-gradient-to-br from-linear-primary via-[#7a64ff] to-[#ea2261] rounded-2xl p-6 md:p-8 text-white animate-fadeIn">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyek0zNiAyNHYySDI0di0yaDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-5 -left-5 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-chart-pie text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold tracking-tight">Dashboard</h1>
                        <p class="text-sm text-white/70">Selamat datang di sistem perpustakaan digital</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl px-4 py-2.5">
                    <p class="text-[10px] uppercase tracking-wider text-white/60 font-semibold">Hari ini</p>
                    <p class="text-sm font-semibold" id="current-date"></p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl px-4 py-2.5">
                    <p class="text-[10px] uppercase tracking-wider text-white/60 font-semibold">Role</p>
                    <p class="text-sm font-semibold capitalize" id="display-role-header">{{ auth()->user()->role ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <div class="group bg-white rounded-2xl border border-slate-100 p-5 md:p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-[#533afd]/10 to-[#7a64ff]/10 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-book text-[#533afd]"></i>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 bg-slate-50 px-2.5 py-1 rounded-full">Koleksi</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-3xl font-bold text-slate-800" id="stat-total-books">0</h3>
                <p class="text-sm text-slate-500">Total Buku</p>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-400">Tersedia: <strong class="text-emerald-600 font-semibold" id="stat-available-books">0</strong></span>
                    <span class="text-slate-400">Dipinjam: <strong class="text-amber-600 font-semibold" id="stat-borrowed-books">0</strong></span>
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-2xl border border-slate-100 p-5 md:p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400/20 to-emerald-600/20 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-emerald-500"></i>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 bg-slate-50 px-2.5 py-1 rounded-full">Pengguna</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-3xl font-bold text-slate-800" id="stat-total-members">0</h3>
                <p class="text-sm text-slate-500">Total Anggota</p>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-400">Admin: <strong class="text-slate-700 font-semibold" id="stat-admin-count">0</strong></span>
                    <span class="text-slate-400">User: <strong class="text-slate-700 font-semibold" id="stat-user-count">0</strong></span>
                </div>
            </div>
        </div>

        <div class="group bg-white rounded-2xl border border-slate-100 p-5 md:p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-exchange-alt text-blue-500"></i>
                </div>
                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 bg-slate-50 px-2.5 py-1 rounded-full">Transaksi</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-3xl font-bold text-slate-800" id="stat-active-loans">0</h3>
                <p class="text-sm text-slate-500">Peminjaman Aktif</p>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-400">Dikembalikan: <strong class="text-emerald-600 font-semibold" id="stat-total-returns">0</strong></span>
                    <span class="text-slate-400">Menunggu: <strong class="text-amber-600 font-semibold" id="stat-pending-loans">0</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Chart + Welcome -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-5 md:p-6 shadow-sm animate-fadeInUp animate-delay-300">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-bold text-slate-800">Aktivitas Perpustakaan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik peminjaman & pengembalian 6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5 text-xs">
                        <span class="w-2.5 h-2.5 rounded-sm bg-[#533afd]"></span>
                        <span class="text-slate-500">Pinjam</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs">
                        <span class="w-2.5 h-2.5 rounded-sm bg-[#22c55e]"></span>
                        <span class="text-slate-500">Kembali</span>
                    </div>
                </div>
            </div>
            <div class="relative" style="height: 280px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Welcome & Quick Actions -->
        <div class="space-y-4 md:space-y-6">
            <div class="bg-gradient-to-br from-[#533afd] via-[#7a64ff] to-[#ea2261] rounded-2xl text-white p-6 shadow-sm relative overflow-hidden animate-fadeInUp animate-delay-200">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTI0IDI0djJoLTE2di0yaDE2ek0yNCAxNHYyaC0xNnYtMmgxNnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-30"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/15 backdrop-blur-sm border border-white/20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold tracking-tight mb-1">Halo, <span class="user-display-name text-white">...</span>!</h2>
                    <p class="text-sm text-white/70 mb-5 leading-relaxed">Siap untuk menjelajahi dunia pengetahuan hari ini?</p>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 border border-white/20 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 active:scale-[0.97] w-full justify-center">
                        <i class="fas fa-search"></i> Jelajahi Katalog
                    </a>
                </div>
                <i class="fas fa-book-open absolute -bottom-6 -right-6 text-7xl text-white opacity-5"></i>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm card-hover animate-fadeInUp animate-delay-400">
                <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-bolt text-amber-500 text-xs"></i>
                    Akses Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 hover:text-slate-800 group">
                        <span class="w-8 h-8 bg-[#533afd]/10 rounded-lg flex items-center justify-center text-[#533afd] text-xs group-hover:scale-110 transition-transform">
                            <i class="fas fa-search"></i>
                        </span>
                        Cari Buku
                    </a>
                    <a href="{{ route('my-loans') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 hover:text-slate-800 group">
                        <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 text-xs group-hover:scale-110 transition-transform">
                            <i class="fas fa-history"></i>
                        </span>
                        Riwayat Peminjaman
                    </a>
                    <div class="role-admin hidden">
                        <a href="{{ route('loans') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 hover:text-slate-800 group">
                            <span class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 text-xs group-hover:scale-110 transition-transform">
                                <i class="fas fa-tasks"></i>
                            </span>
                            Kelola Peminjaman
                        </a>
                        <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm text-slate-600 hover:text-slate-800 group">
                            <span class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 text-xs group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Card (Denda) -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm card-hover animate-fadeInUp animate-delay-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Total Denda</p>
                        <h3 class="text-xl font-bold text-red-500 mt-0.5" id="stat-total-fines">Rp 0</h3>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center text-red-500">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-100">
                    <p class="text-xs text-slate-400">Denda yang belum dibayar oleh anggota</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    let activityChart;

    $(document).ready(function() {
        const now = new Date();
        $('#current-date').text(now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
        if ($('#display-role-header').text() === '-') {
            $('#display-role-header').text(user.role);
        }
        $('.user-display-name').text(user.name);

        $.get(`${API_URL}/dashboard/stats`, function(res) {
            const d = res.data;
            $('#stat-total-books').text(d.total_books);
            $('#stat-available-books').text(d.total_available);
            $('#stat-borrowed-books').text(d.active_loans);
            $('#stat-total-members').text(d.total_members);
            $('#stat-admin-count').text(d.admin_count);
            $('#stat-user-count').text(d.user_count);
            $('#stat-active-loans').text(d.active_loans);
            $('#stat-total-returns').text(d.total_returns);
            $('#stat-pending-loans').text(d.pending_loans);
            $('#stat-total-fines').text('Rp ' + parseInt(d.total_fines).toLocaleString('id-ID'));
        });

        $.get(`${API_URL}/dashboard/chart`, function(res) {
            const d = res.data;
            const ctx = document.getElementById('activityChart').getContext('2d');

            if (activityChart) activityChart.destroy();

            const gradient1 = ctx.createLinearGradient(0, 0, 0, 250);
            gradient1.addColorStop(0, '#533afd');
            gradient1.addColorStop(1, '#7a64ff');

            const gradient2 = ctx.createLinearGradient(0, 0, 0, 250);
            gradient2.addColorStop(0, '#22c55e');
            gradient2.addColorStop(1, '#4ade80');

            activityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: d.months,
                    datasets: [
                        {
                            label: 'Peminjaman',
                            data: d.loans,
                            backgroundColor: gradient1,
                            borderRadius: 8,
                            borderSkipped: false,
                            barPercentage: 0.4,
                            categoryPercentage: 0.7
                        },
                        {
                            label: 'Pengembalian',
                            data: d.returns,
                            backgroundColor: gradient2,
                            borderRadius: 8,
                            borderSkipped: false,
                            barPercentage: 0.4,
                            categoryPercentage: 0.7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Inter', size: 12 },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#94a3b8',
                                font: { size: 11, family: 'Inter' }
                            },
                            grid: { color: '#f1f5f9', drawBorder: false }
                        },
                        x: {
                            ticks: {
                                color: '#94a3b8',
                                font: { size: 11, family: 'Inter' }
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    });
</script>
@endpush