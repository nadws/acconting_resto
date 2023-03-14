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
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('sistem_po') }}">Purchase
                                Order (PO)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('pembelian_po') }}">Pembelian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('timbang') }}">Timbang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pembayaran') }}">Pembukuan</a>
                        </li>
                    </ul>

                    <x-btn-setting />

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Po</th>
                                    <th>Total Rp Po</th>
                                    <th>Total Rp Beli</th>
                                    <th>Admin Po</th>
                                    <th>Admin Beli</th>
                                    <th>Status</th>
                                    <th>Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($p->tgl)) }}</td>
                                    <td>
                                        {{ $p->no_po }}
                                    </td>

                                    <td>Rp. {{ number_format($p->total, 0) }}</td>
                                    <td>Rp. {{ number_format($p->total_beli, 0) }}</td>
                                    <td>{{ $p->admin }}</td>
                                    <td>{{ $p->admin_beli }}</td>
                                    <td>
                                        <span class=" badge bg-{{ $p->po != $p->beli ? 'danger' : 'success' }}"><i
                                                class="fas {{ $p->po != $p->beli ? 'fa-clipboard-list' : 'fa-tasks' }} "></i>
                                            {{ $p->po != $p->beli ? 'Diproses' : 'Selesai' }}</span>
                                    </td>
                                    <td>
                                        @if (!empty($tambah))
                                        @if ($p->po != $p->beli)
                                        <a href="{{ route('tambah_beli', ['no_po' => $p->no_po]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Pembelian"
                                            class="btn btn-sm btn-primary">Belanja
                                        </a>
                                        @else
                                        <a href="{{ route('tambah_beli', ['no_po' => $p->no_po]) }}"
                                            class="btn btn-sm btn-primary disabled">Belanja
                                        </a>
                                        @endif
                                        @endif
                                        @if (!empty($history))
                                        <a href="" data-bs-toggle="modal" data-bs-target="#detail"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Nota Pembelian"
                                            no_po="{{ $p->no_po }}" class="btn btn-warning btn-sm detail">History</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-modal id="detail" title="Daftar {{ $title }}" size="modal-lg">
        <div id=detail_po></div>
    </x-modal>

    <x-modal id="detail_sub" title="Daftar {{ $title }}" size="modal-lg-max2">
        <div id=detail_sub_po></div>
    </x-modal>

    <x-modal id="print" title="Daftar {{ $title }}" size="modal-lg-max2">
        <div id="nota"></div>
    </x-modal>

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
                    <input type="hidden" name="route" value="pembelian_po">
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
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
            $(document).on('click', '.detail', function() {

                var no_po = $(this).attr('no_po');
                $.ajax({
                    url: "{{ route('detail_po2') }}?no_po=" + no_po,
                    type: "Get",
                    success: function(data) {

                        $('#detail_po').html(data);
                    }
                });
            });
            $(document).on('click', '.print', function() {

                var no_po = $(this).attr('no_po');
                $.ajax({
                    url: "{{ route('print_detail') }}?no_po=" + no_po,
                    type: "Get",
                    success: function(data) {

                        $('#nota').html(data);
                    }
                });
            });
            $(document).on('click', '.detail_sub', function() {
                var sub_po = $(this).attr('sub_po');
                $("#detail_sub").modal('show')
                $.ajax({
                    url: "{{ route('detail_sub') }}?sub_po=" + sub_po,
                    type: "Get",
                    success: function(data) {
                        $('#detail_sub_po').html(data);
                        $('#tb_bkin').DataTable({
                            "paging": false,
                            "pageLength": 100,
                            "scrollY": "100%",
                            "lengthChange": false,
                            // "ordering": false,
                            "info": false,
                            "stateSave": true,
                            "autoWidth": true,
                            // "order": [ 5, 'DESC' ],
                            "searching": true,
                        });

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