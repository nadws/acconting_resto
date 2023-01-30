<table class="table" id="tableDetailAkun">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>No Nota</th>
            <th>Post Akun</th>
            <th>Post Center</th>
            <th>Keterangan</th>
            <th>Debit</th>
            <th>Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($akun as $no => $d)
            <tr>
                <td>{{ $no+1 }}</td>
                <td>{{ $d->tgl }}</td>
                <td>{{ $d->no_nota }}</td>
                <td>{{ $d->nm_akun }}</td>
                <td>post</td>
                <td>{{ $d->ket }}</td>
                <td>{{ number_format($d->debit,0) ?? 0 }}</td>
                <td>{{ number_format($d->kredit,0) ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>