<tr id="baris{{$count}}">
    <td>
        <select name="id_bahan[]" id="" class="form-control  select id_bahan id_bahan{{$count}}" detail='{{$count}}'>
            <option value="">Pilih Bahan</option>
            @foreach ($list_bahan as $l)
            <option value="{{$l->id_list_bahan}}">{{$l->nm_bahan}} </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" name="qty[]" style="text-align: right;" class="form-control qty_beli qty_beli{{$count}}"
            value="0" detail='{{$count}}'>
    </td>
    <td>
        <select name="id_satuan[]" id="" class="form-control  satuan{{$count}} select">
            <option value="">Pilih Satuan</option>
            @foreach ($satuan as $l)
            <option value="{{$l->id_satuan}}">{{$l->nm_satuan}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" name="h_satuan[]" style="text-align: right;" class="form-control h_satuan h_satuan{{$count}}"
            value="0" detail='{{$count}}'>
    </td>
    <td>
        <input type="text" name="ttl_rp[]" style="text-align: right;" class="form-control total{{$count}}" value="0"
            readonly>
    </td>
    <td><a href="#" class="btn rounded-pill remove_baris" count="{{$count}}"><i
                class="fas fa-trash text-danger"></i></a></td>
</tr>