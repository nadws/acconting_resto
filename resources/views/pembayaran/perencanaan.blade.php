<div class="modal-body">
    <table width="100%" class="table table-bordered table-striped">
        <thead class="bg-costume">
            <tr style="background-color: #3950A3; color: white">
                <th style="text-align: center">Bahan</th>
                <th style="text-align: right">Qty</th>
                <th style="text-align: center">Satuan</th>
                <th style="text-align: right">Rp Satuan</th>
                <th style="text-align: right">Total Rp</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total1 = 0;
            @endphp
            @foreach ($detail as $d)
            <tr>
                <td style="text-align: center">{{$d->nm_bahan}}
                    {{-- <input type="hidden" name="id_akun[]" value="{{$d->id_akun}}"> --}}
                    <input type="hidden" name="id_bahan[]" value="{{$d->id_bahan}}">
                    <input type="hidden" name="qty[]" value="{{$d->qty}}">
                    <input type="hidden" name="id_satuan[]" value="{{$d->id_satuan}}">
                    <input type="hidden" name="ttl_rp[]" value="{{$d->ttl_rp}}">
                    <input type="hidden" name="tgl" value="{{$d->tgl}}">
                    <input type="hidden" name="no_po" value="{{$d->no_po}}">
                    <input type="hidden" name="h_satuan[]" value="{{$d->h_satuan}}">
                </td>
                <td style="text-align: right">{{$d->qty}}</td>
                <td style="text-align: center">{{$d->nm_satuan}}</td>
                <td style="text-align: right">Rp.{{number_format($d->h_satuan,0)}}</td>
                <td style="text-align: right">Rp.{{number_format($d->ttl_rp,0)}}</td>
            </tr>
            @php
            $total1 +=$d->ttl_rp
            @endphp
            @endforeach
        </tbody>

    </table>
    <div class="row">
        <div class="col-lg-5">

        </div>
        <div class="col-lg-7">
            <hr style="border:1px solid #3950A3">
            <table class="table" width="100%">
                <tbody>

                    @php
                    $total2=0;
                    @endphp
                    @foreach ($biaya as $b)
                    @php
                    $total2+= $b->rupiah
                    @endphp
                    <tr>
                        <td>
                            {{$b->nm_akun}}
                            <input type="hidden" name="id_akun_tambahan[]" value="{{$b->id_akun}}">
                            <input type="hidden" name="rupiah[]" value="{{$b->rupiah}}">
                        </td>
                        <td>:</td>
                        <td align="right" colspan="2">Rp. {{number_format($b->rupiah,0)}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        <th>:</th>
                        <th style="text-align: right" colspan="2">Rp.{{ number_format($total1 + $total2,0) }}
                            <input type="hidden" id="total_rp" name="total_rp" value="{{$total1 + $total2}}">
                            <input type="hidden" class="total_hitung" value="">
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="border-top: 3px solid #3950A3">Pembayaran</th>
                        <th style="border-top: 3px solid #3950A3">:</th>
                        <td width="25%" style="border-top: 3px solid #3950A3; ">
                            <select class="select form-control " id="swal-input2" name="akun2[]" required>
                                <option value="">-Pilih Pembayaran-</option>
                                @foreach ($akun as $a)
                                <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
                                @endforeach
                            </select>

                        </td>
                        <td width="25%" style="border-top: 3px solid #3950A3; ">
                            <input name="pembayaran[]" type="text" class="form-control bayar bayar1" urutan='1'
                                style="text-align: right">
                        </td>
                        <td width="5%" style="border-top: 3px solid #3950A3; ">
                            <a href="#" class="btn rounded-pill tambah_pembayaran"><i
                                    class="fas fa-plus text-secondary"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tbody id="tbh_pembayaran">

                </tbody>


            </table>
        </div>
    </div>


</div>