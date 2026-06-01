<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerpusDigital — Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        linear: { primary: "#533afd", "primary-hover": "#4434d4", ink: "#0d253d", "ink-subtle": "#64748d", canvas: "#f6f9fc" }
                    },
                    borderRadius: { xl: "16px", "2xl": "20px" }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f6f9fc; color: #0d253d; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out both; }
        .animate-fadeIn { animation: fadeIn 0.5s ease-out both; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body class="antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-gradient-to-br from-[#533afd] to-[#7a64ff] rounded-lg flex items-center justify-center text-white shadow-lg shadow-[#533afd]/20">
                    <i class="fas fa-book-open text-sm"></i>
                </div>
                <span class="text-lg font-bold tracking-tight text-slate-800">Perpus<span class="text-[#533afd]">Digital</span></span>
            </a>
            <div class="flex items-center gap-2">
                <a href="/login" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">Masuk</a>
                <a href="/register" class="px-5 py-2 bg-gradient-to-r from-[#533afd] to-[#7a64ff] hover:from-[#4434d4] hover:to-[#6956e8] text-white rounded-full text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="min-h-[90vh] flex items-center pt-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#533afd]/5 via-white to-[#ea2261]/5"></div>
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-[#533afd]/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-[#ea2261]/10 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 animate-fadeInUp">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#533afd]/10 text-[#533afd] rounded-full text-xs font-semibold">
                        <i class="fas fa-graduation-cap"></i> Perpustakaan Digital Kampus
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 leading-tight tracking-tight">
                        Pinjam & Baca<br>
                        <span class="bg-gradient-to-r from-[#533afd] via-[#7a64ff] to-[#ea2261] bg-clip-text text-transparent">Pengetahuan Tanpa Batas</span>
                    </h1>
                    <p class="text-lg text-slate-500 leading-relaxed max-w-lg">
                        Akses ribuan koleksi buku, jurnal, dan e-book kapan saja, di mana saja. 
                        Perpustakaan digital yang dirancang untuk kenyamanan belajar Anda.
                    </p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="/register" class="px-6 py-3 bg-gradient-to-r from-[#533afd] to-[#7a64ff] hover:from-[#4434d4] hover:to-[#6956e8] text-white rounded-full text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 active:scale-[0.97]">
                            Mulai Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                        <a href="/login" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 hover:border-slate-300 rounded-full text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                            Sudah Punya Akun?
                        </a>
                    </div>
                </div>
                <div class="hidden lg:flex justify-center animate-fadeInUp animate-delay-2">
                    <div class="relative">
                        <div class="w-80 h-96 bg-gradient-to-br from-[#533afd] to-[#7a64ff] rounded-2xl shadow-2xl rotate-6 opacity-20 absolute top-4 left-4"></div>
                        <div class="w-80 h-96 bg-white border border-slate-100 rounded-2xl shadow-xl p-6 relative">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                    <div class="w-8 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded flex items-center justify-center text-blue-600 text-xs"><i class="fas fa-book"></i></div>
                                    <div class="flex-1"><p class="text-xs font-semibold text-slate-800">Laskar Pelangi</p><p class="text-[10px] text-slate-400">Andrea Hirata</p></div>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                    <div class="w-8 h-10 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded flex items-center justify-center text-emerald-600 text-xs"><i class="fas fa-book"></i></div>
                                    <div class="flex-1"><p class="text-xs font-semibold text-slate-800">Bumi Manusia</p><p class="text-[10px] text-slate-400">Pramoedya A. Toer</p></div>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                    <div class="w-8 h-10 bg-gradient-to-br from-amber-100 to-amber-200 rounded flex items-center justify-center text-amber-600 text-xs"><i class="fas fa-book"></i></div>
                                    <div class="flex-1"><p class="text-xs font-semibold text-slate-800">Calculus</p><p class="text-[10px] text-slate-400">James Stewart</p></div>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400"><i class="fas fa-check-circle text-emerald-500 mr-1"></i> Tersedia</span>
                                <span class="text-xs font-semibold text-[#533afd]">Katalog Lengkap <i class="fas fa-arrow-right text-[10px] ml-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-16 animate-fadeIn">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center shadow-sm">
                    <p class="text-3xl md:text-4xl font-extrabold text-[#533afd]">500+</p>
                    <p class="text-sm text-slate-500 mt-1">Judul Buku</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center shadow-sm">
                    <p class="text-3xl md:text-4xl font-extrabold text-[#533afd]">1.200+</p>
                    <p class="text-sm text-slate-500 mt-1">Anggota Aktif</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center shadow-sm">
                    <p class="text-3xl md:text-4xl font-extrabold text-[#533afd]">3.000+</p>
                    <p class="text-sm text-slate-500 mt-1">Transaksi</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center shadow-sm">
                    <p class="text-3xl md:text-4xl font-extrabold text-[#533afd]">50+</p>
                    <p class="text-sm text-slate-500 mt-1">E-book PDF</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 animate-fadeInUp">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight">Kenapa <span class="text-[#533afd]">PerpusDigital</span>?</h2>
                <p class="text-slate-500 mt-3">Fitur lengkap yang memudahkan Anda mengelola dan mengakses koleksi perpustakaan.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#533afd]/10 to-[#7a64ff]/10 rounded-2xl flex items-center justify-center text-[#533afd] text-lg mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">Katalog Digital</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Cari buku berdasarkan judul, penulis, atau kategori dengan mudah dan cepat.</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400/20 to-emerald-600/20 rounded-2xl flex items-center justify-center text-emerald-500 text-lg mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">Pinjam Online</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Ajukan peminjaman secara online tanpa perlu datang ke perpustakaan.</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-2xl flex items-center justify-center text-blue-500 text-lg mb-4">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">E-book Digital</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Baca e-book PDF langsung dari browser atau download untuk offline.</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 animate-fadeInUp animate-delay-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400/20 to-amber-600/20 rounded-2xl flex items-center justify-center text-amber-500 text-lg mb-4">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">Riwayat Transaksi</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Pantau status peminjaman, riwayat pengembalian, dan denda secara real-time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-[#533afd] via-[#7a64ff] to-[#ea2261] rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden shadow-2xl animate-fadeInUp">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyek0zNiAyNHYySDI0di0yaDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-5 -left-5 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
                <div class="relative z-10">
                    <i class="fas fa-graduation-cap text-5xl text-white/20 mb-6"></i>
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-3">Siap Menjelajahi Ilmu?</h2>
                    <p class="text-white/70 text-lg mb-8 max-w-lg mx-auto">Daftar sekarang dan mulai perjalanan belajar Anda dengan akses ke ribuan koleksi buku.</p>
                    <a href="/register" class="inline-flex items-center gap-2 bg-white text-[#533afd] hover:bg-slate-50 px-6 py-3 rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 active:scale-[0.97]">
                        Daftar Gratis <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-[#533afd] to-[#7a64ff] rounded-lg flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-book-open text-xs"></i>
                    </div>
                    <span class="text-sm font-bold text-slate-700">PerpusDigital</span>
                </div>
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} PerpusDigital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            // Smooth scroll
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top }, 500);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</body>
</html>