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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="{{ route('sistem_po') }}">Purchase
                                        Order (PO)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('pembelian_po') }}">Pembelian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('timbang') }}">Timbang</a>
                                </li>
                            </ul>

                            <x-btn-setting />
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                                class="btn icon icon-left btn-primary" style="float: right"><i
                                    class="bi bi-plus-circle"></i>
                                Tambah</a> --}}
                        </div>
                        <div class="card-body">

                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>No Po</th>
                                        <th>Admin</th>
                                        <th>Total Rp</th>
                                        <th>Pembeli</th>
                                        <th>Tempat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian as $no => $d)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($d->tgl)) }}</td>
                                        <td><a href="#" class="detailPo" sub_no_po="{{ $d->sub_no_po }}">{{
                                                $d->sub_no_po }}</a></td>
                                        <td>{{ $d->admin }}</td>
                                        <td>Rp. {{ number_format($d->ttl_rp + $d->lain, 0) }}</td>

                                        <td>
                                            {{ $d->pembeli }}
                                        </td>
                                        <td>
                                            {{ $d->tempat_beli }}
                                        </td>
                                        <td>
                                            <h6>
                                                <span class=" badge bg-{{ $d->timbang == 'T' ? 'danger' : 'success' }}">
                                                    <i
                                                        class="fas {{ $d->timbang == 'T' ? 'fa-clipboard-list' : 'fa-tasks' }} "></i>
                                                    {{ $d->timbang == 'T' ? 'Diproses' : 'Selesai' }}</span>


                                            </h6>
                                        </td>
                                        <td>
                                            @if ($d->timbang == 'Y')
                                                @if (!empty($update))
                                                <a href="{{ route('timbangEdit', $d->sub_no_po) }}"
                                                    class="btn btn-sm btn-success {{ $d->selesai == 'T' ? '' : 'disabled' }} "><i
                                                        class="fas fa-pen"></i></a>
                                                @endif
                                            @else
                                                @if (!empty($tambah))
                                                <a href="{{ route('timbangView', $d->sub_no_po) }}"
                                                    class="btn btn-sm btn-primary">Timbang</a>
                                                @endif
                                            @endif
                                            @if (!empty($print))
                                            <a href="{{ route('print_timbang', ['sub_no_po' => $d->sub_no_po]) }}"
                                                target="_blank" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-print"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<x-modal id="modalDetail" title="Detail {{ $title }}" size="modal-lg-max">
    <div id="detail_po"></div>
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
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $u)
                @php
                $akses = SettingHal::akses($halaman, $u->id);

                $create = SettingHal::btnSetHal($halaman, $u->id, 'create');

                $read = SettingHal::btnSetHal($halaman, $u->id, 'read');

                $update = SettingHal::btnSetHal($halaman, $u->id, 'update');

                @endphp
                <input type="hidden" name="route" value="timbang">
                <tr>
                    <td>{{ $u->nama }}</td>

                    <td>
                        <label><input type="checkbox" class="akses_h akses_h{{ $u->id }}" id_user="{{ $u->id }}"
                                id_user="{{ $u->id }}" {{ empty($akses->id_permission_page) ? '' : 'Checked' }} />
                            Akses</label>
                        <input type="hidden" class="open_check{{ $u->id }}" name="id_user[]" {{
                            empty($akses->id_permission_page) ? 'disabled' : '' }} value="{{ $u->id }}">
                    </td>
                    <td>
                        <input type="hidden" name="id_permission_gudang" value="{{ $halaman }}">

                        @foreach ($create as $c)
                        <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                value="{{ $c->id_permission_button }}" {{ empty($c->id_permission_page) ? '' : 'Checked'
                            }}
                            class="open_check{{ $u->id }}"
                            {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                            {!! $c->nm_permission_button !!}</label>
                        <br>
                        @endforeach
                    </td>
                    <td>

                        @foreach ($read as $r)
                        <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' : 'Checked'
                            }}
                            class="open_check{{ $u->id }}"
                            {{ empty($akses->id_permission_page) ? 'disabled' : '' }} />
                            {!! $r->nm_permission_button !!}</label> <br>
                        @endforeach
                    </td>
                    <td>

                        @foreach ($update as $r)
                        <label><input type="checkbox" name="id_permission{{ $u->id }}[]"
                                value="{{ $r->id_permission_button }}" {{ empty($r->id_permission_page) ? '' : 'Checked'
                            }}
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
            function loadDetail(sub_no_po) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('detail_timbang') }}?sub_no_po=" + sub_no_po,
                    success: function(r) {
                        $('#detail_po').html(r);
                    }
                });
            }

            $(document).on('click', '.detailPo', function() {
                var sub_no_po = $(this).attr('sub_no_po')
                $('#modalDetail').modal('show')
                loadDetail(sub_no_po)
            })

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