<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Teknisi - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-orange-600">SIMAC Teknisi</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-3 relative flex items-center gap-4">
                        <span class="text-sm text-gray-500">Halo, {{ Auth::user()->nama }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Teknisi</h1>
            <p class="mt-2 text-sm text-gray-600">Selamat datang kembali! Berikut adalah ringkasan pekerjaan Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Card Maintenance -->
            <a href="{{ route('maintenance.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-orange-50 transition duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 group-hover:text-orange-700">Jadwal Maintenance</h5>
                    <div class="p-3 bg-orange-100 rounded-full group-hover:bg-orange-200">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <p class="font-normal text-gray-700">Lihat jadwal maintenance rutin yang ditugaskan kepada Anda.</p>
            </a>

            <!-- Card Perbaikan -->
            <a href="{{ route('perbaikan.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-blue-50 transition duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700">Riwayat Perbaikan</h5>
                    <div class="p-3 bg-blue-100 rounded-full group-hover:bg-blue-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                </div>
                <p class="font-normal text-gray-700">Catat dan kelola data perbaikan kerusakan AC.</p>
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Akun</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ Auth::user()->nama }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ Auth::user()->email }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 uppercase tracking-wide text-orange-600 font-bold">{{ Auth::user()->role }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">No. HP</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ Auth::user()->no_hp ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

</body>
</html>
