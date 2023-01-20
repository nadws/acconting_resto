<div class="row" id="row{{$count}}">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">List Bahan = Resep</label>
            <select name="id_list_bahan[]" detail="{{$count}}" id="id_list_bahan1"
                class="id_list_bahan form-control select satuan input_detail input_stok listBahan listBahan{{$count}}"
                required>
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
            <input type="hidden" id="idSatuanResep{{$count}}" readonly name="id_satuan[]"
                class="form-control input_detail input_stok">
            <input type="text" id="satuanResep{{$count}}" readonly class="form-control input_detail input_stok">
            <span class="text-danger" style="white-space: nowrap"><em>Satuan mengikuti resep</em></span>

        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Merk Bahan</label>
            <select name="id_merk_bahan[]" id="id_merk_bahan{{$count}}"
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
            <input type="text" class="form-control input_detail input_stok qty_monitoring qty_monitoring{{$count}}"
                id="qtyDaging1" qty=1 name="qty[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Unit Prize</label>
            <input type="text" class="form-control  input_detail input_stok total_rpDaging total_rpDaging{{$count}}"
                name="ttl_rp[]" total_rp='{{$count}}' required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty Resep</label>
            <input type="text" readonly class="form-control input_detail input_stok qtyResep qtyResep{{$count}}"
                id="qtyResep1" qty=1 name="qtyResep[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Total Rp</label>
            <input readonly type="text" class="form-control input_detail input_stok t_rp t_rp{{$count}}" name="t_rp[]"
                t_rp="1" required>
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="">PPN</label>
            <input type="text" class="form-control input_detail input_stok ppn ppn{{$count}}" name="ppn[]" required>
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="">Aksi</label> <br>
            <a href="#" class="btn btn-danger remove_monitoring btn-sm" count="{{$count}}"><i
                    class="fas fa-trash"></i></a>
        </div>
    </div>
</div>