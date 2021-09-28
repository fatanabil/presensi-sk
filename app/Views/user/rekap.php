<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Rekap Absen</h1>

    <div class="row">
        <div class="col-lg-8">

            <div class="row">
                <div class="col-sm-1">
                    <h1 class="h6">Kelas</h1>
                    <h1 class="h6">Guru</h1>
                </div>
                <div class="col-sm-1">
                    <h1 class="h6">:</h1>
                    <h1 class="h6">:</h1>
                </div>
                <div class="col-sm">
                    <h1 class="h6" id="kelas"><?= $kelas->kelas;  ?></h1>
                    <h1 class="h6"><?= $kelas->nama_guru; ?></h1>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-4 mt-2">
                    <select class="form-control form-control-solid" name="semester" id="semester-select">
                        <option value="all" selected>Semua Semester</option>
                        <option value="ganjil">Semester Ganjil</option>
                        <option value="genap">Semester Genap</option>
                    </select>
                </div>
                <div class="col-lg-4 mt-2">
                    <a id="pdf" href="<?= base_url(); ?>/rekap-pdf/<?= $kelas->kelas; ?>/all"><button type="button" class="btn btn-success"><i class="fas fa-file-download mr-2"></i>Rekap Absensi</button></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mt-4 ">
                    <thead>
                        <tr>
                            <th style="width:20px">#</th>
                            <th style="width:150px">Nama</th>
                            <th style="width:50px; text-align:center">Hadir</th>
                            <th style="width:50px; text-align:center">Ijin</th>
                            <th style="width:50px; text-align:center">Sakit</th>
                            <th style="width:50px; text-align:center">Alpa</th>
                            <th style="width:50px; text-align:center">Total</th>
                        </tr>
                    </thead>
                    <tbody id="result">
                        <?php $i = 1 ?>
                        <?php foreach ($siswa as $dt) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $dt->nama; ?></td>
                                <td style="text-align: center;"><?= $dt->hadir; ?></td>
                                <td style="text-align: center;"><?= $dt->ijin; ?></td>
                                <td style="text-align: center;"><?= $dt->sakit; ?></td>
                                <td style="text-align: center;"><?= $dt->alpa; ?></td>
                                <td style="text-align: center;"><?= $dt->total; ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>