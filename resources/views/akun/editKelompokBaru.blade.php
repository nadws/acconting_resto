<div class="row">
    <input type="hidden" class="form-control id_akun_kelompok_baru" name="id_akun" required>
    <div class="col-lg-3">
        <input type="hidden" id="editIdAkun" value="{{ $aktiva->id_akun }}">
        <label for="">Nama Kelompok</label>
        <input type="text" class="form-control " value="{{ $aktiva->nm_kelompok }}" name="nm_kelompok" required>
    </div>
    <div class="col-lg-1">
        <label for="">Umur</label>
        <input type="text" class="form-control " value="{{ $aktiva->umur }}" name="umur" required>
    </div>
    <div class="col-lg-2">
        <label for="">satuan</label>
        <Select name="satuan_aktiva" class="form-control select2" required>
            <option value="">Pilih Satuan</option>
            <option {{$aktiva->satuan == 1 ? 'selected' : ''}} value="1">Bulan</option>
            <option {{$aktiva->satuan == 2 ? 'selected' : ''}} value="2">Tahun</option>
        </Select>
    </div>
    <div class="col-lg-2">
        <label for="">Nilai/tahun (%)</label>
        <input type="text" class="form-control " value="{{ $aktiva->tarif * 100 }}" name="tarif" required>
    </div>
    <div class="col-lg-3">
        <label for="">Contoh Barang</label>
        <input type="text" class="form-control " value="{{ $aktiva->barang_kelompok }}" name="barang" required>
    </div>

</div>