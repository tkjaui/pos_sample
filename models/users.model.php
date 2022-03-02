<?php

require_once "connection.php";

class UsersModel{
  static public function MdlShowUsers($table, $item, $value){
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

  static public function MdlAddUser($table, $data){
    $stmt = Connection::connect()->prepare("INSERT INTO $table(name, password, profile, photo) VALUES (:name, :password, :profile, :photo)");
       
    try {
      $stmt -> bindParam(":name", $data["name"], PDO::PARAM_STR);
      $stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
      $stmt -> bindParam(":profile", $data["profile"], PDO::PARAM_STR);
      $stmt -> bindParam(":photo", $data["photo"], PDO::PARAM_STR);
  
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'error';
      }
      
      $stmt -> close();
      $stmt = null;
    }
    catch(Exception $e){
      echo $e;
    };
  }

  static public function MdlEditUser($table, $data){  
    try{   
      $stmt = Connection::connect()->prepare("UPDATE $table set password = :password, profile = :profile, photo = :photo WHERE name = :name");  
      $stmt -> bindParam(":name", $data["name"], PDO::PARAM_STR);
      $stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
      $stmt -> bindParam(":profile", $data["profile"], PDO::PARAM_STR);
      $stmt -> bindParam(":photo", $data["photo"], PDO::PARAM_STR);
      
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'error';
      }

      $stmt -> close();
      $stmt = null;
    }
    catch(Exception $e){
      echo $e;
    };
  } 

  // updata user
  static public function mdlUpdateUser($table, $item1, $value1, $item2, $value2){
		$stmt = Connection::connect()->prepare("UPDATE $table set $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $value1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $value2, PDO::PARAM_STR);

		if ($stmt->execute()) {		
			return 'ok';
		} else {
			return 'error';	
		}
		
		$stmt -> close();
		$stmt = null;
	}

  //delete user
  static public function mdlDeleteUser($table, $data){
    $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
    $stmt -> bindParam(":id", $data, PDO::PARAM_STR);

    if($stmt->execute()){
      return 'ok';
    } else {
      return 'error';
    }

    $stmt -> close();
    $stmt = null;
  }

}