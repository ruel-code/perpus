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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        linear: {
                            primary: "#533afd",
                            "primary-hover": "#4434d4",
                            "primary-focus": "#2e2b8c",
                            ink: "#0d253d",
                            "ink-muted": "#273951",
                            "ink-subtle": "#64748d",
                            "ink-tertiary": "#a1a4a5",
                            canvas: "#f6f9fc",
                            "surface-1": "#ffffff",
                            "surface-2": "#f1f5f9",
                            "surface-3": "#e2e8f0",
                            "surface-4": "#cbd5e1",
                            hairline: "#e3e8ee",
                            "hairline-strong": "#cbd5e1",
                            "hairline-tertiary": "#94a3b8",
                            "inverse-canvas": "#000000",
                            "inverse-ink": "#ffffff",
                            "brand-secure": "#533afd",
                            "semantic-success": "#22c55e",
                            "semantic-overlay": "rgba(15, 23, 42, 0.5)"
                        }
                    },
                    borderRadius: {
                        xs: "4px",
                        sm: "6px",
                        md: "8px",
                        lg: "12px",
                        xl: "16px"
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        *, *::before, *::after { box-sizing: border-box; }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f6f9fc;
            color: #0d253d;
        }
        
        /* Smooth scroll & tap highlights */
        html { scroll-behavior: smooth; -webkit-tap-highlight-color: transparent; }

        /* ===== Animations ===== */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes pulseSoft { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        @keyframes ripple { to { transform: scale(4); opacity: 0; } }

        .animate-fadeIn { animation: fadeIn 0.4s ease-out both; }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out both; }
        .animate-fadeInDown { animation: fadeInDown 0.4s ease-out both; }
        .animate-scaleIn { animation: scaleIn 0.3s ease-out both; }
        .animate-slideInLeft { animation: slideInLeft 0.4s ease-out both; }
        .animate-slideInRight { animation: slideInRight 0.4s ease-out both; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradientShift 4s ease infinite; }
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }
        .animate-delay-500 { animation-delay: 0.5s; }

        /* Card hover lift */
        .card-hover { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0, 55, 112, 0.08), 0 2px 6px rgba(0, 55, 112, 0.04); }

        /* Button ripple effect */
        .btn-ripple { position: relative; overflow: hidden; }
        .btn-ripple::after { content: ''; position: absolute; inset: 0; background: rgba(255,255,255,0.3); border-radius: inherit; transform: scale(0); opacity: 1; }
        .btn-ripple:active::after { animation: ripple 0.4s ease-out; }

        /* Shimmer loading */
        .shimmer { background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 6px; }

        /* Skeleton loading cards */
        .skeleton { background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 8px; }

        /* Modal animations */
        .modal-overlay { transition: opacity 0.25s ease; }
        .modal-content { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .modal-overlay:not(.hidden) ~ .modal-content { animation: scaleIn 0.3s ease-out; }

        /* Sidebar slide */
        .sidebar-mobile { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-overlay { transition: opacity 0.3s ease; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* SweetAlert */
        .swal2-popup {
            background-color: #ffffff !important;
            border: 1px solid #e3e8ee !important;
            color: #0d253d !important;
            border-radius: 12px !important;
            box-shadow: rgba(0, 55, 112, 0.08) 0 8px 24px, rgba(0, 55, 112, 0.04) 0 2px 6px !important;
        }
        .swal2-title { color: #0d253d !important; }
        .swal2-html-container { color: #273951 !important; }
        .swal2-confirm {
            background-color: #533afd !important;
            color: #ffffff !important;
            border-radius: 9999px !important;
            font-weight: 500 !important;
            padding: 8px 18px !important;
        }
        .swal2-cancel {
            background-color: #ffffff !important;
            border: 1px solid #e3e8ee !important;
            color: #273951 !important;
            border-radius: 9999px !important;
            font-weight: 500 !important;
            padding: 8px 18px !important;
        }

        /* DataTables */
        .dataTables_wrapper { color: #0d253d !important; }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate { color: #273951 !important; font-size: 13px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #64748d !important;
            border: 1px solid transparent !important;
            border-radius: 9999px !important;
            transition: all 0.15s ease !important;
            padding: 4px 12px !important;
            font-weight: 500 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f1f5f9 !important; color: #0d253d !important; border: 1px solid #e3e8ee !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background: #533afd !important; color: #ffffff !important; border: 1px solid #533afd !important; }
        table.dataTable {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            width: 100% !important;
            margin: 1rem 0 !important;
            background-color: #ffffff !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        table.dataTable thead th {
            background-color: #f8fafc !important;
            color: #0d253d !important;
            font-weight: 600 !important;
            border-bottom: 1px solid #e3e8ee !important;
            padding: 12px 16px !important;
            font-size: 12px !important;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        table.dataTable tbody tr { background-color: #ffffff !important; color: #273951 !important; transition: background-color 0.15s ease !important; }
        table.dataTable tbody tr:hover { background-color: #f1f5f9 !important; }
        table.dataTable tbody tr:last-child td { border-bottom: none !important; }
        table.dataTable tbody td { padding: 14px 16px !important; border-bottom: 1px solid #f1f5f9 !important; }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: #ffffff !important;
            color: #0d253d !important;
            border: 1px solid #e3e8ee !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            outline: none !important;
            font-size: 13px !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #533afd !important;
            box-shadow: 0 0 0 3px rgba(83, 58, 253, 0.12) !important;
        }

        /* Page transition */
        .page-enter { animation: fadeInUp 0.4s ease-out both; }

        /* Table row actions fade */
        .table-actions { opacity: 0.6; transition: opacity 0.2s ease; }
        tr:hover .table-actions { opacity: 1; }

        /* Status badge pulse for active states */
        .badge-pulse { position: relative; }
        .badge-pulse::before { content: ''; position: absolute; inset: -2px; border-radius: inherit; background: currentColor; opacity: 0.15; animation: pulseSoft 2s infinite; }
    </style>
</head>
<body class="bg-linear-canvas text-linear-ink antialiased">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden opacity-0 md:hidden" onclick="toggleSidebar()"></div>

    <div id="app" class="flex h-screen overflow-hidden">
        <!-- Sidebar (desktop: static, mobile: overlay) -->
        <aside id="sidebar" class="sidebar-mobile fixed md:static inset-y-0 left-0 z-50 w-64 bg-[#0d253d] border-r border-[#1c3554] text-slate-300 flex-shrink-0 flex-col -translate-x-full md:translate-x-0 md:flex transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]">
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#533afd] to-[#7a64ff] rounded-lg flex items-center justify-center text-white shadow-lg shadow-[#533afd]/20">
                    <i class="fas fa-book-open text-lg"></i>
                </div>
                <span class="text-base font-semibold tracking-tight text-white">PerpusDigital</span>
                <button onclick="toggleSidebar()" class="md:hidden ml-auto text-slate-400 hover:text-white transition"><i class="fas fa-times"></i></button>
            </div>
            
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-dashboard">
                    <i class="fas fa-chart-pie w-5 text-slate-400"></i> Dashboard
                </a>

                <div class="pt-4 pb-1.5 px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Data Master</div>

                <a href="{{ route('catalog') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-catalog">
                    <i class="fas fa-search w-5 text-slate-400"></i> Katalog Buku
                </a>

                <div class="role-admin hidden">
                    <a href="{{ route('books') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-books">
                        <i class="fas fa-book w-5 text-slate-400"></i> Manajemen Buku
                    </a>
                    <a href="{{ route('categories') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-categories">
                        <i class="fas fa-tags w-5 text-slate-400"></i> Manajemen Kategori
                    </a>
                    <a href="{{ route('users') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-users">
                        <i class="fas fa-users w-5 text-slate-400"></i> Manajemen Anggota
                    </a>
                </div>

                <div class="pt-4 pb-1.5 px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Transaksi</div>

                <div class="role-user hidden">
                    <a href="{{ route('my-loans') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-my-loans">
                        <i class="fas fa-history w-5 text-slate-400"></i> Peminjaman Saya
                    </a>
                </div>

                <div class="role-admin hidden">
                    <a href="{{ route('loans') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-loans">
                        <i class="fas fa-exchange-alt w-5 text-slate-400"></i> Manajemen Pinjam
                    </a>
                    <a href="{{ route('fines') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-fines">
                        <i class="fas fa-file-invoice-dollar w-5 text-slate-400"></i> Manajemen Denda
                    </a>
                </div>

                <div class="pt-4 pb-1.5 px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Laporan</div>
                <div class="role-admin hidden">
                    <a href="{{ route('reports') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-reports">
                        <i class="fas fa-file-alt w-5 text-slate-400"></i> Laporan Perpustakaan
                    </a>
                </div>

                <div class="pt-4 pb-1.5 px-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pengaturan</div>
                <div class="role-admin hidden">
                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-md hover:bg-white/5 hover:text-white transition duration-150 nav-link text-sm font-medium text-slate-300" id="nav-settings">
                        <i class="fas fa-cog w-5 text-slate-400"></i> Pengaturan Sistem
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-[#1c3554]">
                <button onclick="logout()" class="flex items-center gap-3 px-4 py-2.5 w-full text-left rounded-md hover:bg-red-500/10 hover:text-red-400 transition duration-150 text-slate-400 text-sm font-medium">
                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-linear-canvas">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-linear-hairline h-16 flex items-center justify-between px-4 md:px-6 flex-shrink-0 sticky top-0 z-30 animate-fadeInDown">
                <button onclick="toggleSidebar()" class="md:hidden w-9 h-9 flex items-center justify-center text-linear-ink-subtle hover:text-linear-primary hover:bg-linear-surface-2 rounded-lg transition duration-150">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <div class="flex items-center gap-4 ml-auto">
                    <div class="text-right">
                        <p class="text-sm font-medium text-linear-ink" id="user-name">Loading...</p>
                        <p class="text-xs text-linear-ink-subtle" id="user-role">...</p>
                    </div>
                    <a href="{{ route('profile') }}" class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border-2 border-white shadow-sm block">
                        <div class="w-full h-full bg-gradient-to-br from-linear-primary to-[#7a64ff] flex items-center justify-center text-white font-semibold text-sm" id="user-initial">
                            <span id="user-initial-text">U</span>
                        </div>
                        <img id="user-avatar-img" class="w-full h-full object-cover hidden" src="" alt="">
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4 md:p-6 page-enter">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const API_URL = '/api';
        const token = localStorage.getItem('auth_token');
        const user = JSON.parse(localStorage.getItem('user'));

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay.classList.toggle('hidden', isOpen);
            overlay.classList.toggle('opacity-0', isOpen);
            document.body.style.overflow = isOpen ? '' : 'hidden';
            if (!isOpen) { setTimeout(() => overlay.classList.remove('opacity-0'), 10); }
        }

        // Check auth
        if (!token && !window.location.pathname.includes('/login') && !window.location.pathname.includes('/register') && window.location.pathname !== '/') {
            window.location.href = '/';
        }

        if (user) {
            $('#user-name').text(user.name);
            $('#user-role').text(user.role.charAt(0).toUpperCase() + user.role.slice(1));
            $('#user-initial-text').text(user.name.charAt(0));
            if (user.photo) {
                $('#user-avatar-img').attr('src', `${API_URL.replace('/api','')}/storage/${user.photo}`).removeClass('hidden');
                $('#user-initial').addClass('hidden');
            }

            if (user.role === 'admin') {
                $('.role-admin').removeClass('hidden');
            } else {
                $('.role-user').removeClass('hidden');
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

        if ($.fn.dataTable) {
            $.fn.dataTable.ext.errMode = 'throw';
        }

        $.ajaxSetup({
            headers: { 
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        $(document).ajaxError(function(event, xhr, settings) {
            if (xhr.status === 401) {
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');
                window.location.href = '/';
            }
        });

        $(document).ready(function() {
            const path = window.location.pathname;
            $('.nav-link').each(function() {
                if ($(this).attr('href').includes(path) && path !== '/') {
                    $(this).addClass('bg-white/10 text-white border-l-2 border-linear-primary').removeClass('hover:bg-white/5');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
