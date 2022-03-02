<?php
require_once "../controllers/services.controller.php";
require_once "../models/services.model.php";

require_once "../controllers/categories.controller.php";
require_once "../models/categories.model.php";

class ServicesTable{
  // Show services table
  public function showServicesTable(){
    $item = null;
    $value = null;
    $order = "id";
    $services = ControllerServices::ctrShowServices($item, $value, $order);

  
    // var_dump($services);
    
    
    $jsonData = '{
      "data": [';
      for($i=0; $i<count($services); $i++){
        //Action buttons
        if(isset($_GET["hiddenProfile"]) && $_GET["hiddenProfile"] != "管理者"){
          $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditService' idService='".$services[$i]["id"]."' data-toggle='modal' data-target='#modalEditService'><i class='fa fa-pencil'></i></button>";
        } else {
          $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditService' idService='".$services[$i]["id"]."' data-toggle='modal' data-target='#modalEditService'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteService' idService='".$services[$i]["id"]."' code='".$services[$i]["code"]."'><i class='fa fa-times'></i></button></div>";
        }
        
        
        //bring the category
        $item = "id";
        $value = $services[$i]["id_category"];
        $categories = ControllerCategories::ctrShowCategories($item, $value);

        // $str = $services[$i]["description"];
        // $charArys = array('UTF-8', 'eucJP-win', 'SJIS-win', 'ASCII', 'EUC-JP', 'SJIS', 'JIS');
        // $charCode = mb_detect_encoding($str, $charArys, true);
        // var_dump($charCode);

        $jsonData .='[
          "'.($i+1).'",
          "'.$services[$i]["code"].'",
          "'.$services[$i]["description"].'",
          "'.$categories["Category"].'",
          "'.number_format($services[$i]["selling_price"]).'円",
          "'.$services[$i]["date"].'",
          "'.$buttons.'"
        ],';
      }

      $jsonData = substr($jsonData, 0, -1);
    $jsonData .= ']
    }';

    echo $jsonData;   
  }
}

// Activate services table
$activateServices = new ServicesTable();
$activateServices -> showServicesTable();