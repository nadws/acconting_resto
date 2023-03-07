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
        <form action="{{route('save_po')}}" method="post">
            @csrf
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">Tanggal Order</label>
                                <input type="date" name="tgl" class="form-control form-control-lg"
                                    value="{{date('Y-m-d')}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="">No Po</label>
                                <input type="text" name="no_po" class="form-control form-control-lg" readonly
                                    value="PO{{$kode}}{{$no_po}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="">Kategori</label>
                                <select name="" id="" class="select_view form-control kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $k)
                                    <option value="{{$k->id_kategori_makanan}}">{{$k->nm_kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="load_menu"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" style="float: right; margin-left: 8px;"
                            class="btn btn-primary">Simpan</button>
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
        var count = 1;
        $(document).on('click', '.tbh_baris', function() {
            count = count + 1;
            $.ajax({
                url: "{{ route('tambah_baris_po') }}?count=" + count ,
                type: "Get",
                success: function(data) {
                    $('#tb_stok').append(data);
                    $(".select").select2();
                }
            });
        });
        $(document).on('click', '.remove_baris', function() {
                var delete_row = $(this).attr('count');

                $('#baris' + delete_row).remove();


        });
        $(document).on('change', '.id_bahan', function() {
                    var detail = $(this).attr('detail');
                    var id_bahan = $('.id_bahan' + detail).val();
                    $.ajax({
                    url: "{{ route('hrga_terakhir_po') }}?detail=" + detail + '&id_bahan=' + id_bahan,
                    type: "Get",
                    dataType: "json",
                    success: function(r) {
                        $('.h_satuan' + detail).val(r['rupiah']);
                        $(".select").select2();
                    }
                 });
                 $.ajax({
                    url: "{{ route('satuan_terakhir_po') }}?detail=" + detail + '&id_bahan=' + id_bahan,
                    type: "Get",
                    success: function(data) {
                        $('.satuan' + detail).html(data);
                        $(".select").select2();
                    }
                 });



        });
   
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
        $(document).on('change', '.kategori', function() {
         var id_kategori = $(this).val()
            $.ajax({
                url: "{{ route('load_pesanan') }}?id_kategori=" + id_kategori,
                type: "Get",
                success: function(data) {
                    $('#load_menu').html(data);
                    $(".select").select2();
                }
            });
                
        });
    });
</script>
@endsection