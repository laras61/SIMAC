<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Maintenance Saya - SIMAC Staff</title>
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
                    <span class="text-xl font-bold text-teal-800">Jadwal Maintenance</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Pesan Sukses/Error -->
        @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
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

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800">Daftar Tugas Maintenance</h3>
            </div>
            
            @if($items->isEmpty())
                <div class="p-10 text-center">
                    <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada tugas aktif</h3>
                    <p class="text-gray-500 mt-1">Anda tidak memiliki jadwal maintenance yang perlu dikerjakan saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Jadwal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset AC</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal_jadwal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->barang->kode_bmn }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->barang->merk }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->barang->lokasi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'selesai')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @elseif($item->status == 'proses')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Proses</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            onclick="openDetailModal(this)"
                                            data-kode-bmn="{{ $item->barang->kode_bmn }}"
                                            data-merk="{{ $item->barang->merk }}"
                                            data-lokasi="{{ $item->barang->lokasi }}"
                                            data-tanggal-jadwal="{{ $item->tanggal_jadwal ? \Carbon\Carbon::parse($item->tanggal_jadwal)->format('Y-m-d') : '' }}"
                                            data-tanggal-dikerjakan="{{ $item->tanggal_dikerjakan ? \Carbon\Carbon::parse($item->tanggal_dikerjakan)->format('Y-m-d') : '' }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-status="{{ $item->status }}"
                                            data-catatan="{{ $item->catatan }}"
                                            data-vendor-nama="{{ $item->vendor->nama_vendor ?? '' }}"
                                            data-vendor-pic="{{ $item->vendor->pic_nama ?? '' }}"
                                            data-vendor-no-hp="{{ $item->vendor->no_hp ?? '' }}"
                                            data-vendor-email="{{ $item->vendor->email ?? '' }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors"
                                            title="Lihat detail maintenance"
                                            aria-label="Lihat detail maintenance"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @if($item->status != 'selesai')
                                            <button onclick="openUpdateModal('{{ $item->id_maintenance }}', '{{ $item->barang->kode_bmn }}', '{{ $item->status }}', '{{ $item->id_vendor }}', '{{ $item->tanggal_dikerjakan }}', '{{ addslashes($item->catatan) }}')" 
                                                class="bg-teal-50 text-teal-700 hover:bg-teal-100 hover:text-teal-900 px-3 py-1 rounded-md text-sm font-medium transition-colors border border-teal-200">
                                                Update Status
                                            </button>
                                        @else
                                            <span class="text-gray-400 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Tuntas
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

    <!-- Modal Detail Maintenance -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="detail-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDetailModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-5 pt-5 pb-4 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900" id="detail-modal-title">Detail Maintenance</h3>
                        <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600" aria-label="Tutup detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Aset</p>
                            <p id="detailAset" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Lokasi</p>
                            <p id="detailLokasi" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Jadwal</p>
                            <p id="detailTanggalJadwal" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Dikerjakan</p>
                            <p id="detailTanggalDikerjakan" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Jenis</p>
                            <p id="detailJenis" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <p id="detailStatus" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Vendor</p>
                            <p id="detailVendor" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">PIC Vendor</p>
                            <p id="detailVendorPic" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">No. HP Vendor</p>
                            <p id="detailVendorNoHp" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email Vendor</p>
                            <p id="detailVendorEmail" class="font-medium text-gray-900">-</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-gray-500">Catatan</p>
                            <p id="detailCatatan" class="font-medium text-gray-900 whitespace-pre-line">-</p>
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

    <!-- Modal Update Status -->
    <div id="updateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeUpdateModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="updateForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-teal-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Update Status Maintenance
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Perbarui progres pengerjaan maintenance untuk aset <span id="modalAsetName" class="font-bold text-gray-700"></span>.
                                    </p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pengerjaan <span class="text-red-500">*</span></label>
                                            <select name="status" id="modalStatus" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md border">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="proses">Sedang Dikerjakan (Proses)</option>
                                                <option value="selesai">Sudah Selesai</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                                            <select name="id_vendor" id="modalVendor" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md border">
                                                <option value="">-</option>
                                                @foreach($listVendors as $vendor)
                                                    <option value="{{ $vendor->id_vendor }}">{{ $vendor->nama_vendor }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengerjaan <span class="text-red-500">*</span></label>
                                            <textarea name="catatan" id="modalCatatan" required rows="3" class="shadow-sm focus:ring-teal-500 focus:border-teal-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2" placeholder="Tambahkan catatan teknis..."></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dikerjakan</label>
                                            <input type="date" name="tanggal_dikerjakan" id="modalTanggalDikerjakan" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm rounded-md border">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeUpdateModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
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

            document.getElementById('detailAset').textContent = [data.kodeBmn, data.merk].filter(Boolean).join(' - ') || '-';
            document.getElementById('detailLokasi').textContent = data.lokasi || '-';
            document.getElementById('detailTanggalJadwal').textContent = formatDateId(data.tanggalJadwal);
            document.getElementById('detailTanggalDikerjakan').textContent = formatDateId(data.tanggalDikerjakan);
            document.getElementById('detailJenis').textContent = data.jenis || '-';
            document.getElementById('detailStatus').textContent = data.status || '-';
            document.getElementById('detailVendor').textContent = data.vendorNama || '-';
            document.getElementById('detailVendorPic').textContent = data.vendorPic || '-';
            document.getElementById('detailVendorNoHp').textContent = data.vendorNoHp || '-';
            document.getElementById('detailVendorEmail').textContent = data.vendorEmail || '-';
            document.getElementById('detailCatatan').textContent = data.catatan || '-';

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function openUpdateModal(id, asetName, currentStatus, vendorId, tanggalDikerjakan, catatan) {
            const modal = document.getElementById('updateModal');
            const form = document.getElementById('updateForm');
            const asestNameSpan = document.getElementById('modalAsetName');
            const statusSelect = document.getElementById('modalStatus');
            const vendorSelect = document.getElementById('modalVendor');
            const catatanInput = document.getElementById('modalCatatan');
            const tanggalInput = document.getElementById('modalTanggalDikerjakan');
            
            // Set action URL dynamically
            form.action = `/maintenance/update/${id}`;
            
            // Set asset name
            asestNameSpan.textContent = asetName;
            
            // Set current status if not pending
            if (currentStatus !== 'pending') {
                statusSelect.value = currentStatus;
            }

            if (vendorSelect) {
                vendorSelect.value = vendorId || '';
            }

            if (catatanInput) {
                catatanInput.value = catatan || '';
            }

            if (tanggalInput) {
                tanggalInput.value = tanggalDikerjakan || '';
            }
            
            modal.classList.remove('hidden');
        }

        function closeUpdateModal() {
            const modal = document.getElementById('updateModal');
            modal.classList.add('hidden');
        }
    </script>

</body>
</html>
