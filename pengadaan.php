<div class="lingkaran">
    <center><h3 class="judul">Daftar Pengadaan</h3></center>
</div>
<div class="container">
    <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
	<thead>
		<tr>
			<th><center>No.</center></th>
			<th><center>Kode Perencanaan</center></th>
            <th><center>Kode Pengadaan</center></th>
			<th><center>No RPJM</center></th>
			<th><center>No RKP</center></th>
			<th><center>Periode RPJM</center></th>
			<th><center>Tahun RKP</center></th>
			<th><center>Jumlah Pengadaan</center></th>
			<th width="180px"></th>
		</tr>
	</thead>
	<tbody>
        <?php include ('koneksi.php');?>
		<?php $nomor=1;?>
		<?php $ambil=$con->query("SELECT*FROM pengadaan JOIN perencanaan ON pengadaan.kode_perencanaan = perencanaan.kode_perencanaan"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){?>
		<tr>
			<td><center><?php echo $nomor++;?></center></td>
			<td><center><?php echo $pecah['kode_perencanaan']?></center></td>
            <td><center><?php echo $pecah['kode_pengadaan']?></center></td>
			<td><center><?php echo $pecah['no_rpjm']?></center></td>
			<td><center><?php echo $pecah['no_rkp']?></center></td>
			<td><center><?php echo $pecah['periode_rpjm']?></center></td>
			<td><center><?php echo $pecah['tahun_rkp']?></center></td>
			<?php 
				$result=$con->query("SELECT COUNT(kode_pengadaan) AS jmlpd FROM detail_pengadaan WHERE kode_pengadaan = '$pecah[kode_pengadaan]'");
				$data=mysqli_fetch_assoc($result);
			?>
			<td><center><?php echo $data['jmlpd']?></center></td>
			<td><center>
				<a href="menu.php?page=detail_pengadaan&kode_pengadaan=<?php echo $pecah['kode_pengadaan'];?>" class= "btn btn-success" >Detail</a>
			</td></center>
		</tr>

		<?php }?>
	</tbody>
</table>
</div>