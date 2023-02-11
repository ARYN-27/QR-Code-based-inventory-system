
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

  <style>
  .data {
    color: #2980b9;
    padding: 1px;
    text-align: center;
    font-size: 50px;
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
            <a class="nav-link active" href="index.php">Imbas Barkod</a>
          </li>
          <li class="nav-item ">
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
          <h5 class="card-title">Imbas Barkod</h5>
          <h3 class="text-center">Barkod</h3>
          <h2 class="data" id="bc">imbas barkod</h2>
          <h3 class="text-center">Nama</h3>
          <h2 class="data" id="nm">tiada data</h2>
          <h3 class="text-center">Status</h3>
          <h2 class="data" id="st">tiada data</h2>
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

<script>

var stat = 0;
var prev_scans = 0;
var count = 0;
setInterval(function () {
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
  var readings = this.responseText;
  var array_readings = readings.split(",");
  
  if(readings.length < 6){

  //  document.getElementById("bc").innerHTML = array_readings[1];
  //  document.getElementById("nm").innerHTML = "0";
  //  document.getElementById("st").innerHTML = "0";
  }else{

           // prev_scans = array_readings[1];
           var xhttp2 = new XMLHttpRequest();
    var params = "scan.php?pi=" + array_readings[1];
   xhttp2.onload = function() {
    var values = this.responseText;
    var arry = values.split(",");
    document.getElementById("bc").innerHTML = arry[1];
    document.getElementById("nm").innerHTML = arry[0];
    document.getElementById("st").innerHTML = arry[2];

    if(arry[0].length < 2 || arry[2].length < 2){
      document.getElementById("nm").innerHTML = "tiada data";
    document.getElementById("st").innerHTML = "tiada data";
    }

  }
    xhttp2.open("GET",params, true);
    xhttp2.send();

    
    
  }



}
    
  };
      xhttp.open("GET", "scan.php?checkscanned=1", true);
      xhttp.send();
      }, 1000);

      </script>


  </body>
</html>
