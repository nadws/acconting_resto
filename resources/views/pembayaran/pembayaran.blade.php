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
                                <h5 style="float: left">Total Pembayaran : <span class="ttl"></span></h5>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" id="btn_pembayaran"
                                    class="btn icon icon-left btn-primary" style="float: right"><i
                                        class="bi bi-plus-circle"></i>
                                    Pembayaran</a>
                            </div>
                            <div class="card-body">

                                <table class="table table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>No PO</th>
                                            <th>Admin</th>
                                            <th>Total Rp</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembayaran as $no => $d)
                                            <tr>
                                                <td><label for="check{{ $no + 1 }}">{{ $no + 1 }}</label></td>
                                                <td><label for="check{{ $no + 1 }}">{{ $d->tgl }}</label></td>
                                                <td><label for="check{{ $no + 1 }}">{{ $d->no_po }}</label></td>
                                                <td><label for="check{{ $no + 1 }}">{{ $d->admin }}</label></td>
                                                <td><label
                                                        for="check{{ $no + 1 }}">{{ number_format($d->ttl_rp, 0) }}</label>
                                                </td>
                                                <td><input class="form-check-input total" no_po="{{ $d->no_po }}"
                                                        value="{{ $d->ttl_rp }}" name="no_po" type="checkbox"
                                                        id="check{{ $no + 1 }}"></td>
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
    <div id="tambah" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg-max" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">
                        Pembayaran Bahan
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div id=input_pembayaran></div>
            

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('input:checkbox').change(function() {
                var total = $(this).val()
                var rupiah = 0;
                $('input[name="no_po"]:checked').each(function() {
                    rupiah += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
                });
                var ttl = parseInt(rupiah).toLocaleString();

                $('.ttl').text(ttl);
            });

            $(document).on('click', '#btn_pembayaran', function() {
                var no_po = []
                $('input[name="no_po"]:checked').each(function() {
                    no_po.push($(this).attr("no_po"))
                });
                $.ajax({
                    url: "{{ route('pembayaran_bahan') }}",
                    method: "GET",
                    data: {
                        no_po: no_po
                    },
                    success: function(data) {
                        $('#input_pembayaran').html(data);
                        $('.select').select2()
                    }
                });
            })
        });
    </script>
@endsection
