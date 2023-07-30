<div class="lingkaran">
        <center><h3 class="judul">Daftar Perencanaan</h3></center>
</div>
<div class="container">

	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>

    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>No RPJM</center></th>
			<th><center>Tanggal RPJM</center></th>
			<th><center>No RKP</center></th>
			<th><center>Tanggal RKP</center></th>
			<th><center>Periode RPJM</center></th>
			<th><center>Tahun RKP</center></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM perencanaan"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_perencanaan']?></center></td>
			<td><center><?php echo $pecah['no_rpjm']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_rpjm']))?></center></td>
			<td><center><?php echo $pecah['no_rkp']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_rkp']))?></center></td>
			<td><center><?php echo $pecah['periode_rpjm']?></center></td>
			<td><center><?php echo $pecah['tahun_rkp']?></center></td>
			<td><center>
				<!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Hapus" data-bs-target="#modalHapus<?=$nomor?>">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit" data-bs-target="#modalEdit<?=$nomor?>">
					<i class="bi bi-pencil"></i>
				</button>
				<a href="menu.php?page=detail_perencanaan&kode_perencanaan=<?php echo $pecah['kode_perencanaan'];?>" class= "btn btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bi bi-card-list"></i></a>
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Barang-->
			<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_perencanaan.php?kode_perencanaan=<?php echo $pecah['kode_perencanaan'];?>">
      						<input type="hidden" name="pkode" value="<?=$pecah['kode_perencanaan']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_perencanaan']?></span>
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

		<!-- Awal Modal Edit Barang-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  			<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Perencanaan</h1>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      				</div>
	  				<form method="POST" action="transaksi/proses_transaksi/proses_perencanaan.php?kode_perencanaan=<?php echo $pecah['kode_perencanaan'];?>">
      					<div class="modal-body">
							<div class="mb-3">
    							<label class="form-label"><b>Periode RPJM</b></label>
    							<input type="text" class="form-control" name="ptahunrkp" value="<?= $pecah['periode_rpjm']?>" style="background: #efefef; pointer-events: none;">
  							</div>	
							<div class="mb-3">
    							<label class="form-label"><b>Tahun RKP</b></label>
    							<input type="number" class="form-control" name="ptahunrkp" value="<?= $pecah['tahun_rkp']?>" style="background: #efefef; pointer-events: none;">
  							</div>	
  							<div class="mb-3">
    							<label class="form-label"><b>No RPJM</b></label>
    							<input type="number" class="form-control" min="1" max="99" name="pnorpjm" value="<?=$pecah['no_rpjm']?>" required>
  							</div>
							<div class="mb-3">
    							<label class="form-label"><b>Tanggal RPJM</b></label>
    							<input type="date" class="form-control" name="ptglrpjm" value="<?= $pecah['tanggal_rpjm']?>" required>
  							</div>
							<div class="mb-3">
    							<label class="form-label"><b>No RKP</b></label>
    							<input type="number" class="form-control" min="1" max="99" name="pnorkp" value="<?= $pecah['no_rkp']?>" required>
  							</div>
							<div class="mb-3">
    							<label class="form-label"><b>Tanggal RKP</b></label>
    							<input type="date" class="form-control" name="ptglrkp" value="<?= $pecah['tanggal_rkp']?>" required>
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
		<!--  Akhir Modal Edit Barang-->

		<?php }?>
	</tbody>
</table>

		<!-- Awal Modal Tambah Pemanfaatan-->
		<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Perencanaan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="transaksi/proses_transaksi/proses_perencanaan.php" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="mb-3">
					<table style="width: 100%">
						<tr>
							<td><label class="form-label"><b class="bold">No RPJM</b></label></td>
							<td><label class="form-label"><b class="bold">Tanggal RPJM</b></label></td>
						</tr>
						<tr>
							<td style="width: 50%"><input type="number" class="form-control" min="1" max="99" name="prno_rpjm" id="prno_rpjm" required></td>
							<td style="width: 50%"><input type="date" class="form-control" name="prtgl_rpjm" id="prtgl_rpjm" required></td>
						</tr>
					</table>
				</div>
				<div class="mb-3">
					<table style="width: 100%">
						<tr>
							<td><label class="form-label"><b class="bold">No RKP</b></label></td>
							<td><label class="form-label"><b class="bold">Tanggal RKP</b></label></td>
						</tr>
						<tr>
							<td style="width: 50%"><input type="number" class="form-control" min="1" max="99" name="prno_rkp" id="prno_rkp" required></td>
							<td style="width: 50%"><input type="date" class="form-control" name="prtgl_rkp" id="prtgl_rkp" required></td>
						</tr>
					</table>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Periode Tahun RPJM</b></label>
					<table style="width: 100%">
						<tr>
							<td style="width:50%"><input type="number" class="form-control" min="1111" max="9999" name="prperiode_rpjmawal" id="prperiode_rpjmawal" required></td>
							<td><b class="bold"> S/d </b></td>
							<td style="width:50%"><input type="number" class="form-control" min="1111" max="9999" name="prperiode_rpjmakhir" id="prperiode_rpjmakhir" required></td>
						</tr>
					</table>
				</div>
				<div class="mb-3">
					<label class="form-label"><b class="bold">Tahun RKP</b></label>
					<input type="number" min="1900" max="2099" class="form-control" name="prthn_rkp" id="prthn_rkp" required>
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
		<!--  Akhir Modal Tambah Pemanfaatan-->

</div>