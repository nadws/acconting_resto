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
        transform: scale(1.5);
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambah" class="btn icon icon-left btn-primary"
                        style="float: right"><i class="bi bi-plus-circle"></i> Tambah</a>
                </div>
                <div class="card-body">

                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Akun</th>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Kategori</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akun as $no => $d)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $d->no_akun }}</td>
                                <td>{{ $d->kd_akun }}</td>
                                <td>{{ $d->nm_akun }}</td>
                                <td>{{ $d->kategoriAkun->nm_kategori }}</td>
                                <td align="right">
                                    @if ($d->id_penyesuaian == 2)
                                    <button type="button" data-toggle="tooltip" data-placement="top" title="Kelompok"
                                        class="btn btn-sm btn-primary edit_kelompok" id_akun="{{$d->id_akun}}"><i
                                            class="bi bi-diagram-3-fill"></i> </button>
                                    @endif
                                    <a id_akun="{{$d->id_akun}}" data-toggle="tooltip" data-placement="top"
                                        title="Post Center" type="button" class="post_center btn btn-sm btn-primary"><i
                                            class="bi bi-stack"></i> </a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Edit"
                                        class="btn btn-sm btn-primary"><i class="bi bi-pen"></i> </a>
                                    <a data-toggle="tooltip" data-placement="top" title="Delete"
                                        href="{{ route('del_akun', $d->id_akun) }}" class="btn btn-sm btn-danger"><i
                                            class="bi bi-trash"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<form action="" method="post">
    <div class="modal fade" id="post_center" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Post Center</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="post_center2">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="saveEditAkun">
    <div class="modal fade" id="editAkun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loadEditAkun"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save/Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="tambah_post">
    <div class="modal fade" id="tbh_post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" class="form-control nm_post" name="nm_post">
                        <input type="hidden" class="form-control " id="id_akun" name="nm_post">
                        <input type="hidden" class="form-control " id="edit_id_post" name="edit_id_post">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save/Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade show_kelompok" onchange="" id="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-costume">
                <h5 class="modal-title" id="exampleModalLabel">Kelompok Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="kelompok_akun">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<form id="save_kelompok_baru">
    <div class="modal fade" id="tambah_k_aktiva" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Kelompok Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control id_akun_kelompok_baru" name="id_akun" required>
                        <div class="col-lg-3">
                            <label for="">Nama Kelompok</label>
                            <input type="text" class="form-control " name="nm_kelompok[]" required>
                        </div>
                        <div class="col-lg-1">
                            <label for="">Umur</label>
                            <input type="text" class="form-control " name="umur[]" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="">satuan</label>
                            <Select name="satuan_aktiva[]" class="form-control  select2" required>
                                <option value="">Pilih Satuan</option>
                                <option value="1">Bulan</option>
                                <option value="2">Tahun</option>
                            </Select>
                        </div>
                        <div class="col-lg-2">
                            <label for="">Nilai/tahun (%)</label>
                            <input type="text" class="form-control " name="tarif[]" required>
                        </div>
                        <div class="col-lg-3">
                            <label for="">Contoh Barang</label>
                            <input type="text" class="form-control " name="barang[]" required>
                        </div>
                        <div class="col-lg-1">
                            <label for="">Aksi</label> <br>
                            <button type="button" class="btn btn-sm btn-primary tbh_kelompok_edit"><i
                                    class="fas fa-plus"></i></button>
                        </div>

                    </div>
                    <div id="tbh_kelompok_edit">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="save_kelompok_edit">
    <div class="modal fade" id="edit_k_aktiva" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-max" role="document">

            <div class="modal-content">
                <div class="modal-header bg-costume">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelompok Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_kelompok" id="id_kelompok">
                    <div id="loadEditKelompok"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="{{route('save_akun')}}" method="post">
    @csrf
    <div class="modal fade text-left tambah" id="tambah">
        <div class="modal-dialog modal-lg" role="document">
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
                                <label for="list_kategori">Kategori Akun</label>
                                <select name="id_kategori" id="pilihKategori" class="select2 form-control">
                                    <option value="">- Kategori Akun -</option>
                                    @foreach ($kategori as $d)
                                    <option value="{{ $d->id_kategori }}">{{ $d->nm_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input type="text" id="noAkun" readonly name="no_akun" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input type="text" name="kd_akun" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input type="text" name="nm_akun" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-3 cashFlow">
                            <div class="form-group">
                                <label for="switchBiaya">Biaya Di Sesuaikan</label> <br>
                                <div class="form-check form-switch form-switch2">
                                    <input class="form-check-input form-check-input2 " name="biayaDisesuaikan"
                                        value="off" type="checkbox" id="switchBiaya" />
                                    <input type="hidden" name="id_biaya" id="id_biaya" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 assets">
                            <div class="form-group">
                                <label for="switchBukuKas">Buku Kas / Bank</label> <br>
                                <div class="form-check form-switch form-switch2">
                                    <input class="form-check-input form-check-input2 " name="bukuKas" value="off"
                                        type="checkbox" id="switchBukuKas" />
                                    <input type="hidden" name="id_kas" id="id_kas" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 lawan_penyesuaian">
                            <hr>
                        </div>
                        <div class="col-md-4 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori"><u>Kategori Asset</u></label>
                                <select name="id_penyesuaian" id="" class="form-control select2 kat_akun input_akun2"
                                    required>
                                    <option value="">--Pilih Kategori--</option>
                                    <option value="1">Umum</option>
                                    <option value="2">Aktiva</option>
                                    <option value="3">ATK</option>
                                    <option value="4">Stok Ts</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 ">
                            <div class="form-group keterangan listKategori">
                                <label for="list_kategori"><u>Asset Umum</u></label>
                                <p>Asset umum memuat data asset yang tunggal tidak memiliki produk</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_umum" data-toggle="modal">
                                    <img src="{{asset('img/umum2.png')}}" alt="" width="80%">
                                </a>
                            </div>
                            <div class="form-group keterangan2 listKategori">
                                <label for="list_kategori"><u>Asset Aktiva</u></label>
                                <p>Asset aktiva memuat data asset yang memiliki produk dan terjadi penurunan nilai asset
                                    setiap bulannya</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_aktiva" data-toggle="modal">
                                    <img src="{{asset('img/aktiva.png')}}" alt="" width="80%">
                                </a>

                            </div>
                            <div class="form-group keterangan3 listKategori">
                                <label for="list_kategori"><u>Asset ATK</u></label>
                                <p>Asset atk memuat data asset yang memiliki produk dan akan di opname setiap
                                    bulannya</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_atk" data-toggle="modal">
                                    <img src="{{asset('img/atk.png')}}" alt="" width="80%">
                                </a>

                            </div>
                            <div class="form-group keterangan4 listKategori">
                                <label for="list_kategori"><u>Asset Stok TS</u></label>
                                <p>Asset stok ts memuat data bahan makanan resto yang akan di opname setiap
                                    bulannya</p>
                                <p>Contoh Jurnal Penyesuaian:</p>
                                <a href="#" data-target="#view_image_atk" data-toggle="modal">
                                    <img src="{{asset('img/atk.png')}}" alt="" width="80%">
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-4 keterangan mb-2 listKategori">
                            <label for="">Satuan</label>
                            <select name="id_satuan"
                                class="form-control select2 satuan input_detail satuan_umum  input_biaya" required>
                                <option value="">-Pilih Satuan-</option>
                                <?php foreach ($satuan as $p) : ?>
                                <option value="{{ $p->id_satuan }}">{{ $p->nm_satuan }}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-12 keterangan2 listKategori">

                            <label for="list_kategori"><u>Table Kelompok</u></label>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Nama Kelompok</label>
                                    <input type="text" class="form-control kelompok" name="nm_kelompok[]" required>
                                </div>
                                <div class="col-lg-1">
                                    <label for="">Umur</label>
                                    <input type="text" class="form-control kelompok" name="umur[]" required>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">satuan</label>
                                    <Select name="satuan_aktiva[]" class="form-control kelompok select2" required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="1">Bulan</option>
                                        <option value="2">Tahun</option>
                                    </Select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Nilai/tahun (%)</label>
                                    <input type="text" class="form-control kelompok" name="tarif[]" required>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Contoh Barang</label>
                                    <input type="text" class="form-control kelompok" name="barang[]" required>
                                </div>
                                <div class="col-lg-1">
                                    <label for="">Aksi</label> <br>
                                    <button type="button" class="btn btn-sm btn-primary tbh_kelompok"><i
                                            class="fas fa-plus"></i></button>
                                </div>

                            </div>
                            <div id="tbh_kelompok">

                            </div>




                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 lawan_penyesuaian mt-4">
                            <label for=""><u>Biaya Penyesuaian</u> </label>
                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">No Akun</label>
                                <input class="form-control input_akun2" type="text" name="no_akun2" id="noAkun2"
                                    placeholder="Cth: 1200" required readonly>
                            </div>

                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Kode Akun</label>
                                <input class="form-control input_akun2" type="text" name="kd_akun2" id="kd_akun"
                                    required>
                            </div>

                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Nama Akun</label>
                                <input class="form-control input_akun2" type="text" name="nm_akun2" id="nm_akun"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-3 lawan_penyesuaian">
                            <div class="form-group">
                                <label for="list_kategori">Kategori Akun</label>
                                <input type="text " class="form-control input_akun2" value="Biaya" readonly>
                                <input type="hidden" name="id_kategori2" class="form-control input_akun2" value="5"
                                    readonly>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        function hideDefault() {
            $('.assets').hide();
            $('.cashFlow').hide();
            $('.lawan_penyesuaian').hide();
            $('.keterangan').hide();
            $('.keterangan2').hide();
            $('.keterangan3').hide();
            $('.keterangan4').hide();
            $('.input_akun2').attr('disabled', 'true');
            $('.kelompok').attr('disabled', 'true');
            $('.satuan_umum').attr('disabled', 'true');
            $('#id_kas').attr('disabled', 'true');
        }

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

        function load_post(id_akun) {
            $.ajax({
                    url: "{{route('post_center_akun')}}",
                    method: "GET",
                    data: {
                        id_akun: id_akun,
                    },
                    success: function(data) {
                        $('#post_center2').html(data);
                        $("#tb-history").DataTable({
                            "lengthChange": false,
                            "autoWidth": false,
                            "stateSave": true,
                        })
                    }
                });
        }

        function load_kelompok(id_akun) {
            $.ajax({
                    url: "{{route('kelompok_akun')}}",
                    method: "GET",
                    data: {
                        id_akun: id_akun,
                    },
                    success: function(data) {
                        $('#kelompok_akun').html(data);
                    }
                });
        }

        function load_edit_akun(id_akun) {
            $.ajax({
                    url: "{{route('loadEditAkun')}}",
                    method: "GET",
                    data: {
                        id_akun: id_akun,
                    },
                    success: function(data) {
                        $('#loadEditAkun').html(data);
                    }
                });
        }

        hideDefault()
        var c = 1

        function loadNoAkun(id_pilih, id = '') {
            $.ajax({
                type: "GET",
                url: "{{route('loadNoAkun')}}?id_pilih="+id_pilih,
                success: function (r) {
                    $("#noAkun"+id).val(r);
                }
            });
        }

        $(document).on('click', '.btnEditAkun', function(){
            var id_akun = $(this).attr('id_akun')
            $("#editAkun").modal('show')
            load_edit_akun(id_akun)
        })

        $(document).on('change', '#pilihKategori', function(){
            var id_pilih = $(this).val()
            loadNoAkun(id_pilih)
            if(id_pilih == 1) {
                $('.assets').show();
                $('.cashFlow').show();
                $('#id_kas').removeAttr('disabled', 'true');
            } else {
                $('.assets').hide();
                $('.cashFlow').hide();
                $('.lawan_penyesuaian').hide();
            }
        })

        $(document).on('change', '#switchBiaya', function(){
            var id_biaya = $('#id_biaya').val()

            if(id_biaya == 0) {
                var b = '1';
                $('.lawan_penyesuaian').show();
                $('.input_akun2').removeAttr('disabled', 'true');
                $('#switchbukukas').attr('disabled', 'true');
            } else {
                var b = '0';
                $('.lawan_penyesuaian').hide();
                $('.listKategori').hide();
                $('.input_akun2').attr('disabled', 'true');
                $('#switchbukukas').removeAttr('disabled', 'true');
            }

            loadNoAkun(5,2)
            $('#id_biaya').val(b);
        })

        $(document).on('change', '#switchBukuKas', function(){
            var id_kas = $("#id_kas").val()
            if (id_kas == '0') {
                var b = '1';
                $('#switchBiaya').attr('disabled', 'true');
            } else {
                var b = '0';
                $('#switchBiaya').removeAttr('disabled', 'true');
            }
            $('#id_kas').val(b);
        })

        $(document).on('change', '.kat_akun', function(){
            var id_kat = $(this).val();
            alert(id_kat);
            if (id_kat == '1') {
                $('.keterangan').show();
                $('.satuan_umum').removeAttr('disabled', 'true');
            } else {
                $('.keterangan').hide();
            }
            if (id_kat == '2') {
                $('.keterangan2').show();
                $('.kelompok').removeAttr('disabled', 'true');
            } else {
                $('.keterangan2').hide();
            }
            if (id_kat == '3') {
                $('.keterangan3').show();
            } else {
                $('.keterangan3').hide();
            }
            if (id_kat == '4') {
                $('.keterangan4').show();
            } else {
                $('.keterangan4').hide();
            }
        })

        $(document).on('click', '.tbh_kelompok', function(){
            c += 1
            $.ajax({
                type: "GET",
                url: "{{route('tambah_kelompok_aktiva')}}?c="+c,
                success: function (r) {
                    $('#tbh_kelompok').append(r);
                    $('.select').select2({
                        dropdownParent: $('#tambah .modal-content')
                    })
                }
            });
        })

        $(document).on('click', '.remove_kelompok', function() {   
                var delete_row = $(this).attr('count');
                $('#row' + delete_row).remove();
        });

        $(document).on('click', '.post_center', function(){
            $("#post_center").modal('show')
            var id_akun = $(this).attr("id_akun");
            load_post(id_akun)
        })

        $(document).on('click', '.edit_kelompok', function(){
            var id_akun = $(this).attr("id_akun");
            load_kelompok(id_akun)
            $(".show_kelompok").modal('show')
        })

        $(document).on('click', '.tambah_k_aktiva', function() {   
                var id_akun = $(this).attr('id_akun');

                $('.id_akun_kelompok_baru').val(id_akun);
                $('#tambah_k_aktiva').modal('show')
                $('.select2').select2({
                    dropdownParent: $('#tambah_k_aktiva .modal-content')
                });
                
        });

        $(document).on('click', '.tbh_kelompok_edit', function() {
           
           c = c + 1;
           $.ajax({
               url: "{{ route('tambah_kelompok_aktiva') }}?count=" + c ,
               type: "Get",
               success: function(data) {
                   $('#tbh_kelompok_edit').append(data);
                   $('.select2').select2({
                        dropdownParent: $('#tambah_k_aktiva .modal-content')
                    });
               }                    
           });  

        });

        $(document).on('click', '.remove_kelompok', function() {   
                var delete_row = $(this).attr('count');
                $('#row' + delete_row).remove();
        });

        $(document).on('submit', '#save_kelompok_baru', function(event) {
                event.preventDefault();
               
                var id_akun = $('.id_akun_kelompok_baru').val();
                var pesanan_new = $("#save_kelompok_baru").serialize()

                $.ajax({
                    url: "{{ route('save_kelompok_baru') }}?" + pesanan_new,
                    method: 'GET',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        toast('Berhasil tambah kelompok')
                        var url = "{{route('kelompok_akun')}}?id_akun=" + id_akun;

                        $('#kelompok_akun').load(url);
                        $('#tambah_k_aktiva').modal('hide');
                    }
                });

        });

        $(document).on('click', '.delete_kelompok_baru', function() {
            if(confirm('Yakin dihapus ?')) {
                var id_kelompok = $(this).attr("id_kelompok");
                var id_akun_kelompok = $(this).attr("id_akun_kelompok");
                $.ajax({
                    type: "GET",
                    url: "{{route('delete_kelompok_baru')}}",
                    data: {
                        id_kelompok: id_kelompok
                    },
                    success: function(response) {
                        toast('Berhasil hapus kelompok')
                        var url = "{{route('kelompok_akun')}}?id_akun=" + id_akun_kelompok;
                        $('#kelompok_akun').load(url);
    
                        
                    }
                });
            }

        });

        $(document).on('click', '.tbh_post', function() {
            var id_akun = $(this).attr("id_akun");
            $(".nm_post").val('');
            $("#edit_id_post").val('');
            $("#id_akun").val(id_akun);
            $("#tbh_post").modal('show')
        });

        $(document).on('submit', '#tambah_post', function(e) {
            e.preventDefault()
            var nm_post = $(".nm_post").val();
            var id_akun = $("#id_akun").val();
            var id_post = $("#edit_id_post").val();

            $.ajax({
                type: "GET",
                url: "{{ route('tambah_post') }}",
                data: {
                    nm_post: nm_post,
                    id_akun: id_akun,
                    id_post:id_post
                },
                success: function(response) {
                    toast('Berhasil tambah post center')

                    $('#tbh_post').modal('hide');
                    load_post(id_akun)
                }
            });

        });

        $(document).on('click', '.delete_post', function() {
            if(confirm('Yakin dihapus ?')) {
                var id_post = $(this).attr("id_post");
                var id_akun2 = $(this).attr("id_akun2");
                $.ajax({
                    type: "GET",
                    url: "{{route('delete_post')}}",
                    data: {
                        id_post: id_post,
                        id_akun2: id_akun2,
                    },
                    success: function(response) {
                        toast('Berhasil hapus post center')
                        load_post(id_akun2)
                    }
                });
            }

        });

        $(document).on('click', '.btn_edit_post', function(){
            var nm_post = $(this).attr('nm_post')
            var id_post = $(this).attr('id_post')
            var id_akun = $(this).attr('id_akun')

            $(".nm_post").val(nm_post);
            $("#edit_id_post").val(id_post);
            $("#id_akun").val(id_akun);
            $("#tbh_post").modal('show')
        })
        
        $(document).on('click', '.btnEditKelompok', function(){
            var id_kelompok = $(this).attr('id_kelompok')
            var id_akun = $(this).attr('id_akun')

            $('#edit_k_aktiva').modal('show')
            $("#id_kelompok").val(id_kelompok)
            $.ajax({
                type: "GET",
                url: "{{route('loadEditkelompok')}}?id_kelompok="+id_kelompok,
                success: function (r) {
                    $("#loadEditKelompok").html(r)
                    $('.select2').select2({
                        dropdownParent: $('#edit_k_aktiva .modal-content')
                    });
                }
            });
        })

        $(document).on('submit', '#save_kelompok_edit', function(event) {
                event.preventDefault();
               
                var pesanan_new = $("#save_kelompok_edit").serialize()
                var id_akun = $("#editIdAkun").val()
                $.ajax({
                    url: "{{ route('edit_kelompok_baru') }}?" + pesanan_new,
                    method: 'GET',
                    success: function(data) {
                        toast('Berhasil tambah kelompok')
                        load_kelompok(id_akun)
                        $('#edit_k_aktiva').modal('hide');
                    }
                });

        });

    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection