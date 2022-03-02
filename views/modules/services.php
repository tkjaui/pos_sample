<div class="content-wrapper">
  <section class="content-header">
    <h1>
      サービスメニュー
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Service memu</li>
    </ol>
  </section>
  

  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addService">サービスを追加</button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive servicesTable" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>コード</th>
              <th>サービス名</th>
              <th>カテゴリー</th>
              <th>金額</th>
              <th>登録日時</th>
              <th>ボタン</th>
            </tr>
          </thead>
  
          <input type="hidden" value="<?php echo $_SESSION["profile"]; ?>" id="hiddenProfile">
        </table>
      </div>   
    </div>
  </section>
</div>

<!-- Modal add product -->
<div id="addService" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">
      <!-- Header -->
      <div class="modal-header" style="background: #3c8dbc; color: #fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>サービスを追加</h4>
      </div>
      <!-- Body -->
      <div class="modal-body">
        <div class="box-body">
          <!-- Input category -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <select class="form-control input-lg" name="newCategory" id="newCategory" required>
                <option value="">カテゴリー選択</option>
                  <?php
                    $item = null;
                    $value1 = null;
                    $categories = controllerCategories::ctrShowCategories($item, $value1);
                    foreach ($categories as $key => $value) {
                      echo '<option value="'.$value["id"].'">'.$value["Category"].'</option>';
                    }                 
                  ?>
              </select>
            </div>
          </div>
          
          <!-- Input code -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-code"></i></span>
              <input class="form-control input-lg" type="text" id="newCode" name="newCode" placeholder="コード" required readonly>
            </div>
          </div> 
          <!-- Input description -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input class="form-control input-lg" type="text" id="newDescription" name="newDescription" placeholder="サービス名" required>
            </div>
          </div>
          <!-- Input Selling price -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
              <input class="form-control input-lg" type="number" inputmode="numeric" id="newSellingPrice" name="newSellingPrice" step="any" placeholder="料金" required>
            </div>      
          </div>
        </div>    
      </div>

      <!-- Footer -->
      <div class="modal-footer" >
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
        <button type="submit" class="btn btn-primary">保存</button>
      </div>
      </form>

      <?php
      $createService = new ControllerServices();
      $createService -> ctrCreateServices();
      ?>
      
    </div>
  </div>
</div>

<!-- Modal edit product -->
<div id="modalEditService" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!-- Header -->
        <div class="modal-header" style="background:#3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">サービスの編集</h4>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="box-body">
            <!-- Select category -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" name="editCategory" readonly required>
                  <option id="editCategory"></option>
                </select>
              </div>
            </div>
            <!-- Input for the code -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" id="editCode" name="editCode" readonly required>
              </div>
            </div>
            <!-- Input for the description -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" id="editDescription" name="editDescription" required>
              </div>
            </div>
            <!-- Input for the selling price -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                <input type="number" class="form-control input-lg" id="editSellingPrice" name="editSellingPrice" step="any" min="0" required>
              </div>    
            </div>
          </div>
        </div>
        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>

      <?php
        $editService = new ControllerServices();
        $editService -> ctrEditServices();
      ?>

    </div>
  </div>
</div>

<?php
  $deleteService = new ControllerServices();
  $deleteService -> ctrDeleteServices();
?>