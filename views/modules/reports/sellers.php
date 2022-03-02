<?php
  if(isset($_GET["initialDate"])){
    $initialDate = $_GET["initialDate"];
    $finalDate = $_GET["finalDate"];
  }else{
    $initialDate = null;
    $finalDate = null;
  }

  $answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);
  
  $item = null;
  $value = null;

  $sales = ControllerSales::ctrShowSales($item, $value);
  $users = ControllerUsers::ctrShowUsers($item, $value);

  $arraySellers = array();
  $arraySellersList = array();

  foreach ($sales as $key => $valueSales) {
    foreach ($users as $key => $valueUsers) {
      if($valueUsers["id"] == $valueSales["idSeller"]){
        //capture sellers in an array
        array_push($arraySellers, $valueUsers["name"]);

        //capture the names and net value in the same array
        $arraySellersList = array($valueUsers["name"] => $valueSales["netPrice"]);

        //add the netPrice of each seller
        foreach ($arraySellersList as $key => $value) {
          $addTotalSales[$key] += $value;
        }
      }
    }
  }

  //avoiding repeated names
  $dontrepeatnames = array_unique($arraySellers);

  // var_dump($arraySellers);
?>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Sellers</h3>
  </div>
  
  <div class="box-body chart-responsive">
    <div class="chart" id="bar-chart" style="height: 300px;"></div>
  </div>
</div>

<script>
 var bar = new Morris.Bar({
  element: 'bar-chart',
  resize: true,
  data: [
    <?php 
      foreach($dontrepeatnames as $value){
        echo "{y: '".$value."', a: '".$addTotalSales[$value]."'},";
      }  
    ?>
    
  ],
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Sales'],
  preUnits: '$',
  hideHover: 'auto'
});
</script>