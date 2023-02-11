<?php
include ("config.php");
include ("iot.php");

// Filter the excel data 
function filterData(&$str){ 
  $str = preg_replace("/\t/", "\\t", $str); 
  $str = preg_replace("/\r?\n/", "\\n", $str); 
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

if(isset($_GET["export"])){

  // Excel file name for download 
  $fileName = "inventori"."_". date('Y-m-d') . ".xlsx"; 
   
  // Column names 
  $fields = array('id', 'inventori', 'barkod', 'pengguna', 'tarikh'); 
   
  // Display column names as first row 
  $excelData = implode("\t", array_values($fields)) . "\n"; 
  
  
        $table_rows = "id,inventori,barkod,pengguna,tarikh";
        $table_name = "logs";
        $row_ref_name = "id";
        $row_ref_content = "0";
    
        $table_contents = read_db($table_rows,$table_name,$row_ref_content,$row_ref_name,1);
  
        if(count($table_contents) != 0){
        for($counter = 0; $counter < count($table_contents); $counter++){
          $date = explode(" ",$table_contents[$counter][4]);
        if(strcmp($date[0],$_GET['export']) == 0){
          $count = $counter + 1;
          $lineData = array($count,$table_contents[$counter][1],$table_contents[$counter][2], $table_contents[$counter][3], $table_contents[$counter][4]);
        }
          
  
          array_walk($lineData, 'filterData'); 
          $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }
  
          // Headers for download 
          header("Content-Type: application/vnd.ms-excel"); 
          header("Content-Disposition: attachment; filename=\"$fileName\""); 
          
          // Render excel data 
          echo $excelData; 
          
          exit;
  
        
      }else{
        alert("No records found to export!");
      }
  
  
  
  
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
          <li class="nav-item active">
            <a class="nav-link" href="log.php">Log Inventori<span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inventori.php">Inventori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pengguna.php">Pengguna</a>
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
          <h5 class="card-title">Log Inventori</h5>
          <form action="index.php" method="GET">
            <label>Tarikh</label>
            <select name="date" class="form-control" >
              <?php
              $table_rows = "id,inventori,barkod,pengguna,tarikh";
              $tablename = "logs";
              $row_ref_name = "id";
              $row_ref_content = "0";
              $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
              $prev_date = "";
              if(count($table_contents) == 0) echo '<option>Tiada tarikh dijumpai</option>';
              for($counter = 0; $counter < count($table_contents); $counter++){
                $date = explode(" ",$table_contents[$counter][4]);
                if(strcmp($date[0],$prev_date) != 0){
                        echo '<option>'.$date[0].'</option>';
                        $prev_date = $date[0];
                }
              }
              ?>
            </select><br>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="index.php?export=<?php echo $_GET["date"]; ?>" class="btn btn-primary">Eksport</a><br><br>
          </form><br>
          
          <?php

      if(isset($_GET['date'])){
      $table_rows = "id,inventori,barkod,pengguna,tarikh,status,idnum,kelas";
      $tablename = "logs";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      echo '<table class="table table-bordered table-striped table-responsive-stack">
      <thead>
        <tr>
          <th scope="col">Bil.</th>
          <th scope="col">Inventori</th>
          <th scope="col">Barkod</th>
          <th scope="col">Pengguna</th>
          <th scope="col">ID</th>
          <th scope="col">kelas</th>
          <th scope="col">Status</th>
          <th scope="col">Tarikh</th>
        </tr>
      </thead>
      <tbody>';

      for($counter = 0; $counter < count($table_contents); $counter++){
        $date = explode(" ",$table_contents[$counter][4]);
        $count = $counter + 1;
        if(strcmp($date[0],$_GET['date']) == 0){
                echo '<tr>
                <th scope="row">'.$count.'</th>
                <td>'.$table_contents[$counter][1].'</td>
                <td>'.$table_contents[$counter][2].'</td>
                <td>'.$table_contents[$counter][3].'</td>
                <td>'.$table_contents[$counter][6].'</td>
                <td>'.$table_contents[$counter][7].'</td>
                <td>'.$table_contents[$counter][5].'</td>
                <td>'.$table_contents[$counter][4].'</td>
                </tr>';
        }
    }

    echo '</tbody>
    </table>';
  }else{
    $table_rows = "id,inventori,barkod,pengguna,tarikh,status,idnum,kelas";
      $tablename = "logs";
      $row_ref_name = "id";
      $row_ref_content = "0";
      $table_contents = read_db($table_rows,$tablename,$row_ref_content,$row_ref_name,1);
      echo '<table class="table table-bordered table-striped table-responsive-stack">
      <thead>
        <tr>
          <th scope="col">Bil.</th>
          <th scope="col">Inventori</th>
          <th scope="col">Barkod</th>
          <th scope="col">Pengguna</th>
          <th scope="col">ID</th>
          <th scope="col">kelas</th>
          <th scope="col">Status</th>
          <th scope="col">Tarikh</th>
        </tr>
      </thead>
      <tbody>';

      for($counter = 0; $counter < count($table_contents); $counter++){
        $count = $counter + 1;
      echo '<tr>
                <th scope="row">'.$count.'</th>
                <td>'.$table_contents[$counter][1].'</td>
                <td>'.$table_contents[$counter][2].'</td>
                <td>'.$table_contents[$counter][3].'</td>
                <td>'.$table_contents[$counter][6].'</td>
                <td>'.$table_contents[$counter][7].'</td>
                <td>'.$table_contents[$counter][5].'</td>
                <td>'.$table_contents[$counter][4].'</td>
                </tr>';
    }

    echo '</tbody>
    </table>';
  }

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
