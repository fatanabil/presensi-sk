<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-4 mr-2">
                    <img src="<?= base_url(); ?>/img/default.svg" alt="">
                </div>
                <div class="col-lg-6">
                    <form action="<?= base_url(); ?>/admin/save" method="post">
                        <div class="row mb-2">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-lg ml-5">
                                <input type="hidden" readonly class="form-control-plaintext" name="id" id="nama" value="<?= $user->id_user; ?>">
                                <select class="form-control form-control-solid" name="id-nama" id="level">
                                    <?php foreach ($guru as $dt) : ?>
                                        <option value="<?= $dt->id_guru; ?>"><?= $dt->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-lg ml-5">
                                <input type="text" readonly class="form-control-plaintext" id="username" value="<?= $user->username; ?>">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="level" class="col-sm-2 col-form-label">Level</label>
                            <div class="col-lg ml-5">
                                <select class="form-control form-control-solid" name="level" id="level">
                                    <option value="user" selected>User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
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