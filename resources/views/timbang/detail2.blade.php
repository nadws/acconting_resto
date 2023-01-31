<div class="col-lg-12 col-sm-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title " style="color: #435EBE">PENIMBANGAN BAHAN</h4>
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
                        <th>Tanggal</th>
                        <th>No Po</th>
                        <th>Bahan</th>
                        <th style="text-align: right">Qty Beli</th>
                        <th>Satuan</th>
                        <th style="text-align: right">Rp Satuan Beli</th>
                        <th style="text-align: right">Total Rp Beli</th>
                        <th style="text-align: right">Qty Timbang</th>
                        <th>Satuan</th>
                        <th style="text-align: right">Rp Satuan Timbang</th>
                        <th style="text-align: right">Total Rp Timbang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase as $p)
                    <tr>
                        <td>{{$p->tgl}}</td>
                        <td>{{$p->no_po}}</td>
                        <td>{{$p->nm_bahan}}</td>
                        <td style="text-align: right">{{$p->qty}}</td>
                        <td>{{$p->nm_satuan}}</td>
                        <td style="text-align: right">{{number_format($p->rp_satuan,0)}}</td>
                        <td style="text-align: right">{{number_format($p->ttl_rp,0)}}</td>
                        <td style="text-align: right"><span
                                class="{{$p->qty == $p->qty_timbang ? '' : 'text-danger'}}">{{$p->qty_timbang}}</span>
                        </td>
                        <td>{{$p->nm_satuan}}</td>
                        <td style="text-align: right">{{number_format($p->hrga_satuan_timbang,0)}}</td>
                        <td style="text-align: right">{{number_format($p->ttl_rp_timbang,0)}}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>