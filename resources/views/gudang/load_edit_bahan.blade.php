<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Nama Bahan</label>
            <input value="{{ $detail->nm_bahan }}" type="text" name="nm_bahan" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <input type="hidden" name="id_list_bahan" value="{{ $detail->id_list_bahan }}">
            <label for="list_kategori">Satuan</label>
            <select name="id_satuan" id="" class="select">
                @foreach ($satuan as $s)
                <option {{$s->id_satuan == $detail->id_satuan ? 'selected' : ''}} value="{{$s->id_satuan}}">{{$s->nm_satuan}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Kategori</label>
            <select name="id_kategori_makanan" id="" class="select">
                @foreach ($kategori as $k)
                    <option {{$k->id_kategori_makanan == $detail->id_kategori_makanan ? 'selected' : ''}} value="{{$k->id_kategori_makanan}}">{{$k->nm_kategori}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Monitoring</label> <br>
            <div class="form-check form-switch form-switch2">
                <input class="form-check-input form-check-input2 " {{$detail->monitoring == 'Y' ? 'checked' : ''}} name="monitoring" value="Y"
                    type="checkbox" id="flexSwitchCheckDefault" />
            </div>
        </div>
    </div>
</div>