<?php

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

require_once "../controllers/categories.controller.php";
require_once "../models/categories.model.php";

class productsTable{
  // Show products table
  public function showProductsTable(){
    $item = null;
    $value = null;
    $order = "id";
    $products = ControllerProducts::ctrShowProducts($item, $value, $order);

    // var_dump($products);
    
    $jsonData = '{
      "data": [';
      for($i=0; $i<count($products); $i++){
        //Image
        $image = "<img src='".$products[$i]["image"]."' width='40px'>";

        
        //Action buttons
        if(isset($_GET["hiddenProfile"]) && $_GET["hiddenProfile"] != "管理者"){
          $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditProduct' idProduct='".$products[$i]["id"]."' data-toggle='modal' data-target='#modalEditProduct'><i class='fa fa-pencil'></i></button>";
        } else {
          $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditProduct' idProduct='".$products[$i]["id"]."' data-toggle='modal' data-target='#modalEditProduct'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteProduct' idProduct='".$products[$i]["id"]."' code='".$products[$i]["code"]."' image='".$products[$i]["image"]."'><i class='fa fa-times'></i></button></div>";
        }
        
        
        //bring the category
        $item = "id";
        $value = $products[$i]["id_category"];
        $categories = ControllerCategories::ctrShowCategories($item, $value);

        $jsonData .='[
          "'.($i+1).'",
          "'.$image.'",
          "'.$products[$i]["code"].'",
          "'.$products[$i]["description"].'",
          "'.$categories["Category"].'",
          "'.number_format($products[$i]["buying_price"]).' 円",
          "'.number_format($products[$i]["selling_price"]).' 円",
          "'.$products[$i]["date"].'",
          "'.$buttons.'"
        ],';
      }

      $jsonData = substr($jsonData, 0, -1);
    $jsonData .= ']
    }';

    echo $jsonData;   
  }
}

// Activate products table
$activateProducts = new productsTable();
$activateProducts -> showProductsTable();