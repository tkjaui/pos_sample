<div class="content-wrapper">
  <section class="content-header">
    <h1>
      売上を編集
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Edit sale</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <!-- The form -->
      <div class="col-lg-4 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>
          <form role="form" method="post" class="saleForm">
            <div class="box-body">
              <div class="box">
                <?php
                  $item = "id";
                  $value = $_GET["idSale"];
                  $sale = ControllerSales::ctrShowSales($item, $value);

                  $itemUser = "id";
                  $valueUser = $sale["idSeller"];
                  $seller = ControllerUsers::ctrShowUsers($itemUser, $valueUser);

                  $itemCustomers = "id";
                  $valueCustomers = $sale["idCustomer"];
                  $customers = ControllerCustomers::ctrShowCustomers($itemCustomers, $valueCustomers);

                  $taxPercentage = round($sale["tax"] * 100 / $sale["netPrice"]);
                  // var_dump($seller);
                ?>

                <!-- Seller input -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="newSeller" id="newSeller" value="<?php echo $seller["name"]; ?>" readonly>
                    <input type="hidden" name="idSeller" value="<?php echo $seller["id"]; ?>">
                  </div>
                </div>

                <!-- Code input -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" class="form-control" name="editSale" id="newSale" value="<?php echo $sale["code"]; ?>" readonly>
                  </div>
                </div>

                <!-- Customer input -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="form-control" name="selectCustomer" id="selectCustomer" required>
                      <option value="<?php echo $customers["id"];?>"><?php echo $customers["name"]; ?></option>

                      <?php 
                        $item = null;
                        $value = null;
                        $customers = ControllerCustomers::ctrShowCustomers($item, $value);

                        foreach ($customers as $key => $value) {
                          echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                        }
                      ?>
                    </select>
                    <span class="input-group-addon">
                      <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">
                        お客様を追加
                      </button>
                    </span>
                  </div>
                </div>

                <!-- Product input -->
                <div class="form-group row newProduct">
                  <?php 
                    $productList = json_decode($sale["products"], true);
                    // var_dump($productList);
                    
                    foreach ($productList as $key => $value) {
                      if($productList[$key]["id_2"] == "addProductSale"){
                        // $item = "id";
                        // $valueProduct = $value["id"];
                        // $order = "id";
                        // $answerProduct = ControllerProducts::ctrShowProducts($item, $valueProduct, $order);
                        
                        echo 
                        '<div class="row" style="padding:5px 15px 30px 0">
            
                        <div class="reji-production">
                          <button type="button" class="btn btn-danger btn-xs removeProduct" idProduct="'.$productList[$key]["id"].'"><i class="fa fa-times"></i></button>
                          <input type="text" style="border:none" class="newProductDescription" idProduct="'.$productList[$key]["id"].'" name="addProductSale" value="'.$productList[$key]["description"].'" required></input>     
                        </div>
              
                        <div class="quantityAndPrice ">
                        
                          <div class="col-xs-4 enterPrice pull-right">
                            <div class="input-group">
                              <input type="number" class="form-control newProductPrice" realPrice="'.$productList[$key]["price"].'" name="newProductPrice" id="newProductPrice" value="'.$productList[$key]["price"].'"  required>
                              <span class="input-group-addon">円</span>
                            </div>
                          </div>
              
                          <div class="col-xs-1 X pull-right">
                            ✖︎
                          </div>
              
                          <div class="col-xs-3 pull-right">
                            <input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="'.$productList[$key]["quantity"].'" required>
                          </div>
              
                        </div>
              
                      </div>';
                      } else {
                        $item = "id";
                        $valueService = $value["id"];
                        $order = "id";
                        $answerService = ControllerServices::ctrShowServices($item, $valueService,$order);
                        
                        echo 
                        '<div class="row" style="padding:5px 15px 30px 0">
            
                        <div class="reji-production">
                          <button type="button" class="btn btn-danger btn-xs removeProduct" idService="'.$answerService["id"].'"><i class="fa fa-times"></i></button>
                          <input type="text" style="border:none" class="newProductDescription" idService="'.$answerService["id"].'" name="addServiceSale" value="'.$answerService["description"].'" required></input>     
                        </div>
              
                        <div class="quantityAndPrice ">
                        
                          <div class="col-xs-4 enterPrice pull-right">
                            <div class="input-group">
                              <input type="number" class="form-control newProductPrice" realPrice="'.$answerService["selling_price"].'" name="newProductPrice" id="newProductPrice" value="'.$answerService["selling_price"].'"  required>
                              <span class="input-group-addon">円</span>
                            </div>
                          </div>
              
                          <div class="col-xs-1 X pull-right">
                            ✖︎
                          </div>
              
                          <div class="col-xs-3 pull-right">
                            <input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="'.$productList[$key]["quantity"].'" required>
                          </div>
              
                        </div>
              
                      </div>';

                      }

                      
                    }
                  ?>
                </div>
                <input type="hidden" name="productsList" id="productsList">
                <!-- Add product button -->
                <button type="button" class="btn btn-default hidden-lg btnAddProduct">Add Product</button>
                <hr>
                <div class="row">
                  <!-- Taxes and total input -->
                  <div class="col-xs-8 pull-right">
                    <table class="table">
                      <thead>
                        <th>Taxes</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="width:50%">
                            <div class="input-group">
                              <input type="number" class="form-control" name="newTaxSale" id="newTaxSale" value="<?php echo $taxPercentage; ?>" min="0" required>
                              <input type="hidden" name="newTaxPrice" id="newTaxPrice" value="<?php echo $sale["tax"]; ?>" required>
                              <input type="hidden" name="newNetPrice" id="newNetPrice" value="<?php echo $sale["netPrice"]; ?>" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                          </td>
                          <td style="width:50%">
                            <div class="input-group">
                              <input type="text" class="form-control" name="newSaleTotal" id="newSaleTotal" placeholder="00000" totalSale="<?php echo $sale["netPrice"]; ?>" value="<?php echo $sale["totalPrice"]; ?>" readonly required>
                              <input type="hidden" name="saleTotal" id="saleTotal" value="<?php echo $sale["totalPrice"]; ?>" required>
                              <span class="input-group-addon">円</span>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <hr>
                </div>
                <hr>
                <!-- Payment method -->
                <div class="form-group row">
                  <div class="col-xs-6" style="padding-right:0">
                    <div class="input-group">
                      <select class="form-control" name="newPaymentMethod" id="newPaymentMethod" required>
                        <option value="">支払い方法</option>
                        <option value="cash">Cash</option>
                        <option value="CC">Credit Card</option>
                        <option value="DC">Debit Card</option>
                      </select>
                    </div>
                  </div>
                  <div class="paymentMethodBoxes"></div>
                  <input type="hidden" name="listPaymentMethod" id="listPaymentMethod" required>
                </div>
                <br>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-left">保存する</button>
            </div>
          </form>

          <?php
            $editSale = new ControllerSales();
            $editSale -> ctrEditSale();
          ?>
          
        </div>
      </div>

      <!-- Products table -->
      <div class="col-lg-8 hidden-md hidden-sm hidden-xs" >
        <div class="tab-wrap">
          <!-- 美容 -->
          <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">美容</label>
          <div class="tab-content">

          <?php
            $colors = array("#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900");

            $item = null;
            $value = null;
            $categories = controllerCategories::ctrShowCategories($item, $value);
              // var_dump($categories[0]["Category"]);
              for($i=0; $i<count($categories); $i++){
                if($categories[$i]["id"] <= 12 ||
                  $categories[$i]["id"] == 25 ){
                  echo '<div class="product" >
                  <div class="l-wrapper_02 card-radius_02" style="background-color: '.$colors[$i].'">
                  <p class="card__title_02" value="'.$categories[$i]["id"].'"  ;>'.$categories[$i]["Category"].'</p>
                </div>';

                $item1 = "id_category";
                $value1 = $categories[$i]["id"];
                $order1 = "id";
                $services1 = controllerServices::ctrShowServicesFromRegi($item1, $value1, $order1);
                foreach ($services1 as $key => $value) { 
                    echo '<div class="l-wrapper_06">
                    <div class="card_06" style="border: 3px solid '.$colors[$i].'">
                      <button class="card-content_06 addServiceSale recoverButton" idService="'.$value["id"].'" >'.$value["description"].'</button>
                    </div>
                  </div>'; 
                }
                echo '</div>' ;
              }         
                }
                
          ?>
          </div>

          <!-- 理容 -->
          <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">理容</label>
          <div class="tab-content">
          <?php
            $colors = array("#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900");

            $item = null;
            $value = null;
            $categories = controllerCategories::ctrShowCategories($item, $value);
              // var_dump($categories[0]["Category"]);
              for($i=0; $i<count($categories); $i++){
                if(13 <= $categories[$i]["id"] && $categories[$i]["id"] <= 16 ||
                    26 <= $categories[$i]["id"] && $categories[$i]["id"] <= 27){
                  echo '<div class="product" >
                  <div class="l-wrapper_02 card-radius_02" style="background-color: '.$colors[$i].'">
                  <p class="card__title_02" value="'.$categories[$i]["id"].'"  ;>'.$categories[$i]["Category"].'</p>
                </div>';

                $item1 = "id_category";
                $value1 = $categories[$i]["id"];
                $order1 = "id";
                $services1 = controllerServices::ctrShowServicesFromRegi($item1, $value1, $order1);
                foreach ($services1 as $key => $value) { 
                    echo '<div class="l-wrapper_06">
                    <div class="card_06" style="border: 3px solid '.$colors[$i].'">
                      <button class="card-content_06 addServiceSale recoverButton" idService="'.$value["id"].'" >'.$value["description"].'</button>
                    </div>
                  </div>'; 
                }
                echo '</div>' ;
              }         
                }
                
          ?>
          </div>
          
          <!-- 商品 -->
          <input id="TAB-03" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-03">商品</label>
          <!-- <div class="box ">
            <div class="box-header with-boader"></div> -->
            <div class="tab-content">
            <?php
            $colors = array("#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900","#ffccff","#ffcc33","yellow","aqua","#ff99ff","#ff9900");

            $item = null;
            $value = null;
            $categories = controllerCategories::ctrShowCategories($item, $value);
              // var_dump($categories[0]["Category"]);
              for($i=0; $i<count($categories); $i++){
                if(28 <= $categories[$i]["id"] && $categories[$i]["id"] <= 35){
                  echo '<div class="product" >
                  <div class="l-wrapper_02 card-radius_02" style="background-color: '.$colors[$i].'">
                  <p class="card__title_02" value="'.$categories[$i]["id"].'"  ;>'.$categories[$i]["Category"].'</p>
                </div>';

                $item1 = "id_category";
                $value1 = $categories[$i]["id"];
                $order1 = "id";
                $products = controllerProducts::ctrShowProductsFromRegi($item1, $value1, $order1);
                foreach ($products as $key => $value) { 
                    echo '<div class="l-wrapper_06">
                    <div class="card_06" style="border: 3px solid '.$colors[$i].'">
                      <button class="card-content_06 addProductSale recoverButton" idProduct="'.$value["id"].'" >'.$value["description"].'</button>
                    </div>
                  </div>'; 
                }
                echo '</div>' ;
              }         
                }
                
          ?>
            
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Module Add Customer -->
<div id="modalAddCustomer" class="modal fade" role="dialog">
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
                <input class="form-control input-lg" type="text" name="newAddress" placeholder="住所" required>
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