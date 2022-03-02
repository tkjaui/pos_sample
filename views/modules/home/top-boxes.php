<?php
$sales = ControllerSales::ctrAddingTotalThisMonthSales();
$productsMonthlySales = ControllerSales::ctrAddingTotalThisMonthProductsSales();

// $categories = ControllerCategories::ctrShowCategories($item, $value);
// $totalCategories = count($categories);

// $customers = ControllerCustomers::ctrShowCustomers($item, $value);
// $totalCustomers = count($customers);

// $products = ControllerProducts::ctrShowProducts($item, $value, $order);
// $totalProducts = count($products);
// var_dump($products);

$target = 300000;
$days = date('t');
$today = date("d");
$required_number = $target / $days * $today;
$achievement_rate = $sales["total_this_month"] / $required_number * 100;
$difference = $sales["total_this_month"] - $required_number;

if($difference == 0){ 
  $color = 'white'; 
} else if($difference > 0){ 
  $color = 'white'; 
}else{ 
  $color = 'red'; 
} 

//今月のサービス売上
$serviceSales = $sales["total_this_month"]-$productsMonthlySales["total"];


?>

<div class="col-lg-4 col-xs-6">
  <div class="small-box bg-aqua">
    <div class="inner">
      
      <h3>目標:¥<?php echo number_format($required_number) ;?></h3>
      <h3>実数: ¥<?php echo number_format($sales["total_this_month"]);?></h3>
      <h3 style="color:<?php echo $color; ?>;">差分: ¥<?php echo number_format($difference) ;?></h3>
      <h3>達成率: <?php echo number_format($achievement_rate,1) ;?>%</h3>
      
      <p>今月の売上進捗(日ベース)</p>
    </div>
    <div class="icon">
      <i class="fa fa-jpy"></i>
    </div>
    <a href="manage-sales" class="small-box-footer">
      More info <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div>
<div class="col-lg-4 col-xs-6">
  <div class="small-box bg-green">
    <div class="inner">
      <h3><?php echo number_format($serviceSales / $sales["total_this_month"] * 100, 1); ?>%</h3>
      <h3>¥<?php echo number_format($serviceSales); ?></h3>
      <p>今月の技術売上割合</p>
    </div>
    <div class="icon">
      <i class="fa fa-cut"></i>
    </div>
    <div class="small-box-footer">
      <div></div>
    </div>
  </div>
</div>
<div class="col-lg-4 col-xs-6">
  <div class="small-box bg-yellow">
    <div class="inner">
      <h3><?php echo number_format($productsMonthlySales["total"] / $sales["total_this_month"] * 100, 1); ?>%</h3>
      <h3>¥<?php echo number_format($productsMonthlySales["total"]); ?></h3>
      <p>今月の商品売上割合</p>
    </div>
    <div class="icon">
      <i class="fa fa-product-hunt"></i>
    </div>
    <div class="small-box-footer">
      <div></div>
    </div>
  </div>
</div>
<!-- <div class="col-lg-3 col-xs-6">
  <div class="small-box bg-red">
    <div class="inner">
      <h3><?php echo number_format($totalProducts); ?></h3>
      <p>Products</p>
    </div>
    <div class="icon">
      <i class="ion ion-ios-cart"></i>
    </div>
    <a href="products" class="small-box-footer">
      More info <i class="fa fa-arrow-circle-right"></i>
    </a>
  </div>
</div> -->
