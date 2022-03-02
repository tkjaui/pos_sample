<?php
require_once "../controllers/categories.controller.php";
require_once "../models/categories.model.php";

class AjaxCategories{
  //Edit category
  public $idCategory;
  public function ajaxEditCategory(){
    $item = "id";
    $value = $this->idCategory;
    $answer = ControllerCategories::ctrShowCategories($item, $value);
    echo json_encode($answer);
  }
}

// Edit Category
if(isset($_POST["idCategory"])){
  $category = new AjaxCategories();
  $category -> idCategory = $_POST["idCategory"];
  $category -> ajaxEditCategory();
}