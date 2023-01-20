<hr>
<div class="row">
    <div class="col-lg-12">
        <h4>Biaya Lain-lain</h4>
    </div>
    <div class="col-lg-3">
        <select name="id_akun_lain[]" id="" class="select form-control inp-lain">
            <option value="">--Pilih Biaya--</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2">
        <input type="number" name="debit_lain[]" class="form-control inp-lain nom_lain nom_lain1" detail='1' value="0">
    </div>
    <div class="col-lg-1">
        <button type="button" class="btn  btn-sm tbh-lain" style="background-color: #F4F7F9; color: #8FA8BD"><i
                class="fas fa-plus"></i></button>
    </div>
    <div id="tambah_biaya_lain">

    </div>

</div>