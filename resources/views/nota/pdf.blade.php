<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota #{{ $nota->no_nota }}</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 1px solid #333;
            padding-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status-badge {
            background-color: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            text-transform: uppercase;
        }

        /* Tabel Barang */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table th {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    padding: 10px 5px;
    text-align: left;
}

        .items-table td {
    padding: 15px 5px;
    background-color: #ffffff;
}



        /* Penyelarasan Teks */
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .font-bold { font-weight: bold; }

        /* Ringkasan Total */
        .summary-table {
            width: 40%;
            float: right;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 5px;
            border-bottom: 1px solid #333;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="35%">
    <div class="title">Mitra Global</div>
    <div>JL PM NOOR RAPAK BINUANG 2, SAMPING POM BENSIN NO 32 SAMARINDA</div>
    <div>Telp: 082190215433</div>

    <div style="margin-top:10px;">Pegawai</div>
    <div class="font-bold">{{ $nota->pegawai->nama }}</div>
</td>

            <td width="35%">
                <div style="margin-top: 30px;">Pelanggan</div>
                <div class="font-bold">{{ $nota->pelanggan->nama }}</div>
                <div>{{ $nota->pelanggan->alamat }}</div>
                <div>Telepon: {{ $nota->pelanggan->telepon }}</div>
            </td>
            <td width="30%" class="text-right">
                <div>Tanggal: {{ \Carbon\Carbon::parse($nota->tanggal)->translatedFormat('d F Y') }}</div>
                <div style="margin-top: 20px;">
                    <span class="font-bold">No Nota #{{ $nota->no_nota }}</span><br>
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="40%">Nama Barang</th>
                <th width="10%" class="text-right">Qty</th>
                <th width="20%" class="text-right">Harga satuan</th>
                <th width="15%" class="text-right">Diskon</th>
                <th width="15%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detils as $row)
            <tr>
                <td>{{ $row->barang->nama }}</td>
                <td class="text-right">{{ $row->jumlah }}</td>
                <td class="text-right">Rp. {{ number_format($row->harga, 0, ',', '.') }}</td>
                <td class="text-right">{{ $row->diskon }}%</td>
                <td class="text-right">Rp. {{ number_format($row->harga * $row->jumlah - ($row->harga * $row->jumlah * $row->diskon / 100), 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data barang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="width: 100%;">
        <table class="summary-table">
            <tr>
                <td colspan="2" style="border:none; color:#888; padding-bottom:15px;">Tanggal : {{ \Carbon\Carbon::parse($nota->tanggal)->translatedFormat('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Subtotal:</td>
                <td class="text-right">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Diskon:</td>
                <td class="text-right">Rp. {{ number_format($totalDiskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total:</td>
                <td class="text-right">Rp. {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

</body>
</html>