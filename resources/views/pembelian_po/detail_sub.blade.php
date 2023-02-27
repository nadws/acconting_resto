<div class="col-lg-12 col-sm-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start">No Sub Menu : {{$sub_po}}</h5>
                    <a href="{{route('print_pembelian',['sub_po' =>$sub_po])}}"
                        class="float-end btn btn-primary mb-4"><i class="fas fa-print"></i> Print</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered" id="tb_bkin">
                        <thead>
                            <tr style="background-color: #3950A3; color: white">
                                <th>Tanggal</th>
                                <th>Nama Bahan</th>
                                <th style="text-align: right">Qty</th>
                                <th>Satuan</th>
                                <th style="text-align: right">Harga Satuan</th>
                                <th style="text-align: right">Total Rp</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $p)
                            <tr>
                                <td>{{date('d-m-Y',strtotime($p->tgl))}}</td>
                                <td>{{$p->nm_bahan}}</td>
                                <td style="text-align: right">{{$p->qty}}</td>
                                <td>{{$p->nm_satuan}}</td>
                                <td style="text-align: right">{{number_format($p->h_satuan,0)}}</td>
                                <td style="text-align: right">{{number_format($p->ttl_rp,0)}}</td>
                                <td>{{$p->admin}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>