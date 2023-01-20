<div class="row" id="lain{{$count}}">
    <div class="col-lg-3 mt-2">
        <select name="id_akun_lain[]" id="" class="select form-control inp-lain">
            <option value="">--Pilih Biaya--</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 mt-2">
        <input type="number" name="debit_lain[]" class="form-control inp-lain nom_lain nom_lain{{$count}}"
            detail='{{$count}}' value="0">
    </div>
    <div class="col-lg-1 mt-2">
        <button type="button" class="btn btn-danger remove_lain  btn-sm " count="{{$count}}"><i
                class="fas fa-trash"></i></button>
    </div>
</div>