<?php
include ("config.php");
include ("iot.php");

if(isset($_GET['scanned'])){


    $table_rows = "id,barkod";
      $tablename = "scan";
      $row_ref_name = "id";
      $row_ref_content = "1";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,0);
      echo $table_contents[0][1];
    $tablename = "scan";
    $update_row_id = "id=1";
    $update_row_content = "barkod='0'";
    update_db($tablename,$update_row_id,$update_row_content);

}

if(isset($_GET['pi'])){
  $scanned_item = "0";
    $item_name = "0";
    $bit_stats = "0";
    $table_rows = "id,nama,barkod,timestamp,status";
      $tablename = "inventori";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      for($counter = 0; $counter < count($table_contents); $counter++){
        if(strcmp($table_contents[$counter][2],$_GET['pi']) == 0){
            $scanned_item = $table_contents[$counter][2];
            $item_name = $table_contents[$counter][1];
            $bit_stats = $table_contents[$counter][4];
        }
      }

      if(strcmp($scanned_item,"0") == 0){
        echo "0,".$_GET['pi'].",0,0";
        return;
    }

$active_user = 0;
    $table_rows = "id,nama,idnum,status,timestamp";
      $tablename = "pengguna";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      
      for($counter = 0; $counter < count($table_contents); $counter++){
        
        if(strcmp($table_contents[$counter][3],"1") == 0){
          $active_user = 1;
        }
      }


      $item_status = "tiada pengguna aktif";
      if($active_user == 1){
      $item_status = "Check-In";
      if(strcmp($bit_stats,"Check-In") == 0)$item_status = "Check-Out";
      $tablename = "inventori";
      $update_row_id = "barkod='".$_GET['pi']."'";
      $update_row_content = "status='".$item_status."'";
      update_db($tablename,$update_row_id,$update_row_content);
      }
      
      echo $item_name.",".$scanned_item.",".$item_status;
      $table_rows = "id,nama,idnum,status,timestamp,kelas";
      $tablename = "pengguna";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      
      for($counter = 0; $counter < count($table_contents); $counter++){
        
        if(strcmp($table_contents[$counter][3],"1") == 0){
            $tablename = "logs";
            $name = "inventori,barkod,pengguna,status,idnum,kelas";
            $value = "'".$item_name."','".$scanned_item."','".$table_contents[$counter][1]."','".$item_status."','".$table_contents[$counter][2]."','".$table_contents[$counter][5]."'";
            insert_db($tablename,$name,$value);
            
        }
      }
}

if(isset($_GET['checkscanned'])){
    $scanned_item = "0";
    $item_name = "0";
    $table_rows = "id,barkod";
      $tablename = "scan";
      $row_ref_name = "id";
      $row_ref_content = "1";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,0);
      $scanned_item =  $table_contents[0][1];
    $tablename = "scan";
    $update_row_id = "id=1";
    $update_row_content = "barkod='0'";
    update_db($tablename,$update_row_id,$update_row_content);

    $table_rows = "id,nama,barkod,timestamp,status";
      $tablename = "inventori";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      for($counter = 0; $counter < count($table_contents); $counter++){
        if(strcmp($table_contents[$counter][2],$scanned_item) == 0){
            $item_name = $table_contents[$counter][1];
            echo $item_name.",".$scanned_item;
            return;
        }
      }
   // if(strcmp($item_name,"0") == 0)$item_name = "Barkod tidak berdaftar";
      echo $item_name.",".$scanned_item;
}

if(isset($_GET['scan'])){

    $tablename = "scan";
    $update_row_id = "id=1";
    $update_row_content = "barkod='".$_GET['scan']."'";
    $status = update_db($tablename,$update_row_id,$update_row_content);
    if($status)echo "OK";

/*
    $scanned_item = "0";
    $item_name = "0";
    $bit_stats = "0";
    $table_rows = "id,nama,barkod,timestamp,status";
      $tablename = "inventori";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      for($counter = 0; $counter < count($table_contents); $counter++){
        if(strcmp($table_contents[$counter][2],$_GET['scan']) == 0){
            $scanned_item = $table_contents[$counter][2];
            $item_name = $table_contents[$counter][1];
            $bit_stats = $table_contents[$counter][4];
        }
      }

      if(strcmp($scanned_item,"0") == 0){
        echo "NOTSET:".$_GET['scan'];
        return;
    }

      $item_status = "Check-In";
      if(strcmp($bit_stats,"Check-In") == 0)$item_status = "Check-Out";
      $tablename = "inventori";
      $update_row_id = "barkod='".$_GET['scan']."'";
      $update_row_content = "status='".$item_status."'";
      update_db($tablename,$update_row_id,$update_row_content);
      
      
      $table_rows = "id,nama,idnum,status,timestamp";
      $tablename = "pengguna";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      for($counter = 0; $counter < count($table_contents); $counter++){
        if(strcmp($table_contents[$counter][3],"1") == 0){
            $tablename = "logs";
            $name = "inventori,barkod,pengguna,status";
            $value = "'".$item_name."','".$scanned_item."','".$table_contents[$counter][1]."','".$item_status."'";
            insert_db($tablename,$name,$value);
        }
      }
*/
    
}



?>