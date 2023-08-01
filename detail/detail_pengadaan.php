<div class="lingkaran">
    <center><h3 class="judul">Detail Pengadaan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_pengadaan = $_GET['kode_pengadaan'];
	$pengadaan = $con->query("SELECT*FROM pengadaan JOIN perencanaan ON pengadaan.kode_perencanaan = perencanaan.kode_perencanaan WHERE kode_pengadaan = '$kode_pengadaan'");
	$data_pengadaan = $pengadaan->fetch_array();

	$sub_total = $con->query("SELECT SUM(apbdesa + perolehan_lain + kekayaan_asli_desa) AS total_biaya FROM detail_pengadaan where kode_pengadaan = '$kode_pengadaan'");
	$sub_total_p = $sub_total->fetch_array();

	?>

	<table class="table">
		<tr>
			<td><h4 class="rincian">No RPJM : <?php echo $data_pengadaan['no_rpjm']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">No RKP : <?php echo $data_pengadaan['no_rkp']?></h4></td>
		</tr>
        <tr>
            <td><h4 class="rincian">Periode RPJM : <?php echo $data_pengadaan['periode_rpjm']?></h4></td>
        </tr>
        <tr>
			<td><h4 class="rincian">Tahun RKP  : <?php echo $data_pengadaan['tahun_rkp']?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Total Biaya  : Rp <?php echo $sub_total_p['total_biaya']?></h4></td>
		</tr>
	</table>

	<!-- Tambah detail pengadaan -->
	<a href="menu.php?page=tambah_detail_pengadaan&kode_pengadaan=<?=$kode_pengadaan?>" class="btn btn-primary" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-plus-circle"></i>Tambah Data</a>

	<a href="../aset/cetak/cetak_detail_pengadaan.php?kode_pengadaan=<?php echo $kode_pengadaan ?>" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Jenis Kegiatan</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Tanggal Perolehan</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT * FROM detail_perencanaan JOIN detail_pengadaan ON detail_perencanaan.kode_detail_perencanaan = detail_pengadaan.kode_detail_perencanaan WHERE detail_pengadaan.kode_pengadaan = '$kode_pengadaan'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['jenis_kegiatan_rencana']?></center></td>
			<td><center><?php echo $pecah['kode_detail_pengadaan']?></center></td>
			<td><center><?php echo $pecah['aset_perencanaan']?></center></td>
			<td><center><?php echo $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tgl_perolehan']))?></center></td>
			<td><center>
				<!-- <a href="detail/proses_detail/proses_detail_dpr.php?hapus_barang_dpr=<?php //echo $pecah['kode_detail_perencanaan'];?>&action=hapus_data_dpr&kode_perencanaan=<?php //echo $kode_perencanaan?>" class= "btn btn-danger">Hapus</a> -->
				
				<!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				
				<!-- <a href="menu.php?page=ubah_detail_rencana&kode_detail_perencanaan=<?php // echo $pecah['kode_detail_perencanaan'];?>" class= "btn btn-warning">Ubah</a> -->
			</td></center>
		</tr>
		
<!-- Awal Modal Edit Barang-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_pengadaan.php">
      <div class="modal-body">
	  		<input type="hidden" name="dpdkode_detail_pengadaan" value="<?=$pecah['kode_detail_pengadaan']?>">
	  		<input type="hidden" name="dpdkode_pengadaan" value="<?=$kode_pengadaan?>">
			<div class="mb-3">
    			<label class="form-label"><b>Kode - Nama Barang - Jumlah</b></label>
    			<input type="text" class="form-control" value="<?=$pecah['kode_detail_pengadaan']?> - <?=$pecah['aset_perencanaan']?> - <?= $pecah['perkiraan_volume']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Lokasi</b></label>
    			<input type="text" class="form-control" value="<?=$pecah['rencana_lokasi']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Jenis Kegiatan</b></label>
    			<input type="text" class="form-control" value="<?= $pecah['jenis_kegiatan_rencana']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Bidang</b></label>
    			<input type="text" class="form-control" value="<?= $pecah['bidang_perencanaan']?>" style="background: #efefef; pointer-events: none;">
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>APBDesa (Rp)</b></label>
    			<input type="number" class="form-control" max="99999999999" name="edpdAPBDesa" value="<?= $pecah['apbdesa']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Perolehan Yg Lain (Rp)</b></label>
    			<input type="number" class="form-control" max="99999999999" name="edpdperolehanlain" value="<?= $pecah['perolehan_lain']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Aset/Kekayaan Asli Desa (Rp)</b></label>
    			<input type="number" class="form-control" max="99999999999" name="edpdkekayaandesa" value="<?= $pecah['kekayaan_asli_desa']?>" required>
  			</div>
			<div class="mb-3">
    			<label class="form-label"><b>Tanggal Perolehan</b></label>
    			<input type="date" class="form-control" name="edpdtgl" value="<?= $pecah['tgl_perolehan']?>" required>
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Penanggung Jawab</b></label>
    			<select class="form-select" name="edpdpengurus">
					<option value="<?=$pecah['nomor_pengurus']?>"><?=$pecah['nomor_pengurus']." - ".$pecah['nama_pengurus']?></option>
					<?php
						$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus WHERE NOT nomor_pengurus='$pecah[nomor_pengurus]'");
						while($pilihan=$pilih_pengurus->fetch_assoc()){
					?>
					<option value="<?= $pilihan['nomor_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
					<?php }	?>
				</select>
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
<!--  Akhir Modal Edit Barang-->

<!-- Awal Modal Hapus Barang-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="detail/proses_detail/proses_detail_pengadaan.php">
      <input type="hidden" name="dpdkode_detail_pengadaan" value="<?=$pecah['kode_detail_pengadaan']?>">
	  <input type="hidden" name="dpdkode_pengadaan" value="<?=$kode_pengadaan?>">
	  <div class="modal-body">

	  		<h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
			<h5 class="text-center">Data ini akan dihapus ?<br>
				<span class="text-danger"><?= $pecah['kode_detail_pengadaan']?> - <?=$pecah['aset_perencanaan']?></span>
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
<!--  Akhir Modal Hapus Barang-->

<!-- Awal Modal Rincian Barang-->
<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
			<h6><b>Jenis Kegiatan : </b></h6>
			<h5 class="ddpd"><?=$pecah['jenis_kegiatan_rencana']?></h5>
			<hr>
			<h6><b>Bidang : </b></h6>
			<h5 class="ddpd"><?=$pecah['bidang_perencanaan']?></h5>
			<hr>
			<h6><b>Nama Barang : </b></h6>
			<h5 class="ddpd"><?=$pecah['aset_perencanaan']?></h5>
			<hr>
			<h6><b>Jumlah : </b></h6>
			<h5 class="ddpd"><?= $pecah['perkiraan_volume']." ".$pecah['rencana_satuan_volume']?></h5>
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
			<h5 class="ddpd"><?=$pecah['keterangan']?></h5>
			<hr>
			<h6><b>Penanggung Jawab : </b></h6>
			<h5 class="ddpd">Nomor : <?=$pecah['nomor_pengurus']?></h5>
			<h5 class="ddpd">Nama : <?=$pecah['nama_pengurus']?></h5>
			<h5 class="ddpd">No Telp : <?=$pecah['no_hp_pengurus']?></h5>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Rincian Barang-->

		<?php }?>
	</tbody>
</table>

</div>