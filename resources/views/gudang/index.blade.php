@extends('theme.app')
@section('content')
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
            <form action="{{ route('save_opname') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="{{ route('produk', 1) }}">Bahan &
                                    barang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('gudang') }}">Opname</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kategori_bahan') }}">Kategori Bahan</a>
                            </li>
                        </ul>
                        <x-btn-setting />

                        @if (!empty($tambah))
                        <button type="submit" class="me-1 btn icon icon-left btn-primary "
                            style="float: right; margin-left: 2px"><i class="far fa-save"></i>
                            Opname</button>
                        @endif

                        @if (!empty($read))
                        <a href="{{ route('export_opname') }}" class="btn icon icon-left btn-primary"
                            style="float: right;margin-left: 2px"><i class="bi bi-file-earmark-excel"></i>
                            Export</a>
                        @endif
                    </div>
                    <div class="card-body">

                        <table class="table" id="tb_bkin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Stok Program</th>
                                    <th>Stok Aktual</th>
                                    <th>Satuan </th>
                                    <th>Opname Countdown </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gudang as $no => $j)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td><a href="#" class="history" id_list_bahan="{{ $j->id_list_bahan }}"
                                            data-bs-toggle="modal" data-bs-target="#history">{{ $j->nm_bahan }}</a>
                                    </td>
                                    @php
                                    $debit = empty($j->debit) ? '0' : $j->debit;
                                    $kredit = empty($j->kredit) ? '0' : $j->kredit;
                                    $stk = $debit - $kredit;
                                    $tgl1 = date('Y-m-d');
                                    $tgl2 = date('Y-m-d', strtotime('30 days', strtotime($j->tgl1)));

                                    if (empty($j->tgl1)) {
                                    $tKerja = '0';
                                    } else {
                                    $totalKerja = new DateTime($tgl1);
                                    $today = new DateTime($tgl2);
                                    $tKerja = $today->diff($totalKerja);
                                    }

                                    @endphp
                                    <td align="right">{{ number_format($stk, 0) }} </td>
                                    <td width="15%">
                                        <input style="text-align: right" type="text" name="stok_ak[]"
                                            class="form-control" value="{{ $stk }}">
                                        <input type="hidden" name="stok_po[]" class="form-control" value="{{ $stk }}">
                                        <input type="hidden" name="id_satuan[]" class="form-control"
                                            value="{{ $j->id_satuan }}">
                                        <input type="hidden" name="id_list_bahan[]" class="form-control"
                                            value="{{ $j->id_list_bahan }}">
                                    </td>
                                    <td>{{ $j->n }}</td>


                                    <td align="center">{{ $tKerja == '0' ? ' - ' : $tKerja->days }} </td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>


                    </div>
                </div>
            </form>
        </section>
    </div>


    <style>
        .modal-lg-max2 {
            max-width: 900px;
        }
    </style>
    <form action="{{ route('save_bahan') }}" method="post">
        @csrf
        <div class="modal fade text-left tambah" id="tambah">
            <div class="modal-dialog  modal-lg-max2" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah {{ $title }}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
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
                                        <input class="form-check-input form-check-input2 " name="monitoring" value="Y"
                                            type="checkbox" id="flexSwitchCheckDefault" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <div class="modal fade text-left " id="history">
        <div class="modal-dialog  modal-lg-max2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        History {{ $title }}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="history_bahan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('save_permission') }}" method="post">
        @csrf
        <x-modal id="akses" title="Setting Akses" btnSave="Y" size="modal-lg-max">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Halaman</th>
                        <th>Create</th>
                        <th>Read</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                    @php
                    $akses = SettingHal::akses($halaman, $u->id);

                    $create = SettingHal::btnSetHal($halaman, $u->id, 'create');

                    $read = SettingHal::btnSetHal($halaman, $u->id, 'read');

                    

                    @endphp
                    <input type="hidden" name="route" value="gudang">
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

                            @foreach ($read as $r)
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

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Agrika</p>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            $('.select2').select2({});

            $(document).on('change', '.filterKategoriMakanan', function() {
                var id_kategori = $(this).val()
                document.location.href = "{{ route('gudang') }}?id_kategori=" + id_kategori
            })


            $(document).on('click', '.history', function() {
                var id_list_bahan = $(this).attr('id_list_bahan');
                $.ajax({
                    url: "{{ route('get_history_bahan') }}",
                    data: {
                        id_list_bahan: id_list_bahan,
                    },
                    type: "GET",
                    success: function(data) {
                        $('#history_bahan').html(data);
                    }
                });


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