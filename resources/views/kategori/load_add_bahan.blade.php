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
        <tr>
            <td>{{ $nos++ }}</td>
            <td><label for="check-{{ $no + 1 }}">{{ $d->nm_bahan }}</label></td>
            <td align="center">

                <input checked class="form-check-input checkAkun" name="id_list_bahan[]" value="{{ $d->id_list_bahan }}"
                    type="checkbox" class="form-check" id="check-{{ $no + 1 }}">


            </td>
        </tr>
        @endforeach
        @foreach ($bahan2 as $no2 => $e)
        <tr>
            <td>{{ $nos++ }}</td>
            <td><label for="check-{{ $no2 + 1 }}">{{ $e->nm_bahan }}</label></td>
            <td align="center">

                <input class="form-check-input checkAkun" name="id_list_bahan[]" value="{{ $e->id_list_bahan }}"
                    type="checkbox" class="form-check" id="check-{{ $no2 + 1 }}">


            </td>
        </tr>
        @endforeach
    </tbody>
</table>