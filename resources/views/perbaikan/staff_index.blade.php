<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perbaikan Saya - SIMAC Staff</title>
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
                    <span class="text-xl font-bold text-teal-800">Riwayat Perbaikan</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Form Lapor Perbaikan Baru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 bg-orange-50 flex justify-between items-center">
                <h3 class="font-bold text-orange-800 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Lapor Perbaikan Baru
                </h3>
            </div>
            <div class="p-6">
                <form id="laporForm" action="{{ route('perbaikan.insert') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" value="baru">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Aset AC <span class="text-red-500">*</span></label>
                            <select name="id_ac" required class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">-- Pilih AC --</option>
                                @foreach($listBarang as $barang)
                                    <option value="{{ $barang->id_ac }}">{{ $barang->kode_bmn }} - {{ $barang->merk }} ({{ $barang->lokasi }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kerusakan/Lapor <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_perbaikan" required value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kerusakan <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_perbaikan" required placeholder="Contoh: AC Bocor, Tidak Dingin" class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                            <select name="id_vendor" class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">-</option>
                                @foreach($listVendors as $vendor)
                                    <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Biaya</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="text" id="biaya_display" class="block w-full rounded-md border-gray-300 pl-10 focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border" placeholder="0">
                                <input type="hidden" name="biaya" id="biaya_actual">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Detail <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" required rows="2" placeholder="Jelaskan kondisi kerusakan..." class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                            <input id="fotoCreateInput" type="file" name="foto" accept="image/jpeg,image/png,image/jpg" class="w-full rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                            <a id="fotoCreateLink" href="#" target="_blank" rel="noopener" class="hidden mt-3 inline-block">
                                <img id="fotoCreatePreview" src="" alt="Preview foto" class="h-32 w-auto rounded-lg border border-gray-200">
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 font-medium shadow-sm transition-colors">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="font-bold text-gray-800">Riwayat Perbaikan Saya</h3>
                
                <!-- Filter Status -->
                <form action="{{ route('perbaikan.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border-gray-300 border p-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Semua Status</option>
                        <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>
            </div>
            
            @if($items->isEmpty())
                <div class="p-10 text-center">
                    <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat</h3>
                    <p class="text-gray-500 mt-1">Anda belum pernah melaporkan kerusakan AC.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset AC</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kerusakan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->barang->kode_bmn }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->barang->lokasi }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->jenis_perbaikan }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $item->deskripsi }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ optional($item->vendor)->nama_vendor ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($item->foto)
                                        <a href="{{ url('/files/' . $item->foto) }}" target="_blank" rel="noopener">
                                            <img src="{{ url('/files/' . $item->foto) }}" alt="Foto" class="h-10 w-10 object-cover rounded border border-gray-200">
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($item->biaya)
                                        Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'selesai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @elseif($item->status == 'proses')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Baru/Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <!-- Tombol Detail -->
                                        <button
                                            type="button"
                                            onclick="openDetailModal(this)"
                                            data-tanggal-perbaikan="{{ $item->tanggal_perbaikan ? \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('Y-m-d') : '' }}"
                                            data-kode-bmn="{{ $item->barang->kode_bmn }}"
                                            data-lokasi="{{ $item->barang->lokasi }}"
                                            data-jenis-perbaikan="{{ $item->jenis_perbaikan }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-vendor-nama="{{ optional($item->vendor)->nama_vendor ?? '-' }}"
                                            data-biaya="{{ $item->biaya ? 'Rp ' . number_format($item->biaya, 0, ',', '.') : '-' }}"
                                            data-status="{{ $item->status }}"
                                            data-foto="{{ $item->foto ? url('/files/' . $item->foto) : '' }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors"
                                            title="Lihat detail perbaikan"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @if($item->status != 'selesai')
                                            <button onclick="openUpdateModal('{{ $item->id_perbaikan }}', '{{ $item->barang->kode_bmn }}', '{{ $item->status }}', '{{ $item->tanggal_perbaikan }}', '{{ $item->biaya }}', '{{ addslashes($item->deskripsi) }}', '{{ $item->id_vendor }}', '{{ addslashes($item->foto) }}')" 
                                                class="text-orange-600 hover:text-orange-900 font-bold text-sm bg-orange-50 px-3 py-1 rounded-md border border-orange-200">
                                                Update
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-sm flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesai
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Perbaikan -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="detail-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDetailModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-5 pt-5 pb-4 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900" id="detail-modal-title">Detail Perbaikan</h3>
                        <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600" aria-label="Tutup detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Tanggal Perbaikan</p>
                            <p id="detailTanggal" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <p id="detailStatus" class="font-medium text-gray-900 capitalize">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kode Aset</p>
                            <p id="detailKode" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Lokasi</p>
                            <p id="detailLokasi" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Jenis Kerusakan</p>
                            <p id="detailJenis" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Vendor</p>
                            <p id="detailVendor" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Biaya</p>
                            <p id="detailBiaya" class="font-medium text-gray-900">-</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-gray-500">Deskripsi Kerusakan</p>
                            <p id="detailDeskripsi" class="font-medium text-gray-900 whitespace-pre-line">-</p>
                        </div>
                        <div class="sm:col-span-2" id="detailFotoContainer">
                            <p class="text-gray-500 mb-2">Foto Dokumentasi</p>
                            <img id="detailFoto" src="" alt="Foto Perbaikan" class="w-full max-h-64 object-contain rounded-lg border border-gray-200">
                            <p id="detailNoFoto" class="text-gray-400 italic hidden">Tidak ada foto.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3 text-right">
                    <button type="button" onclick="closeDetailModal()" class="inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Perbaikan -->
    <div id="updateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeUpdateModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="updateForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Update Laporan Perbaikan</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Perbarui status dan biaya perbaikan untuk aset <span id="modalAsetName" class="font-bold"></span>.</p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Perbaikan <span class="text-red-500">*</span></label>
                                            <select name="status" id="modalStatus" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm border p-2">
                                                <option value="baru">Baru / Pending</option>
                                                <option value="proses">Sedang Diproses</option>
                                                <option value="selesai">Selesai</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Biaya (Rp)</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                                </div>
                                                <input type="text" id="modal_biaya_display" class="block w-full rounded-md border-gray-300 pl-10 focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-2 border" placeholder="0">
                                                <input type="hidden" name="biaya" id="modal_biaya_actual">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perbaikan <span class="text-red-500">*</span></label>
                                            <input type="date" name="tanggal_perbaikan" id="modalTanggalPerbaikan" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm border p-2">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                                            <select name="id_vendor" id="modalVendor" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm border p-2">
                                                <option value="">-</option>
                                                @foreach($listVendors as $vendor)
                                                    <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_vendor }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                                            <input id="fotoUpdateInput" type="file" name="foto" accept="image/jpeg,image/png,image/jpg" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm border p-2">
                                            <a id="fotoUpdateLink" href="#" target="_blank" rel="noopener" class="hidden mt-3 inline-block">
                                                <img id="fotoUpdatePreview" src="" alt="Preview foto" class="h-32 w-auto rounded-lg border border-gray-200">
                                            </a>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Deskripsi</label>
                                            <textarea name="deskripsi" id="modalDeskripsi" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm border p-2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                        <button type="button" onclick="closeUpdateModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
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
    <script>
        function formatDateId(value) {
            if (!value) return '-';
            const date = new Date(value);
            if (Number.isNaN(date.getTime())) return value;
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        function openDetailModal(button) {
            const data = button.dataset;
            
            document.getElementById('detailTanggal').textContent = formatDateId(data.tanggalPerbaikan);
            document.getElementById('detailStatus').textContent = data.status || '-';
            document.getElementById('detailKode').textContent = data.kodeBmn || '-';
            document.getElementById('detailLokasi').textContent = data.lokasi || '-';
            document.getElementById('detailJenis').textContent = data.jenisPerbaikan || '-';
            document.getElementById('detailVendor').textContent = data.vendorNama || '-';
            document.getElementById('detailBiaya').textContent = data.biaya || '-';
            document.getElementById('detailDeskripsi').textContent = data.deskripsi || '-';

            const fotoImg = document.getElementById('detailFoto');
            const noFoto = document.getElementById('detailNoFoto');
            
            if (data.foto) {
                fotoImg.src = data.foto;
                fotoImg.classList.remove('hidden');
                noFoto.classList.add('hidden');
            } else {
                fotoImg.src = '';
                fotoImg.classList.add('hidden');
                noFoto.classList.remove('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        const biayaDisplay = document.getElementById('biaya_display');
        const biayaActual = document.getElementById('biaya_actual');

        biayaDisplay.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            biayaActual.value = value;
            if (value) {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }
        });

        // Konfirmasi Submit Laporan Baru
        document.getElementById('laporForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: 'Kirim Laporan?',
                text: "Pastikan data kerusakan yang Anda masukkan sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea580c', // orange-600
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kirim Laporan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Modal Logic
        const modalBiayaDisplay = document.getElementById('modal_biaya_display');
        const modalBiayaActual = document.getElementById('modal_biaya_actual');

        modalBiayaDisplay.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            modalBiayaActual.value = value;
            if (value) {
                this.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                this.value = '';
            }
        });

        function openUpdateModal(id, asetName, status, tanggalPerbaikan, biaya, deskripsi, vendorId, fotoPath) {
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('updateForm').action = `/perbaikan/update/${id}`;
            document.getElementById('modalAsetName').textContent = asetName;
            document.getElementById('modalStatus').value = status;
            document.getElementById('modalDeskripsi').value = deskripsi;
            document.getElementById('modalVendor').value = vendorId || '';
            document.getElementById('modalTanggalPerbaikan').value = tanggalPerbaikan || '';

            const fotoLink = document.getElementById('fotoUpdateLink');
            const fotoPreview = document.getElementById('fotoUpdatePreview');
            if (fotoLink && fotoPreview) {
                if (fotoPath) {
                    const url = `{{ url('/files') }}/${fotoPath}`;
                    fotoPreview.src = url;
                    fotoLink.href = url;
                    fotoLink.classList.remove('hidden');
                } else {
                    fotoPreview.src = '';
                    fotoLink.href = '#';
                    fotoLink.classList.add('hidden');
                }
            }
            
            if (biaya) {
                modalBiayaActual.value = biaya;
                modalBiayaDisplay.value = new Intl.NumberFormat('id-ID').format(biaya);
            } else {
                modalBiayaActual.value = '';
                modalBiayaDisplay.value = '';
            }
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }

        (function initFotoPreview() {
            const bindPreview = (inputId, linkId, imgId) => {
                const input = document.getElementById(inputId);
                const link = document.getElementById(linkId);
                const img = document.getElementById(imgId);
                if (!input || !link || !img) return;
                input.addEventListener('change', function () {
                    const file = input.files && input.files[0];
                    if (!file) {
                        img.src = '';
                        link.href = '#';
                        link.classList.add('hidden');
                        return;
                    }
                    const url = URL.createObjectURL(file);
                    img.src = url;
                    link.href = url;
                    link.classList.remove('hidden');
                });
            };

            bindPreview('fotoCreateInput', 'fotoCreateLink', 'fotoCreatePreview');
            bindPreview('fotoUpdateInput', 'fotoUpdateLink', 'fotoUpdatePreview');
        })();
    </script>
</body>
</html>
