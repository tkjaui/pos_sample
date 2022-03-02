<?php
  if($_SESSION["profile"] != "管理者"){
    echo '<script>
      window.location = "home";
    </script>';
    return;
  }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      お客様一覧
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Customers</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-header with-border">           
        <button class="btn btn-primary" data-toggle="modal" data-target="#addCustomer">
          お客様を追加
        </button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>名前</th>
              <th>性別</th>
              <th>メールアドレス</th>
              <th>電話番号</th>
              <th>住所</th>
              <th>誕生日</th>
              <th>総来店回数</th>
              <th>最終来店日</th>
              <th>メモ</th>
              <!-- <th>総支払金額</th> -->
              <!-- <th>平均単価</th> -->
              <th>ボタン</th>
            </tr>
          </thead>
          
          <tbody>
            <?php
              $item = null;
              $value = null;
              $Customers = ControllerCustomers::ctrShowCustomers($item, $value);
              
              foreach($Customers as $key => $value){
                echo '<tr>
                  <td>'.($key+1).'</td>
                  <td class="name" id="'.$value["id"].'"><a href="index.php?route=customer-details&id='.$value["id"].'">'.$value["name"].'</a></td>
                  <td>'.$value["sex"].'</td>
                  <td>'.$value["email"].'</td>
                  <td>'.$value["phone"].'</td>
                  <td>'.$value["address"].'</td>
                  <td>'.$value["birthdate"].'</td>
                  <td>'.$value["purchases"].'</td>
                  <td>'.$value["lastPurchase"].'</td>
                  <td>'.$value["memo"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditCustomer" data-toggle="modal" data-target="#modalEditCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["profile"] == "管理者"){
                        echo '<button class="btn btn-danger btnDeleteCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-times"></i></button>';
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

<!-- Modal add customer -->
<div id="addCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST">
        <!-- Modal header -->
        <div class="modal-header" style="background:#3c8dbc; color:#fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">お客様を追加</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">
            <!-- Name input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="newCustomer" placeholder="名前" required>
              </div>
            </div>
            <!-- Input sex -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-female"></i></span>
                <select class="form-control input-lg" name="newSex" id="newSex" required>
                  <option value="">性別選択</option>
                  <option value="男性">男性</option>
                  <option value="女性">女性</option>
                </select>
              </div>
            </div>
            <!-- Email input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control input-lg" type="text" name="newEmail" placeholder="メールアドレス">
              </div>
            </div>
            <!-- Phone input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="newPhone" placeholder="電話番号" required>
              </div>
            </div>
            <!-- Address input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="newAddress" placeholder="住所">
              </div>
            </div>
            <!-- birthdate input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                <input class="form-control input-lg" type="text" name="newBirthdate" placeholder="誕生日">
              </div>
            </div>
            <!-- memo input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note-o"></i></span>
                <input class="form-control input-lg" type="text" name="newMemo" placeholder="メモ">
              </div>
            </div>
            
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>

      <?php
        $createCustomer = new ControllerCustomers();
        $createCustomer -> ctrCreateCustomers();
      ?>

    </div>
  </div>
</div>

<!-- Modal Edit customer -->
<div id="modalEditCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!-- Modal Header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 clasd="modal-title">お客様を編集</h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <div class="box-body">
            <!-- Name input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="editCustomer" id="editCustomer" required>
                <input type="hidden" id="idCustomer" name="idCustomer">
              </div>
            </div>
            <!-- Input sex -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-female"></i></span>
                <select class="form-control input-lg" name="editSex" id="editSex" required>
                  <option value="">性別選択</option>
                  <option value="男性">男性</option>
                  <option value="女性">女性</option>
                </select>
              </div>
            </div>
            <!-- Email input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control input-lg" type="text" name="editEmail" id="editEmail">
              </div>
            </div>
            <!-- Phone input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="editPhone" id="editPhone" required>
              </div>
            </div>
            <!-- Address input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="editAddress" id="editAddress" required>
              </div>
            </div>
            <!-- Birthdate input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                <input class="form-control input-lg" type="text" name="editBirthdate" id="editBirthdate" required>
              </div>
            </div>
            <!-- memo input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note-o"></i></span>
                <input class="form-control input-lg" type="text" name="editMemo" id="editMemo" required>
              </div>
            </div>
            
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>

      <?php
        $editCustomer = new ControllerCustomers();
        $editCustomer -> ctrEditCustomers();
      ?>
    </div>
  </div>
</div>

<?php
  $deleteCustomer = new ControllerCustomers();
  $deleteCustomer -> ctrDeleteCustomers();
?>

