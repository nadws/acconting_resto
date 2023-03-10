<div class="modal-body">
    @if (!empty($tambahMerk))
    <button class="btn btn-primary btn-sm float-end mb-2 tb_merk" id_list_bahan="{{$id_list_bahan}}"><i
            class="fas fa-plus-circle"></i> Merk</button>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Merk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($merk as $no => $m)
            <tr>
                <td>{{$no+1}}</td>
                <td>{{$m->nm_merk}}</td>
                <td>
                    @if (!empty($updateMerk))
                    <a href="" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    @endif

                    @if (!empty($deleteMerk))
                    <a href="#" id_merk_bahan="{{$m->id_merk_bahan}}" id_list_bahan="{{$id_list_bahan}}"
                        class="btn btn-danger btn-sm delete_bahan"><i class="fas fa-trash-alt"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>