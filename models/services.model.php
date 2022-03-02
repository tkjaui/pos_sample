<?php
require_once 'connection.php';

class ServicesModel{
  //Show Services
  static public function mdlShowServices($table, $item, $value, $order){
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

  //Show Services from regi
  static public function mdlShowServicesFromRegi($table, $item, $value, $order){
    if($item != null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id ASC");
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

  //Add Services
  static public function mdlAddServices($table, $data){
    $stmt = Connection::connect()->prepare("INSERT INTO $table(id_category, code, description, selling_price) VALUES (:id_category, :code, :description, :selling_price)");

    $stmt -> bindParam(":id_category", $data["id_category"], PDO::PARAM_INT);
    $stmt -> bindParam(":code", $data["code"], PDO::PARAM_STR);
    $stmt -> bindParam(":description", $data["description"], PDO::PARAM_STR);
    $stmt -> bindParam(":selling_price", $data["selling_price"], PDO::PARAM_STR);

    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
      
    
  }

  //Edit Services
  static public function mdlEditServices($table, $data){
    try{
      $stmt = Connection::connect()->prepare("UPDATE $table SET id_category = :id_category, description = :description, selling_price = :selling_price WHERE code = :code");
      $stmt -> bindParam(":id_category", $data["id_category"], PDO::PARAM_INT);
      $stmt -> bindParam(":code", $data["code"], PDO::PARAM_STR);
      $stmt -> bindParam(":description", $data["description"], PDO::PARAM_STR);
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
  static public function mdlDeleteServices($table, $data){
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
  static public function mdlUpdateServices($table, $item1, $value1, $value){
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

  //Update services
  static public function mdlUpdateService($table, $item1, $value1, $value){
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
}