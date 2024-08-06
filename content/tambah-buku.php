<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $judul = $_POST['judul'];
    $jumlah = $_POST['jumlah'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penulis = $_POST['penulis'];
    $id_kategori = $_POST['id_kategori'];


    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO buku (judul, jumlah, penerbit, tahun_terbit, penulis, id_kategori) VALUES ('$judul','$jumlah', '$penerbit', '$tahun_terbit', '$penulis', '$id_kategori')");
        header("location:?pg=buku&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE buku SET judul = '$judul', jumlah = '$jumlah', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', penulis = '$penulis', id_kategori = '$id_kategori' WHERE id = '$id'");
        header("location:?pg=buku&ubah=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM buku WHERE id = '$id'");
    header("location:?pg=buku&hapus=berhasil");
}

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");


?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-header">Data Buku</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="id_kategori" id="" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php while ($rowKategori = mysqli_fetch_assoc($kategori)) : ?>
                                    <option <?= (isset($rowEdit['id_kategori']) && $rowEdit['id_kategori'] == $rowKategori['id']) ? 'selected' : '' ?> value="<?= $rowKategori['id'] ?>"><?= $rowKategori['nama_kategori'] ?></option>
                                <?php endwhile ?>
                            </select>

                            <label for="" class="form-label">Judul Buku</label>
                            <input value="<?= $rowEdit['judul'] ?? ''; ?>" type="text" class="form-control" id="" name="judul">

                            <label for="" class="form-label">Jumlah</label>
                            <input value="<?= $rowEdit['jumlah'] ?? ''; ?>" type="number" class="form-control" id="" name="jumlah">

                            <label for="" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="" name="penerbit" value="<?= $rowEdit['penerbit'] ?? ''; ?>">

                            <label for="" class="form-label">Tahun Terbit</label>
                            <input type="text" class="form-control" id="" name="tahun_terbit" value="<?= $rowEdit['tahun_terbit'] ?? ''; ?>">

                            <label for="" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="" name="penulis" value="<?= $rowEdit['penulis'] ?? ''; ?>">

                            <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3"></input>
                            <a href="?pg=buku" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>