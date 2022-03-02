<?php
error_reporting(0);

if(isset($_GET["initialDate"])){
  $initialDate = $_GET["initialDate"];
  $finalDate = $_GET["finalDate"];
}else{
  $initialDate = null;
  $finalDate = null;
}

$answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);

$arrayDates = array();
$arraySales = array();
$addingDailyPayments = array();
$addingDailyCustomers = array();

foreach ($answer as $key => $value) {
  //Capture only month and day
  $singleDate = substr($value["sell_date"],0,10);
  
  //Introduce dates in arrayDates
  array_push($arrayDates, $singleDate);

  //Capture the sales
  $arraySales = array($singleDate => $value["totalPrice"]);

  //Ccapture the customers
  $arrayCustomers = array($singleDate => 1);

  //Add payments made in the same day
  foreach ($arraySales as $key => $value) {
    $addingDailyPayments[$key] += $value;
  }

  //Add customers made in the same day
  foreach ($arrayCustomers as $key => $value) {
    $addingDailyCustomers[$key] += $value;
  }
}

$daily_sales = array();
foreach ($addingDailyPayments as $key => $value) {
  array_push($daily_sales, array("y" => $value, "label" => "$key" ));
}

$daily_customers = array();
foreach ($addingDailyCustomers as $key => $value) {
  array_push($daily_customers, array("y" => $value, "label" => "$key" ));
}

?>

<?php
//barのデータ
$dataPoints = $daily_sales;
 
//Lineのデータ
$dataPoints_line = $daily_customers;
?>


<head>
  <script>
  window.onload = function() {
  
  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
      text: "売上（日別）",
    },
    axisY: {
      // title: "売上"
    },
    data: [{
      type: "column",
      yValueFormatString: "¥#,##0",
      dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
  });
  chart.render();


  var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    theme: "light2",
    title: {
      text: "来客数（日別)"
    },
    subtitles:[
      
		{
			// text: "合計：人"
		}
		],
    axisY: {
      // title: "Number of Push-ups"
    },
    data: [{
      type: "line",
      yValueFormatString: "##人",
      dataPoints: <?php echo json_encode($dataPoints_line, JSON_NUMERIC_CHECK); ?>
    }]
  });
  chart2.render();
  }
  </script>
</head>

<body>
  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
  <div id="chartContainer2" style="height: 370px; width: 100%; margin-top:20px;"></div>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

<div class="box-body">
  <table class="table table-bordered table-striped dt-responsive tables" width="100%">
    <thead>
      <tr>
        <th>日付</th>
        <th>技術売上</th>
        <th>商品売上</th>
        <th>合計売上</th>
        <th>客数</th>
        <th>客単価</th>
        <th>詳細</th>
      </tr>
    </thead>

    <tbody>
        <?php
        $answerDailySales = ControllerSales::ctrDailySales($initialDate, $finalDate);
        foreach ($answerDailySales as $key => $value) {
          echo '<tr>';
          
          if(is_null($value["date"])){
            echo '<td>合計</td>';
          }else{
            echo '<td>'.$value["date"].'</td>';
          }
  
          echo
          '<td>¥'.number_format($value["sum(totalPrice)"] - $value["sum(product_sales)"]).'</td>
          <td>¥'.number_format($value["sum(product_sales)"]).'</td>
          <td>¥'.number_format($value["sum(totalPrice)"]).'</td>
          <td>'.number_format($value["count(totalPrice)"]).'</td>
          <td>¥'.number_format($value["sum(totalPrice)"] / $value["count(totalPrice)"]).'</td>
          <td><a href="index.php?route=manage-sales&initialDate='.$value["date"].'&finalDate='.$value["date"].'"><button>詳細</button></a></td> 
        </tr>';
        }
        ?> 
      
    </tbody>
  </table>
</div>




