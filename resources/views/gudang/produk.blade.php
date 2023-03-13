@extends('theme.app')
@section('content')
<style>
    .form-switch2 .form-check-input2 {
        background-image: url(data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3E%3Ccircle r='3' fill='rgba(0, 0, 0, 0.25)'/%3E%3C/svg%3E);
background-position: 0;
        border-radius: 2em;
        margin-left: -2.5em;
        transition: background-position .15s ease-in-out;
        width: 40px;
        transform: scale(2);
        margin-top: 8px;
        margin-left: -22px;
    }
</style>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('produk', 1) }}">Bahan &
                                barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gudang') }}">Opname</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kategori_bahan') }}">Kategori Bahan</a>
                        </li>
                    </ul>
                    <x-btn-setting />

                    @if (!empty($tambah))
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                        class="me-2 btn icon icon-left btn-primary" style="float: right"><i
                            class="bi bi-plus-circle"></i> Tambah</a>
                    @endif
                </div>
                <div class="card-body">

                    <table class="table" id="tb_bkin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan </th>
                                <th>Kategori </th>
                                <th>Stok</th>
                                <th>Satuan </th>
                                <th>Monitor </th>
                                <th>Opname Countdown </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gudang as $no => $j)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td><a href="#" class="merk" id_list_bahan="{{ $j->id_list_bahan }}"
                                        data-bs-toggle="modal" data-bs-target="#merk">{{ $j->nm_bahan }}</a></td>
                                <td>{{ $j->nm_kategori }}</td>

                                @php
                                $debit = empty($j->debit) ? '0' : $j->debit;
                                $kredit = empty($j->kredit) ? '0' : $j->kredit;
                                $stk = $debit - $kredit;
                                $tgl1 = date('Y-m-d');
                                $tgl2 = date('Y-m-d', strtotime('30 days', strtotime($j->tgl)));

                                if (empty($j->tgl)) {
                                $tKerja = '0';
                                } else {
                                $totalKerja = new DateTime($tgl1);
                                $today = new DateTime($tgl2);
                                $tKerja = $today->diff($totalKerja);
                                }
                                @endphp
                                <td>{{ number_format($stk, 0) }}</td>
                                <td>{{ $j->n }}</td>
                                <td>
                                    <i
                                        class="{{ $j->monitoring == 'Y' ? 'text-success fas fa-2x fa-check-circle' : 'text-danger fas fa-2x fa-times-circle' }}"></i>
                                </td>

                                <td align="center">{{ $tKerja == '0' ? ' - ' : $tKerja->d }} </td>
                                <td style="white-space: nowrap">
                                    @if (!empty($update))
                                    <a href="#" class="btn btn-sm btn-warning editBahan"
                                        idListBahan="{{ $j->id_list_bahan }}"><i class="fas fa-pen"></i></a>
                                    @endif
                                    @php
                                    $adaStok = DB::table('stok_ts')
                                    ->where('id_bahan', $j->id_list_bahan)
                                    ->first();
                                    @endphp
                                    @if (!empty($delete))
                                        @if (empty($adaStok))
                                        <a href="{{ route('hapusBahan', [$j->id_list_bahan, $id_jenis]) }}"
                                            onclick="return confirm('Yakin ingin dihapus ?')"
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>


                </div>
            </div>

        </section>
    </div>

    <x-modal id="tambah" title="Tambah {{ $title }}" btnSave="Y" size="modal-lg-max">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="id_jenis" value="{{ $id_jenis }}">
                    <label for="list_kategori">Nama Bahan</label>
                    <input type="text" name="nm_bahan" class="form-control">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="list_kategori">Satuan</label>
                    <select name="id_satuan" id="" class="select2">
                        @foreach ($satuan as $s)
                        <option value="{{ $s->id_satuan }}">{{ $s->nm_satuan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="list_kategori">Kategori</label>
                    <select name="id_kategori_makanan" id="" class="select2">
                        @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori_makanan }}">{{ $k->nm_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="list_kategori">Monitoring</label> <br>
                    <div class="form-check form-switch form-switch2">
                        <input class="form-check-input form-check-input2 " name="monitoring" value="Y" type="checkbox"
                            id="flexSwitchCheckDefault" />
                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    <form action="{{ route('edit_bahan') }}" method="post">
        @csrf
        <x-modal id="editBahan" title="Edit {{ $title }}" btnSave="Y" size="modal-lg-max">
            <input type="hidden" name="id_jenis" value="{{ $id_jenis }}">
            <div id="loadEditBahan"></div>
        </x-modal>
    </form>

    <x-modal id="merk" title="Merk {{ $title }}" btnSave="" size="modal-lg">
        <div id="merk_bahan"></div>
    </x-modal>


    <form id="tambah_bahan">
        <x-modal id="tbh_merk" title="Merk {{ $title }}" btnSave="Y" size="">
            <div class="row">
                <div class="col-lg-12">
                    <label for="">Nama Merk</label>
                    <input type="text" name="nm_merk" class="form-control nm_merk">
                    <input type="hidden" name="id_list_bahan" id="id_list_bahan" class="form-control">
                </div>
            </div>
        </x-modal>
    </form>

    <form action="{{ route('save_permission') }}" method="post">
        @csrf
        <x-modal id="akses" title="Setting Akses" btnSave="Y" size="modal-lg-max">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Halaman</th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                    @php
                    $akses = DB::selectOne("SELECT a.*, b.id_permission_page FROM permission_button_gudang
                    AS
                    a
                    LEFT JOIN (
                    SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
                    WHERE b.id_user ='$u->id' AND b.id_permission_gudang = '$halaman'
                    ) AS b ON b.id_permission_button = a.id_permission_button");

                    $create = btnSetHal($halaman, $u->id, 'create');


                    $update = btnSetHal($halaman, $u->id, 'update');

                    $delete = btnSetHal($halaman, $u->id, 'delete');

                    @endphp
                    <input type="hidden" name="route" value="produk">
                    <input type="hidden" name="id" value="1">
                    <tr>
                        <td>{{ $u->nama }}</td>

                        <td>
                            <label><input type="checkbox" class="akses_h akses_h{{ $u->id }}" id_user="{{ $u->id }}"
                                    id_user="{{ $u->id }}" {{ empty($akses->id_permission_page) ? '' : 'Checked' }} />
                                Akses</label>
                            <input type="hidden" class="open_check{{ $u->id }}" name="id_user[]" {{
                                empty($akses->id_permission_page) ? 'disabled' : '' }}
                            value="{{ $u->id }}">
                        </td>
                        <td>
                            <input type="hidden" name="id_permission_gudang" value="{{ $halaman }}">

                            @foreach ($create as $c)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $c->id_permission_button }}" {{ empty($c->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $c->nm_permission_button !!}</label>
                            <br>
                            @endforeach
                        </td>
                        <td>

                            @foreach ($update as $r)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $r->nm_permission_button !!}</label> <br>
                            @endforeach
                        </td>
                        <td>

                            @foreach ($delete as $r)
                            <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                    value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' :
                                'Checked' }}
                                class="open_check{{ $u->id }}"
                                {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                                {!! $r->nm_permission_button !!}</label> <br>
                            @endforeach
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </x-modal>
    </form>
    
    @endsection

    @section('scripts')
    <script>
        $(document).ready(function() {

                function toast(pesan) {
                    Toastify({
                        text: pesan,
                        duration: 3000,
                        style: {
                            background: "#EAF7EE",
                            color: "#7F8B8B"
                        },
                        close: true,
                        avatar: "https://cdn-icons-png.flaticon.com/512/190/190411.png"
                    }).showToast();
                }

                $(document).on('click', '.editBahan', function() {
                    var idListBahan = $(this).attr('idListBahan')
                    $('#editBahan').modal('show')
                    $.ajax({
                        type: "GET",
                        url: "{{ route('loadEditBahan') }}?idListBahan=" + idListBahan,
                        success: function(r) {
                            $("#loadEditBahan").html(r)
                            $('.select').select2({
                                dropdownParent: $('#editBahan .modal-content')
                            });

                        }
                    });
                })


                function load_bahan(id_list_bahan) {
                    $.ajax({
                        url: "{{ route('get_merk') }}",
                        method: "GET",
                        data: {
                            id_list_bahan: id_list_bahan,
                        },
                        success: function(data) {
                            $('#merk_bahan').html(data);
                        }
                    });
                }
                $(document).on('click', '.merk', function() {
                    var id_list_bahan = $(this).attr('id_list_bahan');
                    load_bahan(id_list_bahan);
                });

                $(document).on('click', '.tb_merk', function() {
                    var id_list_bahan = $(this).attr("id_list_bahan");
                    $("#id_list_bahan").val(id_list_bahan);
                    $("#tbh_merk").modal('show')
                });

                $(document).on('submit', '#tambah_bahan', function(e) {
                    e.preventDefault()
                    var nm_merk = $(".nm_merk").val();
                    var id_list_bahan = $("#id_list_bahan").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_bahan') }}",
                        data: {
                            nm_merk: nm_merk,
                            id_list_bahan: id_list_bahan
                        },
                        success: function(response) {
                            toast('Berhasil menambah merk bahan')

                            $('#tbh_merk').modal('hide');
                            $(".nm_merk").val('')
                            load_bahan(id_list_bahan)
                        }
                    });

                });

                $(document).on('click', '.delete_bahan', function() {
                    if (confirm('Yakin dihapus ?')) {
                        var id_merk_bahan = $(this).attr("id_merk_bahan");
                        var id_list_bahan = $(this).attr("id_list_bahan");
                        $.ajax({
                            type: "GET",
                            url: "{{ route('delete_bahan') }}",
                            data: {
                                id_merk_bahan: id_merk_bahan,
                                id_list_bahan: id_list_bahan,
                            },
                            success: function(response) {
                                toast('Berhasil hapus merk bahan')
                                load_bahan(id_list_bahan)
                            }
                        });
                    }

                });

                $(document).on('click', '.akses_h', function() {
                    var id_user = $(this).attr('id_user');
                    if ($('.akses_h' + id_user).prop("checked") == true) {
                        $('.open_check' + id_user).removeAttr('disabled');
                    } else {
                        $('.open_check' + id_user).prop('disabled', true);

                    }

                });
            });
    </script>
    @endsection