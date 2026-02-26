pada halaman pdf dibawah ini, ubah agar format setiap halaman bagian atas(header) selalu teerdapat informasi perusahaan seperti pada halaman pertama, dan dibagian bawah ada ttd. jika halaman berpindah llakukan hal yg sama, jadi yang berbeda hanya detail barangnya melanjutkan dari barang sebelumnya

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
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: top;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
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
        }
        .items-table th {
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    /*padding: 1px 5px;*/
    text-align: left;
}

        .items-table td {
    /*padding: 1px 5px;*/
    background-color: #ffffff;
}



        /* Penyelarasan Teks */
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .font-bold { font-weight: bold; }

        /* Ringkasan Total */
        .summary-wrapper {
    width: 100%;
    border-top: 1px solid #333; /* Garis full kiri ke kanan */
    margin-top: 10px;
    padding-top: 5px;
}

.summary-table {
    width: 40%;
    float: right;
    border-collapse: collapse;
}

        .summary-table td {
            padding: 5px 5px;
        }

        @page {
        size: A5 portrait;
        margin: 15px;
    }
    </style>
</head>
<body>
    @php
    $chunks = $detils->chunk(10); // 10 item per halaman
    $no = 1;
@endphp

@foreach($chunks as $chunk)
@php

$totalDiskon = 0;
    $subtotal = 0;
    $total = 0;
@endphp
{{-- ================= HEADER (REPEAT SETIAP HALAMAN) ================= --}}
<table class="header-table">
    <tr>
        <td width="35%">
            <div class="title">Mitra Global Abadi</div>
            <div>SAMARINDA</div>
            <div>Telp: 082190215433</div>
        </td>

        <td width="35%">
            <div style="margin-top: 20px;">Pelanggan</div>
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

<br>

{{-- ================= TABEL BARANG ================= --}}
<table class="items-table">
    <thead>
        <tr>
            <th width="10%">No.</th>
            <th width="50%">Nama Barang</th>
            <th width="10%">Qty</th>
            <th width="10%">Harga satuan</th>
            <th width="10%">Diskon</th>
            <th width="10%" class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($chunk as $row)
        @php
            $rowSubtotal = $row->harga * $row->jumlah;
            $rowDiskon = $rowSubtotal * ($row->diskon / 100);
            $subtotal += $rowSubtotal;
            $totalDiskon += $rowDiskon;
            $total = $subtotal - $totalDiskon;
        @endphp
        <tr>
            <td>{{ $no++ }}</td>
            <td>
                {{ $row->barang->kategori->nama }}-
                {{ $row->barang->merk->nama }}-
                {{ $row->barang->nama }}
            </td>
            <td>{{ $row->jumlah }}</td>
            <td>{{ number_format($row->harga, 0, ',', '.') }}</td>
            <td>{{ $row->diskon }}%</td>
            <td class="text-right">
                {{ number_format($row->harga * $row->jumlah - ($row->harga * $row->jumlah * $row->diskon / 100), 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= FOOTER (REPEAT SETIAP HALAMAN) ================= --}}
<div style="width: 100%;">
    <div class="summary-wrapper">
    <table class="summary-table">
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

    <div style="width: 100%; margin-top: 20px; clear: both;">
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left;">
                    <p style="margin-left: 20px;">Hormat Kami,</p>
                    <br><br>
                    (_________________)
                </td>
                <td style="text-align: right">
                    <p style="margin-right: 35px;">Penerima,</p>
                    <br><br>
                    (_________________)
                </td>
            </tr>
        </table>
    </div>
</div>

@if(!$loop->last)
    <div style="page-break-after: always;"></div>
@endif

@endforeach
</body>
</html>