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

    $kode_transaksi = $_POST['kode_transaksi'];
    $id_anggota = $_POST['id_anggota'];
    $id_user = $_POST['id_user'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $id_kategori = $_POST['id_kategori'];

    $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, id_user, tgl_pinjam, tgl_kembali, status) VALUES 
    ('$kode_transaksi','$id_anggota', '$id_user', '$tgl_pinjam','$tgl_kembali','1')");

    if ($insert) {
        $id_peminjam = mysqli_insert_id($koneksi);
        foreach ($id_kategori as $key => $value) {
            $id_kategori = $_POST['id_kategori'][$key];
            $id_buku = $_POST['id_buku'][$key];
            $insert = mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman,id_kategori, id_buku ) VALUES 
    ('$id_peminjam', '$id_kategori','$id_buku')");
            header("location:?pg=peminjaman&tambah=berhasil");
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "UPDATE peminjaman SET deleted_at = 1 WHERE id = '$id'");
    header("location:?pg=peminjaman&hapus=berhasil");
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");

//kode transaksi
$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;

$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

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
                    <div class="card-header">Detail Transaksi Peminjaman</div>
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
                        <a href="?pg=peminjaman" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
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
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-5">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="date" class="form-control" name="tgl_kembali" value="">
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
                            </div>

                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Tahun Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->
                            </tbody>
                        </table>
                    </div>



                    <div class="mx-3 mb-3">
                        <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3"></input>
                        <a href="?pg=peminjaman" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
<?php endif ?>