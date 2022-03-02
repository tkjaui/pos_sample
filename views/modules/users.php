
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      ユーザー管理
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">User Management</li>
    </ol>
  </section>


  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUser">
          ユーザー追加
        </button>       
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>名前</th>
              <th>写真</th>
              <th>プロファイル</th>
              <th>ステータス</th>
              <th>最終ログイン</th>
              <th>編集・削除</th>
            </tr>
          </thead>
          <tbody>

          <?php
            $item = null; 
            $value = null;
            $users = ControllerUsers::ctrShowUsers($item, $value);
            
            foreach ($users as $key => $value){
              // var_dump($value);
              echo '
              <tr>
                <td>'.($key+1).'</td>
                <td>'.$value["name"].'</td>';

                if ($value["photo"] != ""){
                  echo '<td><img src="'.$value["photo"].'" class="img-thumbnail" width="40px"></td>';
                }else{
                  echo '<td><img src="views/img/users/default/anonymous.png" class="img-thumbnail" width="40px"></td>';  
                }

                echo '<td>'.$value["profile"].'</td>';

                if($value["status"] != 0){
                  echo '<td><button class="btn btn-success btnActivate btn-xs" userId="'.$value["id"].'" userStatus="0">Activated</button></td>';
                }else{
                  echo '<td><button class="btn btn-danger btnActivate btn-xs" userId="'.$value["id"].'" userStatus="1">Deactivated</button></td>';
                }
                
                echo '<td>'.$value["lastLogin"].'</td>

                <td>
                  <div class="btn-group">                   
                    <button class="btn btn-warning btnEditUser" idUser="'.$value["id"].'" data-toggle="modal" data-target="#editUser"><i class="fa fa-pencil"></i></button>';
                    if($_SESSION["profile"] == "管理者"){
                      echo '<button class="btn btn-danger btnDeleteUser" userId="'.$value["id"].'" userPhoto="'.$value["photo"].'"><i class="fa fa-times"></i></button>';
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

<!-- Modal Add User-->
<div id="addUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ユーザーを追加</h4>       
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="newName" placeholder="名前" required>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="newPassword" placeholder="パスワード" required>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="newProfile">
                  <option value="">プロファイル選択</option>
                  <option value="管理者">管理者</option>
                  <option value="スタイリスト">スタイリスト</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="panel">Upload image</div>
              <input class="newPics" type="file" name="newPhoto" required>
              <p class="help-block">Maximum size 2Mb</p>
              <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" alt="" width="100px">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>

        <?php
          $createUser = new ControllerUsers();
          $createUser -> ctrCreateUser();
        ?>

      </form>  
    </div>
  </div>
</div>

<!-- Modal Edit User-->
<div id="editUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">  
        <div class="modal-header" style="background: #3c8dbc; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ユーザーを編集</h4>
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <!-- input name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input value="" type="text" id="EditName" class="form-control input-lg" name="EditName" placeholder="名前" required readonly>
              </div>
            </div>

            <!-- input password -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="EditPasswd" placeholder="パスワード">
                <input type="hidden" name="currentPasswd" id="currentPasswd">
              </div>
            </div>

            <!-- input profile -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="EditProfile">
                  <option value="">プロファイル選択</option>
                  <option value="管理者">管理者</option>
                  <option value="スタイリスト">スタイリスト</option>
                </select>
              </div>
            </div>

            <!-- input photo -->
            <div class="form-group">
              <div class="panel">Upload image</div>
              <input class="newPics" type="file" name="editPhoto">
              <p class="help-block">Maximum size 2Mb</p>
              <img src="views/img/products/default/anonymous.png" class="thumbnail preview" width="100px">
              <input type="hidden" name="currentPicture" id="currentPicture">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>

        <?php
          $editUser = new ControllerUsers();
          $editUser -> ctrEditUser();
        ?>

      </form>  
    </div>
  </div>
</div>

<?php
  $deleteUser = new ControllerUsers();
  $deleteUser -> ctrDeleteUser();
?>
