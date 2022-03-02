<?php

class ControllerCategories{
  //create categories
  static public function ctrCreateCategory(){
    if(isset($_POST["newCategory"])){
      
        $table = 'categories';
        $data = $_POST['newCategory'];
        $answer = CategoriesModel::mdlAddCategory($table, $data);

        if($answer == 'ok'){
          echo '<script>
            swal({
              type: "success",
              title: "カテゴリーが追加されました",
              showConfirmButton: true,
              confirmButtonText: "閉じる"
            }).then(function(result){
              if(result.value){
                window.location = "categories";
              }
            });
          </script>';
        }
      
    }
  }

  //Show categories
  static public function ctrShowCategories($item, $value){
    $table = "categories";
    $answer = CategoriesModel::mdlShowCategories($table, $item, $value);
    return $answer;
  }

  //Edit category
  static public function ctrEditCategory(){
    if(isset($_POST["editCategory"])){
      
        $table = "categories";
        $data = array("Category"=>$_POST["editCategory"], "id"=>$_POST["idCategory"]);
        $answer = CategoriesModel::mdlEditCategory($table, $data);

        if($answer == "ok"){
          echo '<script>
            swal({
              type: "success",
              title: "カテゴリーが保存されました",
              showConfirmButton: true,
              confirmButtonText: "閉じる"
            }).then(function(result){
              if(result.value){
                window.location = "categories";
              }
            });
          </script>';
        } 
      
    }
  }

  //Delete category
  static public function ctrDeleteCategory(){
    if(isset($_GET["idCategory"])){
      $table = "categories";
      $data = $_GET["idCategory"];
      $answer = CategoriesModel::mdlDeleteCategory($table, $data);

      if($answer == 'ok'){
        echo '<script>
          swal({
            type: "success",
            title: "カテゴリーが削除されました",
            showConfirmButton: true,
            confirmButtonText: "閉じる"
          }).then(function(result){
            if(result.value){
              window.location = "categories";
            }
          })
        </script>';
      }
    }
  }
}