<?php

include("koneksi.php");

$tahun = date("Y");

?>

<div class="container" style="padding-top: 0.8cm;">

<div class="lingkaran" style="width:100%; margin-left: 0%; margin-bottom: 3%;">
    <center><h5 class="judul" style="margin-top: 3%;">JUMLAH TRANSAKSI ASET</h5></center>
	<center><h5 class="judul">PEMERINTAH DESA SENDANGTIRTO-KEC.BERBAH-SLEMAN-DI YOGYAKARTA</h5></center>
	<center><h5 class="judul" style="margin-bottom: 3%;">TAHUN <?php echo $tahun ?></h5></center>
</div>

<!-- <table>
    <tr>
        <td><input style="width: 100%; margin-left: 0.4cm; margin-bottom: 1cm;" type="text" class="form-control" name="tahun_keputusan" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" placeholder="Masukkan Tahun" required></td>
        <td><a href="menu.php?page=tambah_inventaris" class="btn btn-success" style="margin-bottom: 1cm; font-size: 15px; border-radius: 5px; width: 100%; margin-left: 0.4cm;"><i class="bi bi-search"></i></a></td>
    </tr>
</table> -->

<!-- <form method="POST" action="detail/proses_detail/proses_inventaris.php">
      <div class="modal-body">
	  	<input type="hidden" name="ein_kode_tp" value="<?php //$pecah_tp['kode_inventaris']?>">
			<div class="mb-3">
    			<label class="form-label"><b>Kode</b></label>
    			<input type="text" class="form-control" value="<?php //$pecah_tp['kode_inventaris']." - ".$pecah_tp['nama_barang_tp']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Identitas</b></label>
				<textarea class="form-control" name="ein_identitas_tp" rows="4" cols="50" style="resize: none;" required><?php //$pecah_tp['identitas_barang']?></textarea>
			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="ein_keterangan_tp" rows="4" cols="50" style="resize: none;" required><?php //$pecah_tp['keterangan_aset']?></textarea>
    			<input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;">
  			</div>
      	</div>
      	<div class="modal-footer">
		  	<button type="submit" class="btn btn-primary" name="bUbahTP">Ubah</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      	</div>
	</form> -->


