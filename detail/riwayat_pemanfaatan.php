<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemanfaatan</title>
</head>
<body>
    <div class="lingkaran">
        <center><h3 class="judul">Riwayat Pemanfaatan</h3></center>
    </div>

    <div class="container">

        <table class="table table-sm" cellspacing="0" width="100%" id="table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th><center>No.</center></th>
                <th><center>Kode</center></th>
                <th><center>Nama Partner</center></th>
                <th><center>Nama Aset</center></th>
                <th><center>Jumlah</center></th>
                <th><center>Bentuk Pemanfaatan</center></th>
                <th><center>Jangka Waktu</center></th>
                <th style="width: 10%"></th>
            </tr>
        </thead>
        <tbody>

            <?php $nomor=1;?>
            <?php $ambil=$con->query("SELECT * FROM transaksi_pemanfaatan_selesai"); ?>
            <?php while($pecah=$ambil->fetch_assoc()){?>
            <tr>
                <td><center><?php echo $nomor++;?></center></td>
                <td><center><?php echo $pecah['kode_riwayat_pemanfaatan']?></center></td>
                <td><center><?php echo $pecah['nama_partner']?></center></td>
                <td><center><?php echo $pecah['nama_aset']?></center></td>
                <td><center><?php echo $pecah['jumlah_p'] ." ".$pecah['satuan_p']?></center></td>
                <td><center><?php echo $pecah['bentuk_pemanfaatan']?></center></td>
                <td><center><?php echo date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></center></td>
                <td><center>
                    
                    <!-- Button trigger modal hapus barang -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                    <!-- Button trigger modal rincian barang -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalrincian<?=$nomor?>" data-toggle="tooltip" data-placement="top" title="Rincian">
                        <i class="bi bi-card-list"></i>
                    </button>
                    
                </td></center>
            </tr>

            <!-- Awal Modal Hapus Detail Pemanfaatan-->
            <div class="modal fade" id="modalHapus<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi !</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="detail/proses_detail/proses_detail_riwayat_pemanfaatan.php">
                                <input type="hidden" name="kode_riwayat_pemanfaatan" value="<?=$pecah['kode_riwayat_pemanfaatan']?>">
                                <input type="hidden" name="file_riwayat" value="<?=$pecah['file_pemanfaatan']?>">
                                <div class="modal-body">
                
                                    <div class="text-danger"><h5 class="text-center">Hapus Riwayat Pemanfaatan ?</h5></div>
                                    <hr>
                                    <h6><b>Nama Partner : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['nama_partner']?></h5>
                                    <hr>
                                    <h6><b>Nama Aset : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['nama_aset']." ( ".$pecah['jumlah_p']." ".$pecah['satuan_p']." ) "?></h5>
                                    <hr>
                                    <h6><b>Bentuk Pemanfaatan : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['bentuk_pemanfaatan']?></h5>
                                    <hr>
                                    <h6><b>Jangka Waktu : </b></h6>
                                    <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sampai dengan ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></h5>
                                    <hr>
                                    <h6><b>Keterangan : </b></h6>
                                    <h5 class="ddpd"><?=$pecah['keterangan']?></h5>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="bHapus">Yakin</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!--  Akhir Modal Hapus Detail Pemanfaatan-->
            
            <!-- Awal Modal Rincian Pemanfaatan-->
            <div class="modal fade" id="modalrincian<?=$nomor?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" class="text-danger" id="staticBackdropLabel">Detail Pemanfaatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><b>Kode : </b></h6>
                    <h5 class="ddpd"><?=$pecah['kode_riwayat_pemanfaatan']?></h5>
                    <hr>
                    <h6><b>Nama Partner : </b></h6>
                    <h5 class="ddpd"><?=$pecah['nama_partner']?></h5>
                    <hr>
                    <h6><b>No Hp : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_hp']?></h5>
                    <hr>
                    <h6><b>Email : </b></h6>
                    <h5 class="ddpd"><?=$pecah['email_partner']?></h5>
                    <hr>
                    <h6><b>Alamat : </b></h6>
                    <h5 class="ddpd"><?=$pecah['alamat']?></h5>
                    <hr>
                    <h6><b>Nomor Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_perdes'];?></h5>
                    <hr>
                    <h6><b>Tahun Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['tahun_perdes'];?></h5>
                    <hr>
                    <h6><b>Tanggal Perdes : </b></h6>
                    <h5 class="ddpd"><?=$pecah['tanggal_perdes'];?></h5>
                    <hr>
                    <h6><b>Nama Aset : </b></h6>
                    <h5 class="ddpd"><?=$pecah['nama_aset'];?></h5>
                    <hr>
                    <h6><b>Jumlah : </b></h6>
                    <h5 class="ddpd"><?=$pecah['jumlah_p']." ".$pecah['satuan_p'];?></h5>
                    <hr>
                    <h6><b>Bentuk Pemanfaatan : </b></h6>
                    <h5 class="ddpd"><?=$pecah['bentuk_pemanfaatan'];?></h5>
                    <hr>
                    <h6><b>Biaya Kontribusi : </b></h6>
                    <h5 class="ddpd"><?=$pecah['biaya_kontribusi'];?></h5>
                    <hr>
                    <h6><b>Jangka Waktu : </b></h6>
                    <h5 class="ddpd"><?=date('d/m/Y', strtotime($pecah['awal_pemanfaatan']))." Sd ".date('d/m/Y', strtotime($pecah['akhir_pemanfaatan']))?></h5>
                    <hr>
                    <h6><b>Keterangan : </b></h6>
                    <h5 class="ddpd"><?=$pecah['keterangan']?></h5>
                    <hr>
                    <h6><b>No Surat Perjanjian : </b></h6>
                    <h5 class="ddpd"><?=$pecah['no_surat_perjanjian']?></h5>
                    <hr>
                    <h6><b>File Surat Perjanjian : </b></h6>
                    <a href='riwayat_pemanfaatan/<?=$pecah['file_pemanfaatan']?>' download><?= $pecah['file_pemanfaatan']?></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
                </form>
                </div>
            </div>
            </div>
            <!--  Akhir Modal Rincian Pemanfaatan-->

        <?php }?>
    <div>
</body>
</html>