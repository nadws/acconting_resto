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
        <form action="{{route('save_pembelian_po')}}" method="post">
            @csrf
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Tanggal Beli</label>
                                <input type="date" name="tgl" class="form-control form-control-lg"
                                    value="{{date('Y-m-d')}}" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="">No Po</label>
                                <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                    value="{{$no_po}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Keterangan</label>
                                <input type="text" name="ket" value="{{$detail2->ket}}"
                                    class="form-control form-control-lg" readonly>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">


                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th colspan="3" style="text-align: center;border-right: 2px solid #435EBE">PO
                                        </th>
                                        <th colspan="4" style="text-align: center">Beli</th>
                                    </tr>
                                    <tr>
                                        <th>Belanja Pasar</th>
                                        <th>Bahan</th>
                                        <th>Qty</th>
                                        <th>Satuan Beli</th>
                                        <th style="border-right: 2px solid #435EBE">Rp Satuan</th>
                                        <th width="10%" style="text-align: center;">Qty</th>
                                        <th>Satuan</th>
                                        <th width="15%" style="text-align: center;">Rp Satuan</th>
                                        <th width="15%" style="text-align: center;">Ttl Rp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase as $no => $p)
                                    <tr>
                                        <td align="center"><input class="form-check-input total" name="cek[]" value="{{ $p->id_purchase }}" type="checkbox"
                                            id="check{{ $no + 1 }}"></td>
                                        <td>
                                            <label for="check{{$no+1}}">{{$p->nm_bahan}}</label>
                                            <input type="hidden" name="id_purchase[]" value="{{$p->id_purchase}}">
                                        </td>
                                        <td>
                                            {{$p->qty}}
                                        </td>
                                        <td>
                                            {{$p->nm_satuan}}
                                        </td>
                                        <td style="border-right: 2px solid #435EBE">
                                            {{number_format($p->rp_satuan,0)}}
                                        </td>
                                        <td>
                                            <input type="text" name="qty[]" style="text-align: right;"
                                                class="form-control qty_beli qty_beli{{$p->id_purchase}}" value="0"
                                                detail='{{$p->id_purchase}}'>
                                        </td>
                                        <td>{{$p->nm_satuan}}</td>
                                        <td><input type="text" name="h_satuan[]" style="text-align: right;"
                                                class="form-control h_satuan h_satuan{{$p->id_purchase}}" value="0"
                                                detail='{{$p->id_purchase}}'></td>
                                        <td><input type="text" name="ttl_rp[]" style="text-align: right;"
                                                class="form-control total{{$p->id_purchase}}" value="0" readonly></td>
                                    </tr>
                                    @endforeach

                                </tbody>


                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="action" value="pasar" id="simpan" style="float: right; margin-left: 8px;"
                            class="btn btn-primary">Simpan</button>
                        <button type="submit" name="action" value="dimuka" id="simpanPembayaranDimuka" style="float: right; margin-left: 8px;"
                            class="btn btn-primary btnSimpan">Pembayaran Dimuka</button>
                        <a href="{{route('sistem_po')}}" style="float: right" class="btn btn-outline-primary">Batal</a>
                    </div>
                </div>

            </section>
        </form>
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
    
        $(document).on('change keyup', '.qty_beli', function() {
      
            var detail = $(this).attr('detail');
            var qty_beli = $('.qty_beli' + detail).val();
            var h_satuan = $('.h_satuan' + detail).val();  
            
            var total = parseFloat(qty_beli) * parseFloat(h_satuan);
            $('.total' + detail).val(total);
                
        });
        $(document).on('change keyup', '.h_satuan', function() {
      
            var detail = $(this).attr('detail');
            var qty_beli = $('.qty_beli' + detail).val();
            var h_satuan = $('.h_satuan' + detail).val();  
            
            var total = parseFloat(qty_beli) * parseFloat(h_satuan);
            $('.total' + detail).val(total);
                
        });

        $(document).on('click', '#simpanPembayaranDimuka', function(){

            location.href = "{{route('save_pembelian_po')}}?jenis=dimuka"
        })
    });
</script>
@endsection