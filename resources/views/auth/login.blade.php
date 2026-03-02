<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMAC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            margin: 0; 
            min-height: 100vh; 
            font-family: 'Poppins', sans-serif; 
            background: #ffffff; 
            overflow: hidden; 
            position: relative; 
        } 
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all hover:shadow-xl hover:scale-[1.01] duration-300 ring-1 ring-orange-50">
        <div class="bg-gradient-to-r from-orange-400 to-amber-400 p-8 text-center relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-full bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
            <h2 class="text-3xl font-extrabold text-white tracking-wide relative z-10 drop-shadow-sm">SIMAC</h2>
            <p class="text-orange-50 mt-2 text-sm font-medium tracking-wider uppercase relative z-10">Sistem Manajemen AC</p>
            
            <!-- Decorative circles -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-10 rounded-full blur-xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white opacity-10 rounded-full blur-xl group-hover:scale-110 transition-transform duration-700 delay-100"></div>
        </div>

        <div class="p-8">
            <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-6">
                <div>
                    <label for="login_id" class="block text-sm font-semibold text-orange-600 mb-1 transition-all duration-300 group-focus-within:text-orange-800 group-focus-within:translate-x-1">Email atau Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" id="login_id" name="login_id" required 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 focus:outline-none transition duration-200 ease-in-out sm:text-sm bg-gray-50 focus:bg-white placeholder-gray-400"
                            placeholder="Masukkan email atau username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-orange-600 mb-1 transition-all duration-300 group-focus-within:text-orange-800 group-focus-within:translate-x-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required 
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 focus:outline-none transition duration-200 ease-in-out sm:text-sm bg-gray-50 focus:bg-white placeholder-gray-400"
                            placeholder="Masukkan password">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-600 focus:outline-none transition-colors duration-200">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="errorMessage" class="bg-red-50 border-l-4 border-red-500 p-4 text-red-700 text-sm hidden rounded-r animate-pulse"></div>

                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg active:scale-95">
                    Sign in
                </button>
            </form>
        </div>
        <div class="bg-orange-50 px-8 py-4 border-t border-orange-100">
            <p class="text-xs text-center text-orange-600/70 font-medium">&copy; {{ date('Y') }} SIMAC. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        async function handleLogin(e) {
            e.preventDefault();
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.classList.add('hidden');
            errorMessage.textContent = '';
            
            // Add loading state to button
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Signing in...';

            const formData = new FormData(e.target);
            
            try {
                const response = await fetch("{{ route('login.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Redirect to dashboard or intended page
                    window.location.href = "{{ route('dashboard') }}"; 
                } else {
                    errorMessage.textContent = data.message || 'Login gagal. Silakan coba lagi.';
                    errorMessage.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
                errorMessage.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    </script>
</body>
</html>