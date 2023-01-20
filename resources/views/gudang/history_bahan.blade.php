<div class="col-lg-12">
    <table class="table" id="tb_bkin">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th style="text-align: right">Debit</th>
                <th style="text-align: right">kredit</th>
                <th style="text-align: right">Saldo</th>
                <th style="text-align: center">Opname</th>
            </tr>
        </thead>
        <tbody>
            @php
            $saldo = 0;
            @endphp
            @foreach ($bahan as $i => $b)
            @php
            $saldo +=$b->debit - $b->kredit;
            @endphp
            <tr>
                <td>{{$i+1}}</td>
                <td>{{ date('d-m-Y',strtotime($b->tgl)) }}</td>
                <td align="right">{{number_format($b->debit,0)}}</td>
                <td align="right">{{number_format($b->kredit,0)}}</td>
                <td align="right">{{number_format($saldo,0)}}</td>
                <td style="text-align: center">
                    <i
                        class="{{$b->opname == 'Y' ? 'text-success fas fa-2x fa-check-circle' : 'text-danger fas fa-2x fa-times-circle' }}"></i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>