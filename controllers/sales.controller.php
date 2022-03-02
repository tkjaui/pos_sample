<?php 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;


class ControllerSales{
  //Show sales
  static public function ctrShowSales($item, $value){
    $table = "sales";
    $answer = ModelSales::mdlShowSales($table, $item, $value);
    return $answer;
  }
  
  //Create sale
  static public function ctrCreateSale(){
    if(isset($_POST["productsList"])){
      //Update customer's purchases and reduce the stock and increase sales of the product
      // 商品購入 → customersのpurchasesアップ、productsのstockダウン、productsのsalesアップ、salesに1行追加
      $productsList = json_decode($_POST["productsList"], true);
      
      // var_dump(count($productsList));
      $totalPurchasedProducts = array();
      
      for($i=0; $i < count($productsList); $i++){
      // foreach ($productsList as $key => $value) {
        array_push($totalPurchasedProducts, $productsList[$i]["quantity"]);

        if($productsList[$i]["id_2"] == "addProductSale"){ //serviceとproductを区別する条件
          $tableProducts = "products";
          $item = "id";
          $valueProductId = $productsList[$i]["id"];
          $order = "id";
          //productのsalesの個数を取得
          $getProduct = productsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);

          //productのsalesの個数をプラス
          $item1a = "sales";
          $value1a = $productsList[$i]["quantity"] + $getProduct["sales"];
          $newSales = productsModel::mdlUpdateProduct($tableProducts, $item1a, $value1a, $valueProductId);
        } else {
          $tableServices = "services";
          $item = "id";
          $valueServiceId = $productsList[$i]["id"];
          $order = "id";
          //serviceのsalesの個数を取得
          $getProduct = servicesModel::mdlShowServices($tableServices, $item, $valueServiceId, $order);

          //serviceのsalesの個数をプラス
          $item1a = "sales";
          $value1a = $productsList[$i]["quantity"] + $getProduct["sales"];
          $newSales = servicesModel::mdlUpdateService($tableServices, $item1a, $value1a, $valueServiceId);
        }
      }

      $tableCustomers = "customers";
      $item = "id";
      $valueCustomer = $_POST["selectCustomer"];
      $getCustomer = ModelCustomers::mdlShowCustomers($tableCustomers, $item, $valueCustomer);

      $item1a = "purchases";
      $value1a = array_sum($totalPurchasedProducts) + $getCustomer["purchases"];
      $customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item1a, $value1a, $valueCustomer);

