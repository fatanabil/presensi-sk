<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <?php if (session()->getFlashData('guru-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('guru-b'); ?>
        </div>
    <?php elseif (session()->getFlashData('guru-g')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('guru-g'); ?>
        </div>
    <?php endif; ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data Guru</h1>

    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Guru</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-10">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Nama</td>
                            <td>Username</td>
                            <td>Jenis Kelamin</td>
                            <td>Alamat</td>
                            <td>Kelas</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($guru as $row) : ?>
                            <tr style="vertical-align: middle;">
                                <td><?= $i; ?></td>
                                <td><?= $row->nama; ?></td>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                <td><?= $row->alamat; ?></td>
                                <td><?= $row->kelas; ?></td>
                                <td>
                                    <input type="text" value=<?= $row->id_guru; ?> hidden>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editmodal">Edit</button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url(); ?>/admin/adddataguru" method="POST">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th style="width: 20rem;">Nama</th>
                                    <th style="width: 5rem;">Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th style="width: 10rem;">Kelas</th>
                                    <th>Hapus</th>
                                </thead>
                                <tbody id="tbdy">
                                    <tr>
                                        <td><input type="text" class="form-control" placeholder="Nama" name="nama-guru[]"></td>
                                        <td>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenkel[]">
                                                <option selected value="L">L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </td>
                                        <td><input type="textarea" class="form-control" placeholder="Alamat" name="alamat-guru[]"></td>
                                        <td>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="kelas[]">
                                                <?php foreach ($kelas as $kl) : ?>
                                                    <option value="<?= $kl->kelas; ?>"><?= $kl->kelas; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><button type="button" class="btn-close" id="del-btn"></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col d-flex flex-row-reverse">
                                <button type="button" class="btn btn-primary" id="add-btn">Tambah input</button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#add-btn').click(function() {
            $('#tbdy').append('<tr><td><input type="text" class="form-control" placeholder="Nama" name="nama-guru[]"></td><td><select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenkel[]"><option selected value="L">L</option><option value="P">P</option></select></td><td><input type="textarea" class="form-control" placeholder="Alamat" name="alamat-guru[]"></td><td><select class="form-select form-select-sm" aria-label=".form-select-sm example" name="kelas[]"><?php foreach ($kelas as $kl) : ?><option value="<?= $kl->kelas; ?>"><?= $kl->kelas; ?></option><?php endforeach; ?></select></td><td><button type="button" class="btn-close" id="del-btn"></button></td></tr>')
        })

        $('#tbdy').on('click', '#del-btn', function() {
            $(this).closest('tr').remove()
        })
    })
</script>
<?= $this->endSection(); ?>