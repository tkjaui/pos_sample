<?php

class Connection{
  static public function connect(){
    $dsn = "mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_59790a943051eee";
    $user = "bb1cc48289a8ae";
    $password = "0dbbd5f2";

    try{
      $link = new PDO($dsn, $user, $password);
      $link -> exec("set names utf8");
      return $link;
    }
    catch(¥Exception $e){
      echo $e->getMessage();
    }
    // finally {
    //   echo 'finally';
    // }
    
  }
}