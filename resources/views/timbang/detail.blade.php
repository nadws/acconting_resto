<div class="row">
    <h5>{{$po}}</h5>
    <div class="col-lg-12">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;border-right: 2px solid #435EBE"></th>
                    <th colspan="4" style="text-align: center;border-right: 2px solid #435EBE">BELI</th>
                    <th colspan="4" style="text-align: center;">TIMBANG</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>No Po</th>
                    <th style="border-right: 2px solid #435EBE">Bahan</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Rp Satuan</th>
                    <th style="border-right: 2px solid #435EBE">Total Rp</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Rp Satuan</th>
                    <th>Total Rp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase as $p)
                <tr>
                    <td>{{$p->tgl}}</td>
                    <td>{{$p->no_po}}</td>
                    <td style="border-right: 2px solid #435EBE">{{$p->nm_bahan}}</td>
                    <td>{{$p->qty}}</td>
                    <td>{{$p->nm_satuan}}</td>
                    <td>{{number_format($p->rp_satuan,0)}}</td>
                    <td style="border-right: 2px solid #435EBE">{{number_format($p->ttl_rp,0)}}</td>
                    <td><span class="{{$p->qty == $p->qty_timbang ? '' : 'text-danger'}}">{{$p->qty_timbang}}</span></td>
                    <td>{{$p->nm_satuan}}</td>
                    <td>{{number_format($p->hrga_satuan_timbang,0)}}</td>
                    <td>{{number_format($p->ttl_rp_timbang,0)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>