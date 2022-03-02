<?php

class ControllerCustomers{
  //Show customers
  static public function ctrShowCustomers($item, $value){
    $table = "customers";
    $answer = ModelCustomers::mdlShowCustomers($table, $item, $value);
    return $answer;
  }

  //Add customers
  static public function ctrCreateCustomers(){

		if(isset($_POST["newCustomer"])){

			if(preg_match('/^[()\-0-9 ]+$/', $_POST["newPhone"])){

			   	$table = "customers";

			   	$data = array("name"=>$_POST["newCustomer"],
					           "email"=>$_POST["newEmail"],
					           "phone"=>$_POST["newPhone"],
					           "address"=>$_POST["newAddress"],
					           "birthdate"=>$_POST["newBirthdate"],
					           "memo"=>$_POST["newMemo"],
					           "sex"=>$_POST["newSex"]

                    );

			   	$answer = ModelCustomers::mdlCreateCustomers($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "お客様は追加されました",
						  showConfirmButton: true,
						  confirmButtonText: "閉じる"
						  }).then(function(result){
									if (result.value) {

									window.location = "customers";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "特殊な文字や空欄は使えません。",
						  showConfirmButton: true,
						  confirmButtonText: "閉じる"
						  }).then(function(result){
							if (result.value) {

							window.location = "customers";

							}
						})

			  	</script>';

			}

		}

	}


  //Edit customer
  static public function ctrEditCustomers(){
    if(isset($_POST["editCustomer"])){

			if(preg_match('/^[()\-0-9 ]+$/', $_POST["editPhone"])){

          $table = "customers";

			   	$data = array("id"=>$_POST["idCustomer"],
			   				   "name"=>$_POST["editCustomer"],
					           "email"=>$_POST["editEmail"],
					           "phone"=>$_POST["editPhone"],
					           "address"=>$_POST["editAddress"],
					           "birthdate"=>$_POST["editBirthdate"],
					           "memo"=>$_POST["editMemo"],
					           "sex"=>$_POST["editSex"]

                    );

          $answer = ModelCustomers::mdlEditCustomers($table, $data);

          if($answer = 'ok'){
            echo '<script>
              swal ({
                type:"success",
                title:"お客様は編集されました",
                showConfirmButton: true,
                confirmButtonText: "閉じる"
              }).then(function(result){
                if(result.value){
                  window.location = "customers";
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
                window.location = "customers";
              }
            })
           </script>';
         }
    }
  }

  //Edit just 1 customer's memo
  static public function ctrEditOnlyCustomersMemo(){
    if(isset($_POST["editOnlyCustomersMemo"])){
          $table = "customers";
			   	$data = array("id"=>$_GET["id"],
                        "memo"=>$_POST["editOnlyCustomersMemo"]);
          $answer = ModelCustomers::mdlEditOnlyCustomersMemo($table, $data);

          if($answer = 'ok'){
            echo '<script>
              swal ({
                type:"success",
                title:"メモは編集されました",
                showConfirmButton: true,
                confirmButtonText: "閉じる"
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?route=customer-details&id='.$_GET["id"].'";
                }
              })
            </script>';
          }
    }
  }

  //Delete customer
  static public function ctrDeleteCustomers(){
    if(isset($_GET["idCustomer"])){
      $table = "customers";
      $data = $_GET["idCustomer"];
      $answer = ModelCustomers::mdlDeleteCutomers($table, $data);

      if($answer == 'ok'){
        echo '<script>
          swal({
            type: "success",
            title: "お客様は削除されました",
            showConfirmButton: true,
            confirmButtonText: "閉じる"
          }).then(function(result){
            if(result.value){
              window.location = "customers";
            }
          })
        </script>';
      }
    }
  }
}