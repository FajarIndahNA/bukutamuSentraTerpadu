<!-- panggil file header -->
<?php include "header.php"; ?>

<?php

// uji jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    $tgl = $_POST['tanggal'];

    //htmlspecialchars agar inputan lebih aman dari injection
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $nope = htmlspecialchars($_POST['nope'], ENT_QUOTES);
    $foto = htmlspecialchars($_POST['foto'], ENT_QUOTES);


    //persiapan query simpan data
    $namafoto = $_FILES['foto']['name'];
    $lokasifoto = $_FILES['foto']['tmp_name'];
    // move_uploaded_file($lokasi, "img/" . $namafoto);
    $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES ('','$tgl','$nama',
    '$alamat','$tujuan','$nope','$namafoto')") or die(mysqli_error($koneksi));

    //uji jika simpan data sukses
    if (move_uploaded_file($lokasifoto, "img/" . $namafoto));
    if ($simpan) {
        echo "<script>alert('Simpan data sukses, Terima Kasih..!');
             document.location='?'</script>";
    } else {
        echo "<script>alert('Simpan Data GAGAL!');
             document.location='?'</script>";
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
<div class="row mt-2">
    <!-- cal-lg-7 -->
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradien-light">
            <!-- acrd-body -->
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Identitas Pengunjung</h1>
                </div>
                <form class="user" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="nama" placeholder="Nama Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="alamat" placeholder="Alamat Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="tujuan" placeholder="Tujuan Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-user" name="nope" placeholder="No.hp Pengunjung" required>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control form-control-user" name="tanggal" value="<?= date('Y-m-d') ?>" placeholder="Tanggal" required>
                    </div>
                    <div>
                        <input type="file" class="form-control" name="foto">
                    </div><br>

                    <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>

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

    <!-- cal-lg-5 -->
    <div class="col-lg-5 mb-3">
        <!-- card -->
        <div class="card shadow">
            <!-- card-body -->
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                </div>
                <?php
                //deklarasi tanggal

                //menampilkan tanggal sekarang
                $tgl_sekarang = date('Y-m-d');

                //menampilkan tanggal kemarin
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
                //mendapatkan 6 hari sebelum tanggal sekarang
                $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));
                $sekarang = date('Y-m-d h:i:s');

                //persiapan query tanpilkan jumlah data pengunjung

                $tgl_sekarang = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal like '%$tgl_sekarang%'"
                ));

                $kemarin = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal like '%$kemarin%'"
                ));
                $seminggu = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal BETWEEN '$seminggu' and '$sekarang'"
                ));

                $bulan_ini = date('m');
                $sebulan = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where month(tanggal) = '$bulan_ini'"
                ));
                $keseluruhan = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu"
                ));
                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Hari ini</td>
                        <td><?= $tgl_sekarang[0] ?></td>
                    </tr>
                    <tr>
                        <td>Kemarin</td>
                        <td><?= $kemarin[0] ?></td>
                    </tr>
                    <tr>
                        <td>Minggu ini</td>
                        <td><?= $seminggu[0] ?></td>
                    </tr>
                    <tr>
                        <td>Bulan ini</td>
                        <td><?= $sebulan[0] ?></td>
                    </tr>
                    <tr>
                        <td>Keseluruhan</td>
                        <td><?= $keseluruhan[0] ?></td>
                    </tr>
                </table>
            </div>
            <!-- card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end cal-lg-5 -->

</div>
<!-- end row -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [<?= date('d-m-Y') ?>]</h6>
    </div>
    <div class="card-body">
        <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa 
                            fa-table"></i>Rekapitulasi Pengunjung</a>
        <a href="logout.php" class="btn btn-danger mb-3"><i class="fa 
                            fa-sign-out-alt"></i>Logout</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N0.</th>
                        <th>Tanggal</th>
                        <th>Nama Pengunjung</th>
                        <th>Alamat</th>
                        <th>Tujuan</th>
                        <th>No.HP</th>
                        <th>Keterangan</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N0.</th>
                        <th>Tanggal</th>
                        <th>Nama Pengunjung</th>
                        <th>Alamat</th>
                        <th>Tujuan</th>
                        <th>No.HP</th>
                        <th>Keterangan</th>
                        <th>Foto</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $tgl = date('Y-m-d');
                    $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu where tanggal like '%$tgl' order by id
                                            desc");
                    $no = 1;
                    while ($data = mysqli_fetch_array($tampil)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['tanggal'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['tujuan'] ?></td>
                            <td><?= $data['nope'] ?></td>
                            <td><a href='update.php?id=<?php echo htmlspecialchars($data['id']); ?>' class="btn btn-warning" role="button"> Ubah</a></td>
                            <td><?php echo "<img src='img/$data[foto]' width='70' height='90' />"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- panggil file footer -->
<?php include "footer.php"; ?>