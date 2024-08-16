<?php
if (isset($_GET['detail'])) {
    // Data peminjam
    $id = $_GET['detail'];
    $detail = mysqli_query(
        $koneksi,
        "SELECT  
    anggota.nama_lengkap as nama_anggota,
    peminjaman.*,
    user.nama_lengkap 
    FROM peminjaman 
    LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota
    LEFT JOIN user ON user.id = peminjaman.id_user
    WHERE peminjaman.id = '$id'"
    );
    $rowDetail = mysqli_fetch_assoc($detail);

    //menghitung detail durasi pinjam
    $tgl_pinjam = $rowDetail['tgl_pinjam'];
    $tgl_kembali = $rowDetail['tgl_kembali'];

    $date_pinjam = new DateTime($tgl_pinjam);
    $date_kembali = new DateTime($tgl_kembali);
    $interval = $date_pinjam->diff($date_kembali);



    //Get Buku
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman 
    LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku 
    LEFT JOIN kategori ON kategori.id = detail_peminjaman.id_kategori
    WHERE id_peminjaman = '$id'");
}

if (isset($_POST['simpan'])) {

    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $kode_kembali = $_POST['kode_pengembalian'];
    $terlambat = $_POST['terlambat'];
    $denda = $_POST['denda'];

    $insert = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman, tgl_pengembalian, kode_pengembalian, terlambat, denda ) VALUES 
    ('$id_peminjaman','$tgl_pengembalian', '$kode_kembali', '$terlambat', '$denda')");

    if ($insert) {
        $insert = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id = '$id_peminjaman'");
        header("location:?pg=pengembalian&tambah=berhasil");
    }
}


// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];

//     $delete = mysqli_query($koneksi, "UPDATE pengembalian SET deleted_at = 1 WHERE id = '$id'");
//     header("location:?pg=pengembalian&hapus=berhasil");
// }

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

//kode transaksi
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$queryKodeKembali = mysqli_query($koneksi, "SELECT max(id) as id_kembali FROM pengembalian");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$rowKodeKembali = mysqli_fetch_assoc($queryKodeKembali);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut_kembali = $rowKodeKembali['id_kembali'];
$no_urut++;
$no_urut_kembali++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);
$kode_pengembalian = "KMBL" . date("dmY") . sprintf("%03s", $no_urut_kembali);



// $kode_pengembalian = "PL" . date("dmY") . sprintf("%03s", $no_urut);

$queryAngota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");

$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 1 ORDER BY id DESC");


?>

<?php
if (isset($_GET['detail'])): ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">Detail Transaksi Pengembalian</div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Kode Transaksi</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['kode_transaksi'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('D, d M Y', strtotime($rowDetail['tgl_pinjam'])) ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date('D, d M Y', strtotime($rowDetail['tgl_kembali'])) ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Durasi Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $interval->days . " Hari" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Anggota</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_anggota'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_lengkap'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= getStatus($rowDetail['status']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="mb-5 mt-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                </tr>
                                <?php $no = 1;
                                while ($rowDetail = mysqli_fetch_assoc($queryDetail)) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $rowDetail['nama_kategori'] ?></td>
                                        <td><?= $rowDetail['judul'] ?></td>
                                    </tr>
                                <?php endwhile ?>
                            </table>
                        </div>
                        <a href="?pg=pengembalian" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                    </div>



                </div>

            </div>
        </div>
    </div>
    </div>
<?php else : ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">Data Pengembalian</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3 row">
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <input type="hidden" class="form-control" name="kode_pengembalian" id="" value="<?= ($kode_pengembalian ?? '') ?>" readonly>
                                                <label for="" class="form-label">Tanggal Pengembalian</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" value="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <label for="" class="form-label">Nama Petugas</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="" id="" value="<?= ($_SESSION['NAMA_LENGKAP'] ?? '') ?>" readonly>
                                                <input type="hidden" name="id_user" value="<?= ($_SESSION['ID_USER'] ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-5">
                                                <label for="" class="form-label">Kode Peminjaman</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <select name="id_peminjaman" id="kode_peminjaman" class="form-control">
                                                    <option value="">Pilih Kode Peminjaman</option>
                                                    <?php while ($rowPeminjaman = mysqli_fetch_assoc($queryPeminjaman)): ?>
                                                        <option value="<?php echo $rowPeminjaman['id'] ?>"><?php echo $rowPeminjaman['kode_transaksi'] ?></option>
                                                    <?php endwhile ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <label for="">Nama Anggota</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input placeholder="Nama Anggota" type="text" class="form-control" readonly name="" id="nama_anggota" value="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <label for="">Tanggal Pinjam</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input placeholder="Tanggal Pinjam" type="text" class="form-control" readonly name="" id="tanggal_pinjam" value="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <label for="">Tanggal Kembali</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input placeholder="Tanggal Kembali" type="text" class="form-control" readonly name="" id="tanggal_kembali" value="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-5">
                                                <label for="">Terlambat</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <input placeholder="Keterangan keterlambatan" type="text" class="form-control" readonly name="terlambat" id="terlambat" value="">
                                                <input type="hidden" name="denda" id="denda">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                                <div align="right" class="total-denda">
                                    <h5></h5>
                                </div>
                            </div>



                            <div class="mx-3 mb-3">
                                <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3"></input>
                                <a href="?pg=pengembalian" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif ?>