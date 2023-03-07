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
                            <a class="nav-link active" aria-current="page" href="{{ route('produk',1) }}">Bahan &
                                barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gudang') }}">Opname</a>
                        </li>
                    </ul>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" class="btn icon icon-left btn-primary"
                        style="float: right"><i class="bi bi-plus-circle"></i> Tambah</a>
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
                                <td>{{$no+1}}</td>
                                <td><a href="#" class="merk" id_list_bahan="{{ $j->id_list_bahan }}"
                                        data-bs-toggle="modal" data-bs-target="#merk">{{$j->nm_bahan}}</a></td>
                                <td>{{$j->nm_kategori}}</td>

                                @php
                                $debit = empty($j->debit) ? '0' : $j->debit;
                                $kredit = empty($j->kredit) ? '0' : $j->kredit;
                                $stk = $debit - $kredit;
                                $tgl1 = date('Y-m-d');
                                $tgl2 = date('Y-m-d',strtotime('30 days',strtotime($j->tgl)));

                                if (empty($j->tgl)) {
                                $tKerja = '0';
                                } else {
                                $totalKerja = new DateTime($tgl1);
                                $today = new DateTime($tgl2);
                                $tKerja = $today->diff($totalKerja);
                                }
                                @endphp
                                <td>{{number_format($stk,0)}}</td>
                                <td>{{$j->n}}</td>
                                <td>
                                    <i
                                        class="{{$j->monitoring == 'Y' ? 'text-success fas fa-2x fa-check-circle' : 'text-danger fas fa-2x fa-times-circle' }}"></i>
                                </td>

                                <td align="center">{{ $tKerja == '0' ? ' - ' : $tKerja->d }} </td>
                                <td style="white-space: nowrap">
                                    <a href="#" class="btn btn-sm btn-warning editBahan"
                                        idListBahan="{{$j->id_list_bahan}}"><i class="fas fa-pen"></i></a>
                                    @php
                                    $adaStok = DB::table('stok_ts')->where('id_bahan', $j->id_list_bahan)->first();
                                    @endphp
                                    @if (empty($adaStok))
                                    <a href="{{ route('hapusBahan',[$j->id_list_bahan, $id_jenis]) }}"
                                        onclick="return confirm('Yakin ingin dihapus ?')"
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
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


    <style>
        .modal-lg-max2 {
            max-width: 900px;
        }
    </style>
    <form action="{{route('save_bahan')}}" method="post">
        @csrf
        <div class="modal fade text-left tambah" id="tambah">
            <div class="modal-dialog  modal-lg-max2" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Tambah {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                        <option value="{{$s->id_satuan}}">{{$s->nm_satuan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="list_kategori">Kategori</label>
                                    <select name="id_kategori_makanan" id="" class="select2">
                                        @foreach ($kategori as $k)
                                        <option value="{{$k->id_kategori_makanan}}">{{$k->nm_kategori}}</option>
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

    <form action="{{route('edit_bahan')}}" method="post">
        @csrf
        <div class="modal fade text-left" id="editBahan">
            <div class="modal-dialog  modal-lg-max2" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Edit {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_jenis" value="{{ $id_jenis }}">
                        <div id="loadEditBahan"></div>
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

    <div class="modal fade text-left" id="merk">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Merk {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div id="merk_bahan"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <form id="tambah_bahan">
        <div class="modal fade text-left" id="tbh_merk">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">
                            Merk {{$title}}
                        </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nama Merk</label>
                                <input type="text" name="nm_merk" class="form-control nm_merk">
                                <input type="hidden" name="id_list_bahan" id="id_list_bahan" class="form-control">
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
    $(document).ready(function () {

        function toast(pesan) {
            Toastify({
                text: pesan,
                duration: 3000,
                style: {
                    background: "#EAF7EE",
                    color: "#7F8B8B"
                },
                close:true,
                avatar: "https://cdn-icons-png.flaticon.com/512/190/190411.png"
            }).showToast();
        }
        
        $(document).on('click', '.editBahan', function(){
            var idListBahan = $(this).attr('idListBahan')
            $('#editBahan').modal('show')
            $.ajax({
                type: "GET",
                url: "{{route('loadEditBahan')}}?idListBahan="+idListBahan,
                success: function (r) {
                    $("#loadEditBahan").html(r)
                    $('.select').select2({
                        dropdownParent: $('#editBahan .modal-content')
                    });
                    
                }
            });
        })


            function load_bahan(id_list_bahan) {
                $.ajax({
                    url: "{{route('get_merk')}}",
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
            if(confirm('Yakin dihapus ?')) {
                var id_merk_bahan = $(this).attr("id_merk_bahan");
                var id_list_bahan = $(this).attr("id_list_bahan");
                $.ajax({
                    type: "GET",
                    url: "{{route('delete_bahan')}}",
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
    });
</script>
@endsection