<table style="width:100%">
    <tr align="center">
        <td>
            <div class="card text-bg-primary mb-3" style="max-width: 30rem;">
                <div class="card-header">PERENCANAAN</div>
                    <div class="card-body">
                        <?php

                                $hitung_detail_perencanaan = $con->query("SELECT SUM(perkiraan_volume) AS aset_perencanaan FROM detail_perencanaan JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE perencanaan.tahun_rkp = '$tahun'");
                                $jumlah_aset_perencanaan = mysqli_fetch_assoc($hitung_detail_perencanaan);

                                if($jumlah_aset_perencanaan['aset_perencanaan'] < 1){
                        ?>
                                    <center><h2 class="card-title"><?= 0 ?></h2><center>
                        <?php
                                } else {
                        ?>
                                    <center><h2 class="card-title"><?= $jumlah_aset_perencanaan['aset_perencanaan'] ?></h2><center>
                        <?php
                                }

                        ?>
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div class="card text-bg-success mb-3" style="max-width: 30rem;">
                <div class="card-header">PENGADAAN</div>
                <div class="card-body">
                    <?php

                        $hitung_detail_pengadaan = $con->query("SELECT SUM(perkiraan_volume) AS aset_pengadaan FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN perencanaan ON detail_perencanaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE perencanaan.tahun_rkp = '$tahun'");
                        $jumlah_aset_pengadaan = mysqli_fetch_assoc($hitung_detail_pengadaan);

                        if($jumlah_aset_pengadaan['aset_pengadaan'] < 1){
                    ?>
                        <center><h2 class="card-title"><?= 0 ?></h2><center>
                    <?php
                        } else {
                    ?>
                        <center><h2 class="card-title"><?= $jumlah_aset_pengadaan['aset_pengadaan'] ?></h2><center>
                    <?php
                        }

                    ?>
                </div>
            </div>      
        </td>
    </tr>
    <tr align="center">
    <td>
        <div class="card text-bg-success mb-3" style="max-width: 30rem;">
            <div class="card-header">PEROLEHAN</div>
                <div class="card-body">
                <?php

                        $hitung_detail_perolehan = $con->query("SELECT SUM(volume_tp) AS aset_perolehan FROM detail_pengadaan_tp JOIN pengadaan_tp WHERE tahun_pengadaan_tp = '$tahun'");
                        $jumlah_aset_perolehan = mysqli_fetch_assoc($hitung_detail_perolehan);

                        if($jumlah_aset_perolehan['aset_perolehan'] < 1){
                ?>
                            <center><h2 class="card-title"><?= 0 ?></h2><center>
                <?php
                        } else {
                ?>
                            <center><h2 class="card-title"><?= $jumlah_aset_perolehan['aset_perolehan'] ?></h2><center>
                <?php
                        }

                ?>
                </div>
            </div>      
        </td>
        <td>
            <div class="card text-bg-warning mb-3" style="max-width: 30rem;">
                <div class="card-header">INVENTARIS</div>
                <div class="card-body">
                <?php

                        $hitung_aset_inventaris = $con->query("SELECT SUM(jumlah) AS aset_inventaris FROM inventaris");
                        $jumlah_aset_inventaris = mysqli_fetch_assoc($hitung_aset_inventaris);

                        if($jumlah_aset_inventaris['aset_inventaris'] < 1){
                ?>
                            <center><h2 class="card-title"><?= 0 ?></h2><center>
                <?php
                        } else {
                ?>
                            <center><h2 class="card-title"><?= $jumlah_aset_inventaris['aset_inventaris'] ?></h2><center>
                <?php
                        }

                ?>
                </div>
            </div>      
        </td>
    </tr>
    <tr align="center">
        <td>
            <div class="card text-bg-secondary mb-3" style="max-width: 30rem;">
                <div class="card-header">PENGGUNAAN</div>
                <div class="card-body">
                <?php

                        $hitung_aset_penggunaan = $con->query("SELECT SUM(jumlah_pg) AS aset_penggunaan FROM detail_penggunaan");
                        $jumlah_aset_penggunaan = mysqli_fetch_assoc($hitung_aset_penggunaan);

                        if($jumlah_aset_penggunaan['aset_penggunaan'] < 1){
                ?>
                            <center><h2 class="card-title"><?= 0 ?></h2><center>
                <?php
                        } else {
                ?>
                            <center><h2 class="card-title"><?= $jumlah_aset_penggunaan['aset_penggunaan'] ?></h2><center>
                <?php
                        }

                ?>
                </div>
            </div>
        </td>
        <td>
            <div class="card text-bg-primary mb-3" style="max-width: 30rem;">
                <div class="card-header">PEMANFAATAN</div>
                <div class="card-body">
                <?php

                        $hitung_aset_pemanfaatan = $con->query("SELECT SUM(jumlah_aset_p) AS aset_pemanfaatan FROM detail_pemanfaatan JOIN pemanfaatan ON detail_pemanfaatan.kode_pemanfaatan = pemanfaatan.kode_pemanfaatan WHERE pemanfaatan.tahun_pemanfaatan = '$tahun'");
                        $jumlah_aset_pemanfaatan = mysqli_fetch_assoc($hitung_aset_pemanfaatan);

                        if($jumlah_aset_pemanfaatan['aset_pemanfaatan'] < 1){
                ?>
                            <center><h2 class="card-title"><?= 0 ?></h2><center>
                <?php
                        } else {
                ?>
                            <center><h2 class="card-title"><?= $jumlah_aset_pemanfaatan['aset_pemanfaatan'] ?></h2><center>
                <?php
                        }

                ?>
                </div>
            </div>      
        </td>
    </tr>
    <tr align="center">
        <td>
            <div class="card text-bg-danger mb-3" style="max-width: 30rem;">
                <div class="card-header">PENGHAPUSAN</div>
                <div class="card-body">
                <?php

                        $hitung_aset_penghapusan = $con->query("SELECT SUM(jumlah_penghapusan) AS aset_penghapusan FROM detail_penghapusan JOIN penghapusan ON detail_penghapusan.kode_penghapusan = penghapusan.kode_penghapusan WHERE penghapusan.tahun_berita_acara = '$tahun'");
                        $jumlah_aset_penghapusan = mysqli_fetch_assoc($hitung_aset_penghapusan);

                        if($jumlah_aset_penghapusan['aset_penghapusan'] < 1){
                ?>
                            <center><h2 class="card-title"><?= 0 ?></h2><center>
                <?php
                        } else {
                ?>
                            <center><h2 class="card-title"><?= $jumlah_aset_penghapusan['aset_penghapusan'] ?></h2><center>
                <?php
                        }

                ?>
                </div>
            </div>      
        </td>
        <td>
            <div class="card text-bg-warning mb-3" style="max-width: 30rem;">
                <div class="card-header">PENGURUS</div>
                <div class="card-body">
                <?php

                        $hitung_pengurus = $con->query("SELECT COUNT(nomor_pengurus) AS jumlah_pengurus FROM pengurus");
                        $jumlah_pengurus = mysqli_fetch_assoc($hitung_pengurus);

                ?>
                            <center><h2 class="card-title"><?= $jumlah_pengurus['jumlah_pengurus'] ?></h2><center>
                </div>
            </div>      
        </td>
    </tr>
</table>
</div>