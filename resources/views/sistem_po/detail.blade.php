<div class="row justify-content-center ">
    <div class="col-lg-12 col-sm-12">

        <h4 class="card-title " style="color: #435EBE">PURCHASE REQUEST</h4>
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
                    <th style="text-align: right">Qty</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: right">Rp Satuan</th>
                    <th style="text-align: right">Total Rp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase as $p)
                <tr>
                    <td style="text-align: center">{{$p->nm_bahan}}</td>
                    <td style="text-align: right">{{$p->qty}}</td>
                    <td style="text-align: center">{{$p->nm_satuan}}</td>
                    <td style="text-align: right">{{number_format($p->rp_satuan,0)}}</td>
                    <td style="text-align: right">{{number_format($p->ttl_rp,0)}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>