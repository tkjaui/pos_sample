<?php

class ControllerProducts{
  //Show Products
  static public function ctrShowProducts($item, $value, $order){
    $table = "products";
    $answer = productsModel::mdlShowProducts($table, $item, $value, $order);
    return $answer;
  }

  
  //Show Products from regi
  static public function ctrShowProductsFromRegi($item, $value, $order){
    $table = "products";
    $answer = productsModel::mdlShowProductsFromRegi($table, $item, $value, $order);
    return $answer;
  }
  

  //Create products
  static public function ctrCreateProducts(){
    if(isset($_POST["newDescription"])){
      if(preg_match('/^[0-9.-]+$/', $_POST["newBuyingPrice"])&&
         preg_match('/^[0-9.]+$/', $_POST["newSellingPrice"])){

          //Validate image
          $route = "views/img/products/default/anonymous.png";

          if(isset($_FILES["newProdPhoto"]["tmp_name"])){
            list($width, $height) = getimagesize($_FILES["newProdPhoto"]["tmp_name"]);
            $newWidth = 500;
            $newHeight = 500;

            //Create the folder
            $folder = "views/img/products/".$_POST["newCode_p"];
            mkdir($folder, 0755);

            //Apply default PHP functions according to the image target
            if($_FILES["newProdPhoto"]["type"] == "image/jpeg"){
              //Save the image in the folder
              $random = mt_rand(100,999);
              $route = "views/img/products/".$_POST["newCode_p"]."/".$random.".jpg";
              $origin = imagecreatefromjpeg($_FILES["newProdPhoto"]["tmp_name"]);
              $destiny = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destiny, $origin, 0,0,0,0, $newWidth, $newHeight, $width, $height);
              imagejpeg($destiny, $route);
            }

            if($_FILES["newProdPhoto"]["type"] == "image/png"){
              //Save the image in the folder
              $random = mt_rand(100,999);
              $route = "views/img/products/".$_POST["newCode_p"]."/".$random.".png";
              $origin = imagecreatefrompng($_FILES["newProdPhoto"]["tmp_name"]);
              $destiny = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destiny, $origin, 0,0,0,0, $newWidth, $newHeight, $width, $height);
              imagejpeg($destiny, $route);
            }
          }

          $table = "products";
          $data = array("id_category" => $_POST["newCategory"],
                        "code" => $_POST["newCode_p"],
                        "description" => $_POST["newDescription"],
                        "buying_price" => $_POST["newBuyingPrice"],
                        "selling_price" => $_POST["newSellingPrice"],
                        "image" => $route);
          $answer = productsModel::mdlAddProducts($table, $data);

          if($answer == 'ok'){
            echo '<script>
              swal({
                type: "success",
                title: "商品は保存されました",
                showConfirmButton: true,
                confirmButtonText: "閉じる"
              }).then(function(result){
                if(result.value){
                  window.location = "products";
                }
              })
            </script>';
          }

         } else {
           echo '<script>
            swal({
              type: "error",
              title: "特殊な文字や空欄は使えません。",
              showConfirmButton: true,
              confirmButtonText: "Close"
            }).then(function(result){
              if(result.value){
                window.location = "products";
              }
            })
           </script>';
         }
    }
  }

  //Edit product
  static public function ctrEditProducts(){
		if(isset($_POST["editDescription"])){
			if(preg_match('/^[0-9.-]+$/', $_POST["editBuyingPrice"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editSellingPrice"])){
          //  validate image
          $route = $_POST["currentImage"];
			   	if(isset($_FILES["editImage"]["tmp_name"]) && !empty($_FILES["editImage"]["tmp_name"])){
            list($width, $height) = getimagesize($_FILES["editImage"]["tmp_name"]);
            $newWidth = 500;
            $newHeight = 500;

            //Create folder
            $folder = "views/img/products/".$_POST["editCode"];

            //Ask if we have another picture in the DB
            if(!empty($_POST["currentImage"]) && $_POST["currentImage"] != "views/img/products/default/anonymous.png"){
              unlink($_POST["currentImage"]);
            }else{
              mkdir($folder, 0755);	
            }

            //apply default PHP function according to the image format
            if($_FILES["editImage"]["type"] == "image/jpeg"){
              //Save the image in the folder
              $random = mt_rand(100,999);
              $route = "views/img/products/".$_POST["editCode"]."/".$random.".jpg";
              $origin = imagecreatefromjpeg($_FILES["editImage"]["tmp_name"]);						
              $destiny = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              imagejpeg($destiny, $route);
            }
            if($_FILES["editImage"]["type"] == "image/png"){
              //Save the image in the folder
              $random = mt_rand(100,999);
              $route = "views/img/products/".$_POST["editCode"]."/".$random.".png";
              $origin = imagecreatefrompng($_FILES["editImage"]["tmp_name"]);
              $destiny = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              imagepng($destiny, $route);
          }
         }

         $table = "products";
         $data = array("id_category" => $_POST["editCategory"],
                       "code" => $_POST["editCode"],
                       "description" => $_POST["editDescription"],
                       "buying_price" => $_POST["editBuyingPrice"],
                       "selling_price" => $_POST["editSellingPrice"],
                       "image" => $route);
         $answer = productsModel::mdlEditProducts($table, $data);

         if($answer == 'ok'){
          echo'<script>
          swal({
              type: "success",
              title: "商品は編集されました",
              showConfirmButton: true,
              confirmButtonText: "閉じる"
              }).then(function(result){
                  if (result.value) {
                  window.location = "products";
                  }
                })
          </script>';
         }
    } else {
      echo'<script>
					swal({
						  type: "error",
						  title: "特殊な文字や空欄は使えません。",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {
							window.location = "products";
							}
						})
			  	</script>';
    }
  }
}

//Delete product
static public function ctrDeleteProducts(){
  if(isset($_GET["idProduct"])){
    $table = "products";
    $data = $_GET["idProduct"];

    if($_GET["image"] != "" && $_GET["image"] != "views/image/products/default/anonymous.png"){
      unlink($_GET["image"]);//ファイルを削除
      rmdir("views/image/products/".$_GET["code"]);//ディレクトリ削除
    }

    $answer = productsModel::mdlDeleteProducts($table, $data);

    if($answer == 'ok'){
      echo '<script>
        swal({
          type: "success",
          title: "商品は削除されました",
          showConfirmButton: true,
          confirmButtonText: "Close"
        }).then(function(result){
          if(result.value){
            window.location = "products";
          }
        })
      </script>';
    }

  }
}

//Show adding of the sales
static public function ctrShowAddingOfTheSales(){
  $table = "products";
  $answer = ProductsModel::mdlShowAddingOfTheSales($table);
  return $answer;
}
}