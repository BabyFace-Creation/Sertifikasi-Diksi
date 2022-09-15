<?php
	session_start();
	include '../../koneksi/koneksi.php';
    $id				                    = mysqli_real_escape_string($db,$_POST['id_suratmasuk']);
	$nomor_suratmasuk	                = mysqli_real_escape_string($db,$_POST['nomor_suratmasuk']);
    $judul                           = mysqli_real_escape_string($db,$_POST['judul']);
    $operator	                        = mysqli_real_escape_string($db,$_POST['operator']);
	

	$file_suratmasuk			            = $_FILES['file_suratmasuk']['name'];
     date_default_timezone_set('Asia/Jakarta'); 
		$tanggal_entry  = date("Y-m-d H:i:s");
        $thnNow = date("Y");
    
	
	$sql  		= "SELECT * FROM tb_suratmasuk where id_suratmasuk='".$id."'";                        
	$query  	= mysqli_query($db, $sql);
	$data 		= mysqli_fetch_array($query);
	
    //jika gambar tidak ada
	if ($file_suratmasuk == ''){
		$ext			= substr($data['file_suratmasuk'], strripos($data['file_suratmasuk'], '.'));	
		$nama_b  		= $thnNow.'-'.$nomor_suratmasuk. $ext;
		rename("../surat_masuk/".$data['file_suratmasuk'], "../surat_masuk/".$nama_b);
		$sql = "UPDATE tb_suratmasuk set 

                        
						nomor_suratmasuk 			= '$nomor_suratmasuk',
                        judul                    	= '$judul',
                        operator            	    = '$operator',
						tanggal_entry               = '$tanggal_entry',
						file_suratmasuk				= '$nama_b' 
				where id_suratmasuk = $id";
				
		$execute = mysqli_query($db, $sql);			
						
		echo "<Center><h2><br>Data Surat masuk telah diubah</h2></center>
		<meta http-equiv='refresh' content='2;url=../detail-suratmasuk.php?id_suratmasuk=".$id."'>";
	}	
	else{
		
        $tipe_file 		= $_FILES['file_suratmasuk']['type'];
        $ukuran_file 	= $_FILES['file_suratmasuk']['size'];
		if (($tipe_file == "application/pdf") and ($ukuran_file <= 10340000)){	
			unlink("../surat_masuk/".$data['file_suratmasuk']);
			$ext_file		= substr($file_suratmasuk, strripos($file_suratmasuk, '.'));			
			$tmp_file 		= $_FILES['file_suratmasuk']['tmp_name'];
			
			$nama_baru = $thnNow.'-'.$nomor_suratmasuk. $ext_file;
			$path = "../surat_masuk/".$nama_baru;
			move_uploaded_file($tmp_file, $path);
			
			$sql = "UPDATE tb_suratmasuk set 

                        
						nomor_suratmasuk 			= '$nomor_suratmasuk',
                        judul                    	= '$judul',
                        operator            	    = '$operator',
						tanggal_entry               = '$tanggal_entry',
						file_suratmasuk				= '$nama_baru' 
				where id_suratmasuk = $id";
				
			$execute = mysqli_query($db, $sql);			
		
			echo "<Center><h2><br>Data Surat masuk telah diubah</h2></center>
				<meta http-equiv='refresh' content='2;url=../detail-suratmasuk.php?id_suratmasuk=".$id."'>";			
		}
		else{
			echo "<Center><h2><br>File yang anda masukkan tidak sesuai ketentuan<br>Silahkan Ulangi</h2></center>
				<meta http-equiv='refresh' content='2;url=../editsuratmasuk.php?id_suratmasuk=".$id."'>";
		}
	
	}
	?>
	