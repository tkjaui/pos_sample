<div class="content-wrapper">
  <section class="content-header">
    <h1>
      ダッシュボード
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <?php
        if($_SESSION["profile"] == "管理者"){
          include "home/top-boxes.php";
        }
      ?>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <?php
          if($_SESSION["profile"] == "管理者"){
            include "home/sales-graph-for-home.php";
          }
        ?>
      </div>
      
      <div class="col-lg-12">
        <?php
          if($_SESSION["profile"] == "スタイリスト"){
            echo '<div class="box box-success">
              <div class="box-header">
                <h1>Welcome '.$_SESSION["name"].'</h1>
              </div>
            </div>';
          }
        ?>
      </div>
    </div>
  </section>
</div>
