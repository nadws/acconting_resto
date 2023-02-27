<div class="col-lg-12 col-sm-12">
    <table class="table table-bordered">
        <thead>
            <tr style="background-color: #3950A3; color: white">
                <th>Tanggal</th>
                <th>No Sub Po</th>
                <th style="text-align: right">Total Rp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase as $p)
            <tr>
                <td>{{date('d-m-Y',strtotime($p->tgl))}}</td>
                <td><a href="#" sub_po="{{$p->sub_no_po}}" class="detail_sub">{{$p->sub_no_po}}</a>
                </td>
                <td style="text-align: right">{{number_format($p->ttl_rp,0)}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>