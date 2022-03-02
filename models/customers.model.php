<?php

require_once "connection.php";

class ModelCustomers{
  //Show customer
  static public function mdlShowCustomers($table, $item, $value){
    if($item != null){
      $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
      $stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
      $stmt -> execute();
      return $stmt -> fetch();
    } else {
      $stmt = Connection::connect()->prepare("SELECT * FROM $table");
      $stmt -> execute();
      return $stmt -> fetchAll();
    }
    $stmt -> close();
    $stmt = null;
  }

  //Create customer
  static public function mdlCreateCustomers($table, $data){
   $stmt = Connection::connect()->prepare("INSERT INTO $table(name, email, phone, address, birthdate, memo, sex) VALUES (:name, :email, :phone, :address, :birthdate, :memo, :sex)");

   $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
   $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
   $stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
   $stmt->bindParam(":address", $data["address"], PDO::PARAM_STR);
   $stmt->bindParam(":birthdate", $data["birthdate"], PDO::PARAM_STR);
   $stmt->bindParam(":memo", $data["memo"], PDO::PARAM_STR);
   $stmt->bindParam(":sex", $data["sex"], PDO::PARAM_STR);

   if($stmt->execute()){
     return 'ok';
   } else { 
     return 'error';
   }

   $stmt -> close();
   $stmt = null;
  }

  //Edit customer
  static public function mdlEditCustomers($table, $data){
    $stmt = Connection::connect()->prepare("UPDATE $table SET name = :name, email = :email, phone = :phone, address = :address, birthdate = :birthdate, memo = :memo, sex = :sex WHERE id = :id");

    $stmt -> bindParam(":id", $data["id"], PDO::PARAM_INT);
    $stmt -> bindParam(":name", $data["name"], PDO::PARAM_STR);
    $stmt -> bindParam(":email", $data["email"], PDO::PARAM_STR);
    $stmt -> bindParam(":phone", $data["phone"], PDO::PARAM_STR);
    $stmt -> bindParam(":address", $data["address"], PDO::PARAM_STR);
    $stmt -> bindParam(":birthdate", $data["birthdate"], PDO::PARAM_STR);
    $stmt -> bindParam(":memo", $data["memo"], PDO::PARAM_STR);
    $stmt -> bindParam(":sex", $data["sex"], PDO::PARAM_STR);


    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;

  }

  //Edit just 1 customer's memo
  static public function mdlEditOnlyCustomersMemo($table, $data){
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

  //Delete customer
  static public function mdlDeleteCutomers($table, $data){
    $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

    $stmt -> bindParam(":id", $data, PDO::PARAM_STR);

    if($stmt -> execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
  }

  //Update customer
  static public function mdlUpdateCustomer($table, $item1, $value1, $value){
    $stmt = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE id = :id");
    $stmt -> bindParam(":".$item1, $value1, PDO::PARAM_STR);
    $stmt -> bindParam(":id", $value, PDO::PARAM_STR);
    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }
    $stmt -> close();
    $stmt = null;
  }
}