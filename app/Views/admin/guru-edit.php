<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Kelas</h1>

    <div class="row mt-3">
        <div class="col-lg-5">
            <form action="<?= base_url(); ?>/admin/guru/update/<?= $guru->id_guru; ?>" method="post">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $guru->nama; ?>">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $guru->username; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenkel" id="L" value="L" <?= $guru->jenkel === 'L' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="L">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenkel" id="P" value="P" <?= $guru->jenkel === 'P' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="P">Perempuan</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" rows="3" name="alamat"><?= $guru->alamat; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="kelas">Kelas</label>
                    <select class="form-select" aria-label="Default select example" id="kelas" name="kelas">
                        <option value="default" <?= $guru->id_kelas == null ? 'selected' : ''; ?>></option>
                        <?php foreach ($kelas as $kl) : ?>
                            <option value="<?= $kl->id_kelas; ?>" <?= $kl->id_kelas === $guru->id_kelas ? 'selected' : ''; ?>><?= $kl->kelas; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="<?= base_url(); ?>/admin/dataguru"><button class="btn btn-secondary mr-3">Kembali</button></a>
                    <button class="btn btn-success" type="submit">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>