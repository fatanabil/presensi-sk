<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Cari Data Absen</h1>

    <div class="row">
        <div class="col-lg-10">

            <form action="<?= base_url(); ?>/user/cari" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Cari Nama Siswa" name="keyword" id="keyword" autofocus>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Tanggal Awal" class="form-control tanggal" name="tanggal-awal" id="tgl-awal" onfocus="(this.type='date')" onblur="(this.type='text')">
                            <input type="text" placeholder="Tanggal Akhir" class="form-control tanggal" name="tanggal-akhir" id="tgl-akhir" onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <button class="btn btn-success" style="width: 100px;" type="submit" id="button-addon2">Cari</button>
                    </div> -->
                </div>
            </form>
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Semester</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="result-cari">
                        <?php if (!empty($absen)) : ?>
                            <?php $i = 1 ?>
                            <?php foreach ($tanggal as $tgl) : ?>
                                <?php if ($tgl->tanggal) : ?>
                                    <?php $currtgl = date('d-M-Y', strtotime($tgl->tanggal)) ?>
                                    <tr>
                                        <td colspan="10" style="text-align: center;"><b><?= $currtgl; ?></b></td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($absen as $dt) : ?>
                                    <?php if ($dt->tanggal == $tgl->tanggal) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $dt->nama; ?></td>
                                            <td><?= $dt->tanggal = date('d-M-Y', strtotime($dt->tanggal)); ?></td>
                                            <td><?= $dt->semester; ?></td>
                                            <?php switch ($dt->absen) {
                                                case 'i':
                                                    echo '<td>Ijin</td>';
                                                    break;
                                                case 's':
                                                    echo '<td>Sakit</td>';
                                                    break;
                                                case 'a':
                                                    echo '<td>Alpa</td>';
                                                    break;
                                                default:
                                                    echo '<td>Hadir</td>';
                                                    break;
                                            } ?>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" style="text-align: center;"><b>Data tidak ditemukan</b></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>