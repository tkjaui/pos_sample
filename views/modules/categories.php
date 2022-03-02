<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      カテゴリー
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Categories</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addCategories">カテゴリーを追加</button>
      </div>

      <div class="box-body">
        <table class="table table-borderd table-striped dt-responsive tables" width="100%">
          <thead>
            <tr>
              <th style="width=10px">#</th>
              <th>カテゴリー</th>
              <th>ボタン</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $item = null;
              $value = null;
              $categories = ControllerCategories::ctrShowCategories($item, $value);

              // var_dump($categories);
              foreach ($categories as $key => $value) {
                echo '<tr>
                  <td>'.($key+1).'</td>
                  <td class="text-uppercase">'.$value['Category'].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditCategory" idCategory="'.$value["id"].'" data-toggle="modal" data-target="#editCategories">
                        <i class="fa fa-pencil"></i>
                      </button>';
                      if($_SESSION["profile"] == "管理者"){
                        echo '<button class="btn btn-danger btnDeleteCategory" idCategory="'.$value["id"].'">
                          <i class="fa fa-times"></i>
                        </button>';
                      }
                      echo '
                    </div>
                  </td>
                </tr>';
              }
            ?>
          </tbody>
        </table>
      </div>     
    </div>
  </section>
</div>

<!-- Modal add categories -->
<div id="addCategories" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST">
        <div class="modal-header" style="background:#3c8dbc; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">カテゴリーを追加</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- input category -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input class="form-control input-lg" type="text" name="newCategory" placeholder="カテゴリー名" required></input>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
  $createCategory = new ControllerCategories();
  $createCategory -> ctrCreateCategory();
?>

<!-- Modal edit category -->
<div id="editCategories" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST">
        <div class="modal-header" style="background:#3c8dbc; color:#fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">カテゴリーを編集</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" class="form-control input-lg" id="editCategory" name="editCategory" required>
                <input type="hidden" name="idCategory" id="idCategory" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>

        <?php
          $editCategory = new ControllerCategories();
          $editCategory -> ctrEditCategory();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
  $deleteCategory = new ControllerCategories();
  $deleteCategory -> ctrDeleteCategory();
?>

