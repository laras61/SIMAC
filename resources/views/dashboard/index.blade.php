<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1f2937;
            --muted: #0f172a;
            --line: #e2e8f0;
            --primary: #0f766e;
            --primary-dark: #115e59;
            --amber: #334155;
            --ok: #166534;
            --warn: #334155;
            --danger: #b91c1c;
            --orange-soft: #f8fafc;
            --amber-soft: #f8fafc;
            --cream-soft: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap {
            width: min(1280px, calc(100% - 28px));
            margin: 22px auto 32px;
        }
        .welcome-card {
            position: relative;
            margin-bottom: 14px;
            border-radius: 16px;
            padding: 28px;
            color: #fff;
            background: linear-gradient(90deg, #0f766e, #134e4a);
            box-shadow: 0 16px 36px rgba(15, 118, 110, .24);
            overflow: hidden;
        }
        .welcome-content {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }
        .welcome-title {
            margin: 0 0 6px;
            font-size: 30px;
            line-height: 1.2;
            font-weight: 700;
        }
        .welcome-text {
            margin: 0;
            color: #ccfbf1;
            opacity: .95;
            font-size: 14px;
            line-height: 1.5;
        }
        .welcome-stripe {
            position: absolute;
            top: 0;
            right: -90px;
            width: 36%;
            height: 100%;
            background: rgba(255, 255, 255, .06);
            transform: skewX(12deg);
        }
        .welcome-glow {
            position: absolute;
            right: 40px;
            bottom: 28px;
            width: 130px;
            height: 130px;
            border-radius: 999px;
            background: rgba(20, 184, 166, .24);
            filter: blur(22px);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
        }
        .stats .card:nth-child(1) { background: linear-gradient(180deg, #e2e8f0, #ffffff); }
        .stats .card:nth-child(2) { background: linear-gradient(180deg, #fee2e2, #ffffff); }
        .stats .card:nth-child(3) { background: linear-gradient(180deg, #fef3c7, #ffffff); }
        .stats .card:nth-child(4) { background: linear-gradient(180deg, #f8fafc, #ffffff); }
        .card .label { color: var(--muted); font-size: 12px; }
        .card .value { margin-top: 6px; font-size: 22px; font-weight: 700; color: var(--primary-dark); }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }
        .menu-item {
            display: block;
            text-decoration: none;
            color: inherit;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            border-top: 3px solid var(--primary);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .menu-item:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.10);
        }
        .menu-title {
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 4px;
            color: var(--primary-dark);
        }
        .menu-desc {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
        }
        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            overflow-x: auto;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            border-top: 3px solid #0f766e;
        }
        .panel h2 { margin: 0 0 10px; font-size: 16px; color: var(--primary-dark); }
        .panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        .filter-days-form {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--muted);
        }
        .filter-days-form input {
            width: 72px;
            padding: 6px 8px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font-family: inherit;
            font-size: 12px;
        }
        .filter-days-form button {
            border: 1px solid #0f766e;
            background: #0f766e;
            color: #fff;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }
        .filter-days-form button:hover {
            background: #115e59;
            border-color: #115e59;
        }
        .btn-detail {
            border: 1px solid #0f766e;
            background: #ffffff;
            color: #0f766e;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-detail:hover {
            background: #f0fdfa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
            text-align: left;
            padding: 8px 6px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        th { color: var(--muted); font-weight: 600; background: #f8fafc; }
        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
        }
        .ok { color: var(--ok); background: #dcfce7; }
        .warn { color: #92400e; background: #fef3c7; }
        .danger { color: var(--danger); background: #fee2e2; }

        .panel:nth-of-type(1) { border-top-color: #0f766e; }
        .panel:nth-of-type(2) { border-top-color: #0f766e; }
        .panel:nth-of-type(3) { border-top-color: #475569; }
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 16px;
        }
        .modal.open { display: flex; }
        .modal-card {
            width: min(640px, 100%);
            max-height: calc(100vh - 32px);
            overflow-y: auto;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 20px 44px rgba(15, 23, 42, 0.2);
            padding: 14px;
        }
        .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .modal-head h3 {
            margin: 0;
            font-size: 16px;
            color: var(--primary-dark);
        }
        .btn-close-modal {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--muted);
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            cursor: pointer;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 8px 10px;
            font-size: 13px;
        }
        .detail-grid .label {
            color: var(--muted);
            font-weight: 600;
        }
        .detail-loading {
            color: var(--muted);
            font-size: 13px;
        }
        @media (max-width: 760px) {
            .welcome-card {
                padding: 22px;
            }
            .welcome-title {
                font-size: 24px;
            }
            .welcome-text {
                font-size: 13px;
            }
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('partials.nav')

    <div class="wrap">
        <div class="welcome-card">
            <div class="welcome-content">
                <h2 class="welcome-title">Selamat Datang, {{ explode(' ', auth()->user()->nama ?? 'Admin')[0] }}!</h2>
                <p class="welcome-text">Anda berada di dashboard Admin.</p>
            </div>
            <div class="welcome-stripe" aria-hidden="true"></div>
            <div class="welcome-glow" aria-hidden="true"></div>
        </div>

        <div class="stats">
            <div class="card">
                <div class="label">Total Barang</div>
                <div class="value">{{ $totalBarang }}</div>
            </div>
            <div class="card">
                <div class="label">Maintenance Lewat Due</div>
                <div class="value">{{ $dueCount }}</div>
            </div>
            <div class="card">
                <div class="label">Maintenance Mendekati Due</div>
                <div class="value">{{ $nearDueCount }}</div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <h2>Jadwal Maintenance Terdekat</h2>
                <form method="GET" action="{{ route('dashboard') }}" class="filter-days-form">
                    <label for="days">Tampilkan:</label>
                    <input
                        type="number"
                        id="days"
                        name="days"
                        min="1"
                        max="365"
                        value="{{ $daysAhead }}"
                    >
                    <span>hari</span>
                    <button type="submit">Terapkan</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Next Due</th>
                        <th>PIC</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($maintenancePlans as $row)
                        <tr>
                            <td>{{ $row['aset'] }}</td>
                            <td>{{ $row['next_due'] }}</td>
                            <td>{{ $row['pic'] }}</td>
                            <td>
                                @if ($row['status'] === 'Terjadwal')
                                    <span class="badge ok">{{ $row['status'] }}</span>
                                @elseif ($row['status'] === 'Mendekati due')
                                    <span class="badge warn">{{ $row['status'] }}</span>
                                @else
                                    <span class="badge danger">{{ $row['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada AC yang perlu maintenance dalam {{ $daysAhead }} hari ke depan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h2>Riwayat Perbaikan Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aset</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($repairHistories as $row)
                        <tr>
                            <td>{{ $row['tanggal'] }}</td>
                            <td>{{ $row['aset'] }}</td>
                            <td>{{ $row['keterangan'] }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail"
                                    data-perbaikan-id="{{ $row['id_perbaikan'] }}"
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Belum ada riwayat perbaikan dalam 7 hari terakhir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <div id="repairDetailModal" class="modal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-head">
                <h3>Detail Perbaikan</h3>
                <button type="button" class="btn-close-modal" id="closeRepairDetailModal">Tutup</button>
            </div>
            <div id="repairDetailBody" class="detail-loading">Memuat detail...</div>
        </div>
    </div>

    <script>
        (function initRepairDetailModal() {
            const modal = document.getElementById('repairDetailModal');
            const body = document.getElementById('repairDetailBody');
            const closeBtn = document.getElementById('closeRepairDetailModal');
            const detailButtons = document.querySelectorAll('[data-perbaikan-id]');

            if (!modal || !body || !closeBtn || !detailButtons.length) return;

            function openModal() {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeModal() {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            }

            function toRupiah(value) {
                if (value === null || value === undefined || value === '') return '-';
                return new Intl.NumberFormat('id-ID').format(Number(value));
            }

            function escapeHtml(value) {
                if (value === null || value === undefined) return '-';
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            async function loadDetail(id) {
                body.className = 'detail-loading';
                body.textContent = 'Memuat detail...';
                openModal();

                try {
                    const response = await fetch(`/perbaikan/${id}`, {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!response.ok) {
                        throw new Error('Gagal memuat data');
                    }

                    const data = await response.json();
                    const aset = `${data.barang?.kode_bmn ?? '-'} / ${data.barang?.lokasi ?? '-'}`;

                    body.className = 'detail-grid';
                    body.innerHTML = `
                        <div class="label">Tanggal</div><div>${escapeHtml(data.tanggal_perbaikan ?? '-')}</div>
                        <div class="label">Aset</div><div>${escapeHtml(aset)}</div>
                        <div class="label">Jenis Perbaikan</div><div>${escapeHtml(data.jenis_perbaikan ?? '-')}</div>
                        <div class="label">Teknisi</div><div>${escapeHtml(data.user?.nama ?? '-')}</div>
                        <div class="label">Vendor</div><div>${escapeHtml(data.vendor?.nama_vendor ?? '-')}</div>
                        <div class="label">Status</div><div>${escapeHtml(data.status ?? '-')}</div>
                        <div class="label">Biaya</div><div>${escapeHtml(data.biaya !== null ? 'Rp ' + toRupiah(data.biaya) : '-')}</div>
                        <div class="label">Deskripsi</div><div>${escapeHtml(data.deskripsi ?? '-')}</div>
                    `;
                } catch (error) {
                    body.className = 'detail-loading';
                    body.textContent = 'Detail perbaikan gagal dimuat.';
                }
            }

            detailButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-perbaikan-id');
                    if (!id) return;
                    loadDetail(id);
                });
            });

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function (event) {
                if (event.target === modal) closeModal();
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.classList.contains('open')) {
                    closeModal();
                }
            });
        })();
    </script>
</body>
</html>
