<?php
$file = "Laporan Persediaan Daging & Ayam.xls";
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$file");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h4>Laporan Persediaan Daging & Ayam</h4>
    <table class="table" border="1" id="tb_bkin">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Kategori </th>
                <th>Stok Program</th>
                <th>Satuan </th>
                <th>Opname Countdown </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gudang as $no => $j)
            <tr>
                <td>{{$no+1}}</td>
                <td>{{$j->nm_bahan}}</td>
                <td>{{$j->nm_kategori}}</td>

                @php
                $debit = empty($j->debit) ? '0' : $j->debit;
                $kredit = empty($j->kredit) ? '0' : $j->kredit;
                $stk = $debit - $kredit;
                $tgl1 = date('Y-m-d');
                $tgl2 = date('Y-m-d',strtotime('30 days',strtotime($j->tgl)));

                if (empty($j->tgl)) {
                $tKerja = '0';
                } else {
                $totalKerja = new DateTime($tgl1);
                $today = new DateTime($tgl2);
                $tKerja = $today->diff($totalKerja);
                }
                @endphp
                <td align="right">{{number_format($stk,0)}}</td>
                <td>{{$j->n}}</td>
                <td align="center">{{ $tKerja == '0' ? ' - ' : $tKerja->d }} days</td>
            </tr>

            @endforeach

        </tbody>

    </table>
</body>

</html>