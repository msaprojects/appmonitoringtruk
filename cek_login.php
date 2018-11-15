<?php 
  require_once('koneksi.php');

    $uuid = "";
    $jabatan = "";
    if(isset($_POST['uuid'])) $uuid = $_POST["uuid"];
    if(isset($_POST['jabatan'])) $jabatan = $_POST["jabatan"];

    $sql = "SELECT * FROM pengguna where uuid='".$uuid."'";

    $r = mysqli_query($con, $sql);
    $result = array();
    $row = mysqli_fetch_array($r);

    $masuk = 0;
    $keluar = 0;
    $loading = 0; 

    if ($row['jabatan']=='sekuriti')
    {
      $masuk = 0;
      $keluar = 0;
      $loading = 8; 
    } else if($row['jabatan']=="muatan")
    {
      $keluar = 0; 
      $masuk = 8;
      $loading = 0;
    }
  
    array_push($result,array(
        "uuid"=>$row['uuid'],
        "jabatan"=>$row['jabatan'],
        "masuk"=> $masuk,
        "keluar"=> $keluar,
        "loading"=> $loading
    ));
    
    echo json_encode(array('result'=>$result));
    // echo $sql;
    mysqli_close($con);
?>
