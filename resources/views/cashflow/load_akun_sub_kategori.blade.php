<table class="table table-hover" id="table3">
    <thead>
        <tr>
            <th width="15">#</th>
            <th>Kategori</th>
            <th>Nama Akun</th>
            <th align="center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($akun as $no => $d)
            <tr>
                <td>{{ $no+1 }}</td>
                <td>
                    <label for="check{{$d->id_akun}}">{{ ucwords($d->nm_kategori) }}</label>
                </td>
                <td for="check{{$d->id_akun}}">
                    <label for="check{{$d->id_akun}}">{{ ucwords($d->nm_akun) }}</label>
                </td>
                @php
                    $checked = DB::table('akun_cashflow')
                            ->where([['id_akun', $d->id_akun],['id_sub_kategori', $id_kategori]])
                            ->first();
                @endphp
                <td>
                    @if (empty($checked->id_akun))
                        <input class="form-check-input checkAkun" name="type" type="checkbox" id_kategori="{{ $id_kategori }}" id_akun="{{ $d->id_akun }}" id="check{{$d->id_akun}}">
                    @else
                        <input checked class="form-check-input checkAkun" name="type" type="checkbox" id_kategori="{{ $id_kategori }}" id_akun="{{ $d->id_akun }}" id="check{{$d->id_akun}}">
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>