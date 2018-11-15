<?php

	require_once('koneksi.php');

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		if (isset($_POST['nosj'])) $nosj = $_POST['nosj'];
	
		if (isset($_POST['filter'])){
	
			$filter = $_POST['filter'];
			if ($filter=="muat")
			{
				$sql = "UPDATE monitoringtruk SET JAMMUAT=NOW() WHERE SJ_NO='$nosj' and JAMMUAT='0000-00-00 00:00:00';";
			}
			else if ($filter=="keluar") 
			{
				$sql = "UPDATE monitoringtruk SET JAMKELUAR=NOW() WHERE SJ_NO='$nosj' and JAMKELUAR='0000-00-00 00:00:00';";
				$sql .= "UPDATE suratjalan SET VALID=1 WHERE SJ_NO='$nosj';";
			}
	
		}
		
		if(mysqli_multi_query($con,$sql)){
			echo 'Berhasil Set Jam Keluar';
		}else{
			echo 'Gagal Proses Jam Keluar';
		}
		
		echo $sql;
		mysqli_close($con);
	
	}
?>