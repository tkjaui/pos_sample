<?php
  session_start();
  // error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POSシステム</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="icon" href="views/img/template/icono-negro.png">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Bootstrap 5.0.2 -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/plugins/iCheck/all.css">


  <!-- jQuery 3 -->
  <script src="views/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Bootstrap 5.0.2 -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
  <!-- FastClick -->
  <script src="views/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="views/dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!-- sweetalert2 -->
  <script src="views/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- By default sweetalert2 doesn't support IE. To enable IE 11 support, include Promise polyfill -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="views/plugins/iCheck/icheck.min.js"></script>
  <!-- InputMask -->
  <script src="views/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- jqueryNumber -->
  <script src="views/plugins/jqueryNumber/jquerynumber.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <!-- Morris chart -->
  <link rel="stylesheet" href="views/bower_components/morris.js/morris.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="views/bower_components/chart.js/Chart.js"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">

  <?php 
    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok"){
      echo '<div class="wrapper">';

      include "modules/header.php";
      include "modules/sidebar.php";
  
      if(isset($_GET["route"])){
        if($_GET["route"] == "home" ||
           $_GET["route"] == "users" ||
           $_GET["route"] == "categories" ||
           $_GET["route"] == "products" ||
           $_GET["route"] == "customers" ||
           $_GET["route"] == "manage-sales" ||
           $_GET["route"] == "create-sales" ||
           $_GET["route"] == "edit-sales" ||
           $_GET["route"] == "sales-report" ||
           $_GET["route"] == "services" ||
           $_GET["route"] == "customer-details" ||
           $_GET["route"] == "logout"){
          include "modules/".$_GET["route"].".php";
        } else {
          include "modules/404.php";
        }
      } else {
        include "modules/home.php";
      }
      include "modules/footer.php";
      echo '</div>';  
    } else {
      include "modules/login.php";
    }
  ?>



  <script src="views/js/template.js" charset="UTF-8"></script>
  <script src="views/js/users.js"></script>
  <script src="views/js/categories.js"></script>
  <script src="views/js/products.js"></script>
  <script src="views/js/customers.js"></script>
  <script src="views/js/sales.js" charset="UTF-8"></script>
  <script src="views/js/reports.js"></script>
  <script src="views/js/services.js"></script>

</body>
</html>
