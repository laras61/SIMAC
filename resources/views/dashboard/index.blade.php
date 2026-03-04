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
            --muted: #64748b;
            --line: #e2e8f0;
            --primary: #0f766e;
            --ok: #166534;
            --warn: #92400e;
            --danger: #b91c1c;
            --ok-soft: #dcfce7;
            --warn-soft: #fef3c7;
            --danger-soft: #fee2e2;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap {
            width: min(1040px, calc(100% - 28px));
            margin: 18px auto 32px;
        }
        .header {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
        }
        h1 { margin: 0; font-size: 24px; color: #0f172a; }
        .sub { margin: 6px 0 0; color: var(--muted); font-size: 13px; }
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
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.04);
        }
        .card .label { color: var(--muted); font-size: 12px; }
        .card .value { margin-top: 6px; font-size: 22px; font-weight: 700; color: #0f172a; }
        .card.primary {
            border-left: 4px solid #0f766e;
            background: #f0fdfa;
        }
        .card.warn { border-left: 4px solid #f59e0b; }
        .card.danger { border-left: 4px solid #ef4444; }
        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            overflow-x: auto;
        }
        .table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }
        .table-head h2 { margin: 0; font-size: 16px; color: #0f172a; }
        .table-meta {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid var(--line);
            color: var(--muted);
            background: #f8fafc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
            text-align: left;
            padding: 8px 6px;
            border-bottom: 1px solid var(--line);
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
        .ok { color: var(--ok); background: var(--ok-soft); }
        .warn { color: var(--warn); background: var(--warn-soft); }
        .danger { color: var(--danger); background: var(--danger-soft); }

        @media (max-width: 560px) {
            .table-head {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    @include('partials.nav')

    <div class="wrap">
        <div class="header">
            <h1>Dashboard SIMAC</h1>
            <p class="sub">Ringkasan data operasional AC.</p>
        </div>

        <div class="stats">
            <div class="card primary">
                <div class="label">Total Barang</div>
                <div class="value">{{ $totalBarang }}</div>
            </div>
            <div class="card danger">
                <div class="label">Maintenance Lewat Due</div>
                <div class="value">{{ $dueCount }}</div>
            </div>
            <div class="card warn">
                <div class="label">Maintenance Mendekati Due</div>
                <div class="value">{{ $nearDueCount }}</div>
            </div>
        </div>

        <div class="panel">
            <div class="table-head">
                <h2>Maintenance 30 Hari Ke Depan</h2>
                <span class="table-meta">{{ $maintenancePlans->count() }} data</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Next Due</th>
                        <th>Teknisi</th>
                        <th>PIC</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($maintenancePlans as $row)
                        <tr>
                            <td>{{ $row['aset'] }}</td>
                            <td>{{ $row['next_due'] }}</td>
                            <td>{{ $row['teknisi'] }}</td>
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
            <div class="table-head">
                <h2>Riwayat Perbaikan Terbaru</h2>
                <span class="table-meta">{{ $repairHistories->count() }} data</span>
            </div>
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

