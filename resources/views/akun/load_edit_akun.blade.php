<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="list_kategori">No Akun</label>
            <input value="{{ $akun->no_akun }}" type="text" id="noAkun" readonly  name="no_akun" class="form-control">
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="form-group">
            <label for="list_kategori">Kode Akun</label>
            <input value="{{ $akun->kd_akun }}" type="text" name="kd_akun" class="form-control">
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="list_kategori">Nama Akun</label>
            <input value="{{ $akun->nm_akun }}" type="text" name="nm_akun" class="form-control">
        </div>
    </div>
</div>