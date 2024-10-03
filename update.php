<!DOCTYPE html>
<html>
<style type="text/css">
    .box {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<?php
include "koneksi.php";
include "header.php";
function input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//cek nilai yang dikirim menggunakan method get dengan nama id
if (isset($_GET['id'])) {
    $id = input($_GET['id']);

    $sql = "select *from ttamu where id = $id";
    $hasil = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_assoc($hasil);
}
//cek apakah ada kiriman form dari methpd post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST["id"]);
    $nama = input($_POST["nama"]);
    $alamat = input($_POST["alamat"]);
    $tujuan = input($_POST["tujuan"]);
    $nope = input($_POST["nope"]);
    $tanggal = $_POST['tanggal'];
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];

    // Query update data
    if (!empty($lokasifoto)) {
        move_uploaded_file($lokasifoto, "img/$namafoto");
        $sql = "UPDATE ttamu SET 
        nama='$nama',
        alamat='$alamat',
        tujuan='$tujuan',
        nope='$nope',
        tanggal='$tanggal',
        foto='$namafoto'
        WHERE id='$id'";
    } else {
        $sql = "UPDATE ttamu SET 
        nama='$nama',
        alamat='$alamat',
        tujuan='$tujuan',
        nope='$nope',
        tanggal='$tanggal'
        WHERE id='$id'";
    }

    // Eksekusi query
    $hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

    // Periksa apakah berhasil atau tidak
    if ($hasil) {
        header("location: admin.php");
    } else {
        echo "<div> Data gagal diupdate </div>";
    }
}


?>
<!-- Head -->
<div class="head text-center">
    <img src="assets/img/logo.png">
    <h2 class="text-white">Sistem Informasi Buku Tamu</h2>
</div>
<!-- end Head -->

<!-- awal row -->
<div class="row mt-2 box">
    <!-- cal-lg-7 -->
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradien-light">
            <!-- card-body -->
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Identitas</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="user" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="nama" value="<?php echo $data['nama']; ?>" placeholder="Nama Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="alamat" value="<?php echo $data['alamat']; ?>" placeholder="Alamat Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="tujuan" value="<?php echo $data['tujuan']; ?>" placeholder="Tujuan Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="nope" value="<?php echo $data['nope']; ?>" placeholder="No.hp Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control form-control-user" name="tanggal" value="<?php echo $data['tanggal']; ?>" placeholder="Tanggal" required>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="foto">
                    </div><br>

                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                    <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Simpan Data</button>

                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="#">Sentra Terpadu Prof. Dr. Soeharso | Kementerian Sosial <?= date('Y') ?></a>
                </div>

            </div>
            <!-- end card-body -->
        </div>
    </div>
    <!-- end col-lg-7 -->