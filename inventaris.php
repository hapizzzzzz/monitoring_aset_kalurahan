<div class="lingkaran">
    <center><h3 class="judul">Daftar Aset</h3></center>
</div>
<div class="container">
	<a href="menu.php?page=tambah_inventaris" class="btn btn-primary" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-plus-circle"></i>Tambah Data</a>
    <a href="../aset/cetak/cetak_invetaris.php" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Jenis Barang</center></th>
			<th><center>Nama Barang</center></th>
            <th><center>Jumlah</center></th>
			<th><center>Identitas</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>

		<?php $ambil=$con->query("SELECT*FROM inventaris JOIN detail_pengadaan ON detail_pengadaan.kode_detail_pengadaan = inventaris.kode_detail_pengadaan JOIN detail_perencanaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan JOIN jenis_barang ON detail_perencanaan.kode_jenis = jenis_barang.kode_jenis");?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_inventaris']?></center></td>
			<td><center><?php echo $pecah['nama_kelompok']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
            <td><center><?php echo $pecah['jumlah']." ".$pecah['satuan']?></center></td>
			<td><center><?php echo $pecah['identitas_barang']?></center></td>
			<td><center>
				<!-- Button trigger modal edit asest -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
                <!-- Button trigger modal rincian aset -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				<!-- Button trigger modal hapus penggunaan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
			</td></center>
		</tr>

<!-- Awal Modal Edit Inventaris-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Aset</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_inventaris.php">
      <div class="modal-body">
			<input type="hidden" name="ein_kode" value="<?=$pecah['kode_inventaris']?>">
			<div class="mb-3">
    			<label class="form-label"><b>Kode</b></label>
    			<input type="text" class="form-control" value="<?=$pecah['kode_inventaris']." - ".$pecah['aset_perencanaan']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Identitas</b></label>
				<textarea class="form-control" name="ein_identitas" rows="4" cols="50" style="resize: none;" required><?= $pecah['identitas_barang']?></textarea>
			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="ein_keterangan" rows="4" cols="50" style="resize: none;" required><?= $pecah['keterangan_aset']?></textarea>
    			<!-- <input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;"> -->
  			</div>
      	</div>
      	<div class="modal-footer">
		  	<button type="submit" class="btn btn-primary" name="bUbah">Ubah</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      	</div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Edit Inventaris-->

<!-- Awal Modal Rincian Inventaris-->
<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Aset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
	  		<h6><b>Kode Pengadaan / Perolehan : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_detail_pengadaan']?></h5>
			<hr>
			<h6><b>Kode Inventaris : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_inventaris']?></h5>
			<hr>
			<h6><b>Jenis Barang : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_jenis']." - ".$pecah['nama_kelompok']?></h5>
			<hr>
            <h6><b>Nama Aset : </b></h6>
			<h5 class="ddpd"><?=$pecah['aset_perencanaan']?></h5>
			<hr>
			<h6><b>Identitas : </b></h6>
			<h5 class="ddpd"><?=$pecah['identitas_barang']?></h5>
			<hr>
			<h6><b>Jumlah : </b></h6>
			<h5 class="ddpd"><?= $pecah['jumlah']." ".$pecah['satuan']?></h5>
			<hr>
			<h6><b>APBDesa : </b></h6>
			<h5 class="ddpd"><?=$pecah['apbdesa']?></h5>
			<hr>
			<h6><b>Perolehan Lain Yg Sah : </b></h6>
			<h5 class="ddpd"><?=$pecah['perolehan_lain']?></h5>
			<hr>
			<h6><b>Aset/Kekayaan Asli Desa : </b></h6>
			<h5 class="ddpd"><?=$pecah['kekayaan_asli_desa']?></h5>
			<hr>
			<h6><b>Tanggal Perolehan : </b></h6>
			<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['tgl_perolehan']))?></h5>
			<hr>
			<h6><b>Keterangan : </b></h6>
			<h5 class="ddpd"><?=$pecah['keterangan_aset']?></h5>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Rincian Invetaris-->

<!-- Awal Modal Hapus Invetaris-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_inventaris.php">
      						<input type="hidden" name="kode_inventaris" value="<?=$pecah['kode_inventaris']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_inventaris']." - ".$pecah['aset_perencanaan']?></span>
								</h5>

      						</div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapus">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
<!--  Akhir Modal Hapus Inventaris-->

<?php }?>


<!-- Pengadaan TP -->

<?php $ambil_tp=$con->query("SELECT*FROM inventaris JOIN detail_pengadaan_tp ON detail_pengadaan_tp.kode_detail_pengadaan_tp = inventaris.kode_detail_pengadaan JOIN jenis_barang ON detail_pengadaan_tp.kode_jenis = jenis_barang.kode_jenis");?>
		<?php while($pecah_tp=$ambil_tp->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah_tp['kode_inventaris']?></center></td>
			<td><center><?php echo $pecah_tp['nama_kelompok']?></center></td>
			<td><center><?php echo $pecah_tp['nama_barang_tp']?></center></td>
            <td><center><?php echo $pecah_tp['jumlah']." ".$pecah_tp['satuan']?></center></td>
			<td><center><?php echo $pecah_tp['identitas_barang']?></center></td>
			<td><center>
				<!-- Button trigger modal edit asest -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
                <!-- Button trigger modal rincian aset -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincianTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				<!-- Button trigger modal hapus penggunaan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusTP<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
			</td></center>
		</tr>

<!-- Awal Modal Edit Inventaris-->
<div class="modal fade modal-lg" id="modalEditTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Aset</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_inventaris.php">
      <div class="modal-body">
	  	<input type="hidden" name="ein_kode_tp" value="<?=$pecah_tp['kode_inventaris']?>">
			<div class="mb-3">
    			<label class="form-label"><b>Kode</b></label>
    			<input type="text" class="form-control" value="<?=$pecah_tp['kode_inventaris']." - ".$pecah_tp['nama_barang_tp']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Identitas</b></label>
				<textarea class="form-control" name="ein_identitas_tp" rows="4" cols="50" style="resize: none;" required><?= $pecah_tp['identitas_barang']?></textarea>
			</div>
			<div class="mb-3">
				<label class="form-label"><b class="bold">Keterangan</b></label>
				<textarea class="form-control" name="ein_keterangan_tp" rows="4" cols="50" style="resize: none;" required><?= $pecah_tp['keterangan_aset']?></textarea>
    			<!-- <input type="text" class="form-control" name="dpdketerangan" id="dpdketerangan" style="background: #efefef; pointer-events: none;"> -->
  			</div>
      	</div>
      	<div class="modal-footer">
		  	<button type="submit" class="btn btn-primary" name="bUbahTP">Ubah</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      	</div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Edit Inventaris-->

<!-- Awal Modal Rincian Inventaris-->
<div class="modal fade" id="modalrincianTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Aset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
	  		<h6><b>Kode Pengadaan / Perolehan : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['kode_detail_pengadaan']?></h5>
			<hr>
			<h6><b>Kode Inventaris : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['kode_inventaris']?></h5>
			<hr>
			<h6><b>Jenis Barang : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['kode_jenis']." - ".$pecah_tp['nama_kelompok']?></h5>
			<hr>
            <h6><b>Nama Aset : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['nama_barang_tp']?></h5>
			<hr>
			<h6><b>Identitas : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['identitas_barang']?></h5>
			<hr>
			<h6><b>Jumlah : </b></h6>
			<h5 class="ddpd"><?= $pecah_tp['jumlah']." ".$pecah_tp['satuan']?></h5>
			<hr>
			<h6><b>Perolehan Lain Yg Sah : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['nominal_perolehan_lain']?></h5>
			<hr>
			<h6><b>Aset/Kekayaan Asli Desa : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['nominal_kekayaan_desa']?></h5>
			<hr>
			<h6><b>Tanggal Perolehan : </b></h6>
			<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah_tp['tanggal_perolehan_tp']))?></h5>
			<hr>
			<h6><b>Keterangan : </b></h6>
			<h5 class="ddpd"><?=$pecah_tp['keterangan_aset']?></h5>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Rincian Invetaris-->

<!-- Awal Modal Hapus Invetaris-->
<div class="modal fade" id="modalHapusTP<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_inventaris.php">
      						<input type="hidden" name="kode_inventaris_tp" value="<?=$pecah_tp['kode_inventaris']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah_tp['kode_inventaris']." - ".$pecah_tp['nama_barang_tp']?></span>
								</h5>

      						</div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapusTP">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
<!--  Akhir Modal Hapus Inventaris-->

<?php }?>



<!-- Pengadaan TP -->

	</tbody>
</table>
</div>