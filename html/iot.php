<?php
/*
iot.php library for iot API platform workshop
Written by Shawal @ Shawal Technologies
July 2020
*/


function generate_hash($words){
    return password_hash($words, PASSWORD_DEFAULT);
}

function verify_hash($key,$hash){
    if (password_verify($key, $hash))return 1;
    return 0;
}

function check_cookie($cookiename){
    if(isset($_COOKIE[$cookiename]))return 1;
        return 0;
}

function read_cookie($cookiename){
    if(isset($_COOKIE[$cookiename]))return $_COOKIE[$cookiename];
    return 0;
}

function delete_cookie($cookiename){
    if(isset($_COOKIE[$cookiename]))setcookie($cookiename, "0", time() - 3600);
}

function set_cookie($cookies_id,$cookies_data){
    setcookie($cookies_id, $cookies_data, time() + (86400 * 30), "/"); //86400 = 1 day
}

function randomstring($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function delete_db($tableName, $row_ref_id, $row_ref_content){
    $sql_del = "DELETE FROM ".$tableName." WHERE ".$row_ref_id." = '$row_ref_content' ";
    if(mysqli_query(mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE), $sql_del)){
        return 1;
    }
}

function insert_db($tablename,$valuename, $valuecontent){
    $insert="INSERT INTO ".$tablename."($valuename) VALUES ($valuecontent)";
       if (mysqli_query(mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE),$insert)) {
           return 1;
    }
    
}

function update_db($dbupdate_table_name, $dbupdate_table_id, $dbupdate_table_content){
    if (mysqli_query(mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE),"UPDATE $dbupdate_table_name SET $dbupdate_table_content WHERE $dbupdate_table_id"))return 1;
  return 0;
}

function read_db($dbtable_list, $dbtable_name, $dbtable_access, $dbcontent_id, $dball){
  $dbcontent_list = explode(",",$dbtable_list); $dba = 0; $dbcontent = array();
  $result = mysqli_query(mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE),"SELECT $dbtable_list FROM $dbtable_name");
      if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
      if($dbtable_access == $row[$dbcontent_id] && $dball == 0){
          for ($arrays = 0; $arrays < sizeof($dbcontent_list); $arrays++)
          $dbcontent[$dba][$arrays] = $row[$dbcontent_list[$arrays]];
          $dba++;
      }elseif($dball == 1){
          for ($arrays = 0; $arrays < sizeof($dbcontent_list); $arrays++)
          $dbcontent[$dba][$arrays] = $row[$dbcontent_list[$arrays]];
          $dba++;
      }
  } 
  if(count($dbcontent) > 0)return $dbcontent;
  return 0; 
}
}

?>