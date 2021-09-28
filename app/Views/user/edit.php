<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Profile</h1>

    <div class="row">
        <div class="col-lg-8">
            <?php if (session()->getFlashData('save-b')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashData('save-b'); ?>
                </div>
            <?php elseif (session()->getFlashData('save-g')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashData('save-g'); ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-4 mr-2">
                    <img src="<?= base_url(); ?>/img/default.svg" alt="">
                </div>
                <div class="col-lg-7">
                    <form action="<?= base_url(); ?>/user/saveprofile" method="post">
                        <div class="row mb-2">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm ml-5">
                                <?php if (session()->get('level') == 'admin') : ?>
                                    <input type="hidden" class="form-control" id="nama" name="id" value="<?= $diri->id_user; ?>">
                                <?php else : ?>
                                    <input type="hidden" class="form-control" id="nama" name="id" value="<?= $diri->id_guru; ?>">
                                <?php endif; ?>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $diri->fullname; ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm ml-5">
                                <input type="text" class="form-control" id="username" name="username" value="<?= $diri->username; ?>">
                            </div>
                        </div>
                        <?php if (session()->get('level') == 'user') : ?>
                            <div class="row mb-2">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm ml-5">
                                    <textarea type="text" class="form-control" id="alamat" name="alamat"><?= $diri->alamat; ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-end my-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>