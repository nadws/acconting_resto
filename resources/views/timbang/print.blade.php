<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


</head>

<style>
    .table1 {
        font-family: sans-serif;
        color: #232323;
        border-collapse: collapse;
    }

    .table1,
    .th1,
    .td1 {
        border: 1px solid #999;
        padding: 1px 20px;
        font-size: 12px;
        white-space: nowrap;
    }
</style>

<body>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center ">
            <div class="col-lg-12 col-sm-12">
                <h4 class="card-title " style="color: #435EBE">PENIMBANGAN BAHAN {{$detail2->id_lokasi == '1' ?
                    'TAKEMORI' : 'SOONDOBU'}}</h4>
                <hr style="border: 2px solid #435EBE">
                <table width="100%" cellpadding="3" style="font-size: 12px">
                    <tr>
                        <td width="20%">Nomor PO</td>
                        <td width="1%">:</td>
                        <td width="40%">{{$detail2->sub_no_po}}</td>
                        <td width="20%">Pembeli</td>
                        <td width="1%">:</td>
                        <td width="30%">{{$detail2->pembeli}}</td>

                    </tr>
                    <tr>
                        <td width="20%">Tanggal Request</td>
                        <td width="1%">:</td>
                        <td>{{date('d-m-Y',strtotime($detail2->tgl))}}</td>
                        <td width="15%">Tempat Beli</td>
                        <td width="1%">:</td>
                        <td>{{$detail2->tempat_beli}}</td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-lg-12">
                        <hr style="border: 1px solid black">
                    </div>
                </div>
                <table class="table1" width="100%">
                    <thead>
                        <tr style="background-color: #3950A3; color: white">
                            <th class="th1">No</th>
                            <th class="th1">Bahan</th>
                            <th class="th1" style="text-align: right">Qty Beli</th>
                            <th class="th1">Satuan Beli</th>
                            <th class="th1" style="text-align: right">Qty Timbang</th>
                            <th class="th1">Satuan Timbang</th>
                            <th class="th1" style="text-align: right">Rp Satuan </th>
                            <th class="th1" style="text-align: right">Total Rp </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase as $no => $p)
                        <tr>
                            <td class="td1">{{$no+1}}</td>
                            <td class="td1">{{$p->nm_bahan}}</td>
                            <td class="td1" style="text-align: right">{{number_format($p->qty,0)}}</td>
                            <td class="td1">{{$p->nm_satuan}}</td>
                            <td class="td1" style="text-align: right">{{number_format($p->qty_timbang,0)}}</td>
                            <td class="td1">{{$p->satuan_timbang}}</td>
                            <td class="td1" style="text-align: right">{{number_format($p->rp_satuan_timbang,0)}}</td>
                            <td class="td1" style="text-align: right">{{number_format($p->ttl_rp_timbang,0)}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        window.print()
    </script>
</body>

</html>