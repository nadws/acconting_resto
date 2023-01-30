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
                                            <th>No PO</th>
                                            <th>Admin</th>
                                            <th>Total Rp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembelian as $no => $d)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td>{{ date('d-m-Y', strtotime($d->tgl)) }}</td>
                                                <td><a href="#" class="detailPo" no_po="{{$d->no_po}}">{{ $d->no_po }}</a></td>
                                                <td>{{ $d->admin }}</td>
                                                <td>Rp. {{ number_format($d->ttl_rp,0) }}</td>
                                                <td>
                                                    <h5><span class=" badge bg-{{$d->timbang == 'T' ? 'danger' : 'success'}}"><i
                                                        class="fas {{$d->timbang == 'T' ? 'fa-clipboard-list' : 'fa-tasks'}} "></i>
                                                    {{$d->timbang == 'T'
                                                    ? 'Diproses' : 'Selesai'}}</span></h5>
                                                </td>
                                                <td>
                                                    @if ($d->timbang == 'Y')
                                                        <a href="{{ route('timbangEdit', $d->no_po) }}" class="btn btn-sm btn-success"><i class="fas fa-pen"></i></a>
                                                    @else
                                                        <a href="{{ route('timbangView', $d->no_po) }}" class="btn btn-sm btn-primary"><i class="fas fa-balance-scale"></i></a>
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

    <div id="modalDetail" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
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
                    {{-- <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Save</span>
                    </button> --}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        function loadDetail(no_po) {
            $.ajax({
                type: "GET",
                url: "{{ route('detail_timbang') }}?no_po=" + no_po,
                success: function (r) {
                    $('#detail_po').html(r);
                }
            });
        }

        $(document).on('click', '.detailPo', function(){
            var no_po = $(this).attr('no_po')
            $('#modalDetail').modal('show')
            loadDetail(no_po)
        })
    });
</script>
@endsection