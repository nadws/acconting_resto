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
        width: 25px;
        height: 25px;
        background: #107AAE;
        border-radius: 50%;
        top: 50%;
        left: 10px;
        transform: scale(1) translateY(-50%);
        transform-origin: 50% 50%;
    }

    input[type="checkbox"]:checked:before {
        left: calc(100% - 35px);
    }

    input[type="checkbox"]:checked:after {
        left: 75px;
        transform: scale(0);
    }
</style>
<hr>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">No Nota</label>
            <input type="text" class="form-control input_detail input_stok" name="no_id" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Keterangan</label>
            <input type="text" class="form-control input_detail input_stok" name="keterangan" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">List Bahan = Resep</label>
            <select name="id_list_bahan[]" detail="1" id="id_list_bahan1"
                class="id_list_bahan form-control select satuan input_detail input_stok listBahan listBahan1" required>
                <option value="">-Pilih data--</option>
                @foreach ($lBahanDaging as $lb)
                <option value="{{ $lb->id_list_bahan }}">{{ $lb->nm_bahan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Satuan</label>
            <input type="hidden" id="idSatuanResep1" readonly name="id_satuan[]"
                class="form-control input_detail input_stok">
            <input type="text" id="satuanResep1" readonly class="form-control input_detail input_stok">
            <span class="text-danger" style="white-space: nowrap"><em>Satuan mengikuti resep</em></span>

        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Merk Bahan</label>
            <select name="id_merk_bahan[]" id="id_merk_bahan1"
                class="form-control select satuan input_detail input_stok merkBahan ">

            </select>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Satuan Beli</label>
            <select name="id_satuanBeli[]" id="satuanBeli1" class="form-control select satuan input_detail input_stok"
                required>
                <?php foreach ($satuan as $p) : ?>
                <option value="<?= $p->id ?>">
                    <?= $p->n ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty Beli</label>
            <input type="text" class="form-control input_detail input_stok qty_monitoring qty_monitoring1"
                id="qtyDaging1" qty=1 name="qty[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Unit Prize</label>
            <input type="text" class="form-control  input_detail input_stok total_rpDaging total_rpDaging1"
                name="ttl_rp[]" total_rp='1' required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty Resep</label>
            <input type="text" readonly class="form-control input_detail input_stok qtyResep qtyResep1" id="qtyResep1"
                qty=1 name="qtyResep[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input readonly type="text" class="form-control input_detail input_stok t_rp t_rp1" name="t_rp[]" t_rp="1"
                required>
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="">PPN</label>
            <input type="text" class="form-control input_detail input_stok ppn ppn1" name="ppn[]" required>
        </div>
    </div>
</div>


<div id="tambah_input_jurnal">

</div>
<div align="right" class="mt-2 col-lg-12">
    <button type="button" class="btn btn-block btn-lg  tbh-stok" style="background-color: #F4F7F9; color: #8FA8BD"><i
            class="fas fa-plus"></i> Tambah Baris Baru</button>
</div>
<div class="col-lg-12">
    <hr>
</div>
<div class="col-lg-3">
    <table>
        <td>
            <div class="wrapper">
                <input type="checkbox" class="onlain">
            </div>
        </td>
        <td>&nbsp; Biaya Lain-lain</td>
    </table>

</div>
</div>