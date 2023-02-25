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
                                        <th>Status</th>
                                        <th>Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembayaran as $no => $d)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $d->tgl }}</td>
                                        <td>{{ $d->no_po }}</td>
                                        <td>{{ $d->admin }}</td>
                                        <td>{{ number_format($d->ttl_rp, 0) }}</td>
                                        <td>
                                            <span class=" badge bg-{{ $d->selesai == 'T' ? 'danger' : 'success'}}">
                                                <i class="{{ $d->selesai == 'T' ? 'fas fa-spinner' :
                                                    'fas fa-check-circle'}}"></i> {{ $d->selesai == 'T' ? 'Prosess' :
                                                'Selesai'}}
                                            </span>
                                        </td>
                                        <td>
                                            <h6>
                                                <span class=" badge bg-{{$d->dimuka == 'T' ? 'warning' :  'success' }}">
                                                    <i
                                                        class="fas {{$d->dimuka == 'T' ? 'fas fa-map-marked' :  'fas fa-money-bill' }} "></i>
                                                    {{$d->dimuka == 'T' ? 'Pasar' : 'Dimuka' }}</span>
                                            </h6>
                                        </td>
                                        <td>
                                            @if ($d->selesai == 'T')
                                            <a href="#" data-bs-toggle="modal" no_po="{{$d->no_po}}"
                                                data-bs-target="#detail" class="btn btn-primary btn-sm bukukan"><i
                                                    class="fas fa-book"></i>
                                                Bukukan</a>
                                            @else
                                            @if ($d->dimuka == 'Y')

                                            @else
                                            <a href="{{route('cancel_pembukuan',['no_po' => $d->no_po])}}"
                                                class="btn btn-warning"><i class="fas fa-redo-alt"></i>
                                                Cancel </a>
                                            @endif

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

<form action="{{route('save_pembukuan')}}" method="post" class="form_save">
    @csrf
    <div id="detail" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg-max" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Pembayaran Bahan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div id="pembukuan"></div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-confirm" disabled>
                        <span class="d-none d-sm-block">Bukukan <i class="fas fa-arrow-circle-right"></i> </span>
                    </button>
                    <button class="btn btn-primary btn-loading" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>


            </div>
        </div>
    </div>
</form>


@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.btn-loading').hide();
            $(document).on('click', '.bukukan', function() {
                var no_po = $(this).attr('no_po');
                $.ajax({
                    url: "{{ route('pembayaran_bahan') }}",
                    method: "GET",
                    data: {
                        no_po: no_po
                    },
                    success: function(data) {
                        $('#pembukuan').html(data);
                        $(".select").select2({
                            dropdownParent: $('#detail .modal-content')
                        });
                    }
                });
            });
            $(document).on('submit', '.form_save', function(event) {
                $('.btn-confirm').hide();
                $('.btn-loading').show();
             });

             var count = 1;
            $(document).on('click', '.tambah_pembayaran', function(event) {
                count = count + 1;
                $.ajax({
                    url: "{{ route('tambah_baris_pembyaran') }}?count=" + count ,
                    type: "Get",
                    success: function(data) {
                        $('#tbh_pembayaran').append(data);
                        $(".select").select2();
                    }
                });
             });
             $(document).on('click', '.remove_baris', function() {
                var delete_row = $(this).attr('count');
                $('#baris' + delete_row).remove();
                var total = 0;
                $(".bayar:not([disabled=disabled]").each(function() {
                    total += parseFloat($(this).val());
                });
                var total_semua = $("#total_rp").val()
                
                if (total < total_semua) {
                    $('.btn-confirm').attr('disabled','disabled')
                } else {
                    $('.btn-confirm').removeAttr('disabled')
                }
            });

            $(document).on('keyup', '.bayar', function() {
                var urutan = $(this).attr('urutan');
                var rupiah = $('.bayar' + urutan).val();
                var total_semua = $("#total_rp").val()

                var total = 0;
                $(".bayar:not([disabled=disabled]").each(function() {
                    total += parseFloat($(this).val());
                });
               
                var total2 = $('.total_hitung').val(total);
                var total3 = total;

                if (total < total_semua) {
                    $('.btn-confirm').attr('disabled','disabled')
                } else {
                    $('.btn-confirm').removeAttr('disabled')
                }
            });
           
        });
</script>
@endsection