<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMAC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login SIMAC</h2>
        
        <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-4">
            <div>
                <label for="login_id" class="block text-sm font-medium text-gray-700">Email atau Username</label>
                <input type="text" id="login_id" name="login_id" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div id="errorMessage" class="text-red-500 text-sm hidden"></div>

            <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign in
            </button>
        </form>
    </div>

    <script>
        async function handleLogin(e) {
            e.preventDefault();
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.classList.add('hidden');
            errorMessage.textContent = '';

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
                    window.location.href = "{{ route('barang.index') }}"; 
                } else {
                    errorMessage.textContent = data.message || 'Login gagal. Silakan coba lagi.';
                    errorMessage.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
                errorMessage.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>