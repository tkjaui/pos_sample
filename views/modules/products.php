<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      商品管理
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>
  

  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addProduct">商品を追加</button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive productsTable" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Image</th>
              <th>コード</th>
              <th>商品名</th>
              <th>カテゴリー</th>
  
              <th>仕入価格</th>
              <th>販売価格</th>
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
<div id="addProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">
      <!-- Header -->
      <div class="modal-header" style="background: #3c8dbc; color: #fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>商品を追加</h4>
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
              <input class="form-control input-lg" type="text" id="newCode_p" name="newCode_p" placeholder="コード" required readonly>
            </div>
          </div> 
          <!-- Input description -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
              <input class="form-control input-lg" type="text" id="newDescription" name="newDescription" placeholder="商品名" required>
            </div>
          </div>
          <!-- Input buying price -->
          <div class="form-group row">
            <div class="col-xs-12 col-sm-6">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                <input class="form-control input-lg" type="number" id="newBuyingPrice" name="newBuyingPrice" step="any" min="0" placeholder="仕入価格" required>
              </div>
            </div>
            <!-- Input Selling price -->
            <div class="col-xs-12 col-sm-6" >
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                <input class="form-control input-lg" type="number" id="newSellingPrice" name="newSellingPrice" step="any" min="0" placeholder="販売価格" required>
              </div>
              <!-- <br> -->
              <!-- Checkbox percentage -->
              <!-- <div class="col-xs-6">
                <div class="form-group">
                  <label>
                    <input type="checkbox" class="minimal percentage" checked>
                    Use percentage
                  </label>
                </div>
              </div> -->
              <!-- Input percentage -->
              <!-- <div class="col-xs-6" style="padding:0">
                <div class="input-group">
                  <input type="number" class="form-control input-lg newPercentage" min="0" value="40" required>
                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                </div>
              </div> -->
            </div>
          </div>
          <!-- input image -->
          <div class="form-group">
            <div class="panel">Upload image</div>
            <input id="newProdPhoto" type="file" class="newImage" name="newProdPhoto" required>
            <p class="help-block">Maximum size 2Mb</p>
            <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" alt="" width="100px">
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
      $createProduct = new ControllerProducts();
      $createProduct -> ctrCreateProducts();
      ?>
      
    </div>
  </div>
</div>

<!-- Modal edit product -->
<div id="modalEditProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!-- Header -->
        <div class="modal-header" style="background:#3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">商品を編集</h4>
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
            <!-- Input for the buying price -->
            <div class="form-group row">
              <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="editBuyingPrice" name="editBuyingPrice" step="any" min="0" required>
                </div>
              </div>
              <!-- Input for the selling price -->
              <div class="col-xs-12 col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" class="form-control input-lg" id="editSellingPrice" name="editSellingPrice" step="any" min="0" required>
                </div>
                <!-- <br> -->
                <!-- Percentage checkbox -->
                <!-- <div class="col-xs-6">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal percentage" checked>
                    </label>
                  </div>
                </div> -->
                <!-- Input for the percentage -->
                <!-- <div class="col-xs-6" style="padding:0">
                  <div class="input-group">
                    <input type="number" class="form-control input-lg newPercentage" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div> -->
              </div>
            </div>
            <!-- input image -->
            <div class="form-group">
              <div class="panel">Upload image</div>
              <input type="file" class="newImage" name="editImage">
              <p class="help-block">Maximum size 2Mb</p>
              <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" alt="" width="100px">
              <input type="hidden" name="currentImage" id="currentImage">
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
        $editProduct = new ControllerProducts();
        $editProduct -> ctrEditProducts();
      ?>

    </div>
  </div>
</div>

<?php
  $deleteProduct = new ControllerProducts();
  $deleteProduct -> ctrDeleteProducts();
?>