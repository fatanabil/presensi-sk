<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">User Lists</h1>

    <?php if (session()->getFlashData('del-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('del-b'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashData('del-g')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('del-g'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashData('edit-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('edit-b'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashData('edit-g')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashData('edit-g'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $row) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row->username; ?></td>
                            <td><?= $row->fullname; ?></td>
                            <?php if ($row->level == 'admin') : ?>
                                <td><span class="badge bg-success"><?= $row->level; ?></span></td>
                            <?php else : ?>
                                <td><span class="badge bg-warning"><?= $row->level; ?></span></td>
                                <?php if ($row->level == 'user') : ?>
                                    <?php if ($row->aktif == null) : ?>
                                        <td><span class="badge bg-danger">Belum Aktif</span></td>
                                    <?php else : ?>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <td>
                                    <a href="<?= base_url(); ?>/userlists/delete/<?= $row->id_user; ?>" onclick="return confirm('Konfirmasi hapus data user')"><button type="button" class="btn btn-danger btn-sm">Hapus</button></a>
                                    <a href="<?= base_url(); ?>/userlists/edit/<?= $row->id_user; ?>"><button type="button" class="btn btn-info btn-sm">Edit</button></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>