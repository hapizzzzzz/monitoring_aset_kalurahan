<div class="lingkaran">
    <center><h3 class="judul">Daftar Penggunaan</h3></center>
</div>
<div class="container">
	<!-- Button trigger modal tambah penggunaan -->
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
	</button>

	<!-- Cetak Penggunaan -->
	<a href="../aset/cetak/cetak_penggunaan.php" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    
	<table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Penggunaan<center></th>
			<th><center>Lokasi Penggunaan</center></th>
			<th><center>Jumlah Penggunaan</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM penggunaan"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_penggunaan']?></center></td>
			<td><center><?php echo $pecah['pengguna']?></center></td>
			<td><center><?php echo $pecah['lokasi']?></center></td>
			<?php 
				$result=$con->query("SELECT COUNT(kode_detail_penggunaan) AS jmldpg FROM detail_penggunaan WHERE kode_penggunaan = '$pecah[kode_penggunaan]'");
				$data=mysqli_fetch_assoc($result);
			?>
			<td><center><?php echo $data['jmldpg']?></center></td>
			<td><center>
				<!-- Button trigger modal hapus penggunaan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit penggunaan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<a href="menu.php?page=detail_penggunaan&kode_penggunaan=<?php echo $pecah['kode_penggunaan'];?>" class= "btn btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bi bi-card-list"></i></a>
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Penggunaan-->
			<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_penggunaan.php">
      						<input type="hidden" name="kode_penggunaan" value="<?=$pecah['kode_penggunaan']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_penggunaan']." - ".$pecah['pengguna']." - ".$pecah['lokasi']?></span>
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
		<!--  Akhir Modal Hapus Penggunaan-->

		<!-- Awal Modal Edit Penggunaan-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Penggunaan</h1>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      				</div>
	  				<form method="POST" action="transaksi/proses_transaksi/proses_penggunaan.php">
      					<div class="modal-body">
						  <div class="mb-3">
    							<label class="form-label"><b>Kode</b></label>
    							<input type="text" class="form-control" name="ekode_penggunaan" value="<?=$pecah['kode_penggunaan']?>" style="background: #efefef; pointer-events: none;">
  							</div>
							<div class="mb-3">
    							<label class="form-label"><b>Pengguna</b></label>
    							<input type="text" class="form-control" name="epengguna" value="<?=$pecah['pengguna']?>" required>
  							</div>			
							<div class="mb-3">
    							<label class="form-label"><b>Lokasi</b></label>
    							<input type="text" class="form-control" name="elokasi_penggunaan" value="<?=$pecah['lokasi']?>" required>
  							</div>			
      						<div class="modal-footer">
		  						<button type="submit" class="btn btn-primary" name="bUbah">Ubah</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</div>
					</form>
    			</div>
  			</div>
		</div>
		<!--  Akhir Modal Edit Penggunaan-->

		<?php }?>
	</tbody>
</table>

<!-- Awal Modal Tambah Penggunaan-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Penggunaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_penggunaan.php">
      	<div class="modal-body">
			<div class="mb-3">
    			<label class="form-label"><b>Pengguna</b></label>
    			<input type="text" class="form-control" name="pengguna" required>
  			</div>
  			<div class="mb-3">
    			<label class="form-label"><b>Lokasi Penggunaan</b></label>
    			<input type="text" class="form-control" name="lokasi_penggunaan" required>
  			</div>
      	</div>
      	<div class="modal-footer">
		  	<button type="submit" class="btn btn-primary" name="bSimpan">Simpan</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      	</div>
		</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Tambah Penggunaan-->

</div>