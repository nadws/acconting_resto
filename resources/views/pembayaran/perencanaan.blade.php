@if (empty($no_po))
<center>
    <div class="modal-body">
        <br>
        <img src="{{asset('assets')}}/img/no-data.svg" width="200px" alt="">
        <h3 class="mt-2">Data tidak ditemukan</h3>
    </div>
    <div class="modal-footer">
        <button type="submit" id="btn_bayar" disabled class="btn btn-primary">Edit/Save</button>
    </div>
</center>
@else
<div class="modal-body">
    <label for="">Tanggal</label>
    <input type="date" name="tgl" class="form-control mb-4" style="width: 200px;" required>
    <label for="" style="font-weight: bold; font-size: larger; color: #629779;">Persediaan Makanan </label>
    <table width="100%" class="table table-bordered">
        <thead class="bg-costume">
            <tr>
                <th>No PO</th>
                <th>Nama Bahan</th>
                <th>Akun</th>
                <th>Keterangan</th>
                <th style="text-align: right">Qty</th>
                <th style="text-align: right">Harga Satuan</th>
                <th style="text-align: right">Total Rp</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($no_po as $d)
                @php
                    $po = DB::select("SELECT b.timbang,a.id_timbang as id_pembelian,c.id_bahan,d.nm_bahan,e.nm_satuan,c.id_satuan_beli,a.h_satuan,a.qty,sum(a.ttl_rp) as ttl_rp FROM `timbang_purchase` as a
                    LEFT JOIN pembelian_purchase as b on a.id_pembelian = b.id_pembelian_purchase
                    LEFT JOIN purchase as c ON b.id_purchase = c.id_purchase
                    LEFT JOIN tb_list_bahan as d ON d.id_list_bahan = c.id_bahan
                    LEFT JOIN tb_satuan as e ON c.id_satuan_beli = e.id_satuan
                    WHERE a.no_po = '$d' GROUP BY c.id_bahan;");

                    // $total += $po->ttl_rp;
                @endphp 
                {{-- @if (!empty($po))
                <tr>
                    <td>{{ $d }}</td>
                    <td>{{ $po->nm_bahan }}</td>
                    <td>Akun</td>
                    <td>ket</td>
                    <td>{{ $po->qty }}</td>
                    <td>{{ $po->h_satuan }}</td>
                    <td>{{ $po->ttl_rp }}</td>
                </tr>
                @endif --}}
                
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <label for="" style="font-weight: bold; font-size: larger; color: #629779;">BCA </label>
    <table width="100%" class="table table-bordered">
        <thead class="bg-costume">
            <tr>
                <th>CFM Invoice</th>
                <th>Nama Customer</th>
                <th>Akun</th>
                <th>Keterangan</th>
                <th style="text-align: right">Total Kg</th>
                <th style="text-align: right">Harga</th>
                <th style="text-align: right">Total Rp</th>
                <th style="text-align: right">Total Rp / Invoce</th>
            </tr>
        </thead>
        {{-- <tbody>
            @php
            $total = 0;
            @endphp
            @foreach ($nota as $n)
            @php
            $invoice = DB::selectOne("SELECT a.no_nota as nota_telur, b.id_akun, d.nm_post, a.urutan, b.no_nota,
            b.tgl,c.nm_akun,
            b.debit
            FROM invoice_telur AS a
            LEFT JOIN tb_jurnal AS b ON b.no_nota = concat('T-',a.no_nota)
            LEFT JOIN tb_akun AS c ON c.id_akun = b.id_akun
            LEFT JOIN tb_post_center AS d ON d.id_post = a.id_post
            WHERE b.id_buku = '1' AND b.id_akun = '32' AND b.setor = 'T' and b.no_nota = '$n'
            GROUP BY a.no_nota
            order by a.id_invoice_telur ASC");

            $ket = DB::select("SELECT a.no_nota, b.jenis, a.pcs, a.kg_jual, a.rupiah,a.rp_kg
            From invoice_telur as a
            LEFT JOIN tb_jenis_telur AS b ON b.id = a.id_jenis_telur
            where concat('T-',a.no_nota) = '$n'
            ")
            @endphp

            @if (empty($invoice))

            @else
            <tr>
                <td style="vertical-align: middle;">{{$n}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_post}} {{$invoice->urutan}}</td>
                <td style="vertical-align: middle;">{{$invoice->nm_akun}}</td>
                <td>
                    @foreach ($ket as $k)
                    @if ($k->kg_jual == 0)
                    @php
                    continue;
                    @endphp
                    @endif
                    {{$k->jenis}} <br>
                    @endforeach
                </td>
                <td style="text-align: right">
                    @foreach ($ket as $k)
                    @if ($k->kg_jual == 0)
                    @php
                    continue;
                    @endphp
                    @endif
                    {{$k->kg_jual}} <br>
                    @endforeach
                </td>
                <td style="text-align: right">
                    @foreach ($ket as $k)
                    @if ($k->kg_jual == 0)
                    @php
                    continue;
                    @endphp
                    @endif
                    {{number_format($k->rupiah,0)}} <br>
                    @endforeach
                </td>
                <td style="text-align: right">
                    @foreach ($ket as $k)
                    @if ($k->kg_jual == 0)
                    @php
                    continue;
                    @endphp
                    @endif
                    {{number_format($k->rp_kg,0)}} <br>
                    @endforeach
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    {{number_format($invoice->debit,0)}}
                    <input type="hidden" name="no_nota[]" value="{{$n}}">
                    <input type="hidden" name="debit[]" value="{{$invoice->debit}}">
                    <input type="hidden" name="id_akun[]" value="{{$invoice->id_akun}}">
                </td>
            </tr>
            @php
            $total += $invoice->debit;
            @endphp
            @endif
            @endforeach
        </tbody> --}}
        <tfoot>
            <tr class="bg-costume">
                <th colspan="6"></th>
                <th style="text-align: right">Total</th>
                <th style="text-align: right;">{{number_format($total,0)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal-footer">
    <button type="submit" id="btn_bayar" class="btn btn-primary">Edit/Save</button>
</div>

@endif