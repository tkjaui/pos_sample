<?php
require_once "connection.php";

class ModelSales{
  //Show sales 
  static public function mdlShowSales($table, $item, $value){
    if($item != null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id ASC");
      $stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
    } else {
      $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id ASC");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }
    $stmt -> close();
    $stmt = null;
  }
  

  //Register sale
  static public function mdlAddSale($table, $data){
    $stmt = Connection::connect()->prepare("INSERT INTO $table(code, idCustomer, idSeller, products, tax, netPrice, totalPrice, paymentMethod, product_sales) VALUES (:code, :idCustomer, :idSeller, :products, :tax, :netPrice, :totalPrice, :paymentMethod, :product_sales)");

    $stmt -> bindParam(":code", $data["code"], PDO::PARAM_INT);
    $stmt -> bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
    $stmt -> bindParam(":idSeller", $data["idSeller"], PDO::PARAM_INT);
    $stmt -> bindParam(":products", $data["products"], PDO::PARAM_STR);
    $stmt -> bindParam(":tax", $data["tax"], PDO::PARAM_STR);
    $stmt -> bindParam(":netPrice", $data["netPrice"], PDO::PARAM_STR);
    $stmt -> bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
    $stmt -> bindParam(":paymentMethod", $data["paymentMethod"], PDO::PARAM_STR);
    $stmt -> bindParam(":product_sales", $data["product_sales"], PDO::PARAM_STR);

    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
  }

  //Edit sales
  static public function mdlEditSale($table, $data){
    $stmt = Connection::connect()->prepare("UPDATE $table SET idCustomer = :idCustomer, idSeller = :idSeller, products = :products, tax = :tax, netPrice = :netPrice, totalPrice = :totalPrice, paymentMethod = :paymentMethod, product_sales = :product_sales WHERE code = :code");
    
    $stmt -> bindParam(":code", $data["code"], PDO::PARAM_INT);
    $stmt -> bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
    $stmt -> bindParam(":idSeller", $data["idSeller"], PDO::PARAM_INT);
    $stmt -> bindParam(":products", $data["products"], PDO::PARAM_STR);
    $stmt -> bindParam(":tax", $data["tax"], PDO::PARAM_STR);
    $stmt -> bindParam(":netPrice", $data["netPrice"], PDO::PARAM_STR);
    $stmt -> bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
    $stmt -> bindParam(":paymentMethod", $data["paymentMethod"], PDO::PARAM_STR);
    $stmt -> bindParam(":product_sales", $data["product_sales"], PDO::PARAM_STR);

    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
  }

  //Edit just 1 customer's memo
  static public function mdlEditOnlySalesMemo($table, $data){
    $stmt = Connection::connect()->prepare("UPDATE $table SET memo = :memo WHERE id = :id");
    
    $stmt -> bindParam(":id", $data["id"], PDO::PARAM_INT);
    $stmt -> bindParam(":memo", $data["memo"], PDO::PARAM_STR);

    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
  }

  //Delete sales
  static public function mdlDeleteSale($table, $data){
    $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
    $stmt -> bindParam(":id", $data, PDO::PARAM_INT);
    if($stmt -> execute()){
      return 'ok';
    } else {
      return 'error';
    }
    $stmt -> close();
    $stmt = null;
  }  

  //Dates range
  static public function mdlSalesDatesRange($table, $initialDate, $finalDate){
    if($initialDate == null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY sell_date ASC");
      $stmt -> execute();
      return $stmt -> fetchAll();
    } else if($initialDate == $finalDate){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sell_date like '%$finalDate%'");
      $stmt -> execute();
      return $stmt -> fetchAll();
    } else {
      $actualDate = new DateTime();
      $actualDate -> add(new DateInterval("P1D"));
      $actualDatePlusOne = $actualDate -> format("Y-m-d");

      $finalDate2 = new DateTime($finalDate);
      $finalDate2 -> add(new DateInterval("P1D"));
      $finalDatePlusOne = $finalDate2 -> format("Y-m-d");

      if($finalDatePlusOne == $actualDatePlusOne){
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sell_date BETWEEN '$initialDate' AND '$finalDatePlusOne' ORDER BY sell_date ASC");
      } else {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sell_date BETWEEN '$initialDate' AND '$finalDate' ORDER BY sell_date ASC");
      }

      $stmt -> execute();
      return $stmt -> fetchAll();
    }
  }

  //Adding total sales
  static public function mdlAddingTotalSales($table){
    $stmt = Connection::connect()->prepare("SELECT SUM(totalPrice) as total FROM $table");
    $stmt -> execute();
    return $stmt -> fetch();
    $stmt -> close();
    $stmt = null;
  }

  //Adding total this month sales（今月だけ）本サンプルは2022年2月のデータ
  static public function mdlAddingTotalThisMonthSales($table){
    $stmt = Connection::connect()->prepare("SELECT SUM(totalPrice) as total_this_month FROM $table WHERE sell_date between '2022-02-01' and '2022-02-28'");
    $stmt -> execute();
    return $stmt -> fetch();
    $stmt -> close();
    $stmt = null;
  }

  //Adding total this month products sales（今月の商品売上）本サンプルは2022年2月のデータ
  static public function mdlAddingTotalThisMonthProductsSales($table){
    $stmt = Connection::connect()->prepare("SELECT SUM(product_sales) as total FROM $table WHERE sell_date between '2022-02-01' and '2022-02-28'");
    $stmt -> execute();
    return $stmt -> fetch();
    $stmt -> close();
    $stmt = null;
  }

  //Adding total sales in specific period（特定の期間の売上の合計）
  static public function mdlTest($table, $initialDate, $finalDate){
    if($initialDate == null){//なぜかinitialdateがnullになってる
      $stmt = Connection::connect()->prepare("SELECT sum(totalPrice),sum(product_sales),count(totalPrice) FROM $table");
      $stmt -> execute();
      return $stmt -> fetch();
    } else if($initialDate == $finalDate){
      $stmt = Connection::connect()->prepare("SELECT sum(totalPrice),sum(product_sales),count(totalPrice) FROM $table WHERE sell_date like '%$finalDate%'");
      $stmt -> execute();
      return $stmt -> fetch();
    } else {
      $actualDate = new DateTime();
      $actualDate -> add(new DateInterval("P1D"));
      $actualDatePlusOne = $actualDate -> format("Y-m-d");

      $finalDate2 = new DateTime($finalDate);
      $finalDate2 -> add(new DateInterval("P1D"));
      $finalDatePlusOne = $finalDate2 -> format("Y-m-d");

      if($finalDatePlusOne == $actualDatePlusOne){
        $stmt = Connection::connect()->prepare("SELECT SUM(totalPrice) FROM $table WHERE sell_date BETWEEN '$initialDate' AND '$finalDatePlusOne'");
      } else {
        $stmt = Connection::connect()->prepare("SELECT SUM(totalPrice) FROM $table WHERE sell_date BETWEEN '$initialDate' AND '$finalDate'");
      }

      $stmt -> execute();
      return $stmt -> fetch();
    }

    $stmt -> close();
    $stmt = null;
  }

  //日別の売上
  static public function mdlDailySales($table, $initialDate, $finalDate){ 
    if($initialDate == null){
      $stmt = Connection::connect()->prepare(
      "SELECT date_format(sell_date,'%Y-%m-%d') as date ,sum(totalPrice),sum(product_sales),count(totalPrice) 
        -- IFNULL(date,0)
        FROM $table 
        GROUP BY date_format(sell_date,'%Y-%m-%d') WITH ROLLUP");
      $stmt -> execute();
      return $stmt -> fetchAll();
    } else if($initialDate == $finalDate){ 
      $stmt = Connection::connect()->prepare(
        "SELECT date_format(sell_date,'%Y-%m-%d') as date,sum(totalPrice),sum(product_sales),count(totalPrice) 
        -- IFNULL(date_format(sell_date,'%Y-%m-%d'),0)
        FROM $table 
        WHERE sell_date like '%$finalDate%' 
        GROUP BY date_format(sell_date,'%Y-%m-%d') WITH ROLLUP");
      $stmt -> execute();
      return $stmt -> fetchAll();
    } else { 
      $actualDate = new DateTime();
      $actualDate -> add(new DateInterval("P1D"));
      $actualDatePlusOne = $actualDate -> format("Ymd");

      $finalDate2 = new DateTime($finalDate);
      $finalDate2 -> add(new DateInterval("P1D"));
      $finalDatePlusOne = $finalDate2 -> format("Ymd");

      $initialDate = new DateTime($initialDate);
      $initialDate2 = $initialDate -> format("Ymd");

      $finalDate = new DateTime($finalDate);
      $finalDate2 = $finalDate -> format("Ymd");

      if($finalDatePlusOne == $actualDatePlusOne){
        $stmt = Connection::connect()->prepare("SELECT date_format(sell_date,'%Y-%m-%d') as date,sum(totalPrice),sum(product_sales),count(totalPrice) FROM $table WHERE sell_date between $initialDate2 and $finalDatePlusOne GROUP BY date_format(sell_date,'%Y-%m-%d') WITH ROLLUP");
      } else {
        $stmt = Connection::connect()->prepare("SELECT date_format(sell_date,'%Y-%m-%d') as date,sum(totalPrice),sum(product_sales),count(totalPrice) FROM $table WHERE sell_date between $initialDate2 and $finalDate2 GROUP BY date_format(sell_date,'%Y-%m-%d') WITH ROLLUP");
      }
      $stmt -> execute();
      return $stmt -> fetchAll();
    }

    $stmt -> close();
    $stmt = null;
  }


}