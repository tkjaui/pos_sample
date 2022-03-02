<?php
error_reporting(0);

//月初
$firstDay = date("2022-02-01");
//月末
$lastDay = date("2022-02-28");

$initialDate = $firstDay;
$finalDate = $lastDay;

$answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);

$arrayDates = array();
$arraySales = array();
$addingDailyPayments = array();
$addingDailyCustomers = array();

foreach ($answer as $key => $value) {
  //Capture only month and day
  $singleDate = substr($value["sell_date"],5,5);
  
  //Introduce dates in arrayDates
  array_push($arrayDates, $singleDate);

  //Ccapture the sales
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
$noRepeatDates = array_unique($arrayDates);
// var_dump($addingDailyPayments);

$daily_sales = array();
foreach ($addingDailyPayments as $key => $value) {
  array_push($daily_sales, array("y" => $value, "label" => "$key" ));
}

$daily_customers = array();
foreach ($addingDailyCustomers as $key => $value) {
  array_push($daily_customers, array("y" => $value, "label" => "$key" ));
}
// var_dump($addingDailyCustomers);
// var_dump($daily_customers);

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
		text: "売上（日別）"
	},
	axisY: {
		// title: "Gold Reserves (in tonnes)"
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
		text: "来客数（日別）"
	},
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



