<table class="table">
    <thead>
        <tr>
            <th width="30%">Bahan</th>
            <th width="10%" style="text-align: right;">Qty</th>
            <th width="15%">Satuan Beli</th>
            <th width="15%" style="text-align: right;">Rp Satuan</th>
            <th width="20%" style="text-align: right;">Total Rp</th>
            <th width="5%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_bahan as $l)
        <tr id="baris{{$l->id_list_bahan}}">
            <td>
                {{$l->nm_bahan}}
                <input type="hidden" name="id_bahan[]" class="form-control" value="{{$l->id_list_bahan}}">
            </td>
            <td>
                <input type="text" name="qty[]" style="text-align: right;" class="form-control qty_beli qty_beli1"
                    value="0" detail='1' required>
            </td>
            <td>
                <select name="id_satuan[]" id="" class="form-control   select" required>
                    @foreach ($satuan as $s)
                    <option value="{{$s->id_satuan}}">{{$s->nm_satuan}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="h_satuan[]" style="text-align: right;" class="form-control h_satuan h_satuan1"
                    value="0" detail='1' required>
            </td>
            <td>
                <input type="text" name="ttl_rp[]" style="text-align: right;" class="form-control total1" value="0"
                    readonly>
            </td>
            <td><a href="#" class="btn rounded-pill remove_baris" count="{{$l->id_list_bahan}}"><i
                        class="fas fa-trash text-danger"></i></a></td>
        </tr>
        @endforeach

    </tbody>
    <tbody id="tb_stok">

    </tbody>
    <tfoot>
        <tr>
            <th colspan="7">
                <button type="button" class="btn btn-block btn-lg tbh_baris"
                    style="background-color: #F4F7F9; color: #8FA8BD; font-size: 14px; padding: 13px;">
                    <i class="fas fa-plus"></i> Tambah Baris Baru

                </button>
            </th>
        </tr>
    </tfoot>


</table>