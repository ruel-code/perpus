<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PerpusDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                            canvas: "#f6f9fc",
                            "surface-1": "#ffffff",
                            "surface-2": "#f1f5f9",
                            hairline: "#e3e8ee",
                            "hairline-strong": "#cbd5e1"
                        }
                    },
                    borderRadius: {
                        xs: "4px", sm: "6px", md: "8px", lg: "12px", xl: "16px"
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; -webkit-tap-highlight-color: transparent; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6f9fc;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes gradientShift { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out both; }
        .animate-fadeIn { animation: fadeIn 0.8s ease-out both; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-gradient { background-size: 200% 200%; animation: gradientShift 4s ease infinite; }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .card-hover { transition: all 0.25s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,55,112,0.1), 0 2px 6px rgba(0,55,112,0.04); }
        input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px white inset !important; }
    </style>
</head>
<body class="bg-linear-canvas text-linear-ink min-h-screen flex items-center justify-center p-4 antialiased relative overflow-hidden">
    <!-- Animated background decoration -->
    <div class="absolute top-0 inset-x-0 h-96 bg-gradient-to-tr from-[#533afd]/10 via-[#ea2261]/5 to-[#f5e9d4]/20 blur-3xl -z-10 animate-gradient"></div>
    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-[#533afd]/5 rounded-full blur-3xl -z-10 animate-float"></div>
    <div class="absolute -top-20 -right-20 w-72 h-72 bg-[#ea2261]/5 rounded-full blur-3xl -z-10 animate-float" style="animation-delay: 2s;"></div>

    <div class="bg-linear-surface-1 p-8 rounded-xl border border-linear-hairline w-full max-w-md shadow-[rgba(0,55,112,0.08)_0_8px_24px,rgba(0,55,112,0.04)_0_2px_6px] card-hover animate-fadeInUp">
        <div class="text-center mb-8 animate-fadeInUp animate-delay-1">
            <div class="w-14 h-14 bg-gradient-to-br from-linear-primary to-[#7a64ff] rounded-xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg shadow-[#533afd]/20">
                <i class="fas fa-book-open text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-linear-ink tracking-tight mb-1.5">Selamat Datang</h1>
            <p class="text-sm text-linear-ink-subtle">Masuk ke Perpustakaan Digital Kampus</p>
        </div>

        <form id="login-form" class="space-y-5 animate-fadeInUp animate-delay-2">
            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Email</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-linear-ink-subtle transition-colors duration-200 group-focus-within:text-linear-primary">
                        <i class="fas fa-envelope text-sm"></i>
                    </span>
                    <input type="email" id="email" autocomplete="email" required class="block w-full pl-10 pr-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 outline-none transition duration-200 placeholder-linear-ink-subtle/50 text-sm" placeholder="admin@perpus.com">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-linear-ink-muted mb-1.5 uppercase tracking-wider">Password</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-linear-ink-subtle transition-colors duration-200 group-focus-within:text-linear-primary">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" id="password" autocomplete="current-password" required class="block w-full pl-10 pr-3.5 py-2.5 bg-white text-linear-ink border border-linear-hairline rounded-lg focus:border-linear-primary focus:ring-2 focus:ring-linear-primary/15 outline-none transition duration-200 placeholder-linear-ink-subtle/50 text-sm" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-linear-primary to-[#7a64ff] hover:from-linear-primary-hover hover:to-[#6956e8] text-white text-sm font-semibold py-2.5 rounded-full transition-all duration-200 shadow-md hover:shadow-lg hover:shadow-[#533afd]/20 focus:outline-none focus:ring-2 focus:ring-linear-primary/30 mt-2 active:scale-[0.98]" style="position:relative;overflow:hidden;">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center border-t border-linear-hairline pt-6 animate-fadeInUp animate-delay-3">
            <p class="text-linear-ink-subtle text-xs">Belum punya akun? <a href="{{ route('register') }}" class="text-linear-primary font-medium hover:text-linear-primary-hover transition duration-150 hover:underline">Daftar Mahasiswa</a></p>
        </div>
    </div>

    <script>
        if (localStorage.getItem('auth_token')) {
            window.location.href = '/dashboard';
        }

        $('#login-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');

            $.ajax({
                url: '/api/login',
                method: 'POST',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    localStorage.setItem('auth_token', response.data.access_token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Login!',
                        text: 'Selamat datang kembali, ' + response.data.user.name,
                        timer: 1500,
                        showConfirmButton: false,
                        background: '#ffffff',
                        color: '#0d253d',
                        confirmButtonColor: '#533afd'
                    }).then(() => {
                        window.location.href = '/dashboard';
                    });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Masuk Sekarang');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem',
                        background: '#ffffff',
                        color: '#0d253d',
                        confirmButtonColor: '#533afd'
                    });
                }
            });
        });
    </script>
</body>
</html>