<?php
	session_start();
	include '../../koneksi/koneksi.php';
	
	
    
	$nomor_suratmasuk	                = mysqli_real_escape_string($db,$_POST['nomor_suratmasuk']);
	$judul                           	= mysqli_real_escape_string($db,$_POST['judul']);
	$operator	                        = mysqli_real_escape_string($db,$_POST['operator']);
        date_default_timezone_set('Asia/Jakarta'); 
		$tanggal_entry  = date("Y-m-d H:i:s");
        $thnNow = date("Y");
	
	$nama_file_lengkap 		= $_FILES['file_suratmasuk']['name'];
	$nama_file 		= substr($nama_file_lengkap, 0, strripos($nama_file_lengkap, '.'));
	$ext_file		= substr($nama_file_lengkap, strripos($nama_file_lengkap, '.'));
	$tipe_file 		= $_FILES['file_suratmasuk']['type'];
	$ukuran_file 	= $_FILES['file_suratmasuk']['size'];
	$tmp_file 		= $_FILES['file_suratmasuk']['tmp_name'];
	
    

	
    if (!($nomor_suratmasuk =='') and !($judul =='') and !($operator =='') and   
		($tipe_file == "application/pdf") and ($ukuran_file <= 10340000)){		
		
		$nama_baru = $thnNow.'-'.$nomor_suratmasuk . $ext_file;
		$path = "../surat_masuk/".$nama_baru;
		move_uploaded_file($tmp_file, $path);
		
		$sql = "INSERT INTO tb_suratmasuk(nomor_suratmasuk, judul, file_suratmasuk, operator, tanggal_entry)
				values ('$nomor_suratmasuk', '$judul', '$nama_baru', '$operator', '$tanggal_entry')";
		$execute = mysqli_query($db, $sql);
		
		echo "<Center><h2><br>Terima Kasih<br>Surat masuk Telah Dimasukkan</h2></center>
			<meta http-equiv='refresh' content='2;url=../datasuratmasuk.php'>";
	}
	else{
		echo "<Center><h2>Silahkan isi semua kolom lalu tekan submit<br>Terima Kasih</h2></center>
			<meta http-equiv='refresh' content='2;url=../inputsuratmasuk.php'>";
	}
	
?>
	