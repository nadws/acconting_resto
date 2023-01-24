<hr>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">No Nota</label>
            <input type="text" class="form-control input_detail " name="no_id[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Tujuan</label>
            <input type="text" class="form-control input_detail " name="tujuan[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Keterangan</label>
            <input type="text" class="form-control input_detail " name="keterangan[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Post Center</label>
            <select name="id_post_center[]" id="" class="select form-control">
                <option value="">-Pilih Post Center-</option>
                @foreach ($post_center as $p)
                <option value="{{$p->id_post}}">{{$p->nm_post}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Satuan</label>
            <select name="id_satuanBeli[]" id="satuanBeli1" class="form-control select satuan input_detail " required>
                <?php foreach ($satuan as $p) : ?>
                <option value="{{$p->id_satuan}}">{{$p->nm_satuan}}</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label for="list_kategori">Qty</label>
            <input type="text" class="form-control input_detail " name="qty[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Rupiah</label>
            <input type="text" class="form-control input_detail rupiah_biaya" name="rupiah[]" required>
        </div>
    </div>

    <div id="tambah_input_jurnal_biaya">

    </div>
    <div align="right" class="mt-2 col-lg-12">
        <button type="button" class="btn btn-block btn-lg  tbh-biaya" id_akun="{{$id_akun}}"
            style="background-color: #F4F7F9; color: #8FA8BD"><i class="fas fa-plus"></i> Tambah Baris Baru</button>
    </div>



</div>