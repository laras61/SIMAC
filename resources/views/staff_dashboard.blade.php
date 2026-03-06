<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">S</div>
                        <span class="text-xl font-bold text-teal-800">SIMAC Staff</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->nama }}</span>
                        <span class="text-xs text-teal-600 uppercase font-bold">{{ Auth::user()->role }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Logout">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="mb-8 bg-gradient-to-r from-teal-700 to-teal-900 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ explode(' ', Auth::user()->nama)[0] }}!</h1>
                <p class="text-teal-100 opacity-90 max-w-xl">Anda berada di dashboard Staff. Kelola aset AC dan pantau jadwal maintenance dengan mudah dari sini.</p>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-12"></div>
            <div class="absolute right-10 bottom-10 w-32 h-32 bg-teal-500/20 rounded-full blur-2xl"></div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <!-- Menu: Data Aset AC -->
            <a href="{{ route('barang.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-teal-600 transition-colors duration-300">
                    <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-teal-700">Data Aset AC</h3>
                <p class="text-sm text-gray-500">Lihat daftar lengkap unit AC dan statusnya.</p>
            </a>

            <!-- Menu: Jadwal Maintenance -->
            <a href="{{ route('maintenance.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors duration-300">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-blue-700">Jadwal Maintenance</h3>
                <p class="text-sm text-gray-500">Cek jadwal pemeliharaan rutin berikutnya.</p>
            </a>

            <!-- Menu: Riwayat Perbaikan -->
            <a href="{{ route('perbaikan.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-600 transition-colors duration-300">
                    <svg class="w-6 h-6 text-orange-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-orange-700">Riwayat Perbaikan</h3>
                <p class="text-sm text-gray-500">Pantau riwayat kerusakan dan perbaikan.</p>
            </a>

             <!-- Menu: Profile User -->
             <a href="{{ route('user.index') }}" class="group bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors duration-300">
                    <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-purple-700">Profil & Akun</h3>
                <p class="text-sm text-gray-500">Kelola informasi akun pengguna.</p>
            </a>

        </div>

        <!-- Quick Stats / Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pesan Sukses Update Profile -->
            @if(session('success'))
            <div class="lg:col-span-2 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Jadwal Maintenance Saya -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Jadwal Maintenance Saya</h3>
                    <a href="{{ route('maintenance.index') }}" class="text-xs text-teal-600 hover:text-teal-800 font-medium">Lihat Semua</a>
                </div>
                <div class="p-6">
                    @if($myMaintenances->isEmpty())
                        <div class="text-center py-8">
                            <div class="bg-gray-50 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Tidak ada jadwal maintenance aktif.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($myMaintenances as $maintenance)
                                <div class="flex items-start gap-4 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 rounded bg-teal-100 text-teal-600 flex items-center justify-center text-xs font-bold">
                                            {{ \Carbon\Carbon::parse($maintenance->tanggal_jadwal)->format('d') }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800">{{ $maintenance->barang->kode_bmn }}</h4>
                                        <p class="text-xs text-gray-500 mb-1">{{ $maintenance->barang->lokasi }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $maintenance->jenis }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Perbaikan Terakhir -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Perbaikan Terakhir</h3>
                    <a href="{{ route('perbaikan.index') }}" class="text-xs text-teal-600 hover:text-teal-800 font-medium">Lihat Semua</a>
                </div>
                <div class="p-6">
                    @if($myRepairs->isEmpty())
                        <div class="text-center py-8">
                            <div class="bg-gray-50 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada riwayat perbaikan.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($myRepairs as $repair)
                                <div class="flex items-start gap-4 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 rounded bg-orange-100 text-orange-600 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800">{{ $repair->barang->kode_bmn }} - {{ $repair->jenis_perbaikan }}</h4>
                                        <p class="text-xs text-gray-500 mb-1">{{ $repair->barang->lokasi }}</p>
                                        <p class="text-xs text-gray-600 line-clamp-1">{{ $repair->deskripsi }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($repair->tanggal_perbaikan)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</body>
</html>
