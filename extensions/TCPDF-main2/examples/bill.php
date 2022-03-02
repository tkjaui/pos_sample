<?php

require_once('../../../controllers/sales.controller.php');
require_once('../../../models/sales.model.php');

require_once('../../../controllers/customers.controller.php');
require_once('../../../models/customers.model.php');

require_once('../../../controllers/users.controller.php');
require_once('../../../models/users.model.php');

require_once('../../../controllers/products.controller.php');
require_once('../../../models/products.model.php');

class printBill{
  public $code;
  public function getBillPrinting(){
    //Bring the information of the sale
    $itemSale = "code";
    $valueSale = $this -> code;
    $answerSale = ControllerSales::ctrShowSales($itemSale, $valueSale);
    
    $saledate = substr($answerSale["sell_date"], 0, -8);
    $products = json_decode($answerSale["products"], true);
    $netPrice = number_format($answerSale["netPrice"], 2);
    $tax = number_format($answerSale["tax"], 2);
    $totalPrice = number_format($answerSale["totalPrice"], 2);

    //Bring the information of the Customer
    $itemCustomer = "id";
    $valueCustomer = $answerSale["idCustomer"];
    $answerCustomer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);
    
    //Bring the information of the Seller
    $itemSeller = 'id';
    $valueSeller = $answerSale["idSeller"];
    $answerSeller = ControllerUsers::ctrShowUsers($itemSeller, $valueSeller);

    require_once('tcpdf_include.php');

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->startPageGroup();

    // Add a page
    $pdf->AddPage();

    $block1 = <<<EOF
      <table>
        <tr>
        <td style="width:150px"><img src="images/img.png"></td>
          <td style="background-color:white; width:140px">
            <div style="font-size:8.5px; text-align:right; line-height:15px;">  
              <br>
              NIT: 71.759.963-9
              <br>
              ADDRESS: Calle 44B 92-11
            </div>
          </td>
          
          <td style="background-color:white; width:140px">
            <div style="font-size:8.5px; text-align:right; line-height:15px;">			
              <br>
              CELLPHONE: 300 786 52 49		
              <br>
              sales@inventorysystem.com
            </div>			
          </td>

          <td style="background-color:white; width:110px; text-align:center; color:red"><br><br>BILL N.<br>$valueSale</td>
        </tr>
      </table>
    EOF;
    // Print text using writeHTML()
    $pdf->writeHTML($block1, false, false, false, false, '');

    $block2 = <<<EOF
      <table>
        <tr>
          <td style="width:540px"><img src="images/back.jpg"></td>
        </tr>
      </table>
      <table style="font-size:10px; padding:5px 10px;">
        <tr>
          <td style="border:1px solid #666; background-color:white; width:390px;">Customer: $answerCustomer[name]</td>
          <td style="border:1px solid #666; background-color:white; width:150px;" text-align:right>Date: $saledate</td>
        </tr>
        <tr>
          <td style="border:1px solid #666;" background-color: white; width="540px">Seller: $answerSeller[name]</td>
        </tr>
        <tr>
          <td style="border-bottom:1px solid #666;" background-color: white; width="540px"></td>
        </tr>
      </table>
    EOF;
    $pdf->writeHTML($block2, false, false, false, false, '');

    $block3 = <<<EOF
      <table style="font-size:10px; padding: 5px 10px;">
        <tr>
          <td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Product</td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">quantity</td>
          <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">value Unit.</td>
          <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">value Total</td>
        </tr>
      </table>
    EOF;
    $pdf->writeHTML($block3, false, false, false, false, '');

    // var_dump($products);
    foreach ($products as $key => $item) {
      $itemProduct = "description";
      $valueProduct = $item["description"];
      $order = null;
      $answerProduct = ControllerProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

      $valueUnit = number_format($answerProduct["selling_price"], 2);
      $totalPrice2 = number_format($item["totalPrice"],2);

      $block4 = <<<EOF
        <table style="font-size:10px; padding:5px 10px">
          <tr>
            <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">$item[description]</td>
            <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">$item[quantity]</td>
            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$$valueUnit</td>
            <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$$totalPrice2</td>
          </tr>
        </table>
      EOF;
      $pdf->writeHTML($block4, false, false, false, false, '');
    }

    $block5 = <<<EOF
      <table style="font-size:10px; padding:5px 10px">
        <tr>
          <td style="color:#333; background-color:white; width:340px; text-align:center"></td>
          <td style="border-bottom:1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
          <td style="border-bottom:1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
        </tr>

        <tr>
          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:center">Net:</td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$$netPrice</td>
        </tr>

        <tr>
          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:center">Tax:</td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$$tax</td>
        </tr>

        <tr>
          <td style="border-right:1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
          <td style="border:1px solid #666; background-color:white; width:100px; text-align:center">Total:</td>
          <td style="border:1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$$totalPrice</td>
        </tr>
      </table>
    EOF;
    $pdf->writeHTML($block5, false, false, false, false, '');


    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('bill.pdf');
  }
}

$bill = new printBill();
$bill -> code = $_GET["code"];
$bill -> getBillPrinting();