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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase as $i => $p)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{date('d-m-Y',strtotime($p->tgl))}}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#detail" class="detail"
                                        no_po="{{$p->no_po}}">{{$p->no_po}}</a>
                                </td>

                                <td>Rp. {{number_format($p->total,0)}}</td>
                                <td>Rp. {{number_format($p->total_beli,0)}}</td>
                                <td>{{$p->admin}}</td>
                                <td>{{$p->admin_beli}}</td>
                                <td>
                                    <h5><span class=" badge bg-{{$p->beli == 'T' ? 'danger' : 'success'}}"><i
                                                class="fas {{$p->beli == 'T' ? 'fa-clipboard-list' : 'fa-tasks'}} "></i>
                                            {{$p->beli == 'T'
                                            ? 'Diproses' : 'Selesai'}}</span></h5>
                                </td>
                                <td>
                                    <a href="{{route('tambah_beli',['no_po' => $p->no_po])}}"
                                        class="btn btn-sm btn-primary"><i
                                            class="fas fa-shopping-cart"></i>
                                    </a>
                                    <a href="{{route('edit_pembelian',['no_po' => $p->no_po])}}"
                                        class="btn btn-sm btn-success {{$p->timbang == 'T' ? '' : 'disabled'}}"><i
                                            class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{route('print_pembelian',['no_po' => $p->no_po])}}" target="_blank"
                                        class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
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
            max-width: 1350px;
        }
    </style>

    <div id="detail" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

        
        
    });
</script>
@endsection