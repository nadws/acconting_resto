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
                                    <td>{{$i+1}}</td>
                                    <td>{{date('d-m-Y',strtotime($p->tgl))}}</td>
                                    <td>
                                        {{$p->no_po}}
                                    </td>

                                    <td>Rp. {{number_format($p->total,0)}}</td>
                                    <td>Rp. {{number_format($p->total_beli,0)}}</td>
                                    <td>{{$p->admin}}</td>
                                    <td>{{$p->admin_beli}}</td>
                                    <td>
                                        <span class=" badge bg-{{$p->po != $p->beli ? 'danger' : 'success'}}"><i
                                                class="fas {{$p->po != $p->beli ? 'fa-clipboard-list' : 'fa-tasks'}} "></i>
                                            {{$p->po != $p->beli
                                            ? 'Diproses' : 'Selesai'}}</span>
                                    </td>
                                    <td>
                                        @if ($p->po != $p->beli)
                                        <a href="{{route('tambah_beli',['no_po' => $p->no_po])}}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Pembelian"
                                            class="btn btn-sm btn-primary"><i class="fas fa-shopping-cart"></i>
                                        </a>
                                        @else
                                        <a href="{{route('tambah_beli',['no_po' => $p->no_po])}}"
                                            class="btn btn-sm btn-primary disabled"><i class="fas fa-shopping-cart"></i>
                                        </a>
                                        @endif
                                        <a href="" data-bs-toggle="modal" data-bs-target="#detail"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Nota Pembelian"
                                            no_po="{{$p->no_po}}" class="btn btn-warning btn-sm detail"><i
                                                class="far fa-clipboard"></i></a>
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
    <style>
        .modal-lg-max2 {
            max-width: 1350px;
        }
    </style>

    <div id="detail" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detail">
                        Daftar {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id=detail_po></div>
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
    <div id="detail_sub" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detail_sub">
                        Daftar {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id=detail_sub_po></div>
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
    <div id="print" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg-max2" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Daftar {{$title}}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="nota"></div>
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

        
        
    });
</script>
@endsection