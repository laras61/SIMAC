<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaikan - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1f2937; }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .panel { background: #fff; border: 1px solid #e2e8f0; border-top: 3px solid #0f766e; border-radius: 12px; padding: 14px; box-shadow: 0 4px 10px rgba(15,23,42,.04); }
        h1 { margin: 0 0 4px; font-size: 24px; color: #0f172a; }
        .sub { margin: 0 0 14px; color: #64748b; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
        th { color: #64748b; background: #f8fafc; }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="wrap">
        <div class="panel">
            <h1>Menu Perbaikan</h1>
            <p class="sub">Total data: {{ $items->count() }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Teknisi</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $row)
                        <tr>
                            <td>{{ $row->tanggal_perbaikan }}</td>
                            <td>{{ optional($row->barang)->merk ?? '-' }}</td>
                            <td>{{ $row->jenis_perbaikan }}</td>
                            <td>{{ optional($row->user)->nama ?? '-' }}</td>
                            <td>{{ $row->biaya ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

