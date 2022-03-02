<?php

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

class AjaxProducts{
  //Generate code from id category
  public $idCategory;
  public function ajaxCreateProductCode(){
    $item = "id_category";
    $value = $this->idCategory;
    $order = "id";
    $answer = ControllerProducts::ctrShowProducts($item, $value, $order);
    echo json_encode($answer);
  }

  //Edit product
  public $idProduct;
  public $getProducts;
  public $productName;

  public function ajaxEditProduct(){
    if($this->getProducts == 'ok'){
      $item = null;
      $value = null;
      $order = "id";
      $answer = controllerProducts::ctrShowProducts($item, $value, $order);
      echo json_encode($answer);
    } else if($this->productName != ""){
      $item = "description";
      $value = $this->productName;
      $order = "id";
      $answer = controllerProducts::ctrShowProducts($item, $value, $order);
      echo json_encode($answer);
    } else {
      $item = "id";
      $value = $this->idProduct;
      $order = "id";
      $answer = controllerProducts::ctrShowProducts($item, $value, $order);
      echo json_encode($answer);
    }
  }
}


//Generate code from id category

if(isset($_POST["idCategory"])){
	$productCode = new AjaxProducts();
	$productCode -> idCategory = $_POST["idCategory"];
	$productCode -> ajaxCreateProductCode();
}

//Edit product
if(isset($_POST["idProduct"])){
  $editProduct = new AjaxProducts();
  $editProduct -> idProduct = $_POST["idProduct"];
  $editProduct -> ajaxEditProduct();
}

//Get product
if(isset($_POST["getProducts"])){
  $getProducts = new AjaxProducts();
  $getProducts -> getProducts = $_POST["getProducts"];
  $getProducts -> ajaxEditProduct();
}

//Get product Name
if(isset($_POST["productName"])){
  $getProducts = new AjaxProducts();
  $getProducts -> productName = $_POST["productName"];
  $getProducts -> ajaxEditProduct();
}