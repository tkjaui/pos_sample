<?php

class ControllerUsers{
  static public function ctrUserLogin(){
    if(isset($_POST["loginUser"])){
      if(preg_match('/^[a-zA-Z0-9a-zA-Z0-9ぁ-んァ-ヶ一-龠々]+$/', $_POST["loginUser"]) &&
         preg_match('/^[a-zA-Z0-9]+$/', $_POST["loginPass"])){

          $encryptpass = crypt($_POST["loginPass"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
          $table = 'users';
          $item = 'name';
          $value = $_POST["loginUser"];
          $answer = UsersModel::MdlShowUsers($table, $item, $value);

          //var_dump($answer)
          if($answer["name"] == $_POST["loginUser"] && $answer["password"] == $encryptpass){
            if($answer["status"] == 1){
              $_SESSION["loggedIn"] = "ok";
              $_SESSION["id"] = $answer["id"];
              $_SESSION["name"] = $answer["name"];
              $_SESSION["photo"] = $answer["photo"];
              $_SESSION["profile"] = $answer["profile"];

              // Register data to know last_login
              date_default_timezone_set("Asia/Tokyo");
              $date = date('Y-m-d');
              $hour = date('H:i:s');

              $actualDate = $date.' '.$hour;

              $item1 = "lastLogin";
              $value1 = $actualDate;

              $item2 = "id";
              $value2 = $answer["id"];

              $lastLogin = UsersModel::mdlUpdateUser($table, $item1, $value1, $item2, $value2);

              if($lastLogin == 'ok'){
                echo '<script>
                  window.location = "home";
                </script>';
              }
  
              echo '<script>
                window.location = "home";
              </script>';
            } else {
              echo '<br><div class="alert alert-danger">User is deactivated</div>';
            }     
          
          } else {
            echo '<br><div class="alert alert-danger">User or password incorrect.</div>';
          }     
      }
    }
  }

  static public function ctrCreateUser(){
    if(isset($_POST["newName"])){
      if(preg_match('/^[a-zA-Z0-9ぁ-んァ-ヶ一-龠々]+$/', $_POST["newName"]) &&
         preg_match('/^[a-zA-Z0-9]+$/', $_POST["newPassword"])){

          // validate image
          $photo = "";

          if (isset($_FILES["newPhoto"]["tmp_name"])){
            list($width, $height) = getimagesize($_FILES["newPhoto"]["tmp_name"]);
            $newWidth = 500;
            $newHeight = 500;

            // create the folder for each user
            $folder = "views/img/users/".$_POST["newName"];
					  mkdir($folder, 0755);
            // $error = error_get_last();
            // echo $error['message'];
            
            // PHP functions depending on the image
            if($_FILES["newPhoto"]["type"] == "image/jpeg"){
              $randomNumber = mt_rand(100,999);
              $photo = "views/img/users/".$_POST["newName"]."/".$randomNumber.".jpg";
              $srcImage = imagecreatefromjpeg($_FILES["newPhoto"]["tmp_name"]);
              $destination = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); 
              imagejpeg($destination, $photo);
            }

            if($_FILES["newPhoto"]["type"] == "image/png"){
              $randomNumber = mt_rand(100,999);
              $photo = "views/img/users/".$_POST["newName"]."/".$randomNumber.".png";
              $srcImage = imagecreatefrompng($_FILES["newPhoto"]["tmp_name"]);
              $destination = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); 
              imagepng($destination, $photo);
            }
          } 


          $table = 'users';
          $encryptpass = crypt($_POST["newPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
          $data = array('name' => $_POST["newName"], 
                         'password' => $encryptpass,
                         'profile' => $_POST["newProfile"],
                         'photo' => $photo);
          $answer = UsersModel::MdlAddUser($table, $data);
          
          if($answer == 'ok'){
            echo '<script>
              swal({
                type: "success",
                title: "ユーザーが追加されました！",
                showConfirmButton: true,
                confirmButtonText: "Close"
              }).then((result) => {
                if(result.value){
                  window.location = "users";
                }
              });
            </script>';
          }


         } else {
           echo '<script>
            swal({
              type: "error",
              title: "特殊な文字や空欄は使えません。",
              showConfirmButton: true,
              confirmButtonText: "Close"
            }).then((result) => {
              if(result.value){
                window.location = "users";
              }
            });
           </script>';
         }
    }
  }

  static public function ctrShowUsers($item, $value){
    $table = "users";
    $answer = UsersModel::MdlShowUsers($table, $item, $value);
    return $answer;
  }

  static public function ctrEditUser(){
    
    if(isset($_POST["EditName"])){
      if(preg_match('/^[a-zA-Z0-9ぁ-んァ-ヶ一-龠々]+$/', $_POST["EditName"])){
        
          // validate image
          $photo = $_POST["currentPicture"];
          if(isset($_FILES["editPhoto"]["tmp_name"]) && !empty($_FILES["editPhoto"]["tmp_name"])){
            list($width, $height) = getimagesize($_FILES["editPhoto"]["tmp_name"]);//[editPhoto]の[tmp_name]を取得
            $newWidth = 500;
            $newHeight = 500;
            
            // create the folder for each user
            $folder = "views/img/users/".$_POST["EditName"];

            //ask first if there's an existing image in the database
            if (!empty($_POST["currentPicture"])){
              unlink($_POST["currentPicture"]);//delete
            }else{
              mkdir($folder, 0755);
            }

            //PHP function depending on the image
            if($_FILES["editPhoto"]["type"] == "image/jpeg"){
              //save the image in the folder
              $randomNumber = mt_rand(100, 999);
              $photo = "views/img/users/".$_POST["EditName"]."/".$randomNumber.".jpg";
              $srcImage = imagecreatefromjpeg($_FILES["editPhoto"]["tmp_name"]);
              $destination = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              imagejpeg($destination, $photo);
            }
            if($_FILES["editPhoto"]["type"] == "image/png"){
              //save the image in the folder
              $randomNumber = mt_rand(100,999);			
              $photo = "views/img/users/".$_POST["EditName"]."/".$randomNumber.".png";						
              $srcImage = imagecreatefrompng($_FILES["editPhoto"]["tmp_name"]);						
              $destination = imagecreatetruecolor($newWidth, $newHeight);
              imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              imagepng($destination, $photo);
            }
          }
        
 
        
          $table = 'users';
          if($_POST["EditPasswd"] != ""){
            if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["EditPasswd"])){
              $encryptpass = crypt($_POST["EditPasswd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            } else {
              echo '<script>
                swal({
                  type: "error",
                  title: "特殊な文字や空欄は使えません。",
                  showConfirmButton: true,
                  confirmButtonText: "Close"
                  }).then(function(result){				
                    if (result.value) {			
                      window.location = "users";
                    }
                  });		
              </script>';
            }
          } else {
            $encryptpass = $_POST["currentPasswd"];
          }
          
          $data = array('name' => $_POST["EditName"],
                        'password' => $encryptpass,
                        'profile' => $_POST["EditProfile"],
                        'photo' => $photo);
          $answer = UsersModel::MdlEditUser($table, $data);
  
          if($answer == 'ok'){
            echo '<script>
              swal({
                type: "success",
                title: "ユーザーは編集されました!",
                showConfirmButton: true,
                confirmButtonText: "Close"
              }).then(function(result){
                if(result.value){
                  window.location = "users";
                }
              });
            </script>';
          } else {
            echo '<script>
              swal({
                type: "error",
                title: "特殊な文字や空欄は使えません。",
                showConfirmButton: true,
                confirmButtonText: "Close"
              }).then(function(result){
                if(result.value){
                  window.location = "users";
                }
              });
            </script>';
          }
        

      }
    }
  }

  //delete user
  static public function ctrDeleteUser(){
    if(isset($_GET["userId"])){
      $table = "users";
      $data = $_GET["userId"];

      if($_GET["userPhoto"] != ""){
        unlink($_GET["userPhoto"]);//ファイルを削除
        rmdir('views/img/users/'.$_GET["username"]);//ディレクトリを削除
      }
      $answer = UsersModel::mdlDeleteUser($table, $data);

      if($answer == 'ok'){
        echo '<script>
          swal({
            type: "success",
					  title: "ユーザーは削除されました！",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
          }).then(function(result){
            if(result.value){
              window.location = "users";
            }
          })
        </script>';
      }
    }
  }
}
  