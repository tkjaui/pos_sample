<?php

class ControllerServices{
  //Show Services
  static public function ctrShowServices($item, $value, $order){
    $table = "services";
    $answer = ServicesModel::mdlShowServices($table, $item, $value, $order);
    return $answer;
  
  }

  //Show Services from regi
  static public function ctrShowServicesFromRegi($item, $value, $order){
    $table = "services";
    $answer = ServicesModel::mdlShowServicesFromRegi($table, $item, $value, $order);
    return $answer;
  
  }

  //Create services
  static public function ctrCreateServices(){
    if(isset($_POST["newDescription"])){
      if(preg_match('/^[a-zA-Z0-9ぁ-んァ-ヶ一-龠々.()% ]+$/', $_POST["newDescription"])){

          $table = "services";
          $data = array("id_category" => $_POST["newCategory"],
                        "code" => $_POST["newCode"],
                        "description" => $_POST["newDescription"],                      
                        "selling_price" => $_POST["newSellingPrice"]);
          $answer = ServicesModel::mdlAddServices($table, $data);

          
          if($answer == 'ok'){
            echo '<script>
              swal({
                type: "success",
                title: "サービスが追加されました",
                showConfirmButton: true,
                confirmTextButton: "閉じる"
              }).then(function(result){
                if(result.value){
                  window.location = "services";
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
              confirmButtonText: "閉じる"
            }).then(function(result){
              if(result.value){
                window.location = "services";
              }
            })
           </script>';
         }
    }
  }

  //Edit Services
  static public function ctrEditServices(){
		if(isset($_POST["editDescription"])){
			if(preg_match('/^[a-zA-Z0-9ぁ-んァ-ヶ一-龠々.()% ]+$/', $_POST["editDescription"])){
          
         $table = "services";
         $data = array("id_category" => $_POST["editCategory"],
                       "code" => $_POST["editCode"],
                       "description" => $_POST["editDescription"],
                       "selling_price" => $_POST["editSellingPrice"]);
         $answer = ServicesModel::mdlEditServices($table, $data);

         if($answer == 'ok'){
          echo'<script>
          swal({
              type: "success",
              title: "サービスが編集されました",
              showConfirmButton: true,
              confirmButtonText: "閉じる"
              }).then(function(result){
                  if (result.value) {
                  window.location = "services";
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
						  confirmButtonText: "閉じる"
						  }).then(function(result){
							if (result.value) {
							window.location = "services";
							}
						})
			  	</script>';
    }
  }
}

//Delete Services
static public function ctrDeleteServices(){
  if(isset($_GET["idService"])){
    $table = "services";
    $data = $_GET["idService"];
    $answer = ServicesModel::mdlDeleteServices($table, $data);

    if($answer == 'ok'){
      echo '<script>
        swal({
          type: "success",
          title: "サービスが削除されました",
          showConfirmButton: true,
          confirmButtonText: "閉じる"
        }).then(function(result){
          if(result.value){
            window.location = "services";
          }
        })
      </script>';
    }

  }
}

//Show adding of the sales
static public function ctrShowAddingOfTheSales(){
  $table = "services";
  $answer = ServicesModel::mdlShowAddingOfTheSales($table);
  return $answer;
}
}