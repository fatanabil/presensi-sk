<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <?php if (session()->getFlashData('error')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashData('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashData('fail-reg')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashData('fail-reg'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashData('rep')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashData('rep'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Registrasi Akun Baru</h1>
                                </div>
                                <form action="<?= base_url(); ?>/auth/validRegister" method="post" class="user">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control form-control-user" placeholder="Username">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" name="repeat-password" placeholder="Repeat Password">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register Account
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url(); ?>/login">Sudah akun? Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>