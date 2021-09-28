<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card" style="width: 18rem;">
                <div class="d-flex justify-content-center" style="height : 220px">
                    <img style="width: 200px;" src="<?= base_url(); ?>/img/default.svg" class="card-img-top" alt="Username">
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if (session()->get('level') == 'user') : ?>
                            <li class="list-group-item">
                                <h4><?= $user->nama; ?></h4>
                            </li>
                            <li class="list-group-item"><?= $user->kelas; ?></li>
                            <li class="list-group-item"><?= $user->alamat; ?></li>
                            <li class="list-group-item"><span class="badge badge-warning">Guru</span></li>
                        <?php else : ?>
                            <li class="list-group-item">
                                <h4><?= $user->fullname; ?></h4>
                            </li>
                            <li class="list-group-item"><span class="badge badge-success">Admin</span></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>