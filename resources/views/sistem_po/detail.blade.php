<div class="row">
    <h5>{{$po}}</h5>
    <div class="col-lg-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No Po</th>
                    <th>Bahan</th>
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
                    <td>{{$p->nm_bahan}}</td>
                    <td>{{$p->qty}}</td>
                    <td>{{$p->nm_satuan}}</td>
                    <td>{{number_format($p->rp_satuan,0)}}</td>
                    <td>{{number_format($p->ttl_rp,0)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>