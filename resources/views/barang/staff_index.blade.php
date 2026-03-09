<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aset AC - SIMAC Staff</title>
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
                        <span class="font-medium">Kembali ke Dashboard</span>
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <span class="text-xl font-bold text-teal-800">Data Aset AC</span>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-500 mr-2">Halo,</span>
                    <span class="text-sm font-semibold text-gray-800">{{ auth()->user()->nama }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Pesan Error -->
        @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter & Search -->
        <div class="mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('barang.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari Kode BMN, Merk, Lokasi..." class="w-full rounded-lg border-gray-300 border p-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 border p-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="rusak" {{ $status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="nonaktif" {{ $status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 font-medium transition-colors h-[42px]">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Data Barang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Daftar Aset AC</h3>
                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded border border-gray-200">Total: {{ $items->count() }} unit</span>
            </div>
            
            @if($items->isEmpty())
                <div class="p-10 text-center">
                    <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Data tidak ditemukan</h3>
                    <p class="text-gray-500 mt-1">Coba ubah kata kunci pencarian Anda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode BMN</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Merk / Tipe</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Instalasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-teal-700">
                                    {{ $item->kode_bmn }}
                                    <div class="text-xs text-gray-400 font-normal mt-0.5">{{ $item->serial_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->merk }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->tipe_ac }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $item->lokasi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->tgl_instalasi)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'aktif')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @elseif($item->status == 'rusak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rusak</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        type="button"
                                        onclick="openDetailModal(this)"
                                        data-kode-bmn="{{ $item->kode_bmn }}"
                                        data-merk="{{ $item->merk }}"
                                        data-tipe-ac="{{ $item->tipe_ac }}"
                                        data-serial-number="{{ $item->serial_number }}"
                                        data-lokasi="{{ $item->lokasi }}"
                                        data-tgl-beli="{{ $item->tgl_beli ? \Carbon\Carbon::parse($item->tgl_beli)->format('d M Y') : '-' }}"
                                        data-tgl-instalasi="{{ $item->tgl_instalasi ? \Carbon\Carbon::parse($item->tgl_instalasi)->format('d M Y') : '-' }}"
                                        data-status="{{ $item->status }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors"
                                        title="Lihat detail aset"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Aset -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="detail-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDetailModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-5 pt-5 pb-4 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900" id="detail-modal-title">Detail Aset AC</h3>
                        <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600" aria-label="Tutup detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Kode BMN</p>
                            <p id="detailKode" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <p id="detailStatus" class="font-medium text-gray-900 capitalize">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Merk</p>
                            <p id="detailMerk" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tipe</p>
                            <p id="detailTipe" class="font-medium text-gray-900">-</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-gray-500">Serial Number</p>
                            <p id="detailSerial" class="font-medium text-gray-900 font-mono bg-gray-50 p-1 rounded inline-block">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Lokasi</p>
                            <p id="detailLokasi" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Beli</p>
                            <p id="detailTglBeli" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Instalasi</p>
                            <p id="detailTglInstalasi" class="font-medium text-gray-900">-</p>
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

    <script>
        function openDetailModal(button) {
            const data = button.dataset;
            
            document.getElementById('detailKode').textContent = data.kodeBmn || '-';
            document.getElementById('detailStatus').textContent = data.status || '-';
            document.getElementById('detailMerk').textContent = data.merk || '-';
            document.getElementById('detailTipe').textContent = data.tipeAc || '-';
            document.getElementById('detailSerial').textContent = data.serialNumber || '-';
            document.getElementById('detailLokasi').textContent = data.lokasi || '-';
            document.getElementById('detailTglBeli').textContent = data.tglBeli || '-';
            document.getElementById('detailTglInstalasi').textContent = data.tglInstalasi || '-';

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
