<div id="baris{{$count}}" class="row">
    <div class="col-lg-6 mt-2 col-6">
        <select name="id_akun[]" id="" class="select form-control id_bahan id_bahan{{$count}}" detail='{{$count}}'>
            <option value="">- Pilih Akun -</option>
            @foreach ($akun as $l)
            <option value="{{$l->id_akun}}">{{$l->nm_akun}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4 col-4 mt-2">
        <input name="rupiah[]" style="text-align: right" type="text" class="form-control total{{$count}} rpBiaya"
            value="0">
    </div>
    <div class="col-lg-2 col-2 mt-2">
        <a href="#" class="btn rounded-pill remove_baris" count="{{$count}}"><i
                class="fas fa-trash text-danger"></i></a>
    </div>
</div>