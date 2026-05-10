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
</head>
<body class="bg-indigo-50 h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg">
                <i class="fas fa-book-open text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat Datang</h1>
            <p class="text-gray-500">Masuk ke Perpustakaan Digital Kampus</p>
        </div>

        <form id="login-form" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" id="email" required class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition" placeholder="admin@perpus.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="password" required class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 outline-none transition" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-xl transition shadow-md hover:shadow-lg">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar Mahasiswa</a></p>
        </div>
    </div>

    <script>
        if (localStorage.getItem('auth_token')) {
            window.location.href = '/dashboard';
        }

        $('#login-form').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button');
            btn.prop('disabled', true).text('Memproses...');

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
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/dashboard';
                    });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Masuk Sekarang');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem'
                    });
                }
            });
        });
    </script>
</body>
</html>
