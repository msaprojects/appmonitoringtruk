<?php
	require_once ('koneksi.php');

	$nosj = "O.1020183045";
	$nopol = "";
	$ekspedisi = "";
	$sopir = "";
	$jamkeluar = "";
	$smessage = "";
	$sreset = 	0; //0 visible, 8 gone
	$proses = 0;
	$flagprosesphp = "";
	
	if (isset($_POST['nosj'])) $nosj = $_POST['nosj'];
	
	$sql = "SELECT monitoringtruk.SJ_NO, monitoringtruk.JAMMASUK, NOPOL, monitoringtruk.SOPIR, EKSPEDISI, JAMKELUAR, STATUS, VALID, JAMMUAT FROM suratjalan, monitoringtruk WHERE suratjalan.SJ_NO=monitoringtruk.SJ_NO AND monitoringtruk.SJ_NO='$nosj' ORDER BY monitoringtruk.JAMMASUK DESC LIMIT 1";
	
	$r = mysqli_query($con, $sql);
	$result = array();
	$row = mysqli_fetch_array($r);

	if($row['STATUS']=="Y")
	{
		if($row['JAMKELUAR']=="0000-00-00 00:00:00")
		{
			if ($row['JAMMUAT'] == "0000-00-00 00:00:00")
			{
				$flagprosesphp = "muat";
				$smessage = "Silahkan Melakukan Proses Muat";
				$sproses = 0;
			}
			else
			{
				if($row['VALID']=="1")
				{
					$smessage = "Data tidak valid";
					$sproses = 8;
				}
				else
				{
					$flagprosesphp = "keluar";
					$smessage = "Silahkan melakukan proses keluar";
					$sproses = 0;
				}
			}
		}
		else
		{
			$smessage = "Truk sudah keluar : ".$row['JAMKELUAR'];
			$sproses = 8;
		}

	}
	else
	{
		$smessage = "Surat Jalan belum dicetak";
		$sproses = 8;
	}


	$nosj = $row['SJ_NO'];
	$nopol = $row['NOPOL'];
	$ekspedisi = $row['EKSPEDISI'];
	$sopir = $row['SOPIR'];
	$jamkeluar = $row['JAMKELUAR'];
	$jammuat = $row['JAMMUAT'];
	$sreset = 0;

	array_push($result, array(
		"nosj" =>$nosj,
		"nopol" =>$nopol,
		"ekspedisi" =>$ekspedisi,
		"sopir" =>$sopir,
		"statusmessage" => $smessage,
		"statusreset" => $sreset,
		"jammuat"=>$jammuat,
		"flagprosesphp" => $flagprosesphp,
		"statusproses" => $sproses,

	));
	
echo json_encode(array('result'=>$result));
mysqli_close($con);


?>