<?php

require_once 'connection.php';

class productsModel{
  //Show products
  static public function mdlShowProducts($table, $item, $value, $order){
    if($item != null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");
      $stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
    } else {
      $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY $order DESC");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }
    $stmt -> close();
    $stmt = null;
  }

  
  //Show products from regi
  static public function mdlShowProductsFromRegi($table, $item, $value, $order){
    if($item != null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");
      $stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetchAll();
    } else {
      $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY $order DESC");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }
    $stmt -> close();
    $stmt = null;
  }

  //Add products
  static public function mdlAddProducts($table, $data){
    try{
      $stmt = Connection::connect()->prepare("INSERT INTO $table(id_category, code, description, image, buying_price, selling_price) VALUES (:id_category, :code, :description, :image, :buying_price, :selling_price)");
    
      $stmt -> bindParam(":id_category", $data["id_category"], PDO::PARAM_INT);
      $stmt -> bindParam(":code", $data["code"], PDO::PARAM_STR);
      $stmt -> bindParam(":description", $data["description"], PDO::PARAM_STR);
      $stmt -> bindParam(":image", $data["image"], PDO::PARAM_STR);
      $stmt -> bindParam(":buying_price", $data["buying_price"], PDO::PARAM_STR);
      $stmt -> bindParam(":selling_price", $data["selling_price"], PDO::PARAM_STR);
  
      if($stmt->execute()){
        return 'ok';
      } else {
        return 'error';
      }
  
      $stmt -> close();
      $stmt = null;
      
    }catch(Exception $e){
      echo $e;
    }; 
  }

  //Edit products
  static public function mdlEditProducts($table, $data){
    try{
      $stmt = Connection::connect()->prepare("UPDATE $table SET id_category = :id_category, description = :description, image = :image, buying_price = :buying_price, selling_price = :selling_price WHERE code = :code");
      $stmt -> bindParam(":id_category", $data["id_category"], PDO::PARAM_INT);
      $stmt -> bindParam(":code", $data["code"], PDO::PARAM_STR);
      $stmt -> bindParam(":description", $data["description"], PDO::PARAM_STR);
      $stmt -> bindParam(":image", $data["image"], PDO::PARAM_STR);
      $stmt -> bindParam(":buying_price", $data["buying_price"], PDO::PARAM_STR);
      $stmt -> bindParam(":selling_price", $data["selling_price"], PDO::PARAM_STR);
  
      if($stmt->execute()){
        return 'ok';
      } else {
        return 'error';
      }
  
      $stmt->close();
      $stmt = null;
    }
    catch (Exception $e){
      echo $e;
    }
  }

  //Delete product
  static public function mdlDeleteProducts($table, $data){
    try{
      $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
      $stmt -> bindParam(":id", $data, PDO::PARAM_STR);

      if($stmt->execute()){
        return 'ok';
      } else {
        return 'error';
      }

      $stmt -> close();
      $stmt = null;
    }catch(Execption $e){
      echo $e;
    }
  }

  //Update product
  static public function mdlUpdateProduct($table, $item1, $value1, $value){
    $stmt = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE id = :id");
    $stmt -> bindParam(":".$item1, $value1, PDO::PARAM_STR);
    $stmt -> bindParam(":id", $value, PDO::PARAM_STR);
    
    if($stmt -> execute()){
      return 'ok';
    } else {
      return 'error';
    }
    $stmt -> close();
    $stmt = null;
  }

  //Show adding of the sales
  static public function mdlShowAddingOfTheSales($table){
    $stmt = Connection::connect()->prepare("SELECT SUM(sales) as total FROM $table");
    $stmt -> execute();
    return $stmt -> fetch();
    $stmt -> close();
    $stmt = null;
  }
}