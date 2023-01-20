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
            <form action="{{route('save_opname')}}" method="post">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn icon icon-left btn-primary "
                            style="float: right; margin-left: 2px"><i class="far fa-save"></i>
                            Opname</button>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#tambah"
                            class="btn icon icon-left btn-primary" style="float: right"><i
                                class="bi bi-plus-circle"></i> Tambah</a>
                    </div>
                    <div class="card-body">

                        <table class="table" id="tb_bkin">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Kategori </th>
                                    <th>Stok Program</th>
                                    <th>Stok Aktual</th>
                                    <th>Satuan </th>
                                    <th>Opname Countdown </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gudang as $no => $j)
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td><a href="#" class="history" id_list_bahan="{{$j->id_list_bahan}}"
                                            data-bs-toggle="modal" data-bs-target="#history">{{$j->nm_bahan}}</a>
                                    </td>
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
                                    <td align="right">{{number_format($stk,0)}}</td>
                                    <td width="15%">
                                        <input style="text-align: right" type="text" name="stok_ak[]"
                                            class="form-control" value="{{$stk}}">
                                        <input type="hidden" name="stok_po[]" class="form-control" value="{{$stk}}">
                                        <input type="hidden" name="id_satuan[]" class="form-control"
                                            value="{{$j->id_satuan}}">
                                        <input type="hidden" name="id_list_bahan[]" class="form-control"
                                            value="{{$j->id_list_bahan}}">
                                    </td>
                                    <td>{{$j->n}}</td>


                                    <td align="center">{{ $tKerja == '0' ? ' - ' : $tKerja->d }} </td>
                                    <td style="white-space: nowrap">
                                        <a href="" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    </td>
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
                                    <label for="list_kategori">Nama Bahan</label>
                                    <input type="text" name="nm_bahan" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="list_kategori">Satuan</label>
                                    <select name="id_satuan" id="" class="select2">
                                        @foreach ($satuan as $s)
                                        <option value="{{$s->id}}">{{$s->n}}</option>
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

    <div class="modal fade text-left " id="history">
        <div class="modal-dialog  modal-lg-max2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        History {{$title}}
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
    });
</script>



@endsection