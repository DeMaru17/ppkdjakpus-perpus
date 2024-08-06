<?php

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])) {
    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $nisn = $_POST['nisn'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];


    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO anggota (nisn, nama_lengkap, jenis_kelamin, no_telp, alamat) VALUES ('$nisn','$nama_lengkap','$jenis_kelamin', '$no_telp', '$alamat')");
    } else {
        $update = mysqli_query($koneksi, "UPDATE anggota SET nisn = '$nisn', nama_lengkap = '$nama_lengkap', jenis_kelamin = '$jenis_kelamin', no_telp = $no_telp, alamat = '$alamat' WHERE id = '$id'");
    }


    header("location:?pg=anggota&tambah=berhasil");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM anggota WHERE id = '$id'");
    header("location:?pg=anggota&hapus=berhasil");
}



?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-header">Data anggota</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">NISN</label>
                            <input value="<?= $rowEdit['nisn'] ?? ''; ?>" type="number" class="form-control" id="" name="nisn">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama anggota</label>
                            <input value="<?= $rowEdit['nama_lengkap'] ?? ''; ?>" type="text" class="form-control" id="" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" id="">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" <?= isset($rowEdit['jenis_kelamin']) && $rowEdit['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?= isset($rowEdit['jenis_kelamin']) && $rowEdit['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">No Telepon</label>
                            <input value="<?= $rowEdit['no_telp'] ?? ''; ?>" type="number" class="form-control" id="" name="no_telp">

                            <label for="" class="form-label">Alamat</label>
                            <input value="<?= $rowEdit['alamat'] ?? ''; ?>" type="text" class="form-control" id="" name="alamat">   

                            <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3"></textarea>
                            <a href="?pg=anggota" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>