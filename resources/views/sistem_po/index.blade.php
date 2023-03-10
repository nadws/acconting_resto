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
            <section class="section">

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('sistem_po') }}">Purchase
                                    Order (PO)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pembelian_po') }}">Pembelian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('timbang') }}">Timbang</a>
                            </li>
                        </ul>

                        @if (Auth::user()->id_posisi == '1')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#akses" class="btn btn-primary  float-end"><i
                                class="fas fa-cog"></i>&nbsp; setting</a>
                        @endif


                        @if (!empty($tambah))
                        <a href="{{ route('tambah_po') }}" style="{{ empty($tambah) ? 'display: none' : '' }}"
                            class="btn icon icon-left btn-primary float-end me-2">
                            {!! $tambah->nm_permission_button !!}
                        </a>
                        @endif


                    </div>
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Po</th>
                                    <th>Admin</th>
                                    <th>Total Rp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ date('d-m-Y', strtotime($p->tgl)) }}</td>
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#detail" class="detail"
                                            no_po="{{ $p->no_po }}">{{ $p->no_po }}</a></td>
                                    <td>{{ $p->admin }}</td>
                                    <td>Rp. {{ number_format($p->total, 0) }}</td>
                                    <td>
                                        @if (!empty($print))
                                        <a href="{{ route('print_po', ['no_po' => $p->no_po]) }}" target="_blank"
                                            class="btn btn-sm btn-primary">{!! $print->nm_permission_button !!}</a>
                                        @endif

                                        @if (!empty($edit))
                                        <a href="{{ route('edit_po', ['no_po' => $p->no_po]) }}"
                                            class="btn btn-sm btn-primary {{ $p->beli == 'Y' ? 'disabled' : '' }}">{!!
                                            $edit->nm_permission_button !!}</a>
                                        @endif

                                        @if (!empty($hapus))
                                        <a href="{{ route('hapus_po', ['no_po' => $p->no_po]) }}"
                                            class="btn btn-sm btn-danger {{ $p->beli == 'Y' ? 'disabled' : '' }}">{!!
                                            $hapus->nm_permission_button !!}</a>
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

    </div>
    <style>
        .modal-lg-max2 {
            max-width: 1350px;
        }

        .modal-lg-max3 {
            max-width: 1200px;
        }
    </style>
    <div id="detail" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg-max2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Detail {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail_po"></div>
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

    <form action="{{route('save_permission')}}" method="post">
        @csrf
        <div id="akses" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg-max3" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Akses {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Halaman</th>
                                    <th>Create</th>
                                    <th>Read</th>
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
                                WHERE b.id_user ='$u->id'
                                ) AS b ON b.id_permission_button = a.id_permission_button");

                                $create = DB::select("SELECT a.*, b.id_permission_page FROM permission_button_gudang AS
                                a
                                LEFT JOIN (
                                SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
                                WHERE b.id_user ='$u->id'
                                ) AS b ON b.id_permission_button = a.id_permission_button
                                WHERE a.jenis = 'create'");

                                $read = DB::select("SELECT a.*, b.id_permission_page FROM permission_button_gudang AS
                                a
                                LEFT JOIN (
                                SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
                                WHERE b.id_user ='$u->id'
                                ) AS b ON b.id_permission_button = a.id_permission_button
                                WHERE a.jenis = 'read'");

                                $update = DB::select("SELECT a.*, b.id_permission_page FROM permission_button_gudang AS
                                a
                                LEFT JOIN (
                                SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
                                WHERE b.id_user ='$u->id'
                                ) AS b ON b.id_permission_button = a.id_permission_button
                                WHERE a.jenis = 'update'");

                                $delete = DB::select("SELECT a.*, b.id_permission_page FROM permission_button_gudang AS
                                a
                                LEFT JOIN (
                                SELECT b.id_permission_button, b.id_permission_page FROM permission_perpage AS b
                                WHERE b.id_user ='$u->id'
                                ) AS b ON b.id_permission_button = a.id_permission_button
                                WHERE a.jenis = 'delete'");


                                @endphp
                                <tr>
                                    <td>{{$u->nama}}</td>

                                    <td>
                                        <label><input type="checkbox" class="akses_h akses_h{{$u->id}}"
                                                id_user="{{$u->id}}" id_user="{{$u->id}}"
                                                {{empty($akses->id_permission_page) ?
                                            '' : 'Checked'}} /> Akses</label>
                                        <input type="hidden" class="open_check{{$u->id}}" name="id_user[]"
                                            {{empty($akses->id_permission_page) ?
                                        'disabled' : ''}}
                                        value="{{$u->id}}">
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_permission_gudang" value="1">

                                        @foreach ($create as $c)
                                        <label><input type="checkbox" name="id_permission{{$u->id}}[]"
                                                value="{{$c->id_permission_button }}" {{empty($c->id_permission_page) ?
                                            '' : 'Checked'}} class="open_check{{$u->id}}"
                                            {{empty($akses->id_permission_page) ?
                                            'disabled' : ''}} /> {!!$c->nm_permission_button!!}</label>
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>

                                        @foreach ($read as $r)
                                        <label><input type="checkbox" name="id_permission{{$u->id}}[]"
                                                value="{{$r->id_permission_button }}" {{empty($r->id_permission_page) ?
                                            '' : 'Checked'}} class="open_check{{$u->id}}"
                                            {{empty($akses->id_permission_page) ?
                                            'disabled' : ''}} />
                                            {!!$r->nm_permission_button!!}</label> <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($update as $up)
                                        <label><input type="checkbox" name="id_permission{{$u->id}}[]"
                                                value="{{$up->id_permission_button }}" {{empty($up->id_permission_page)
                                            ?
                                            '' : 'Checked'}} class="open_check{{$u->id}}"
                                            {{empty($akses->id_permission_page) ?
                                            'disabled' : ''}} />
                                            {!!$up->nm_permission_button!!}</label> <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($delete as $d)
                                        <label><input type="checkbox" name="id_permission{{$u->id}}[]"
                                                value="{{$d->id_permission_button }}" {{empty($d->id_permission_page) ?
                                            '' : 'Checked'}} class="open_check{{$u->id}}"
                                            {{empty($akses->id_permission_page) ?
                                            'disabled' : ''}} />
                                            {!!$d->nm_permission_button!!}</label> <br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>


    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2021 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                        href="https://saugi.me">Saugi</a></p>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.detail', function() {
        var no_po = $(this).attr('no_po');
            $.ajax({
                url: "{{ route('detail_po') }}?no_po=" + no_po,
                type: "Get",
                success: function(data) {
                    $('#detail_po').html(data);
                }
            });
        });

        $(document).on('click', '.akses_h', function() {
            var id_user = $(this).attr('id_user'); 
                if($('.akses_h'+ id_user).prop("checked") == true){
                    $('.open_check'+ id_user).removeAttr('disabled');
                } else{
                    $('.open_check'+ id_user).prop('disabled', true);
                    
                }
                
        });
    });
</script>
@endsection