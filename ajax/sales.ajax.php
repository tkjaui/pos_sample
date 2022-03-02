<?php

require_once "../controllers/sales.controller.php";
require_once "../models/sales.model.php";

class AjaxSales{
  public $idSale;
  public function ajaxEditSale(){
    $item = "id";
    $value = $this -> idSale;
    $answer = ControllerSales::ctrShowSales($item, $value);
    echo json_encode($answer);
  }
}

if(isset($_POST["idSale"])){
  $Sales = new AjaxSales();
  $Sales -> idSale = $_POST["idSale"];
  $Sales -> ajaxEditSale();
}