      $item1b = "lastPurchase";
      date_default_timezone_set('Asia/Tokyo');
      $date = date('Y-m-d');
      $hour = date('H:i:s');
      $value1b = $date.' '.$hour;
      $dateCustomer = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item1b, $value1b, $valueCustomer);

      // Product sum price
      preg_match_all('/"id_2":"(\w+)/', $_POST["productsList"], $match_id2);
      preg_match_all('/"totalPrice":"(\w+)/', $_POST["productsList"], $match_totalPrice);
      $product_sum_price = [];
 
      for($i=0; $i<count($match_id2[1]); $i++){
        if($match_id2[1][$i] == "addProductSale"){
          array_push($product_sum_price, $match_totalPrice[1][$i]);
        }
      }
      $productSumPrice = array_sum($product_sum_price);          

      //Save the sale
      $table = "sales";
      if(preg_match('/"id_2":"addProductSale"/', $_POST["productsList"])){//もし商品だったら（サービスじゃなかったら）
        $data = array("idSeller" => $_POST["newSeller"],
                      "idCustomer" => $_POST["selectCustomer"],
                      "code" => $_POST["newSale"],
                      "products" => $_POST["productsList"],
                      "tax" => $_POST["newTaxPrice"],
                      "netPrice" => $_POST["newNetPrice"],
                      "totalPrice" => $_POST["saleTotal"],
                      "paymentMethod" => $_POST["listPaymentMethod"],
                      "product_sales" => $productSumPrice);//ここだけ追加
      } else {
        $data = array("idSeller" => $_POST["newSeller"],
                      "idCustomer" => $_POST["selectCustomer"],
                      "code" => $_POST["newSale"],
                      "products" => $_POST["productsList"],
                      "tax" => $_POST["newTaxPrice"],
                      "netPrice" => $_POST["newNetPrice"],
                      "totalPrice" => $_POST["saleTotal"],
                      "paymentMethod" => $_POST["listPaymentMethod"]);
      }
      
      $answer = ModelSales::mdlAddSale($table, $data);

      if($answer == "ok"){

        $profile = CapabilityProfile::load("POS-5890");
        $connector = new RawbtPrintConnector();
        $printer = new Printer($connector, $profile);
        $printer->text("please visit example.com\n");
        $printer->cut();
        $printer->pulse();
        $printer->close();

        echo '<script>
          // localStorage.removeItem("range");
          swal({
            type: "success",
            title: "お会計が完了しました。<br>おつりは'.number_format($_POST["newCashChange"]).'円です。",
            showConfirmButton: true,
            confirmButtonText: "閉じる",

          }).then(function(result){
            if(result.value){
              window.location = "create-sales";
            }
          })
        </script>';
      }
    }
  }

  //Edit sale
  static public function ctrEditSale(){
    if(isset($_POST["editSale"])){
      // 編集するレコードを指定
      $table = "sales";
      $item = "code";
      $value = $_POST["editSale"];
      $getSale = ModelSales::mdlShowSales($table, $item, $value);
      
      //Check if there's any editted sale 編集するsalesのレコードがあるか確認
      if($_POST["productsList"] == ""){
        $productsList = $getSale["products"];
        $productChange = false;
      } else {
        $productsList = $_POST["productsList"];
        $productChange = true;
      }
      // var_dump($productsList);

      if($productChange){
        $products = json_decode($getSale["products"], true);
        $totalPurchasedProducts = array();
        foreach ($products as $key => $value) {
          array_push($totalPurchasedProducts, $value["quantity"]);

          if($products[$key]["id_2"] == "addProductSale"){ //serviceとproductを区別する条件
            $tableProducts = "products";
            $item = "id";
            $value1 = $value["id"];
            $order = "id";
            $getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $value1, $order);
  
            $item1a = "sales";
            $value1a = $getProduct["sales"] - $value["quantity"];
            $newSales = ProductsModel::mdlShowProducts($tableProducts, $item1a, $value1a, $value); 
          } else {
            $tableServices = "services";
            $item = "id";
            $value1 = $value["id"];
            $order = "id";
            $getProduct = ServicesModel::mdlShowServices($tableServices, $item, $value1, $order);
  
            $item1a = "sales";
            $value1a = $getProduct["sales"] - $value["quantity"];
            $newSales = servicesModel::mdlUpdateService($tableServices, $item1a, $value1a, $value); 
          }
               
          
        }
        $tableCustomers = "customers";
        $item = "id";
        $valueCustomer = $_POST["selectCustomer"];
        $getCustomer = ModelCustomers::mdlShowCustomers($tableCustomers, $item, $valueCustomer);
        
        $item1a = "purchases";
        $value1a = $getCustomer["purchases"] - array_sum($totalPurchasedProducts);
        $customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item1a, $value1a, $valueCustomer);

        
        //Update the customer's purchases and reduce the stock and increment product sales
        $productsList_2 = json_decode($productsList, true);
        $totalPurchasedProducts_2 = array();
        foreach ($productsList_2 as $key => $value) {
          array_push($totalPurchasedProducts_2, $value["quantity"]);

          if($productsList_2[$key]["id_2"] == "addProductSale"){
            $tableProducts_2 = "products";
            $item_2 = "id";
            $value_2 = $value["id"];
            $order = "id";
            $getProduct_2 = ProductsModel::mdlShowProducts($tableProducts_2, $item_2, $value_2, $order);
  
            $item1a_2 = "sales";
            $value1a_2 = $value["quantity"] + $getProduct_2["sales"];
            $newSales_2 = ProductsModel::mdlUpdateProduct($tableProducts_2, $item1a_2, $value1a_2, $value_2);
          } else {
            $tableServices_2 = "services";
            $item_2 = "id";
            $value_2 = $value["id"];
            $order = "id";
            $getProduct_2 = ServicesModel::mdlShowServices($tableServices_2, $item_2, $value_2, $order);
  
            $item1a_2 = "sales";
            $value1a_2 = $value["quantity"] + $getProduct_2["sales"];
            $newSales_2 = ServicesModel::mdlUpdateServices($tableServices_2, $item1a_2, $value1a_2, $value_2);
          }
        }
        $tableCustomers_2 = "customers";
        $item_2 = "id";
        $value_2 = $_POST["selectCustomer"];
        $getCustomer_2 = ModelCustomers::mdlShowCustomers($tableCustomers_2, $item_2, $value_2);

        $item1a_2 = "purchases";
        $value1a_2 = array_sum($totalPurchasedProducts_2) + $getCustomer_2["purchases"];
        $customerPurchases_2 = ModelCustomers::mdlUpdateCustomer($tableCustomers_2, $item1a_2, $value1a_2, $value_2);

        $item1b_2 = "lastPurchase";
        date_default_timezone_set('Asia/Tokyo');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $value1b_2 = $date.' '.$hour;
        $dateCustomer_2 = ModelCustomers::mdlUpdateCustomer($tableCustomers_2, $item1b_2, $value1b_2, $value_2);  
      }

      
      // Product sum price
      preg_match_all('/"id_2":"(\w+)/', $productsList, $match_id2);
      preg_match_all('/"totalPrice":"(\w+)/', $productsList, $match_totalPrice);
      $product_sum_price = [];
      for($i=0; $i<count($match_id2[1]); $i++){
        if($match_id2[1][$i] == "addProductSale"){
          array_push($product_sum_price, $match_totalPrice[1][$i]);
        }
      }
      $productSumPrice = array_sum($product_sum_price); 

      //Save purchase changes
      if(preg_match('/"id_2":"addProductSale"/', $productsList)){//もし商品だったら（サービスじゃなかったら）
      $data = array("idSeller" => $_POST["idSeller"],
                    "idCustomer" => $_POST["selectCustomer"],
                    "code" => $_POST["editSale"],
                    "products" => $productsList,
                    "tax" => $_POST["newTaxPrice"],
                    "netPrice" => $_POST["newNetPrice"],
                    "totalPrice" => $_POST["saleTotal"],
                    "paymentMethod" => $_POST["listPaymentMethod"],
                    "product_sales" => $productSumPrice);//ここだけ追加;
      } else {
      $data = array("idSeller" => $_POST["idSeller"],
                    "idCustomer" => $_POST["selectCustomer"],
                    "code" => $_POST["editSale"],
                    "products" => $productsList,
                    "tax" => $_POST["newTaxPrice"],
                    "netPrice" => $_POST["newNetPrice"],
                    "totalPrice" => $_POST["saleTotal"],
                    "paymentMethod" => $_POST["listPaymentMethod"]);
      }
                    
      $answer = ModelSales::mdlEditSale($table, $data);
      if($answer == "ok"){
        echo '<script>
          localStorage.removeItem("range");
          swal({
            type: "success",
            title: "売上が編集されました",
            showConfirmButton: true,
            confirmButtonText: "閉じる"
          }).then(function(result){
            if(result.value){
              window.location = "manage-sales"
            }
          })
        </script>';
      }  
    }
  }

  //Edit just 1 sale's memo
  static public function ctrEditOnlySalesMemo(){
    // $item = "id";
    // $value = $_GET["idSale"];
    // $order = "id";
    // $sales = ControllerSales::ctrShowSales($item, $value, $order);
    // var_dump($_POST["value"]);

    if(isset($_POST["editOnlySalesMemo"])){
      $table = "sales";
      $data = array("id"=>$_POST["idSale"],
                    "memo"=>$_POST["editOnlySalesMemo"]);
      $answer = ModelSales::mdlEditOnlySalesMemo($table, $data);

      if($answer = 'ok'){
        echo '<script>
          swal ({
            type:"success",
            title:"メモは編集されました",
            showConfirmButton: true,
            confirmButtonText: "閉じる"
          }).then(function(result){
            if(result.value){
              window.location = "index.php?route=customer-details&id='.$_GET["id"].'";
            }
          })
        </script>';
      }
    }
  }

  //Delete sale
  static public function ctrDeleteSale(){
    if(isset($_GET["idSale"])){
      $table = "sales";
      $item = "id";
      $value = $_GET["idSale"];
      $getSale = ModelSales::mdlShowSales($table,$item,$value);
      // var_dump($getSale);

      //Update last purchase date
      $tableCustomers = "customers";
			$itemsales = null;
			$valuesales = null;
			$getSales = ModelSales::mdlShowSales($table, $itemsales, $valuesales);

			$saveDates = array();
			foreach ($getSales as $key => $value) {			
				if($value["idCustomer"] == $getSale["idCustomer"]){
					array_push($saveDates, $value["sell_date"]);
        }
      }

      if(count($saveDates) > 1){
				if($getSale["sell_date"] > $saveDates[count($saveDates)-2]){
					$item = "lastPurchase";
					$value = $saveDates[count($saveDates)-2];
					$valueIdCustomer = $getSale["idCustomer"];
					$customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item, $value, $valueIdCustomer);
				}else{
					$item = "lastPurchase";
					$value = $saveDates[count($saveDates)-1];
					$valueIdCustomer = $getSale["idCustomer"];
					$customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item, $value, $valueIdCustomer);
				}

      } else {
        $item = "lastPurchase";
				$value = "0000-00-00 00:00:00";
				$valueIdCustomer = $getSale["idCustomer"];
				$customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item, $value, $valueIdCustomer);
      }

      //Format products and customer table
      $products =  json_decode($getSale["products"], true);
			$totalPurchasedProducts = array();

      foreach ($products as $key => $value) {
				array_push($totalPurchasedProducts, $value["quantity"]);

        if($products[$key]["id_2"] == "addProductSale"){
          $tableProducts = "products";
          $item = "id";
          $valueProductId = $value["id"];
          $order = "id";
          $getProduct = ProductsModel::mdlShowProducts($tableProducts, $item, $valueProductId, $order);
  
          $item1a = "sales";
          $value1a = $getProduct["sales"] - $value["quantity"];
          $newSales = ProductsModel::mdlUpdateProduct($tableProducts, $item1a, $value1a, $valueProductId);
        } else {
          $tableServices = "services";
          $item = "id";
          $valueServiceId = $value["id"];
          $order = "id";
          $getService = ServicesModel::mdlShowServices($tableServices, $item, $valueServiceId, $order);
  
          $item1a = "sales";
          $value1aa = $getService["sales"] - $value["quantity"];
          $newSales = ServicesModel::mdlUpdateServices($tableServices, $item1a, $value1aa, $valueServiceId);
        }
			}

      $tableCustomers = "customers";
			$itemCustomer = "id";
			$valueCustomer = $getSale["idCustomer"];
			$getCustomer = ModelCustomers::mdlShowCustomers($tableCustomers, $itemCustomer, $valueCustomer);

			$item1a = "purchases";
			$value1a = $getCustomer["purchases"] - array_sum($totalPurchasedProducts);
			$customerPurchases = ModelCustomers::mdlUpdateCustomer($tableCustomers, $item1a, $value1a, $valueCustomer);
      
      //Delete Sale
      $answer = ModelSales::mdlDeleteSale($table, $_GET["idSale"]);
      if($answer == 'ok'){
        echo'<script>
				swal({
					  type: "success",
					  title: "この売上を削除しました",
					  showConfirmButton: true,
					  confirmButtonText: "閉じる",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {
								window.location = "manage-sales";
								}
							})
				</script>';
        
      }
    }
  }
  
  //Dates range
  static public function ctrSalesDatesRange($initialDate, $finalDate){
    $table = "sales";
    $answer = ModelSales::mdlSalesDatesRange($table, $initialDate, $finalDate);
    return $answer;
  }

  //Download exel
  public function ctrDownloadReport(){
    if(isset($_GET["report"])){
      $table = "sales";
      
      if(isset($_GET["initialDate"]) && isset($_GET["finalDate"])){
        $sales = ModelSales::mdlSalesDatesRange($table, $_GET["initialDate"], $_GET["finalDate"]);
      } else {
        $item = null;
        $value = null;
        $sales = ModelSales::mdlShowSales($table, $item, $value);
      }

      //Create excel file
      $name = $_GET["report"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); // Excel file
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$name.'"');
			header("Content-Transfer-Encoding: binary");

      $sample = "<table border='0'> 
      <tr> 
      <td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
      <td style='font-weight:bold; border:1px solid #eee;'>customer</td>
      <td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
      <td style='font-weight:bold; border:1px solid #eee;'>quantity</td>
      <td style='font-weight:bold; border:1px solid #eee;'>products</td>
      <td style='font-weight:bold; border:1px solid #eee;'>tax</td>
      <td style='font-weight:bold; border:1px solid #eee;'>netPrice</td>		
      <td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
      <td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
      <td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
      </tr>
      </table>";

      echo $sample;

      // foreach ($sales as $row => $item) {
      //   $customer = ControllerCustomers::ctrShowCustomers("id", $item["idCustomer"]);
      //   $vender = ControllerUsers::ctrShowUsers("id", $item["idSeller"]);
      // }

      // // var_dump($vender);
      // echo "$item['code']"
    }
  }

  //Adding total sales
  static public function ctrAddingTotalSales(){
    $table = "sales";
    $answer = ModelSales::mdlAddingTotalSales($table);
    return $answer;
  }

  //Adding total this month sales（今月分だけ）
  static public function ctrAddingTotalThisMonthSales(){
    $table = "sales";
    $answer = ModelSales::mdlAddingTotalThisMonthSales($table);
    return $answer;
  }

  //Adding total this month products sales（今月の商品売上）
  static public function ctrAddingTotalThisMonthProductsSales(){
    $table = "sales";
    $answer = ModelSales::mdlAddingTotalThisMonthProductsSales($table);
    return $answer;
  }

  //Adding total sales in specific period（特定の期間の売上の合計）
  static public function ctrTest(){
    $table = "sales";
    $answer = ModelSales::mdlTest($table, $initialDate, $finalDate);
    return $answer;
  }

  //日別の売上
  static public function ctrDailySales($initialDate, $finalDate){
    $table = "sales";
    $answer = ModelSales::mdlDailySales($table, $initialDate, $finalDate);
    return $answer;
  }
  
}
