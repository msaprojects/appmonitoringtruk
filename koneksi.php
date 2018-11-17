<?php

	 define('HOST','127.0.0.1');
	 define('USER','root');
	 define('PASS','hanyaadminyangtau');
	 define('DB','c_erp_plant_sigk');
	 
	 $con = mysqli_connect(HOST, USER, PASS, DB) or die ('gagal konek ke database');

	 define('HOST488','127.0.0.1');
	 define('USER488','root');
	 define('PASS488','hanyaadminyangtau');
	 define('DB488','visiting');
	 
	 $con488 = mysqli_connect(HOST488, USER488, PASS488, DB488) or die ('gagal konek ke database visiting');

?>