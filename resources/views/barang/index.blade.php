<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang - SIMAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #fff7ed; color: #431407; }
        .wrap { width: min(1100px, calc(100% - 28px)); margin: 18px auto 32px; }
        .panel { background: #fff; border: 1px solid #fed7aa; border-top: 3px solid #f97316; border-radius: 12px; padding: 14px; box-shadow: 0 12px 26px rgba(194,65,12,.08); }
        h1 { margin: 0 0 4px; font-size: 24px; color: #9a3412; }
        .sub { margin: 0 0 14px; color: #c2410c; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 8px 6px; border-bottom: 1px solid #ffedd5; white-space: nowrap; }
        th { color: #9a3412; background: #fff7ed; }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="wrap">
        <div class="panel">
            <h1>Menu Barang</h1>
            <p class="sub">Total data: {{ $items->count() }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Kode BMN</th>
                        <th>Merk</th>
                        <th>Serial Number</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $row)
                        <tr>
                            <td>{{ $row->kode_bmn }}</td>
                            <td>{{ $row->merk }}</td>
                            <td>{{ $row->serial_number }}</td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{{ $row->status }}</td>
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
