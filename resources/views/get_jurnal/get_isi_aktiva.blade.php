<hr>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">No Id</label>
            <input type="text" class="form-control input_detail " name="no_id[]" required>
        </div>
    </div>
    <div class="col-md-2">
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
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Keterangan</label>
            <input type="text" class="form-control input_detail " name="keterangan[]" required>
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
            <input type="text" class="form-control input_detail qty_aktiva" name="qty[]" value="0" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Rp/Satuan</label>
            <input type="text" class="form-control input_detail rupiah_biaya rps_aktiva" value="0" name="rupiah[]"
                required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">PPN</label>
            <input type="text" class="form-control input_detail rupiah_biaya ppn_biaya" value="0" name="rupiah[]"
                required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="list_kategori">Rupiah + Pajak</label>
            <input type="text" class="form-control input_detail rupiah_biaya ttl_rp_aktiva" name="rupiah[]" readonly>
        </div>
    </div>

    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Nama Kelompok</th>
                    <th>Umur</th>
                    <th>Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelompok as $k)
                <tr>
                    <td><input type="radio" name="id_kelpok" value="{{$k->id_kelompok}}" id=""></td>
                    <td>{{$k->nm_kelompok}}</td>
                    <td>{{$k->umur}}</td>
                    <td>{{$k->barang_kelompok}}</td>
                </tr>
                @endforeach
            </tbody>


        </table>
    </div>





</div>