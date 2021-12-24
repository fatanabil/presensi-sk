<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <?php if (session()->getFlashData('kelas-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('kelas-b'); ?>
        </div>
    <?php elseif (session()->getFlashData('kelas-g')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashData('kelas-g'); ?>
        </div>
    <?php elseif (session()->getFlashdata('del-kelas-b')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('del-kelas-b'); ?>
        </div>
    <?php elseif (session()->getFlashdata('del-kelas-g')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashData('del-kelas-g'); ?>
        </div>
    <?php endif; ?>


    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data Kelas</h1>

    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addkelas"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Kelas</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-10">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Jumlah siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($kelas as $row) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $row->kelas; ?></td>
                                <td><?= $row->nama; ?></td>
                                <td><?= $row->jumlah; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>/admin/kelas/edit/<?= $row->id_kelas; ?>"><button class="btn btn-info btn-sm">Edit</button></a> |
                                    <a href="<?= base_url(); ?>/kelas/delete/<?= $row->id_kelas; ?>"><button class="btn btn-danger btn-sm">Hapus</button></a>
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
    <div class="modal fade" id="addkelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addkelasLabel" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addkelasLabel">Tambah Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url(); ?>/admin/adddatakelas" method="POST">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th style="width: 20rem;">Kelas</th>
                                    <th style="width: 20rem;">Guru</th>
                                    <th>Hapus</th>
                                </thead>
                                <tbody id="tbdy">
                                    <tr>
                                        <td><input type="text" class="form-control" placeholder="Kelas" name="nama-kelas[]"></td>
                                        <td>
                                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="guru[]">
                                                <option value="default" selected></option>
                                                <?php foreach ($guru as $gr) : ?>
                                                    <option value="<?= $gr->id_guru; ?>"><?= $gr->nama; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><button type="button" class="btn-close" id="del-btn"></button></td>
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
</div>

<script>
    $(document).ready(function() {
        $('#add-btn').click(function() {
            $('#tbdy').append('<tr><td><input type = "text"class = "form-control" placeholder = "Kelas" name = "nama-kelas[]"></td><td><select class = "form-select form-select-sm" aria - label = ".form-select-sm example" name = "guru[]"><option value="default" selected></option><?php foreach ($guru as $gr) : ?><option value = "<?= $gr->id_guru; ?>"><?= $gr->nama; ?></option><?php endforeach; ?></select></td><td><button type = "button" class = "btn-close" id = "del-btn"></button></td ></tr>')
        })
        $('#tbdy').on('click', '#del-btn', function() {
            $(this).closest('tr').remove()
        })
    })
</script>

<?= $this->endsection(); ?>