<tr id="baris{{$count}}">
    <th>Pembayaran</th>
    <th>:</th>
    <td width="25%">
        <select class="select form-control " name="akun2[]" required>
            <option value="">-Pilih Pembayaran-</option>
            @foreach ($akun as $a)
            <option value="{{$a->id_akun}}">{{$a->nm_akun}}</option>
            @endforeach
        </select>

    </td>
    <td width="25%">
        <input type="text" name="pembayaran[]" class="form-control bayar{{$count}} bayar" urutan='{{$count}}'
            style="text-align: right">
    </td>
    <td width="5%">
        <a href="#" class="btn rounded-pill remove_baris" count="{{$count}}"><i
                class="fas fa-trash-alt text-danger"></i></a>
    </td>
</tr>