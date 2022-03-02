<?php
  $item = null;
  $value = null;

  $sales = ControllerSales::ctrShowSales($item, $value);
  $customers = ControllerCustomers::ctrShowCustomers($item, $value);

  $arrayCustomers = array();
  $arrayCustomersList = array();

  foreach ($sales as $key => $valueSales) {
    foreach ($customers as $key => $valueCustomers) {
      if($valueCustomers["id"] == $valueSales["idCustomer"]){
        //capture customers in an array
        array_push($arrayCustomers, $valueCustomers["name"]);

        //capture the names and net value in the same array
        $arrayCustomersList = array($valueCustomers["name"] => $valueSales["netPrice"]);

        //add the netPrice of each seller
        foreach ($arrayCustomersList as $key => $value) {
          $addTotalSales[$key] += $value;
        }
      }
    }
  }

  //avoiding repeated names
  $dontrepeatnames = array_unique($arrayCustomers);

  // var_dump($arraySellers);
?>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Customers</h3>
  </div>
  
  <div class="box-body chart-responsive">
    <div class="chart" id="bar-chart2" style="height: 300px;"></div>
  </div>
</div>

<script>
 var bar = new Morris.Bar({
  element: 'bar-chart2',
  resize: true,
  data: [
    <?php 
      foreach($dontrepeatnames as $value){
        echo "{y: '".$value."', a: '".$addTotalSales[$value]."'},";
      }  
    ?>
    
  ],
  barColors: ['#f6a'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Sales'],
  preUnits: '$',
  hideHover: 'auto'
});
</script>