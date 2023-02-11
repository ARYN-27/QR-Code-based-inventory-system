<?php
include ("config.php");
include ("iot.php");

if(isset($_POST['nama']) && isset($_POST['id']) && isset($_POST['kelas']) ) {
    $tablename = "pengguna";
    $nama = $_POST['nama'];
    $id = $_POST['id'];
    $kelas = $_POST['kelas'];
    $status = "0";
    $name = "nama,idnum,status,kelas";
    $value = "'".$nama."','".$id."','".$status."','".$kelas."'";
    insert_db($tablename,$name,$value);
 }

 if(isset($_GET['set']) && isset($_GET['stat'])) {
  $nama = $_GET['set'];
  $stat = $_GET['stat'];
  $tablename = "pengguna";
  $update_row_id = "idnum='$nama'";
  if(strcmp($stat,"0") == 0){
    $update_row_content = "status='1'";
  }else{
    $update_row_content = "status='0'";
  }
  update_db($tablename,$update_row_id,$update_row_content);
}

if(isset($_GET['del'])) {
  $del_id = $_GET['del'];
  $tablename = "pengguna";
  $row_ref_name = "idnum";
  $row_ref_content = $del_id;
  
  delete_db($tablename,$row_ref_name,$row_ref_content);
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>I-inventori</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-top.css" rel="stylesheet">

    <style>
      .table-responsive-stack tr {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
}


.table-responsive-stack td,
.table-responsive-stack th {
   display:block;
/*      
   flex-grow | flex-shrink | flex-basis   */
   -ms-flex: 1 1 auto;
    flex: 1 1 auto;
}

.table-responsive-stack .table-responsive-stack-thead {
   font-weight: bold;
}

@media screen and (max-width: 768px) {
   .table-responsive-stack tr {
      -webkit-box-orient: vertical;
      -webkit-box-direction: normal;
          -ms-flex-direction: column;
              flex-direction: column;
      border-bottom: 3px solid #ccc;
      display:block;
      
   }
   /*  IE9 FIX   */
   .table-responsive-stack td {
      float: left\9;
      width:100%;
   }
}
    </style>
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="#">i-Inventori</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Imbas Barkod</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="log.php">Log Inventori<span class="sr-only"></span></a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="inventori.php">Inventori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="pengguna.php">Pengguna</a>
          </li>
        </ul>
       
      </div>
    </nav>

    <main role="main" class="container">

      <!--
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Menu</h5>
          <a href="#" class="btn btn-primary">Inventori</a>
          <a href="#" class="btn btn-primary">Pengguna</a><br><br>
          
        </div>
      </div>
-->
      <br>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Pengguna</h5>
          <form action="pengguna.php" method="post">
            <div class="form-group">
              <label>Tambah pengguna baru</label>
              <input type="text" class="form-control" name="nama" placeholder="Nama">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="id" placeholder="ID">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="kelas" placeholder="kelas">
            </div>
            <button type="submit" class="btn btn-primary">Daftar Pengguna</button>
          </form> <br>
          
          <?php

      $table_rows = "id,nama,idnum,status,timestamp,kelas";
      $tablename = "pengguna";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      echo '<table class="table table-bordered table-striped table-responsive-stack">
      <thead>
        <tr>
          <th scope="col">Bil.</th>
          <th scope="col">Nama</th>
          <th scope="col">ID</th>
          <th scope="col">Kelas</th>
          <th scope="col">Status pengguna</th>
        </tr>
      </thead>
      <tbody>';

      for($counter = 0; $counter < count($table_contents); $counter++){
        $count = $counter + 1;
      echo '<tr>
                <th scope="row">'.$count.'</th>
                <td>'.$table_contents[$counter][1].'</td>
                <td>'.$table_contents[$counter][2].'</td>
                <td>'.$table_contents[$counter][5].'</td>
                <td><a href="pengguna.php?set='.$table_contents[$counter][2].'&stat='.$table_contents[$counter][3].'"'; 
                if(strcmp($table_contents[$counter][3],"0") == 0){
                  echo'class="btn btn-danger">Tidak Aktif</a>';
                }else{
                  echo'class="btn btn-success">Pengguna Aktif</a>';
                } 
                echo'<a> </a><a href="pengguna.php?del='.$table_contents[$counter][2].'" class="btn btn-warning">Padam</a></td></tr>';
    }

    echo '</tbody>
    </table>';


    ?>
          
              
              
           
          
        </div>
      </div>
      

    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>



    <script>
      $(document).ready(function() {

$('.table-responsive-stack').each(function (i) {
   var id = $(this).attr('id');
   //alert(id);
   $(this).find("th").each(function(i) {
      $('#'+id + ' td:nth-child(' + (i + 1) + ')').prepend('<span class="table-responsive-stack-thead">'+             $(this).text() + ':</span> ');
      $('.table-responsive-stack-thead').hide();
      
   });
   

   
});





$( '.table-responsive-stack' ).each(function() {
var thCount = $(this).find("th").length; 
var rowGrow = 100 / thCount + '%';
//console.log(rowGrow);
$(this).find("th, td").css('flex-basis', rowGrow);   
});




function flexTable(){
if ($(window).width() < 768) {
   
$(".table-responsive-stack").each(function (i) {
   $(this).find(".table-responsive-stack-thead").show();
   $(this).find('thead').hide();
});
   
 
// window is less than 768px   
} else {
   
   
$(".table-responsive-stack").each(function (i) {
   $(this).find(".table-responsive-stack-thead").hide();
   $(this).find('thead').show();
});
   
   

}
// flextable   
}      

flexTable();

window.onresize = function(event) {
 flexTable();
};






// document ready  
});
    </script>


  </body>
</html>
