<div class="row">
    <div class="col-lg-12">
        <a href="#" id_akun='<?= $id_akun ?>'
            class="btn btn-primary btn-sm tbh_post" style="float: right"><i class="fas fa-plus"></i>Post Center</a>
        <br>
        <br>
        <table class="table" id="tb-history">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Post Center</th>
                    <th>NPWP</th>
                    <th>No Telpon</th>
                    <th>
                        <center>
                            Aksi
                        </center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($post_center as $p) : ?>
                <tr>
                    <td>
                        <?= $i++ ?>
                    </td>
                    <td>
                        <?= $p->nm_post ?>
                    </td>
                    <td>
                        <?= $p->npwp ?>
                    </td>
                    <td>
                        <?= $p->no_telepon ?>
                    </td>
                    <td>
                        <center>
                            <a href="" data-toggle="modal" data-target="#edit" id_post="<?= $p->id_post ?>"
                                class="btn btn-sm btn-primary btn_edit"><i class="fas fa-edit"></i></a>
                            <a href="#" id_post="<?= $p->id_post ?>" id_akun2='<?= $id_akun ?>'
                                class="btn btn-sm btn-danger delete_post"><i class="fas fa-trash-alt"></i></a>
                        </center>

                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>