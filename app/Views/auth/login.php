<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">

                                <?php if (session()->getFlashData('password')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashData('password'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashData('login')) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session()->getFlashData('login'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashData('username')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashData('username'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang</h1>
                                </div>
                                <form action="<?= base_url(); ?>/auth/validLogin" method="post" class="user">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username" aria-describedby="emailHelp" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url(); ?>/register">
                                        Belum punya akun? buat akun
                                    </a>
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