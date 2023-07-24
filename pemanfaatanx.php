<div class="lingkaran">
    <center><h3 class="judul">Daftar Pemanfaatan</h3></center>
</div>
<div class="container">
	<!-- <a href="menu.php?page=tambah_inventaris" class="btn btn-primary" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-plus-circle"></i>Tambah Data</a> -->
    <!-- Button trigger modal edit pemanfaatan -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>
    <a href="../aset/cetak/cetak_invetaris.php" target="_blank" class="btn btn-success" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%" value="val"><i class="bi bi-printer"></i>Cetak</a>
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Partner</center></th>
			<th><center>Bentuk Pemanfaatan</center></th>
			<th><center>No Surat Perjanjian</center></th>
            <th><center>Awal Jangka Waktu</center></th>
			<th><center>Akhir Jangka Waktu</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>

		<?php $ambil=$con->query("SELECT*FROM pemanfaatan");?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_pemanfaatan']?></center></td>
			<td><center><?php echo $pecah['nama_partner']?></center></td>
			<td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
			<td><center><?php echo $pecah['no_surat_perjanjian']?></center></td>
            <td><center><?php echo date('d/m/Y', strtotime($pecah['awal_jangka_waktu']))?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['akhir_jangka_waktu']))?></center></td>
			<td><center>
				<!-- Button trigger modal edit pemanfaatan -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>">
					<i class="bi bi-pencil"></i>
				</button>
                <!-- Button trigger modal rincian pemanfaatan -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>">
					<i class="bi bi-card-list"></i>
				</button>
				<!-- Button trigger modal hapus pemanfaatan -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>">
					<i class="bi bi-trash"></i>
				</button>
			</td></center>
		</tr>

<!-- Awal Modal Edit Pemanfaatan-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pemanfatan</h1>
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
<!--  Akhir Modal Edit Pemanfaatan-->

<!-- Awal Modal Rincian Pemanfaatan-->
<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Pemanfaatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <div class="modal-body">
			<h6><b>Kode Pemanfaatan : </b></h6>
			<h5 class="ddpd"><?=$pecah['kode_pemanfaatan']?></h5>
			<hr>
			<h6><b>Nama Partner : </b></h6>
			<h5 class="ddpd"><?=$pecah['nama_partner']?></h5>
			<hr>
			<h6><b>Nomor Perdes : </b></h6>
			<h5 class="ddpd"><?=$pecah['nomor_perdes']?></h5>
			<hr>
            <h6><b>Tahun Perdes : </b></h6>
			<h5 class="ddpd"><?=$pecah['tahun_perdes']?></h5>
			<hr>
			<h6><b>Tanggal Perdes : </b></h6>
			<h5 class="ddpd"><?= date('d/m/Y', strtotime($pecah['tanggal_perdes']))?></h5>
			<hr>
			<h6><b>Bentuk Pemanfaatan : </b></h6>
			<h5 class="ddpd"><?= $pecah['bentuk_pemanfaatan']?></h5>
			<hr>
			<h6><b>Nomor Surat Perjanjian : </b></h6>
			<h5 class="ddpd"><?=$pecah['no_surat_perjanjian']?></h5>
			<hr>
			<h6><b>Awal Jangka Waktu : </b></h6>
			<h5 class="ddpd"><?= date('d/m/Y', strtotime($pecah['awal_jangka_waktu']))?></h5>
			<hr>
			<h6><b>Akhir Jangka Waktu : </b></h6>
			<h5 class="ddpd"><?= date('d/m/Y', strtotime($pecah['akhir_jangka_waktu']))?></h5>
			<hr>
			<h6><b>File Pemanfaatan : </b></h6>
			<a href='file_pemanfaatan/<?=$pecah['file_pemanfaatan']?>' download><?= $pecah['file_pemanfaatan']?></a>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
	</form>
    </div>
  </div>
</div>
<!--  Akhir Modal Rincian Pemanfaatan-->

<!-- Awal Modal Hapus Pemanfaatan-->
<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="transaksi/proses_transaksi/proses_pemanfaatan.php">
      						<input type="hidden" name="kode_pemanfaatan" value="<?=$pecah['kode_pemanfaatan']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_pemanfaatan']." - ".$pecah['no_surat_perjanjian']." - ".$pecah['nama_partner']?></span>
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
<!--  Akhir Modal Hapus Pemanfaatan-->

<?php }?>

	</tbody>
</table>

<!-- Awal Modal Tambah Pemanfaatan-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pemanfatan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_pemanfaatan.php" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label"><b>Nomor Perdes</b></label>
            <input type="text" class="form-control" name="nomor_perdes" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="5" required>
        </div>
		<div class="mb-3">
            <label class="form-label"><b>Nama Partner</b></label>
            <input type="text" class="form-control" name="nama_partner" required>
        </div>
        <div class="mb-3">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <label class="form-label"><b>Tahun</b></label>
                        <input type="text" class="form-control" name="tahun_perdes" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="4" required>
                    </td>
                    <td>
                        <label class="form-label"><b>Tanggal Perdes</b></label>
                        <input type="date" class="form-control" name="tanggal_perdes" required>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mb-3">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <label class="form-label"><b>Bentuk Pemanfaatan</b></label>
                        <select class="form-select" name="bentuk_pemanfaatan" style="width:100%">
				            <option value="Sewa">Sewa</option>
				            <option value="Pinjam pakai">Pinjam Pakai</option>
				            <option value="Kerja sama">Kerja Sama</option>
				            <option value="Bangun serah guna / Bangun guna serah">Bangun Serah Guna / Bangun Guna Serah</option>
			            </select>
                    </td>
                    <td>
                        <label class="form-label"><b>Nomor Surat Perjanjian</b></label>
                        <input type="text" class="form-control" name="no_surat_perjanjian" required>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mb-3">
            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="form-label"><b>Awal Periode</b></label>
                        <input type="date" class="form-control" name="awal_periode_pemanfaatan" required>
                    </td>
                    <td>
                        <label class="form-label"><b>Akhir Periode</b></label>
                        <input type="date" class="form-control" name="akhir_periode_pemanfaatan" required>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>File Surat Perjanjian</b></label>
            <input type="file" class="form-control" name="file">
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