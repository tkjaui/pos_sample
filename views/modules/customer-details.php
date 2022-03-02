<div class="content-wrapper">

  <?php
    $item = "id";
    $value = $_GET["id"];
    $Customers = ControllerCustomers::ctrShowCustomers($item, $value);
    // var_dump($Customers);
  ?>

  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Edit sale</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="head1">
      <h3>お客様カード</h3>
    </div>

    <h4>お客様ID： <?php echo $Customers["id"] ;?> </h4>
    <h4>登録日時：<?php echo $Customers["registerDate"] ;?></h4>
    <h4>お名前：<?php echo $Customers["name"] ;?></h4>
    <h4>生年月日：<?php echo $Customers["birthdate"] ;?></h4>
    <h4>性別：<?php echo $Customers["sex"] ;?></h4>
    <h4>住所：<?php echo $Customers["address"] ;?></h4>
    <h4>電話番号：<?php echo $Customers["phone"] ;?></h4>
    <h4>メールアドレス：<?php echo $Customers["email"] ;?></h4>
    <h4>メモ：<?php echo $Customers["memo"] ;?><button style="margin-left:10px" class="btn btn-warning btnEditCustomer2" data-toggle="modal" data-target="#modalEditCustomer2" idCustomer="<?php echo $Customers["id"];?>"><i class="fa fa-pencil"></i></button></h4>
    
    <div class="box-body">
      <table class="table table-bordered table-striped dt-responsive tables" width="100%">
        <thead>
          <tr>
            <!-- <th style="width:10px">#</th> -->
            <th>会計日時</th>
            <th>施術者</th>
            <th>支払方法</th>
            <th>サービス・商品</th>
            <th>税込価格</th>
            <th>メモ</th>
          </tr>
        </thead>

        <!-- まずsales全体を引っ張ってきて、その中でidCustomerが一致しているものを表示させている。初めからidCustomerが一致しているsalesレコードを引っ張ってきてもなぜかうまくいかない。 -->
        <tbody>
          <?php
            $item = null;
            $value = null;
            $order = "id";
            $sales = ControllerSales::ctrShowSales($item, $value, $order);

            foreach ($sales as $key => $value) {
              if($sales[$key]["idCustomer"] == $_GET["id"]){
                // var_dump($sales[$key]["idCustomer"]);
                echo 
                '<tr>
                
                <td>'.$value["sell_date"].'</td>';

                $itemUser = "id";
                $valueUser = $value["idSeller"];
                $userAnswer = ControllerUsers::ctrShowUsers($itemUser, $valueUser);
                echo '<td>'.$userAnswer["name"].'</td>
                <td>'.$value["paymentMethod"].'</td>';

                

                //test
                $test = [];
                $category = [];
                // echo $value["products"];
                preg_match_all('/"id":"(\w+)/', $value["products"], $match_id);
                preg_match_all('/"id_2":"(\w+)/', $value["products"], $match_id2);
                preg_match_all('/"idCategory":"(\w+)/', $value["products"], $match_idCategory);
                
                //初めの1はidがつくかつかないか、次の1は配列の順番  最後の数字を$iとかにする？   
                for($i=0; $i<4; $i++){
                  if($match_id2[1][$i] == "addProductSale"){
                    // array_push($test, [$match_id[1][$i], $match_id2[1][$i]]);
                    $itemProduct = "id";
                    $valueProduct = $match_id[1][$i];
                    $order = "id";
                    $productAnswer = ControllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);
                    // echo '<td>'.$productAnswer["description"].'</td>';
                    array_push($test, $productAnswer["description"]);
                  }if($match_id2[1][$i] == "addServiceSale"){
                    // array_push($test, [$match_id[1][$i], $match_id2[1][$i]]);
                    $itemService = "id";
                    $valueService = $match_id[1][$i];
                    $order = "id";
                    $serviceAnswer = ControllerServices::ctrShowServices($itemService, $valueService, $order);
                    // echo '<td>'.$serviceAnswer["description"].'</td>';
                    array_push($test, $serviceAnswer["description"]);
                  }
                  $itemCategory = "id";
                  $valueCategory = $match_idCategory[1][$i];
                  $order = "id";
                  $categoryAnswer = ControllerCategories::ctrShowCategories($itemCategory, $valueCategory, $order);
                  array_push($category, $categoryAnswer["Category"]);
                }
                
                echo '<td>';
                for($i=0; $i<count($test); $i++){
                  echo $category[$i].'&nbsp;'.$test[$i].'<br>';
                }
                echo '</td>';

                echo '<td>'.number_format($value["totalPrice"]).'円</td>
                <td>'.$value["memo"].'<button style="margin-left:10px" class="btn btn-warning btnEditSales2" data-toggle="modal" data-target="#modalEditSales2" idSale="'.$value["id"].'"><i class="fa fa-pencil"></i></button></td>
                
              </tr>';
              }
            }
          ?> 
        </tbody>
      </table>
    </div>  
  </section>
</div>

<!-- Modal Edit customer'memo -->
<div id="modalEditCustomer2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!-- Modal Header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 clasd="modal-title">メモを編集</h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <div class="box-body">
            <!-- memo input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note-o"></i></span>
                <input class="form-control input-lg" type="text" name="editOnlyCustomersMemo" id="editOnlyCustomersMemo" required>
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
        $editCustomer -> ctrEditOnlyCustomersMemo();
      ?>
    </div>
  </div>
</div>

<!-- Modal Edit sales memo -->
<div id="modalEditSales2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!-- Modal Header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 clasd="modal-title">メモを編集</h4>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <div class="box-body">
            <!-- memo input -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note-o"></i></span>
                <input class="form-control input-lg" type="text" name="editOnlySalesMemo" id="editOnlySalesMemo" required>
                <input type="hidden" id="idSale" name="idSale">
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
        $editCustomer = new ControllerSales();
        $editCustomer -> ctrEditOnlySalesMemo();
      ?>
    </div>
  </div>
</div>
