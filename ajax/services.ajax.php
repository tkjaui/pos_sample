<?php

require_once "../controllers/services.controller.php";
require_once "../models/services.model.php";

class AjaxServices{
  //Generate code from id category
  public $idCategory;
  public function ajaxCreateServiceCode(){
    $item = "id_category";
    $value = $this->idCategory;
    $order = "id";
    $answer = ControllerServices::ctrShowServices($item, $value, $order);
    echo json_encode($answer);
  }

  //Edit product
  public $idService;
  public $getServices;
  public $serviceName;

  public function ajaxEditService(){
    if($this->getServices == 'ok'){
      $item = null;
      $value = null;
      $order = "id";
      $answer = controllerServices::ctrShowServices($item, $value, $order);
      echo json_encode($answer);
    } else if($this->serviceName != ""){
      $item = "description";
      $value = $this->serviceName;
      $order = "id";
      $answer = controllerServices::ctrShowServices($item, $value, $order);
      echo json_encode($answer);
    } else {
      $item = "id";
      $value = $this->idService;
      $order = "id";
      $answer = controllerServices::ctrShowServices($item, $value, $order);
      echo json_encode($answer);
    }
  }
}


//Generate code from id category
if(isset($_POST["idCategory"])){
	$serviceCode = new AjaxServices();
	$serviceCode -> idCategory = $_POST["idCategory"];
	$serviceCode -> ajaxCreateServiceCode();
}

//Edit product
if(isset($_POST["idService"])){
  $editService = new AjaxServices();
  $editService -> idService = $_POST["idService"];
  $editService -> ajaxEditService();
}

//Get product
if(isset($_POST["getServices"])){
  $getServices = new AjaxServices();
  $getServices -> getServices = $_POST["getServices"];
  $getServices -> ajaxEditService();
}

//Get product Name
if(isset($_POST["serviceName"])){
  $getServices = new AjaxServices();
  $getServices -> serviceName = $_POST["serviceName"];
  $getServices -> ajaxEditService();
}