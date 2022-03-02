<?php 
  $item = null;
  $value = null;
  $order = "id";

  $products = ControllerProducts::ctrShowProducts($item, $value, $order);
?>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Recently Added Products</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <ul class="products-list product-list-in-box">
      <?php
        for($i=0; $i<count($products); $i++){
          echo '<li class="item">
            <div class="product-img">
              <img src="'.$products[$i]["image"].'" alt="ProductImage">
            </div>
            <div class="product-info">
              <a href="" class="product-title">'.$products[$i]["description"].'
                <span class="label label-warning pull-right">$'.$products[$i]["selling_price"].'</span>
              </a>
            </div>
          </li>';
        }
      ?>
    </ul>
  </div>

  <div class="box-footer text-center">
    <a href="products" class="uppercase">See all products</a>
  </div>
</div>