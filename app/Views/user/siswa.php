<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <?php if (session()->getFlashData('siswa-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('siswa-b'); ?>
        </div>
    <?php elseif (session()->getFlashData('siswa-g')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashData('siswa-g'); ?>
        </div>
    <?php elseif (session()->getFlashData('del-siswa-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('del-siswa-b'); ?>
        </div>
    <?php elseif (session()->getFlashData('del-siswa-g')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashData('del-siswa-g'); ?>
        </div>
    <?php endif; ?>

    <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsiswa"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Siswa</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa as $row) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $row->nama; ?></td>
                                <td><?= $row->jenkel; ?></td>
                                <td><?= $row->alamat; ?></td>
                                <td><?= $row->kelas; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>/admin/kelas/edit/<?= $row->id_siswa; ?>"><button class="btn btn-info btn-sm">Edit</button></a> |
                                    <a href="<?= base_url(); ?>/siswa/delete/<?= $row->id_siswa; ?>"><button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda ingin menghapus data ini ?')">Hapus</button></a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addsiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addsiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addsiswaLabel">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url(); ?>/user/adddatasiswa" method="POST">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th style="width: 20rem;">Nama</th>
                                    <th style="width: 5rem;">Jenkel</th>
                                    <th>Alamat</th>
                                    <th style="width: 5rem;">Kelas</th>
                                    <th>Hapus</th>
                                </thead>
                                <tbody id="tbdy">
                                    <tr>
                                        <td><input type="text" class="form-control" placeholder="Nama" name="nama[]"></td>
                                        <td>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenkel[]">
                                                <option value="L" selected>L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Alamat" name="alamat[]"></td>
                                        <td><input type="text" class="form-control" placeholder="<?= $siswa[0]->kelas; ?>" name="kelas[]" disabled></td>
                                        <td><button type=" button" class="btn-close" id="del-btn"></button></td>
                                        <td><input type="text" class="form-control" name="kelas[]" value="<?= $siswa[0]->id_kelas; ?>" hidden></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col d-flex flex-row-reverse">
                                <button type="button" class="btn btn-primary" id="add-btn">Tambah input</button>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add-btn').click(function() {
                $('#tbdy').append('<tr><td><input type="text" class="form-control" placeholder="Nama" name="nama[]"></td><td><select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenkel[]"><option value="L">L</option><option value="P">P</option></select></td><td><input type="text" class="form-control" placeholder="Alamat" name="alamat[]"></td><td><input type="text" class="form-control" placeholder="<?= $siswa[0]->kelas; ?>" name="kelas[]" disabled></td><td><button type=" button" class="btn-close" id="del-btn"></button></td><td><input type="text" class="form-control" name="kelas[]" value="<?= $siswa[0]->id_kelas; ?>" hidden></td></tr>')
            })
            $('#tbdy').on('click', '#del-btn', function() {
                $(this).closest('tr').remove()
            })
        })
    </script>
</div>

<?= $this->endsection(); ?>