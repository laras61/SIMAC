<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIMAC Staff</title>
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
                <div class="flex items-center gap-4">
                    <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-teal-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span class="font-medium">Kembali</span>
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <span class="text-xl font-bold text-teal-800">Profil Saya</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-600 to-teal-800 px-6 py-8 text-center">
                @if($user->foto_profi)
                    <div class="relative w-24 h-24 rounded-full mx-auto mb-4 shadow-lg overflow-hidden border-4 border-white group">
                        <img src="{{ url('/files/' . $user->foto_profi) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        <a href="{{ url('/files/' . $user->foto_profi) }}" target="_blank" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                @else
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-3xl font-bold text-teal-700 uppercase">
                        {{ substr($user->nama, 0, 1) }}
                    </div>
                @endif
                <h2 class="text-2xl font-bold text-white">{{ $user->nama }}</h2>
                <p class="text-teal-100 opacity-90 font-medium uppercase tracking-wider text-sm mt-1">{{ $user->role }}</p>
            </div>

            <div class="p-8">
                <form action="{{ route('user.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                            <div class="flex items-center gap-4">
                                @if($user->foto_profi)
                                    <div class="relative w-16 h-16 rounded-full overflow-hidden border border-gray-200 flex-shrink-0 group">
                                        <img src="{{ url('/files/' . $user->foto_profi) }}" alt="Current Profile" class="w-full h-full object-cover">
                                        <a href="{{ url('/files/' . $user->foto_profi) }}" target="_blank" class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="foto_profi" accept="image/jpeg,image/png,image/jpg" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-all border border-gray-300 rounded-lg cursor-pointer">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                                </div>
                            </div>
                            @error('foto_profi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow">
                            @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow bg-gray-50" readonly>
                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah secara mandiri. Hubungi admin jika perlu perubahan.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow" placeholder="08xxxxxxxxxx">
                            @error('no_hp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="border-t border-gray-100 pt-6 mt-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ganti Password</h3>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4 text-sm text-yellow-800">
                                Kosongkan bagian ini jika tidak ingin mengubah password.
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                                    <input type="password" name="current_password" class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow" placeholder="Masukkan password lama">
                                    @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <input type="password" name="password" class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow" placeholder="Minimal 8 karakter">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 border p-3 focus:ring-teal-500 focus:border-teal-500 transition-shadow" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('staff.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-medium shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#0d9488'
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#0d9488'
            });
        </script>
    @endif
</body>
</html>
