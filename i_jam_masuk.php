<?php

    require_once('koneksi.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){

        //Mendapatkan Nilai Variable
        $nopol = "";
        $ekspedisi = "";
        $sopir ="";

        $nopol = $_POST['NOPOL'];
        $ekspedisi = $_POST['EKSPEDISI'];
        $sopir = $_POST['SOPIR'];
        //Pembuatan Syntax SQL
        $sql = "INSERT into monitoringtruk(NOPOL, SOPIR, EKSPEDISI, JAMMASUK, WAKTU, USER) values ('".$nopol."', '".$sopir."', '".$ekspedisi."', NOW(), NOW(), 'MobileApps');";
         
        //Eksekusi Query database
        if(mysqli_query($con,$sql)){
            // echo $sql;
            echo 'Jam Masuk nopol : '.$nopol.' Berhasil Di tambahkan';
        }else{
            echo 'Gagal Menambahkan Jam Masuk Untuk Nopol : '.$nopol;
            echo $sql;
        }
         // echo $sql;
        mysqli_close($con);
    }
?>
