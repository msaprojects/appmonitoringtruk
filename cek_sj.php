<?php
	require_once ('koneksi.php');

	$nosj = "o.1020183045";
	$nopol = "";
	$ekspedisi = "";
	$sopir = "";
	$jamkeluar = "";
	$jammuat = "";
	$smessage = "";
	$sreset = 	0; //0 visible, 8 gone
	$proses = 0;
	$flagprosesphp = "";
	$cekbynopol = "";
	$flagproses = "";
	$opsales = "";
	$optj = "";
	$cusnama = "";

	if (isset($_POST['nosj'])) $nosj = $_POST['nosj'];
	if (isset($_POST['flagproses'])) $flagproses = $_POST['flagproses'];
	
	if ($flagproses == "batal") {
		$nopol = $nosj;
		$nosj = "";
		$cekbynopol = " AND monitoringtruk.JAMMUAT='0000-00-00 00:00:00' AND monitoringtruk.JAMKELUAR='0000-00-00 00:00:00' AND monitoringtruk.NOPOL='$nopol' AND (monitoringtruk.SJ_NO='' OR monitoringtruk.SJ_NO='-') ";
	}
	else
	{
		$cekbynopol = " AND monitoringtruk.SJ_NO='$nosj' ";
	}

	
	// $sql = "SELECT monitoringtruk.SJ_NO, monitoringtruk.JAMMASUK, NOPOL, monitoringtruk.SOPIR, EKSPEDISI, JAMKELUAR, STATUS, VALID, JAMMUAT FROM suratjalan, monitoringtruk WHERE suratjalan.SJ_NO=monitoringtruk.SJ_NO AND monitoringtruk.SJ_NO='$nosj' ORDER BY monitoringtruk.JAMMASUK DESC LIMIT 1";

	$sql = "SELECT monitoringtruk.SJ_NO, monitoringtruk.JAMMASUK, NOPOL, monitoringtruk.SOPIR, EKSPEDISI, JAMKELUAR, STATUS, VALID, JAMMUAT, suratjalan.OP_SALES, suratjalan.CUS_NAMA, suratjalan.OP_TJ FROM monitoringtruk LEFT JOIN suratjalan ON suratjalan.SJ_NO=monitoringtruk.SJ_NO WHERE NOPOL<>''".$cekbynopol." ORDER BY monitoringtruk.JAMMASUK DESC LIMIT 1";
	
	$r = mysqli_query($CONLOCAL, $sql);
	$result = array();
	$row = mysqli_fetch_array($r);

	if($row['STATUS']=="Y" && ($row['SJ_NO']!="" || $row['SJ_NO']!="-"))
	{
		if($row['JAMKELUAR']=="0000-00-00 00:00:00")
		{
			if ($row['JAMMUAT'] == "0000-00-00 00:00:00")
			{
				$flagprosesphp = "muat";
				$smessage = "Silahkan Melakukan Proses MUAT";
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
					$smessage = "Silahkan melakukan Proses KELUAR";
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
		if($flagproses=="batal")
		{
			$flagprosesphp = "batal";
			$smessage = "Silahkan melakukan Proses BATAL MUAT";
			$sproses = 0;
		}
		else
		{
			$smessage = "Surat Jalan tidak ada / belum dicetak";
			$sproses = 8;
		}
	}

	if($row == false)
	{
		$nopol = "";
		if($flagproses=="batal")
		{
			$smessage = "NOPOL tidak ada / tidak diizinkan BATAL MUAT";
			$sproses = 8;
		}
		else
		{
			$smessage = "Surat Jalan tidak ada / belum dicetak";
			$sproses = 8;
		}
	}
	else
	{
		$nosj = $row['SJ_NO'];
		$nopol = $row['NOPOL'];
		$ekspedisi = $row['EKSPEDISI'];
		$sopir = $row['SOPIR'];
		$jamkeluar = $row['JAMKELUAR'];
		$jammuat = $row['JAMMUAT'];
		$opsales = $row['OP_SALES'];
		$cusnama = $row['CUS_NAMA'];
		$optj = $row['OP_TJ'];
	}
	$sreset = 0;

	array_push($result, array(
		"nosj" =>$nosj,
		"nopol" =>$nopol,
		"ekspedisi" =>$ekspedisi,
		"sopir" =>$sopir,
		"statusmessage" => $smessage,
		"statusreset" => $sreset,
		"jammuat"=>$jammuat,
		"opsales" => $opsales,
		"flagprosesphp" => $flagprosesphp,
		"statusproses" => $sproses,
		"cusnama" => $cusnama,
		"optj" => $optj

	));
	
echo json_encode(array('result'=>$result));
mysqli_close($CONLOCAL);
// echo $sql;


?>