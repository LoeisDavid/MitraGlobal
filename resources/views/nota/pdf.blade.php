<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota #{{ $nota->no_nota }}</title>

    <style>
        @page {
            size: 9.5in 5.5in;
            margin: 5mm 10mm 5mm 10mm;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
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

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items-table th {
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            text-align: left;
            padding: 2px 4px;
        }

        .items-table td {
            padding: 2px 4px;
        }

        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .font-bold { font-weight: bold; }

        /* Hindari pecah halaman */
        .no-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .summary-wrapper {
            width: 100%;
            border-top: 1px solid #333;
            margin-top: 4px;
            padding-top: 4px;
            clear: both;
        }

        .summary-table {
            width: 35%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 2px 4px;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 8px;
            clear: both;
        }

        .ttd-table {
            width: 100%;
        }

        .ttd-table td {
            vertical-align: top;
        }

        table {
            table-layout: fixed;
            word-wrap: break-word;
        }

        /* Hilangkan header/footer bawaan browser jika print langsung dari web */
  @media print {
    html, body {
      width: 9.5in;
      height: 11in;
    }
  }
    </style>
</head>

<body>

@php
    $chunks = $detils->chunk(10); // LEBIH AMAN utk landscape
    $no = 1;
@endphp

@foreach($chunks as $chunk)

@php
    $subtotal = 0;
    $totalDiskon = 0;
    $total = 0;
@endphp

<!-- ================= HEADER ================= -->
 @if ($loop->first)
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
            <div>Tanggal:
                {{ \Carbon\Carbon::parse($nota->tanggal)->translatedFormat('d F Y') }}
            </div>
            <div style="margin-top: 20px;">
                <span class="font-bold">No Nota #{{ $nota->no_nota }}</span>
            </div>
        </td>
    </tr>
</table>
 @endif


<!-- ================= ITEMS ================= -->
<table class="items-table">
    <thead>
        <tr>
            <th width="6%">No.</th>
            <th width="46%">Nama Barang</th>
            <th width="8%">Qty</th>
            <th width="12%">Harga</th>
            <th width="8%">Diskon</th>
            <th width="20%" class="text-right">Subtotal</th>
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
                {{ $row->barang->kategori->nama }} -
                {{ $row->barang->merk->nama }} -
                {{ $row->barang->nama }}
            </td>
            <td>{{ $row->jumlah }}</td>
            <td>{{ number_format($row->harga, 0, ',', '.') }}</td>
            <td>{{ $row->diskon }}%</td>
            <td class="text-right">
                {{ number_format($rowSubtotal - $rowDiskon, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- ================= FOOTER + TTD ================= -->
@if ($loop->last)
<div class="summary-wrapper">
        <table class="summary-table">
            <tr>
                <td class="font-bold">Subtotal:</td>
                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Diskon:</td>
                <td class="text-right">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total:</td>
                <td class="text-right font-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="ttd-wrapper">
        <table class="ttd-table">
            <tr>
                <td style="text-align:left;">
                    <p style="margin-left:20px;">Hormat Kami,</p>
                    <br><br>
                    (_________________)
                </td>

                <td style="text-align:right;">
                    <p style="margin-right:35px;">Penerima,</p>
                    <br><br>
                    (_________________)
                </td>
            </tr>
        </table>
    </div>
@endif

@if(!$loop->last)
    <div style="page-break-after: always;"></div>
@endif

@endforeach

</body>
</html>