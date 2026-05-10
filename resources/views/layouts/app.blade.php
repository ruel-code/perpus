<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Digital - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #4f46e5 !important;
            color: white !important;
            border: none !important;
            border-radius: 0.375rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div id="app" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden md:flex flex-col transition-all duration-300">
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">PerpusDigital</span>
            </div>
            
            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-dashboard">
                    <i class="fas fa-chart-pie w-5"></i> Dashboard
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Koleksi</div>
                <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-catalog">
                    <i class="fas fa-search w-5"></i> Katalog Buku
                </a>

                <div class="role-admin role-petugas hidden">
                    <a href="{{ route('books') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-books">
                        <i class="fas fa-book w-5"></i> Manajemen Buku
                    </a>
                </div>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Transaksi</div>
                
                <div class="role-mahasiswa hidden">
                    <a href="{{ route('my-loans') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-my-loans">
                        <i class="fas fa-history w-5"></i> Peminjaman Saya
                    </a>
                </div>

                <div class="role-admin role-petugas hidden">
                    <a href="{{ route('loans') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-loans">
                        <i class="fas fa-exchange-alt w-5"></i> Manajemen Pinjam
                    </a>
                    <a href="{{ route('fines') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800 transition nav-link" id="nav-fines">
                        <i class="fas fa-file-invoice-dollar w-5"></i> Manajemen Denda
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-indigo-800">
                <button onclick="logout()" class="flex items-center gap-3 px-4 py-3 w-full text-left rounded-lg hover:bg-red-600 transition text-red-200">
                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 flex-shrink-0">
                <button class="md:hidden text-gray-500 hover:text-indigo-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900" id="user-name">Loading...</p>
                        <p class="text-xs text-gray-500" id="user-role">...</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold" id="user-initial">
                        U
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const API_URL = '/api';
        const token = localStorage.getItem('auth_token');
        const user = JSON.parse(localStorage.getItem('user'));

        // Check auth
        if (!token && !window.location.pathname.includes('/login') && !window.location.pathname.includes('/register') && window.location.pathname !== '/') {
            window.location.href = '/';
        }

        if (user) {
            $('#user-name').text(user.name);
            $('#user-role').text(user.role.charAt(0).toUpperCase() + user.role.slice(1));
            $('#user-initial').text(user.name.charAt(0));

            // Show role based menus
            if (user.role === 'admin') {
                $('.role-admin').removeClass('hidden');
            } else if (user.role === 'petugas') {
                $('.role-petugas').removeClass('hidden');
            } else if (user.role === 'mahasiswa') {
                $('.role-mahasiswa').removeClass('hidden');
            }
        }

        function logout() {
            $.ajax({
                url: `${API_URL}/logout`,
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}` },
                success: function() {
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    window.location.href = '/';
                },
                error: function() {
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    window.location.href = '/';
                }
            });
        }

        // Global AJAX setup
        $.ajaxSetup({
            headers: { 'Authorization': `Bearer ${token}` }
        });

        // Set active nav
        $(document).ready(function() {
            const path = window.location.pathname;
            $('.nav-link').each(function() {
                if ($(this).attr('href').includes(path) && path !== '/') {
                    $(this).addClass('bg-indigo-700 text-white');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
