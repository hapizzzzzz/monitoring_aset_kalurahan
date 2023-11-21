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
    <center><h3 class="judul">Detail Penghapusan</h3></center>
</div>
<div class="container">
	
	<?php

	$kode_penghapusan = $_GET['kode_penghapusan'];
	$penghapusan = $con->query("SELECT*FROM penghapusan WHERE kode_penghapusan = '$kode_penghapusan'");
	$data_penghapusan = $penghapusan->fetch_array();

	?>

	<table class="table" style="width:80%">
		<tr>
			<td><h4 class="rincian">Nomor Berita Acara : <?php echo $data_penghapusan['no_berita_acara']?></h4></td>
			<td><h4 class="rincian">Tahun Berita Acara : <?php echo $data_penghapusan['tahun_berita_acara']?></h4></td>
		</tr>
    <tr>
      <td><h4 class="rincian">Tanggal Berita Acara : <?php echo date('d/m/Y', strtotime($data_penghapusan['tanggal_berita_acara']))?></h4></td>
			<td><h4 class="rincian">Nomor Keputusan : <?php echo $data_penghapusan['nomor_keputusan']?></h4></td>
		</tr>
		<tr>
			<td><h4 class="rincian">Tahun Keputusan : <?php echo $data_penghapusan['tahun_keputusan']?></h4></td>
			<td><h4 class="rincian">File Penghapusan : <a href='file_penghapusan/<?=$data_penghapusan['file_penghapusan']?>' download><?= $data_penghapusan['file_penghapusan']?></a></h4></td>
		</tr>
	</table>

	<!-- Button trigger modal tambah detail penghapusan -->
	<a href="menu.php?page=tambah_detail_penghapusan&kode_penghapusan=<?=$kode_penghapusan?>" class="btn btn-primary" style="margin-bottom: 3%; font-size: 15px; border-radius: 10px; width: 15%"><i class="bi bi-plus-circle"></i>Tambah Data</a>

	<table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode</center></th>
			<th><center>Nama Barang</center></th>
			<th><center>Jumlah</center></th>
			<th><center>Penyebab</center></th>
			<th><center>Tindakan</center></th>
      		<th><center>Tanggal</center></th>
			<th style="width: 20%"></th>
		</tr>
	</thead>
	<tbody>

		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT * FROM detail_penghapusan WHERE kode_penghapusan = '$kode_penghapusan' ORDER BY tanggal_penghapusan DESC"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_detail_penghapusan']?></center></td>
			<td><center><?php echo $pecah['nama_barang']?></center></td>
			<td><center><?php echo $pecah['jumlah_penghapusan'] ." ".$pecah['satuan_barang']?></center></td>
			<td><center><?php echo $pecah['penyebab_penghapusan']?></center></td>
      		<td><center><?php echo $pecah['tindakan_penghapusan']?></center></td>
			<td><center><?php echo date('d/m/Y', strtotime($pecah['tanggal_penghapusan']))?></center></td>
			<td><center>
				
				<!-- Button trigger modal hapus detail -->
				<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
					<i class="bi bi-trash"></i>
				</button>
				<!-- Button trigger modal edit detail -->
				<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Edit">
					<i class="bi bi-pencil"></i>
				</button>
				<!-- Button trigger modal rincian detail -->
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
					<i class="bi bi-card-list"></i>
				</button>
				
			</td></center>
		</tr>

		<!-- Awal Modal Hapus Detail Penghapusan-->
		<div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  				<div class="modal-dialog">
    				<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
        					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      					</div>
	  					<form method="POST" action="detail/proses_detail/proses_detail_penghapusan.php">
						  	<input type="hidden" name="h_kode_penghapusan" value="<?=$kode_penghapusan?>">
						  	<input type="hidden" name="h_kode_detail_penghapusan" value="<?=$pecah['kode_detail_penghapusan']?>">
	  						<div class="modal-body">
			
							  <div class="modal-body">
                                <div class="text-danger"><h5 class="text-center">Data ini akan dihapus ?</h5></div>
                                <hr>

                                <h6><b>Kode : </b></h6>
                                <h5 class="ddpd"><?=$pecah['kode_detail_penghapusan']?></h5>
                                <hr>
                                <h6><b>Kode Inventaris : </b></h6>
                                <h5 class="ddpd"><?=$pecah['kode_inventaris']?></h5>
								<hr>
                                <h6><b>Nama Barang : </b></h6>
                                <h5 class="ddpd"><?=$pecah['nama_barang']?></h5>
								<hr>
                                <h6><b>Jumlah Penghapusan : </b></h6>
                                <h5 class="ddpd"><?=$pecah['jumlah_penghapusan']." ".$pecah['satuan_barang']?></h5>
                                <hr>
                                <h6><b>Penyebab Penghapusan : </b></h6>
                                <h5 class="ddpd"><?=$pecah['penyebab_penghapusan']?></h5>
								<hr>
                                <h6><b>Tindakan : </b></h6>
                                <h5 class="ddpd"><?=$pecah['keterangan_penghapusan']?></h5>
								<hr>
                                <h6><b>Tanggal Penghapusan : </b></h6>
                                <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['tanggal_penghapusan']))?></h5>
                              </div>

      						</div>
      						<div class="modal-footer">
								<button type="submit" class="btn btn-primary" name="bHapus">Yakin</button>
        						<button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
      						</div>
						</form>
    				</div>
  				</div>
			</div>
		<!--  Akhir Modal Hapus Detail Penghapusan-->

		<!-- Awal Modal Edit Detail Penghapusan-->
		<div class="modal fade modal-lg" id="modalEdit<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Detail Penghapusan</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST" action="detail/proses_detail/proses_detail_penghapusan.php" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label"><b>APBDesa</b></label>
						<input type="number" class="form-control" max="99999999999" name="e_apbdesa" value="<?= $pecah['apbdesa']?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label"><b>Perolehan Lain Yg Sah</b></label>
						<input type="number" class="form-control" max="99999999999" name="e_perolehan_lain" value="<?= $pecah['perolehan_lain']?>" required>
					</div>
					<div class="mb-3">
						<label class="form-label"><b>Kekayaan Asli Desa</b></label>
						<input type="number" class="form-control" max="99999999999" name="e_kekayaan_asli_desa" value="<?= $pecah['kekayaan_asli_desa']?>" required>
					</div>
					<div class="mb-3">
						<input type="hidden" name="kode_penghapusan" value="<?=$kode_penghapusan?>">
						<input type="hidden" name="e_kode_detail_penghapusan" value="<?=$pecah['kode_detail_penghapusan']?>">
						<label class="form-label"><b>Penyebab Penghapusan</b></label>
						<textarea class="form-control" name="e_penyebab_penghapusan" rows="4" cols="50" style="resize: none;" required><?= $pecah['penyebab_penghapusan']?></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label"><b>Tindakan Penghapusan</b></label>
						<textarea class="form-control" name="e_tindakan_penghapusan" rows="4" cols="50" style="resize: none;" required><?= $pecah['tindakan_penghapusan']?></textarea>
					</div>
					<div class="mb-3">
						<label class="form-label"><b class="bold">Penanggung Jawab</b></label>
						<select class="form-select" id="e_penanggung_jawab" name="e_penanggung_jawab">
							<option value="<?= $pecah['nama_penanggung_jawab']?>"><?= $pecah['nama_penanggung_jawab']?></option>
							<?php
								$pilih_pengurus = $con->query("SELECT pengurus.nomor_pengurus, pengurus.nama_pengurus FROM pengurus");
								while($pilihan=$pilih_pengurus->fetch_assoc()){
							?>
							<option value="<?= $pilihan['nama_pengurus']?>"><?=  $pilihan['nomor_pengurus']." - ".$pilihan['nama_pengurus']?></option>
							<?php }	?>
						</select>
					</div>
					<div class="mb-3">
    					<label class="form-label"><b class="bold">Tanggal Penghapusan<b></label>
    					<input value="<?= $pecah['tanggal_penghapusan']?>" type="date" class="form-control" name="e_tanggal_penghapusan" required>
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
		<!--  Akhir Modal Edit Detail Penghapusan-->

		<!-- Awal Modal Rincian Penghapusan-->
		<div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Rincian Penghapusan</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h6><b>Kode : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_detail_penghapusan']?></h5>
				<hr>
				<h6><b>Kode Inventaris : </b></h6>
				<h5 class="ddpd"><?=$pecah['kode_inventaris']?></h5>
				<hr>
				<h6><b>Tahun Pengadaan / Perolehan : </b></h6>
				<h5 class="ddpd"><?=$pecah['tahun_perolehan']?></h5>
				<hr>
				<h6><b>Nama Barang : </b></h6>
				<h5 class="ddpd"><?=$pecah['nama_barang']." ( ".$pecah['jenis_barang']." ) "?></h5>
				<hr>
				<h6><b>Jumlah : </b></h6>
				<h5 class="ddpd"><?=$pecah['jumlah_penghapusan']." ".$pecah['satuan_barang']?></h5>
				<hr>
				<h6><b>APBDesa : </b></h6>
				<h5 class="ddpd"><?=$pecah['apbdesa']?></h5>
				<hr>
				<h6><b>Perolehan Lain Yg Sah : </b></h6>
				<h5 class="ddpd"><?=$pecah['perolehan_lain']?></h5>
				<hr>
				<h6><b>Kekayaan Asli Desa : </b></h6>
				<h5 class="ddpd"><?=$pecah['kekayaan_asli_desa']?></h5>
				<hr>
				<h6><b>Identitas Barang : </b></h6>
				<h5 class="ddpd"><?=$pecah['identitas_barang']?></h5>
				<hr>
				<h6><b>Keterangan / Penyebab : </b></h6>
				<h5 class="ddpd"><?=$pecah['penyebab_penghapusan']?></h5>
				<hr>
				<h6><b>Tindakan : </b></h6>
				<h5 class="ddpd"><?=$pecah['tindakan_penghapusan']?></h5>
				<hr>
				<h6><b>Penanggung Jawab : </b></h6>
				<h5 class="ddpd"><?=$pecah['nama_penanggung_jawab']?></h5>
				<hr>
				<h6><b>Tanggal Penghapusan : </b></h6>
				<h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['tanggal_penghapusan']))?></h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
			</div>
			</form>
			</div>
		</div>
		</div>
		<!--  Akhir Modal Rincian Penghapusan-->

		<?php }?>

	</tbody>
	</table>

</div>

<script>
	function detail(){
		// alert("ok");
		var kode = $("#pilihan_aset").val();

		if(kode.length == "") {
			$('#jumlah_pn').val("");
			$('#satuan_pn').val("");
		} else {
		$.ajax({
			url :"detail/data_detail_pemanfaatan.php",
			method :"POST",
			data : {'kode':kode},
			dataType : "json",
			success:function(data){

				if(data){
					$('#jumlah_pn').val(data.jumlah_kuota);
					$('#satuan_pn').val(data.satuan);
				}

			}
		})
	}
	}
</script>

<script>
      $(document).ready(function () {
        $(".ch").chosen({
          width: "100%",
          no_results_text: "Oops, nothing found!",
          allow_single_deselect: true,
        });
      });
</script>