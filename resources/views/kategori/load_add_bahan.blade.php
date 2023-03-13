<input type="hidden" name="id_kategori_makanan" value="{{ $id_kategori }}">
<table width="100%" class="table table-hover" id="tableBahan">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th>Nama Bahan</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $nos = 1;
        @endphp 
        @foreach ($bahan as $no => $d)
            @php
            $ada = DB::table('tb_bahan_kategori_makanan')
                        ->where([['id_list_bahan', $d->id_list_bahan], ['id_kategori','!=', $id_kategori]])
                        ->first();
                $checked = DB::table('tb_bahan_kategori_makanan')
                    ->where([['id_list_bahan', $d->id_list_bahan], ['id_kategori', $id_kategori]])
                    ->first();
                $check = !empty($checked) ? 'checked' : '';
            @endphp
            @if (!$ada)
                
            <tr>
                <td>{{ $nos++ }}</td>
                <td><label for="check-{{ $no + 1 }}">{{ $d->nm_bahan }}</label></td>
                <td align="center">

                    <input {{ $check }} class="form-check-input checkAkun" name="id_list_bahan[]"
                        value="{{ $d->id_list_bahan }}" type="checkbox" class="form-check"
                        id="check-{{ $no + 1 }}">


                </td>
            </tr>
            @endif
            
        @endforeach
    </tbody>
</table>
