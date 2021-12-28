<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Data Kelas</h1>

    <div class="row mt-3">
        <div class="col-lg-5">
            <form action="<?= base_url(); ?>/admin/kelas/update/<?= $kelas->id_kelas; ?>" method="POST">
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $kelas->kelas; ?>">
                </div>
                <div class="mb-3">
                    <label for="guru" class="form-label">Guru</label>
                    <select class="form-select" aria-label="Default select example" name="guru" id="guru">
                        <option value="default" <?= $kelas->id_guru === null ? 'selected' : ''; ?>></option>
                        <?php foreach ($guru as $gr) : ?>
                            <option value="<?= $gr->id_guru; ?>" <?= $gr->id_guru === $kelas->id_guru ? 'selected' : '' ?>><?= $gr->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="<?= base_url(); ?>/admin/datakelas"><button class="btn btn-secondary mr-3">Kembali</button></a>
                    <button class=" btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>