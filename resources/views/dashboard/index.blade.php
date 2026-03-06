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
            <h2>Maintenance 30 Hari Ke Depan (Termasuk Lewat Due)</h2>
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
                            <td colspan="5">Tidak ada AC yang perlu maintenance dalam 30 hari ke depan.</td>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($repairHistories as $row)
                        <tr>
                            <td>{{ $row['tanggal'] }}</td>
                            <td>{{ $row['aset'] }}</td>
                            <td>{{ $row['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada riwayat perbaikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>



