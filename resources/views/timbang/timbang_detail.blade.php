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
        <form action="{{route('save_timbang')}}" method="post">
            @csrf
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label for="">Tanggal</label>
                                <input type="date" name="tgl" class="form-control form-control-lg"
                                    value="{{$beli->tgl}}" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="">No Po</label>
                                <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                    value="{{$no_po}}">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Pembeli</label>
                                <input type="text" name="pembeli" class="form-control form-control-lg"
                                    value="{{$beli->pembeli}}" readonly>
                            </div>
                            <div class="col-lg-3">
                                <label for="">Tempat beli</label>
                                <input type="text" name="tempat_beli" class="form-control form-control-lg" readonly
                                    value="{{$beli->tempat_beli}}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="30%">Bahan</th>
                                    <th width="10%" style="text-align: right;">Qty</th>
                                    <th width="15%">Satuan Beli</th>
                                    <th width="15%" style="text-align: right;">Rp Satuan</th>
                                    <th width="20%" style="text-align: right;">Total Rp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian as $detail => $d)

                                <input type="hidden" name="id_pembelian[]" value="{{ $d->id_pembelian }}">
                                <input type="hidden" name="timbang[]" value="{{ $d->timbang }}">
                                <input type="hidden" name="dimuka[]" value="{{ $d->dimuka }}">
                                <input type="hidden" name="id_bahan[]" value="{{ $d->id_bahan }}">
                                <tr>
                                    <td>
                                        <select disabled id="" class="form-control  select_view id_bahan id_bahan1"
                                            detail='1'>
                                            <option value="">Pilih Bahan</option>
                                            @foreach ($list_bahan as $l)
                                            <option {{ $l->id_list_bahan == $d->id_bahan ? 'selected' : ''}}
                                                value="{{$l->id_list_bahan}}">{{$l->nm_bahan}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="qty[]" style="text-align: right;"
                                            class="form-control qty_beli qty_beli{{ $detail+1 }}" required
                                            detail='{{ $detail+1 }}'>
                                        <input type="hidden" name="qty_beli[]" style="text-align: right;"
                                            class="form-control qty_beli" required>
                                    </td>
                                    <td>

                                        <select id="" class="form-control  select_view" disabled>
                                            <option value="">Pilih Satuan</option>
                                            @foreach ($satuan as $l)
                                            <option {{$l->id_satuan == $d->id_satuan_bahan ? 'selected' : ''}}
                                                value="{{$d->id_satuan_bahan}}">{{$l->nm_satuan}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id_satuan[]" value="{{$d->id_satuan_bahan}}}">
                                    </td>
                                    <td>
                                        <input type="number" name="h_satuan[]" style="text-align: right;"
                                            class="form-control h_satuan h_satuan{{ $detail+1 }}" value="" readonly
                                            detail='{{ $detail+1 }}'>
                                    </td>
                                    <td>
                                        <input type="number" name="ttl_rp[]" style="text-align: right;"
                                            class="form-control total{{ $detail+1 }}" value="{{ $d->ttl_rp }}" readonly>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" style="float: right; margin-left: 8px;"
                            class="btn btn-primary">Simpan</button>
                        <a href="{{route('timbang')}}" style="float: right" class="btn btn-outline-primary">Batal</a>
                    </div>
                </div>

            </section>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on('change keyup', '.qty_beli', function() {
            
            var detail = $(this).attr('detail');
            var qty_beli = $('.qty_beli' + detail).val();
            var total = $('.total' + detail).val();  
            var totalT = parseFloat(total) / parseFloat(qty_beli);
            $('.h_satuan' + detail).val(totalT);
                
        });
    });
</script>
@endsection