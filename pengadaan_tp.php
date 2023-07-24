	<script
      src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"
      integrity="sha512-eSeh0V+8U3qoxFnK3KgBsM69hrMOGMBy3CNxq/T4BArsSQJfKVsKb5joMqIPrNMjRQSTl4xG8oJRpgU2o9I7HQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"
      integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

<div class="lingkaran">
    <center><h3 class="judul">Daftar Perolehan</h3></center>
</div>
<div class="container">

    <!-- Button trigger modal tambah barang -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-plus-circle"></i>Tambah Data
    </button>

	<!-- Button trigger modal cetak barang -->
	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetak" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%">
		<i class="bi bi-printer"></i>Cetak
	</button>

    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode Pengadaan</center></th>
            <th><center>Asal Usul Barang</center></th>
			<th><center>Tahun Pengadaan</center></th>
            <th><center>Jumlah</center></th>
			<th width="180px"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM pengadaan_tp"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_pengadaan_tp']?></center></td>
            <td><center><?php echo $pecah['sumber_perolehan_tp']?></center></td>
			<td><center><?php echo $pecah['tahun_pengadaan_tp']?></center></td>
			<?php 
				$result=$con->query("SELECT COUNT(kode_detail_pengadaan_tp) AS jmlpdtp FROM detail_pengadaan_tp WHERE kode_pengadaan_tp = '$pecah[kode_pengadaan_tp]'");
				$data=mysqli_fetch_assoc($result);
			?>
			<td><center><?php echo $data['jmlpdtp']?></center></td>
			<td><center>
			    <!-- Button trigger modal hapus barang -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
				    <i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit barang -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal detail barang -->
				<a href="menu.php?page=detail_pengadaantp&kode_pengadaan_tp=<?php echo $pecah['kode_pengadaan_tp'];?>" class= "btn btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bi bi-card-list"></i></a>
			</td></center>
		</tr>

<!-- Awal Modal Edit Barang-->
<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="transaksi/proses_transaksi/proses_pengadaan_tp.php">
	  <input type="hidden" name="etahuntp" value="<?=$pecah['tahun_pengadaan_tp']?>">
        <div class="modal-body">
	  	<div class="mb-3">
    	    <label class="form-label"><b>Kode Pengadaan</b></label>
    	    <input type="text" class="form-control" name="edptpkode" value="<?=$pecah['kode_pengadaan_tp']?>" style="background: #efefef; pointer-events: none;">
  	  	</div>
  	  	<div class="mb-3">
    	    <label class="form-label"><b>Nama Sumber</b></label>
    	    <input type="text" class="form-control" name="edptpsumber" value="<?=$pecah['sumber_perolehan_tp']?>" required>
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
	  					<form method="POST" action="transaksi/proses_transaksi/proses_pengadaan_tp.php">
      						<input type="hidden" name="tpkode" value="<?=$pecah['kode_pengadaan_tp']?>">
	  						<div class="modal-body">

							  <h6 class="text-danger">*Semua data lain yang memiliki kaitan dengan dengan data ini akan dihapus !</h6><br>
			
								<h5 class="text-center">Data ini akan dihapus ?<br>
									<span class="text-danger"><?= $pecah['kode_pengadaan_tp']?></span>
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

    <?php }?>
  </tbody>
</table>

<!-- Awal Modal Tambah Barang-->
<div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="transaksi/proses_transaksi/proses_pengadaan_tp.php">
      <div class="modal-body">
  	<div class="mb-3">
    	  <label class="form-label"><b>Nama Sumber</b></label>
    	  <input type="text" class="form-control" name="dptpnamasumber" required>
  	</div>
	<div class="mb-3">
    	  <label class="form-label"><b>Tahun</b></label>
    	  <input type="number" min="1900" max="2099" class="form-control" name="dptptahun" id="dptptahun" required>
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
<!--  Akhir Modal Tambah Barang-->

<!-- Awal Modal Cetak Perolehan-->
<div class="modal fade" id="modalCetak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Pilih Tahun Perolehan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
	  <form method="POST" action="../aset/cetak/cetak_pengadaan_tp.php?" target="_blank">
    	<div class="modal-body">
  			<div class="mb-3">
    	  		<select class="ch" name="pilihan_tahun_tp">
					<?php
						$pilih_tahun = $con->query("SELECT DISTINCT tahun_pengadaan_tp FROM pengadaan_tp");
						while($pilihan_tahun=$pilih_tahun->fetch_assoc()){
					?>
					<option value="<?= $pilihan_tahun['tahun_pengadaan_tp']?>"><?= $pilihan_tahun['tahun_pengadaan_tp']?></option>
					<?php } ?>
				</select>
  			</div>
       	</div>
       	<div class="modal-footer">
	 		<button type="submit" class="btn btn-success" name="bSimpan">Cetak</button>
        	<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
       	</div>
      </form>
    </div>
  </div>
</div>
<!--  Akhir Modal Cetak Perolehan-->

</div>

<script>
      $(document).ready(function () {
        $(".ch").chosen({
          width: "100%",
          no_results_text: "Oops, nothing found!",
          allow_single_deselect: true,
        });
      });
</script>