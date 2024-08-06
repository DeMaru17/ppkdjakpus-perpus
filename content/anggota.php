<?php
$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA ANGGOTA</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-anggota" class="btn btn-primary">Tambah</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">Data Berhasil Ditambah</div>
                    <?php endif; ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger">Data Telah Dihapus</div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowAnggota['nisn'] ?></td>
                                    <td><?= $rowAnggota['nama_lengkap'] ?></td>
                                    <td><?= $rowAnggota['jenis_kelamin'] ?></td>
                                    <td><?= $rowAnggota['no_telp'] ?></td>
                                    <td><?= $rowAnggota['alamat'] ?></td>
                                    <td><a href="?pg=tambah-anggota&edit=<?= $rowAnggota['id'] ?>" class="btn btn-sm btn-primary">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-anggota&delete=<?= $rowAnggota['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>