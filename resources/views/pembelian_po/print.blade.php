<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center ">
            <div class="col-lg-10 col-sm-12">

                <h4 class="card-title p-4" style="color: #435EBE">PEMBELIAN PO</h4>
                <hr style="border: 2px solid #435EBE">

                <table width="100%" cellpadding="10">
                    <tr>
                        <td width="15%">Admin</td>
                        <td width="1%">:</td>
                        <td width="40%">{{$detail2->admin}}</td>
                        <td width="20%">Tanggal Request</td>
                        <td width="1%">:</td>
                        <td>{{date('d-m-Y',strtotime($detail2->tgl))}}</td>
                    </tr>
                    <tr>
                        <td width="15%">Nomor Po</td>
                        <td width="1%">:</td>
                        <td>{{$detail2->no_po}}</td>
                        <td width="20%">Departement</td>
                        <td width="1%">:</td>
                        <td>Takemori</td>
                    </tr>


                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #3950A3; color: white">
                            <th style="text-align: center">Bahan</th>
                            <th style="text-align: right">Qty PO</th>
                            <th style="text-align: center">Satuan PO</th>
                            <th style="text-align: center">Qty Beli</th>
                            <th style="text-align: center">Satuan Beli</th>
                            <th style="text-align: right">Rp Satuan</th>
                            <th style="text-align: right">Total Rp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase as $p)
                        <tr>
                            <td style="text-align: center">{{$p->nm_post}}</td>
                            <td style="text-align: right">{{$p->qty}}</td>
                            <td style="text-align: center">{{$p->nm_satuan}}</td>
                            <td style="text-align: right">{{$p->qty_beli}}</td>
                            <td style="text-align: center">{{$p->nm_satuan}}</td>
                            <td style="text-align: right">{{number_format($p->hrga_satuan_beli,0)}}</td>
                            <td style="text-align: right">{{number_format($p->ttl_rp_pembelian,0)}}</td>
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