<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      売上一覧
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="create-sales">
          <button class="btn btn-primary">
            レジへ
          </button>
        </a>
        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
          <span>
            <i class="fa fa-calendar"></i> Date Range
          </span>
          <i class="fa fa-caret-down"></i>
        </button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>会計日時</th>
              <th>お客様</th>
              <th>施術者</th>
              <th>支払方法</th>
              <th>サービス・商品</th>
              <th>税抜価格</th>
              <th>税込価格</th>
              
              <th>ボタン</th>
            </tr>
          </thead>

          <tbody>
              <?php
                if(isset($_GET["initialDate"])){
                  $initialDate = $_GET["initialDate"];
                  $finalDate = $_GET["finalDate"];
                } else{
                  $initialDate = null;
                  $finalDate = null;
                }                
                $answer = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);


                foreach($answer as $key => $value){
                  echo 
                  '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["sell_date"].'</td>';

                  $itemCustomer = "id";
                  $valueCustomer = $value["idCustomer"];
                  $customerAnswer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);
                  echo '<td class="name" id="'.$customerAnswer["id"].'"><a href="index.php?route=customer-details&id='.$customerAnswer["id"].'">'.$customerAnswer["name"].'</a></td>';
                  
                  $itemUser = "id";
                  $valueUser = $value["idSeller"];
                  $userAnswer = ControllerUsers::ctrShowUsers($itemUser, $valueUser);
                  echo '<td>'.$userAnswer["name"].'</td>
                  <td>'.$value["paymentMethod"].'</td>';

                  //test
                  $test = [];
                  $category = [];
                  // echo $value["products"];
                  preg_match_all('/"id":"(\w+)/', $value["products"], $match_id);
                  preg_match_all('/"id_2":"(\w+)/', $value["products"], $match_id2);
                  preg_match_all('/"totalPrice":"(\w+)/', $value["products"], $match_totalPrice);
                  preg_match_all('/"idCategory":"(\w+)/', $value["products"], $match_idCategory);
                  // var_dump($match_idCategory);

                  //初めの1はidがつくかつかないか、次の1は配列の順番  最後の数字を$iとかにする？   
                  for($i=0; $i<count($match_id[1]); $i++){
                    if($match_id2[1][$i] == "addProductSale"){
                      // var_dump($match_id2[1][$i]);
                      // array_push($test, [$match_id[1][$i], $match_id2[1][$i]]);
                      $itemProduct = "id";
                      $valueProduct = $match_id[1][$i];
                      $order = "id";
                      $productAnswer = ControllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);
                      array_push($test, $productAnswer["description"]);
                    }if($match_id2[1][$i] == "addServiceSale"){
                      // array_push($test, [$match_id[1][$i], $match_id2[1][$i]]);
                      $itemService = "id";
                      $valueService = $match_id[1][$i];
                      $order = "id";
                      $serviceAnswer = ControllerServices::ctrShowServices($itemService, $valueService, $order);
                      // echo '<td>'.$serviceAnswer["description"].'</td>';
                      array_push($test, $serviceAnswer["description"]);
                    }

                    $itemCategory = "id";
                    $valueCategory = $match_idCategory[1][$i];
                    $order = "id";
                    $categoryAnswer = ControllerCategories::ctrShowCategories($itemCategory, $valueCategory, $order);
                    array_push($category, $categoryAnswer["Category"]);
                  }
                  // var_dump($category);

                  echo '<td>';
                  for($i=0; $i<count($test); $i++){
                    echo $category[$i].'&nbsp;'.$test[$i].'<br>';
                  }
                  echo '</td>';
                  
                  $product_sum_price = [];
                  for($i=0; $i<count($test); $i++){
                    if($match_id2[1][$i] == "addProductSale"){
                      // var_dump($match_totalPrice[1][$i]);
                      array_push($product_sum_price, $match_totalPrice[1][$i]);
                    }
                  }     
                  // var_dump($product_sum_price);    
                  // var_dump(array_sum($product_sum_price));

                  echo 
                  '<td>¥'.number_format($value["netPrice"]).'</td>
                  <td>¥'.number_format($value["totalPrice"]).'</td>
                  <td>
                    <div class="btn-group">';
                      if($_SESSION["profile"] == "管理者"){
                        echo '
                        
                        <button class="btn btn-danger btnDeleteSale" idSale="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                      }
                    echo '  
                    </div>
                  </td>
                </tr>';
                }
              ?> 
            
          </tbody>
        </table>

        

        <?php
          $deleteSale = new ControllerSales();
          $deleteSale -> ctrDeleteSale();
        ?>

      </div>
    </div>
  </section>
</div>

