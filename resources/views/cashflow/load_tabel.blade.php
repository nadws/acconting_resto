<table class="table" id="tableLoad">
    <thead>
        <tr>
            <th>Cashflow</th>
            <th>Rp</th>
            <th>Aksi</th>
            {{-- <th>Pemasukan &nbsp; <button id="btnSubKategori" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i> Kategori</button></th>
            <th></th> --}}
        </tr>
        <tr>
            <th>Pemasukan</th>
            <th></th>
            <th><button jenis="1" class="btn btn-sm btn-primary btnSubKategori"><i class="bi bi-plus-circle"></i> Kategori</button></th>
        </tr>
    </thead>
    <tbody>
        @php           
            $ttlKredit1 = 0;
            $ttlDebit1 = 0;
        @endphp
        @foreach ($subKategori1 as $d)
        <input type="hidden" class="id_sub_kategori" value="{{ $d->id }}">
            <tr>
                <td>&emsp;&emsp;{{ ucwords($d->sub_kategori) }}</td>
                <td></td>
                <td><button class="btn btn-sm btn-primary btnSubKategoriAkun" id="{{ $d->id }}"><i class="bi bi-plus-circle"></i> Akun</button></td>
            </tr>
            @php

                $akun1 = DB::select("SELECT b.nm_akun,b.id_akun,c.id_sub_kategori,a.kd_gabungan, sum(a.kredit) as kredit, a.debit FROM tb_jurnal as a
                        LEFT JOIN tb_akun_fix as b ON a.id_akun = b.id_akun
                        LEFT JOIN akun_cashflow as c ON b.id_akun = c.id_akun
                        WHERE c.id_sub_kategori = '$d->id' AND a.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY a.id_akun");
            @endphp
            @foreach ($akun1 as $a)
            @php
                $kredit = $a->kredit;
                $debit = $a->debit;

                $ttlKredit1 += $kredit;
                $ttlDebit1 += $debit;
            @endphp
            <tr>
                <td>&emsp;&emsp;&emsp;&emsp; <a href="#" class="detailAkun" kd_gabungan="{{$a->kd_gabungan}}" id_kategori="{{ $a->id_sub_kategori }}" id_akun="{{ $a->id_akun }}">{{ ucwords($a->nm_akun) }}</a></td>
                <td>Rp. {{ number_format($kredit,0) }}</td>
                <td></td>
            </tr>
            @endforeach
        @endforeach
        <tr>
            <th>Pengeluaran</th>
            <th></th>
            <th><button jenis="2" class="btn btn-sm btn-primary btnSubKategori"><i class="bi bi-plus-circle"></i> Kategori</button></th>
        </tr>
        @php
            $ttlKredit2 = 0;
            $ttlDebit2 = 0;
        @endphp
        @foreach ($subKategori2 as $d)
        <input type="hidden" class="id_sub_kategori" value="{{ $d->id }}">
            <tr>
                <td>&emsp;&emsp;{{ ucwords($d->sub_kategori) }}</td>
                <td></td>
                <td><button class="btn btn-sm btn-primary btnSubKategoriAkun" id="{{ $d->id }}"><i class="bi bi-plus-circle"></i> Akun</button></td>
            </tr>
            @php
                $akun2 = DB::select("SELECT c.id_sub_kategori,a.id_akun,a.kd_gabungan,b.nm_akun, a.kredit, sum(a.debit) as debit FROM tb_jurnal as a
                        LEFT JOIN tb_akun_fix as b ON a.id_akun = b.id_akun
                        LEFT JOIN akun_cashflow as c ON b.id_akun = c.id_akun
                        WHERE c.id_sub_kategori = '$d->id' AND a.tgl BETWEEN '$tgl1' AND '$tgl2' GROUP BY a.id_akun");
            @endphp
            @foreach ($akun2 as $a)
            @php
                $kredit = $a->kredit;
                $debit = $a->debit;

                $ttlKredit2 += $kredit;
                $ttlDebit2 += $debit;
            @endphp
            <tr>
                <td>&emsp;&emsp;&emsp;&emsp; <a href="#" class="detailAkun" kd_gabungan="{{$a->kd_gabungan}}" id_kategori="{{ $a->id_sub_kategori }}" id_akun="{{ $a->id_akun }}">{{ ucwords($a->nm_akun) }}</a></td>
                <td>Rp. {{ number_format($debit,0) }}</td>
                <td></td>
            </tr>
            @endforeach
        @endforeach
        <tr>
            <th>Selisih Pemasukan & Pengeluaran</th>
            <th>Rp. {{ number_format(($ttlKredit1 + $ttlKredit2) - ($ttlDebit2 + $ttlDebit1),0) }}</th>
            <th></th>
        </tr>
        
    </tbody>
</table>