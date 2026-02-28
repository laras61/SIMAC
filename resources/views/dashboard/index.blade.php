<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIMAC</title>
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #fff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --ok: #0f766e;
            --warn: #b45309;
            --danger: #b91c1c;
            --blue-soft: #eff6ff;
            --teal-soft: #ecfeff;
            --amber-soft: #fffbeb;
            --rose-soft: #fff1f2;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        .wrap {
            width: min(1040px, calc(100% - 28px));
            margin: 18px auto 32px;
        }
        .top {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }
        h1 { margin: 0; font-size: 24px; }
        .sub { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }
        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px;
        }
        .stats .card:nth-child(1) { background: linear-gradient(180deg, var(--blue-soft), #fff); }
        .stats .card:nth-child(2) { background: linear-gradient(180deg, var(--rose-soft), #fff); }
        .stats .card:nth-child(3) { background: linear-gradient(180deg, var(--amber-soft), #fff); }
        .stats .card:nth-child(4) { background: linear-gradient(180deg, var(--teal-soft), #fff); }
        .card .label { color: var(--muted); font-size: 12px; }
        .card .value { margin-top: 6px; font-size: 22px; font-weight: 700; }
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
            border-radius: 10px;
            padding: 12px;
            border-top: 3px solid #cbd5e1;
        }
        .menu-item:hover {
            border-color: #cbd5e1;
            background: #fcfdff;
        }
        .menu-title {
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 4px;
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
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 10px;
            overflow-x: auto;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
            border-top: 3px solid #bfdbfe;
        }
        .panel h2 { margin: 0 0 10px; font-size: 16px; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
            text-align: left;
            padding: 8px 6px;
            border-bottom: 1px solid #edf2f7;
            white-space: nowrap;
        }
        th { color: var(--muted); font-weight: 600; background: #f8fbff; }
        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
        }
        .ok { color: var(--ok); background: #ecfeff; }
        .warn { color: var(--warn); background: #fff7ed; }
        .danger { color: var(--danger); background: #fef2f2; }

        .panel:nth-of-type(1) { border-top-color: #93c5fd; }
        .panel:nth-of-type(2) { border-top-color: #6ee7b7; }
        .panel:nth-of-type(3) { border-top-color: #fcd34d; }
    </style>
</head>
<body>
    @include('partials.nav')

    @php
        $dueCount = collect($maintenancePlans)->where('status', 'Lewat due')->count();
        $nearDueCount = collect($maintenancePlans)->where('status', 'Mendekati due')->count();
    @endphp

    <div class="wrap">
        <div class="top">
            <div>
                <h1>Dashboard SIMAC</h1>
                <p class="sub">Informasi inti operasional AC + akses menu admin</p>
            </div>
        </div>

        <div class="menu-grid">
            @foreach ($adminMenus as $menu)
                <a class="menu-item" href="{{ route($menu['route']) }}">
                    <p class="menu-title">{{ $menu['name'] }}</p>
                    <p class="menu-desc">{{ $menu['desc'] }}</p>
                </a>
            @endforeach
        </div>

        <div class="stats">
            <div class="card">
                <div class="label">Total Barang</div>
                <div class="value">{{ count($maintenancePlans) }}</div>
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
            <h2>Maintenance 6 Bulan (Wajib Ditindak)</h2>
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
                    @foreach ($maintenancePlans as $row)
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
                    @endforeach
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
                        <th>Ganti Freon</th>
                        <th>Part Diganti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repairHistories as $row)
                        <tr>
                            <td>{{ $row['tanggal'] }}</td>
                            <td>{{ $row['aset'] }}</td>
                            <td>{{ $row['freon'] }}</td>
                            <td>{{ $row['part'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
