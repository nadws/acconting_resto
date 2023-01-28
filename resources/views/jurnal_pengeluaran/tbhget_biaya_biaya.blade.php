<div class="row" id="biaya{{$count}}">
    <div class="col-md-2">
        <div class="form-group">

            <input type="text" class="form-control input_detail " name="no_id[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">

            <input type="text" class="form-control input_detail " name="tujuan[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">

            <input type="text" class="form-control input_detail " name="keterangan[]" required>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">

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

            <select name="id_satuanBeli[]" id="satuanBeli{{$count}}" class="form-control select satuan input_detail "
                required>
                <?php foreach ($satuan as $p) : ?>
                <option value="{{$p->id_satuan}}">{{$p->nm_satuan}}</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">

            <input type="text" class="form-control input_detail " name="qty[]" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <input type="text" class="form-control input_detail rupiah_biaya" name="rupiah[]" required>
        </div>
    </div>

    <div class="col-lg-1">
        <button type="button" class="btn btn-danger remove_lain  btn-sm " count="{{$count}}"><i
                class="fas fa-trash"></i></button>
    </div>





</div>