<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <?php if (session()->getFlashData('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('pesan'); ?>
        </div>
    <?php elseif (session()->getFlashData('pesan-g')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('pesan-g'); ?>
        </div>
    <?php endif; ?>

    <h1 class="h3 mb-4 text-gray-800">Absensi</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-sm-1">
                    <h1 class="h6">Tanggal</h1>
                    <h1 class="h6">Kelas</h1>
                    <h1 class="h6">Guru</h1>
                </div>
                <div class="col-sm-1">
                    <h1 class="h6">:</h1>
                    <h1 class="h6">:</h1>
                    <h1 class="h6">:</h1>
                </div>
                <div class="col">
                    <h1 class="h6"><?= date("d-M-Y"); ?></h1>
                    <h1 class="h6"><?= $kelas->kelas;  ?></h1>
                    <h1 class="h6"><?= $kelas->nama_guru; ?></h1>
                </div>
            </div>

            <form action="<?= base_url(); ?>/user/save" method="post">
                <?php csrf_field(); ?>

                <div class="row mt-2">
                    <div class="col-lg-4">
                        <select class="form-control form-control-solid" name="semester">
                            <option value="ganjil" selected>Semester Ganjil</option>
                            <option value="genap">Semester Genap</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th style="width:20px">#</th>
                                <th style="width:200px">Nama</th>
                                <th style="width:50px;">Hadir</th>
                                <th style="width:50px;">Ijin</th>
                                <th style="width:50px;">Sakit</th>
                                <th style="width:50px;">Alpa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($siswa as $dt) : ?>
                                <tr>
                                    <td hidden>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="dt<?= $i; ?>[id]" value="<?= $dt->id_siswa; ?>">
                                            <input type="text" class="form-control" name="dt<?= $i; ?>[nama]" value="<?= $dt->nama; ?>">
                                        </div>
                                    </td>
                                    <td><?= $i; ?></td>
                                    <td><?= $dt->nama; ?></td>
                                    <td style="text-align: center;"><input class="form-check-input" type="radio" name="dt<?= $i; ?>[absen]" value="h" checked></td>
                                    <td style="text-align: center;"><input class="form-check-input" type="radio" name="dt<?= $i; ?>[absen]" value="i"></td>
                                    <td style="text-align: center;"><input class="form-check-input" type="radio" name="dt<?= $i; ?>[absen]" value="s"></td>
                                    <td style="text-align: center;"><input class="form-check-input" type="radio" name="dt<?= $i; ?>[absen]" value="a"></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>