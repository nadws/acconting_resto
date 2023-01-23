<style>
    input[type="checkbox"] {
        appearance: none;
        width: 60px;
        height: 15px;
        background: #81BFD9;
        border-radius: 5px;
        position: relative;
        outline: 0;
        cursor: pointer;
    }

    input[type="checkbox"]:before,
    input[type="checkbox"]:after {
        position: absolute;
        content: "";
        transition: all .25s;
    }

    input[type="checkbox"]:before {
        width: 35px;
        height: 35px;
        background: #107AAE;
        border: 5px solid #107AAE;
        border-radius: 50%;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    input[type="checkbox"]:after {
        width: 35px;
        height: 35px;
        background: #76777B;
        border: 5px solid #76777B;
        border-radius: 50%;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    input[type="checkbox"]:checked:before {
        left: calc(100% - 35px);
    }

    input[type="checkbox"]:checked:after {
        left: 75px;
        transform: scale(0);
    }
</style>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Tanggal</label>
            <input class="form-control" type="date" name="tgl" value="{{$kredit->tgl}}" required>
            <input class="form-control" type="hidden" name="no_nota" value="{{$kredit->no_nota}}" required>

        </div>
    </div>
    <div class="col-1">
        <div class="mt-3 ml-1 ">
            <p class="mt-4 ml-2 text-warning"><strong>Db</strong></p>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Akun</label>
            <select name="id_akun" id="id_pilih" class="select form-control" required="">
                <option value="">- Pilih Akun -</option>
                @foreach ($akun as $ak)
                <option value="{{ $ak->id_akun }}" {{$debit->id_akun == $ak->id_akun ? 'Selected' : ''}}>{{ $ak->nm_akun
                    }}</option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="col-sm-2 col-md-2">
        <div class="form-group">
            <label for="list_kategori">Debit</label>
            <input type="number" class="form-control total " value="{{$kredit->kredit}}" id="total" name="total"
                readonly>
        </div>
    </div>
    <div class="col-sm-2 col-md-2">
        <div class="form-group">
            <label for="list_kategori">Kredit</label>
            <input type="number" class="form-control" readonly>
        </div>
    </div>

    <div class="col-sm-3 col-md-3">
        <!-- <div class="form-group">
          <input class="form-control" type="text" name="no_urutan" placeholder="Nomor id" required>
        </div> -->
    </div>
    <div class="col-1">
        <div class="mt-1">
            <p class="mt-1 ml-3 text-warning"><strong>Cr</strong></p>
        </div>
    </div>

    <div class="col-sm-3 col-md-3">
        <div class="form-group">
            <select name="metode" id="metode" class="select form-control" required="">
                <option value="" data-select2-id="13">-Pilih Akun-</option>
                @foreach ($akun as $a)
                <option value="{{$a->id_akun}}" {{$kredit->id_akun == $a->id_akun ? 'Selected' : ''}}>{{$a->nm_akun}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-2 col-md-2">
        <div class="form-group">
            <input type="number" class="form-control" disabled>
        </div>
    </div>
    <div class="col-sm-2 col-md-2">
        <div class="form-group">

            <input type="number" class="form-control total" value="{{$kredit->kredit}}" id="total1" disabled>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="list_kategori">No Nota</label>
                <input type="text" class="form-control input_detail input_stok" value="{{$debit->no_urutan}}"
                    name="no_id" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="list_kategori">Keterangan</label>
                <input type="text" class="form-control input_detail input_stok" name="keterangan"
                    value="{{$debit->ket}}" required>
            </div>
        </div>
    </div>
    @php
    $i = 1;
    @endphp
    @foreach ($debit2 as $n => $d)
    <div class="row">

        <div class="col-md-2">
            <div class="form-group">
                <label for="list_kategori">List Bahan = Resep</label>
                <select name="id_list_bahan[]" detail="{{$d->id_stok_ts}}" id="id_list_bahan{{ $d->id_stok_ts }}"
                    class="select form-control" required>
                    <option value="">-Pilih data--</option>
                    @foreach ($lBahanDaging as $lb)
                    <option value="{{ $lb->id_list_bahan }}" {{$lb->id_list_bahan == $d->id_bahan ? 'Selected' : ''}}>{{
                        $lb->nm_bahan }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Satuan</label>
                <input type="hidden" id="idSatuanResep{{$d->id_stok_ts}}" readonly name="id_satuan[]"
                    class="form-control input_detail input_stok" value="{{$d->id}}">
                <input type="text" id="satuanResep{{$d->id_stok_ts}}" readonly
                    class="form-control input_detail input_stok" value="{{$d->n}}">
                <span class="text-danger" style="white-space: nowrap"><em>Satuan mengikuti resep</em></span>

            </div>
        </div>
        @php
        $merk = DB::table('tb_merk_bahan')->where('id_list_bahan', $d->id_bahan)->get();
        @endphp
        <div class="col-md-2">
            <div class="form-group">
                <label for="list_kategori">Merk Bahan</label>
                <select name="id_merk_bahan[]" id="id_merk_bahan{{$d->id_stok_ts}}"
                    class="form-control select satuan input_detail input_stok merkBahan ">
                    @foreach ($merk as $m)
                    <option value='{{$m->id_merk_bahan}}' {{$m->id_merk_bahan == $d->id_merk_bahan ? 'Selected' :
                        ''}}>{{$m->nm_merk}}
                    </option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Satuan Beli</label>
                <select name="id_satuanBeli[]" class="form-control select satuan input_detail input_stok" required>
                    <?php foreach ($satuan as $p) : ?>
                    <option value="<?= $p->id ?>" {{$p->id == '18' ? 'Selected' : ''}}>
                        <?= $p->n ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Qty Beli</label>
                <input type="text"
                    class="form-control input_detail input_stok qty_monitoring qty_monitoring{{$d->id_stok_ts}}"
                    id="qtyDaging1" qty=1 name="qty[]" required value="{{$d->qty}}">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Unit Prize</label>
                <input type="text"
                    class="form-control  input_detail input_stok total_rpDaging total_rpDaging{{$d->id_stok_ts}}"
                    name="ttl_rp[]" total_rp='{{$d->id_stok_ts}}' required value="{{$d->unit_prize}}">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Qty Resep</label>
                <input type="text" readonly
                    class="form-control input_detail input_stok qtyResep qtyResep{{$d->id_stok_ts}}"
                    id="qtyResep{{$d->id_stok_ts}}" qty=1 name="qtyResep[]" required value="{{$d->debit}}">
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <label for="list_kategori">Total Rp</label>
                <input readonly type="text" class="form-control input_detail input_stok t_rp t_rp{{$d->id_stok_ts}}"
                    name="t_rp[]" t_rp="1" required value="{{$d->unit_prize * $d->qty}}">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group">
                <label for="">PPN</label>
                <input type="text" class="form-control input_detail input_stok ppn ppn{{$d->id_stok_ts}}" name="ppn[]"
                    required value="{{$d->ppn}}">
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-lg-12">
        <hr>
    </div>
    <div class="col-lg-3">
        <table>
            <td>
                <div class="wrapper">
                    <input type="checkbox" class="onlain" checked>
                </div>
            </td>
            <td>&nbsp; Biaya Lain-lain</td>
        </table>

    </div>
</div>

@foreach ($lain as $l)
<div class="row" id="lain">
    <div class="col-lg-3 mt-2">
        <select name="id_akun_lain[]" id="" class="select form-control inp-lain">
            <option value="">--Pilih Biaya--</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}" {{$l->id_akun == $a->id_akun ? 'Selected' : ''}}>{{$a->nm_akun}} </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 mt-2">
        <input type="number" name="debit_lain[]" class="form-control inp-lain nom_lain nom_lain" detail=''
            value="{{$l->debit}}">
    </div>
</div>
@endforeach
</div>