//Biable localStorage check
if(localStorage.getItem("captureRange") != null){
  $('#daterange-btn span').html(localStorage.getItem('captureRange'));
} else {
  $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Date Range');
}

$('.salesTable').DataTable({
  "ajax": "ajax/datatable-sales.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

//Adding products to the sale from the table
$(".card_06").on("click", "button.addProductSale", function(){
  var idProduct = $(this).attr("idProduct");
  // console.log(idProduct);
  $(this).removeClass("btn-primary addProductSale");
  $(this).addClass("btn-default");

  var data = new FormData();
  data.append("idProduct", idProduct);

  $.ajax({
    url: "ajax/products.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      var description = answer["description"];
      var stock = answer["stock"];
      var price = answer["selling_price"];
      var idCategory = answer["id_category"];

      $(".newProduct").append(        
        '<div class="row" style="padding:0px 15px 30px 0">'+
          
          '<div class="reji-production">'+
            '<button type="button" class="btn btn-danger btn-xs removeProduct" idProduct ="'+idProduct+'"><i class="fa fa-times"></i></button>'+
            '<input type="text" style="border:none" class="newProductDescription" idProduct="'+idProduct+'" name="addProductSale" value="'+description+'" idCategory="'+idCategory+'" required></input>'+          
          '</div>'+

          '<div class="quantityAndPrice ">'+
          
            '<div class="col-xs-5 enterPrice pull-right">'+
              '<div class="input-group">'+
                '<input type="number" class="form-control newProductPrice" realPrice="'+price+'" name="newProductPrice" id="newProductPrice" value="'+price+'"  required>'+
                '<span class="input-group-addon">円</span>'+
              '</div>'+
            '</div>'+

            '<div class="col-xs-1 X pull-right">'+
              '✖︎'+
            '</div>'+

            '<div class="col-xs-3 pull-right">'+
              '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock="'+stock+'" newStock="'+Number(stock-1)+'" required>'+
            '</div>'+

          '</div>'+

        '</div>'
        )

        // Adding total prices
        addingTotalPrices();

        //Add Tax
        addTax()

        //Group products in json format
        listProducts()

        //Format products price
        $(".newProductPrice").number(true);

        //レシート
        $("#receipt_description").append(      
          '<div idProduct="'+idProduct+'">'+description+
          '<br>                   1 x '+price+'円</div>'
        )

        //仮売り
        $("#receipt_description2").append(      
          '<div idProduct="'+idProduct+'">'+
            '<div class="price2"> '+description+'</div>'+
            '<div class="price1">1 x '+price+'円</div>'+
          '</div>'
        )

    }
  })
});


//Adding services to the sale from the regi
$(".card_06").on("click", "button.addServiceSale", function(){
  var idService = $(this).attr("idService");
  $(this).removeClass("btn-primary addServiceSale");
  $(this).addClass("btn-default");

  var data = new FormData();
  data.append("idService", idService);

  $.ajax({
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      var description = answer["description"];
      var price = answer["selling_price"];

      var idCategory = answer["id_category"];
      var data = new FormData();
      data.append("idCategory", idCategory);
      $.ajax({
        url: "ajax/categories.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
          var categories = answer["Category"];
          
          $(".newProduct").append(      
            '<div class="row" style="padding:0px 15px 30px 0">'+
              
              '<div class="reji-production">'+
                '<button type="button" class="btn btn-danger btn-xs removeProduct" idService ="'+idService+'"><i class="fa fa-times"></i></button>'+
                '<input type="text" style="border:none" class="newProductDescription" idService="'+idService+'" name="addServiceSale" value="'+categories+' '+description+'" idCategory="'+idCategory+'" required></input>'+          
              '</div>'+

              '<div class="quantityAndPrice ">'+
              
                '<div class="col-xs-5 enterPrice pull-right">'+
                  '<div class="input-group">'+
                    '<input type="number" class="form-control newProductPrice" realPrice="'+price+'" name="newProductPrice" id="newProductPrice" value="'+price+'"  required>'+
                    '<span class="input-group-addon">円</span>'+
                  '</div>'+
                '</div>'+

                '<div class="col-xs-1 X pull-right">'+
                  '✖︎'+
                '</div>'+

                '<div class="col-xs-3 pull-right">'+
                  '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" required>'+
                '</div>'+

              '</div>'+

            '</div>'
            
            )

        // Adding total prices
        addingTotalPrices();

        

        //Add Tax
        addTax()

        //Group products in json format
        listProducts()

        //Format products price
        $(".newProductPrice").number(true);

        //レシート
        $("#receipt_description").append(      
            '<div idService="'+idService+'">'+categories+' '+description+
            '<br>                   1 x '+price+'円</div>'
        )

        //仮売り
        $("#receipt_description2").append(      
          '<div idService="'+idService+'">'+
            '<div class="price2">'+categories+' '+description+'</div>'+
            '<div class="price1">1 x '+price+'円</div>'+
          '</div>'
        )

        // 15%OFFがすでにあるか検索
        // var input = document.getElementById("productsList").value;
        // let targetStr = '"id":"172"';
        // let result = input.indexOf(targetStr);
        // console.log(input);
        // console.log(result);

        //もし15％OFFがあれば
        // if(result != -1){
        //   console.log('ある');
          // 合計
          // var totalPrice = $('#newSaleTotal').attr('totalSale');
          // console.log(totalPrice);
          //15％引きの金額
          // var elems = document.getElementsByClassName('reji-production');
          // elems.querySelector('[idService="172"]');
          // console.log(elems);
          // var discount = document.get

          // var new_totalPrice = totalPrice-discountPrice;
          // console.log(new_totalPrice);

        
        // }

    }
      })

    }
  })
});




//When table loads everytime that navigate in it
$(".salesTable").on("draw.dt", function(){
  if(localStorage.getItem("removeProduct") != null){
    var listidServices = JSON.parse(localStorage.getItem('removeProduct'));
    
    for(var i=0; i<listidServices.length; i++){
      $("button.recoverButton[idService='"+listidServices[i]["idService"]+"']").removeClass('btn-default');
      $("button.recoverButton[idService='"+listidServices[i]["idService"]+"']").addClass('btn-primary addServiceSale');
    }
  }
})

//REMOVE PRODUCTS FROM THE SALE AND RECOVER BUTTON
var idRemoveProduct = [];
localStorage.removeItem("removeProduct");
$(".box-body").on("click", "button.removeProduct", function(){
  $(this).parent().parent().remove();
  var idService = $(this).attr("idService");
  var idProduct = $(this).attr("idProduct");

  if(idService == "172"){
    document.getElementById('15%off').disabled = false;
  }
  if(idService == "171"){
    document.getElementById('shokaiwari').disabled = false;
  }

  
  //Store in localstorage the ID of the product we want to delete
  if(localStorage.getItem("removeProduct") == null){
    idRemoveProduct = [];
  } else {
    idRemoveProduct.concat(localStorage.getItem("removeProduct"))
  }

  idRemoveProduct.push({"idService":idService});
  idRemoveProduct.push({"idProduct":idProduct});
  localStorage.setItem("removeProduct", JSON.stringify(idRemoveProduct));
  
  $("button.recoverButton[idService='"+idService+"']").removeClass('btn-default');
  $("button.recoverButton[idService='"+idService+"']").addClass('addServiceSale');
  $("button.recoverButton[idProduct='"+idProduct+"']").removeClass('btn-default');
  $("button.recoverButton[idProduct='"+idProduct+"']").addClass('addProductSale');

  if($(".newProduct").children().length == 0){
    $("#newTaxSale").val(0);
    $("#newTotalSale").val(0);
    $("#totalSale").val(0);
    $("#newTotalSale").attr("totalSale", 0);
  } else {
    //Adding total price
    addingTotalPrices();

    //Add Tax
    addTax();

    //Group products in json format
    listProducts()
  }

  
})

//Adding product from a device
var numProduct = 0;
$('.btnAddProduct').click(function(){
  numProduct++;
  var data = new FormData();
  data.append("getProducts", "ok");

  $.ajax({
    url: "ajax/products.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer)
      $(".newProduct").append(
        '<div class="row" style="padding:5px 15px">'+

          '<div class="col-xs-6 padding-right:0px">'+
            '<div class="input-group">'+
              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct><i class="fa fa-times"></i></button></span>'+
              '<select class="form-control newProductDescription" id="product'+numProduct+'" idProduct name="newProductDescription" required>'+
                '<option>Select product</option>'+
              '</select>'+
            '</div>'+
          '</div>'+
        
          '<div class="col-xs-3 enterQuantity">'+
            '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock newStock required>'+
          '</div>'+

          '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+
            '<div class="input-group">'+
              '<input type="number" class="form-control newProductPrice" realPrice="" name="newProductPrice" readonly required>'+
              '<span class="input-group-addon">円</span>'+
            '</div>'+
          '</div>'+
        '</div>');
      
      //Adding products to the select 
      answer.forEach(functionForEach);
      function functionForEach(item, index){
        if(item.stock != 0){
          $("#product"+numProduct).append(
            '<option idProduct="'+item.id+'" value="'+item.description+'">'+item.description+'</option>'
          )
        }
      }

      //Adding total price
      addingTotalPrices();

      //addTax
      addTax();

      //Set format to the product price
      $('.newProductPrice').number(true);
    }
  })
})

//Adding service from a device
var numService = 0;
$('.btnAddService').click(function(){
  numService++;
  var data = new FormData();
  data.append("getServices", "ok");

  $.ajax({
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer)
      $(".newProduct").append(
        '<div class="row" style="padding:5px 15px">'+

          '<div class="col-xs-6 padding-right:0px">'+
            '<div class="input-group">'+
              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idService><i class="fa fa-times"></i></button></span>'+
              '<select class="form-control newProductDescription" id="service'+numService+'" idService name="newProductDescription" required>'+
                '<option>Select service</option>'+
              '</select>'+
            '</div>'+
          '</div>'+
        
          '<div class="col-xs-3 enterQuantity">'+
            '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock newStock required>'+
          '</div>'+

          '<div class="col-xs-3 enterPrice" style="padding-left:0px">'+
            '<div class="input-group">'+
              '<input type="text" class="form-control newServicePrice" realPrice="" name="newServicePrice" readonly required>'+
              '<span class="input-group-addon">円</span>'+
            '</div>'+
          '</div>'+
        '</div>');
      
      //Adding products to the select 
      answer.forEach(functionForEach);
      function functionForEach(item, index){
        if(item.stock != 0){
          $("#service"+numService).append(
            '<option idService="'+item.id+'" value="'+item.description+'">'+item.description+'</option>'
          )
        }
      }

      //Adding total price
      addingTotalPrices();

      //addTax
      addTax();

      //Set format to the product price
      $('.newProductPrice').number(true);
    }
  })
})

//Select product
$(".box-body").on("change", "select.newProductDescription", function(){
  var productName = $(this).val();
  
  var newProductDescription = $(this).parent().parent().parent().children().children().children(".newProductDescription");
  var newProductPrice = $(this).parent().parent().parent().children(".enterPrice").children().children(".newProductPrice");
  var newProductQuantity = $(this).parent().parent().parent().children(".enterQuantity").children(".newProductQuantity");
  // console.log(newProductPrice.val());

  var data = new FormData();
  data.append("productName", productName);

  $.ajax({
    url: "ajax/products.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      $(newProductDescription).attr('idProduct', answer["id"]);
      $(newProductPrice).val(answer["selling_price"]);
      $(newProductPrice).attr("realPrice", answer["selling_price"]);

      //Group products in json format
      listProducts()
    }
  })
})

//Select service
$(".box-body").on("change", "select.newServiceDescription", function(){
  var serviceName = $(this).val();
  var newServiceDescription = $(this).parent().parent().parent().children().children().children(".newServiceDescription");
  var newServicePrice = $(this).parent().parent().parent().children(".enterPrice").children().children(".newServicePrice");
  var newServiceQuantity = $(this).parent().parent().parent().children(".enterQuantity").children(".newServiceQuantity");
  // console.log(newProductPrice);

  var data = new FormData();
  data.append("serviceName", serviceName);

  $.ajax({
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      $(newServiceDescription).attr('idService', answer["id"]);
      $(newServicePrice).val(answer["selling_price"]);
      $(newServicePrice).attr("realPrice", answer["selling_price"]);

      //Group products in json format
      listProducts()
    }
  })
})

//Modify quantity
$(".box-body").on("change", "input.newProductQuantity", function(){
  var price = $(this).parent().parent().children(".enterPrice").children().children(".newProductPrice");
  var finalPrice = $(this).val() * price.attr("realPrice");
  price.val(finalPrice);

  var newStock = Number($(this).attr("stock")) - $(this).val();
  $(this).attr("newStock", newStock);

  if(Number($(this).val()) > Number($(this).attr("stock"))){
    //If quantity is more than the stock value set initial values
    $(this).val(1);
    var finalPrice = $(this).val() * price.attr("realPrice");
    price.val(finalPrice);
    addingTotalPrices();

    swal({
      title: "The quantity is more than your stock",
      text: "There is only"+$(this).attr("stock")+" units!",
      type: "error",
      confirmButtonText: "Close"
    });
    return;
  }

  //Adding total price
  addingTotalPrices();

  //Add Tax
  addTax();

  //Group products in json format
  listProducts()
})

//Modify service price
$(".box-body").on("input", "input.newProductPrice", function(){
  var price = $(this).parent().parent().children(".enterPrice").children().children(".newProductPrice");
  var finalPrice = $(this).val() * price.attr("realPrice");
  price.val(finalPrice);

  //Adding total price
  addingTotalPrices();

  //Add Tax
  addTax();

  //Group products in json format
  listProducts()
})

//Price addition
function addingTotalPrices(){

  // var priceItem = $('.newServicePrice') serviceもnewProductPriceにしてる、便宜上;
  var priceItem = $('.newProductPrice') ;
  var arrayAdditionPrice = [];

  for(var i=0; i<priceItem.length; i++){
    arrayAdditionPrice.push(Number($(priceItem[i]).val()));
  }
  function additionalArrayPrices(totalSale, numberArray){
    return totalSale + numberArray;
  }
  var addingTotalPrice = arrayAdditionPrice.reduce(additionalArrayPrices);

  $("#newSaleTotal").val(addingTotalPrice);
  $('#saleTotal').val(addingTotalPrice);
  $('#newSaleTotal').attr('totalSale', addingTotalPrice);

  // console.log(arrayAdditionPrice);
}


//Add Tax
function addTax(){
  var tax = $('#newTaxSale').val();
  var totalPrice = $('#newSaleTotal').attr('totalSale');
  var taxPrice = Number(totalPrice * tax/100);
  var totalwithTax = Number(taxPrice) + Number(totalPrice);

  $("#newSaleTotal").val(totalwithTax);
  $("#saleTotal").val(totalwithTax);
  $("#newTaxPrice").val(taxPrice);
  $("#newNetPrice").val(totalPrice);
}

//When tax changes
$("#newTaxSale").change(function(){
  addTax();
})

//Final price format
$("#newSaleTotal").number(true);

//price format
$("#newProductPrice").number(true);

//Select method payment
$("#newPaymentMethod").on('change',function(){
  var method = $(this).val();
  if(method == "cash"){
    $(this).parent().parent().removeClass("col-xs-6");
    $(this).parent().parent().addClass("col-xs-4");
    $(this).parent().parent().parent().children(".paymentMethodBoxes").html(
      '<div class="col-xs-4 payment_price">'+
        '<div style="font-weight:bold">お支払い金額</div>'+
        '<div class="input-group">'+
          '<input type="number" class="form-control input-lg" id="newCashValue" name="newCashValue" placeholder="0" required>'+
          '<span class="input-group-addon">円</span>'+
        '</div>'+
      '</div>'+

      '<div class="col-xs-4" id="getCashChange" style="padding-left:0px">'+
        '<div style="font-weight:bold">おつり</div>'+
        '<div class="input-group">'+
          '<input type="text" class="form-control input-lg" id="newCashChange" name="newCashChange" placeholder="0" readonly required>'+
          '<span class="input-group-addon">円</span>'+
        '</div>'+
      '</div>'
    )
    

    //Adding format to the price
    $('#newCashValue').number(true);
    $('#newCashChange').number(true);

    //List method in the entry
    listMethods();
    
  } else {
    $(this).parent().parent().removeClass("col-xs-4");
    $(this).parent().parent().addClass("col-xs-6");
    $(this).parent().parent().parent().children('.paymentMethodBoxes').html(
      '<div class="col-xs-6" style="padding-left:0px">'+
        '<div class="input-group">'+
          '<input type="number" class="form-control input-lg" id="newTransactionCode" placeholder="Transaction code" required>'+
          '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
        '</div>'+
      '</div>'
    )
  }
})

// $.ajaxSetup({
//   beforeSend : function(xhr) {
//       xhr('text/html;charset=UTF-8');
//   }
// });


function BtPrint(prn){
  var S = "#Intent;scheme=rawbt;";
  var P =  "package=ru.a402d.rawbtprinter;end;";
  var textEncoded = encodeURI(prn);
  window.location.href="intent:"+textEncoded+S+P;
}

// for php demo call
function ajax_print(url, btn) {
    b = $(btn);
    b.attr('data-old', b.text());
    b.text('wait');
    $.get(url, function (data) {
      window.location.href = data;  
    }).fail(function () {
        alert("ajax error");
    }).always(function () {
        b.text(b.attr('data-old'));
    })

    // var S = "#Intent;scheme=rawbt;";
    // var P =  "package=ru.a402d.rawbtprinter;end;";
    // var textEncoded = encodeURI(prn);
    // window.location.href="intent:"+textEncoded+S+P;
}


// Cash change
$(".saleForm").on("input", 'input#newCashValue', function(){
  var cash = $(this).val();
  var change = Number(cash) - Number($('#saleTotal').val());
  
  var newCashChange = $(this).parent().parent().parent().children('#getCashChange').children().children("#newCashChange");
  newCashChange.val(change);

  //会計時に必要金額より少ない金額で決済されるのを防ぐため
  // if(change >= 0){
    
  //   $('.modal-footer').html(
  //     '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">閉じる</button>'+
  //     '<button type="submit" class="btn btn-primary" onclick="ajax_print(rawbt-receipt.php,this)">会計をする</button>'+
      
  //   )
  // }  

  $('input#newCashChange').val(change);
  
})

// レシート お預り金額とお釣り  
$(".saleForm").on("change", 'input#newCashValue', function(){
  var cash = $(this).val();
  var change = Number(cash) - Number($('#saleTotal').val());

  if($("div#receipt_oazukari")){
    $("div#receipt_oazukari").children().remove();
    $("div#receipt_oazukari").append(      
      '<div>                      '+cash+'円</div>'
    )
  }else{
    $("div#receipt_oazukari").append(      
      '<div>                      '+cash+'円</div>'
    )
  }
  
  if($("div#newCashChange")){
    $("div#newCashChange").children().remove();
    $("div#newCashChange").append(      
      '<div>                      '+change+'円</div>'
    )
  }else{
    $("div#newCashChange").append(      
      '<div>                      '+change+'円</div>'
    )
  }
  
})


//Change transaction code
$('.box-body').on("change", "input#newTransactionCode", function(){
  //List method in the entry
  listMethods();
})

//List all the products
function listProducts(){
  var productsList = [];
  var description = $(".newProductDescription");
  var quantity = $('.newProductQuantity');
  var price = $('.newProductPrice');
  

  for(var i=0; i < description.length; i++){
    productsList.push({
      "id": $(description[i]).attr('idProduct') || $(description[i]).attr('idService'),
      "description": $(description[i]).val(),
      "quantity": $(quantity[i]).val(),
      "price": $(price[i]).attr("realPrice"),
      "totalPrice": $(price[i]).val(),
      "id_2": $(description[i]).attr("name"),
      "idCategory": $(description[i]).attr('idCategory')
    })
  }
  // console.log(productsList);
  $('#productsList').val(JSON.stringify(productsList));
}

//List method payment
function listMethods(){
  // var listMethods = "";
  if($("#newPaymentMethod").val() == "cash"){
    $("#listPaymentMethod").val("cash");
    // console.log("cash1");
  } else {
    $("#listPaymentMethod").val($("#newPaymentMethod").val()+"-"+$("#newTransactionCode").val());
  }
}

//Edit sale button
$(".tables").on("click", ".btnEditSale", function(){
  var idSale = $(this).attr("idSale");
  window.location = "index.php?route=edit-sales&idSale="+idSale;
})

//Function to deactivate "ADD" buttons when the product has been selected in the folder
function removeAddServiceSale(){
  //capture all the product's id that were selected in the sale
  var idServices = $(".removeProduct");
  //capture al the buttons to add that appear in the table
  var tableButtons = $(".salesTable tbody button.addServiceSale");
  //navigate the cycle to get the different idServices that were added to the sale
  for(var i = 0; i < idServices.length; i++){
    //capture the IDs of the products added to the sale
    var button = $(idServices[i]).attr("idService");
    //go over the table that appears to deactivate the "add" buttons
    for(var j = 0; j < tableButtons.length; j ++){
			if($(tableButtons[j]).attr("idService") == button){
				$(tableButtons[j]).removeClass("btn-primary addServiceSale");
				$(tableButtons[j]).addClass("btn-default");
      }
    } 
  }
}

//Everytime that the table is loaded when we navigate through it executes a function
$('.salesTable').on( 'draw.dt', function(){
	removeAddServiceSale();
})

//delete sale
$(".tables").on("click", ".btnDeleteSale", function(){
  var idSale = $(this).attr("idSale");
  swal({
        title: '本当にこの売上を削除しますか?',
        text: "今ならまだキャンセルできます!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'キャンセル',
        confirmButtonText: 'はい、削除します!'
      }).then(function(result){
        if (result.value) {        
            window.location = "index.php?route=manage-sales&idSale="+idSale;
        }
  })
})

//Print bill 
$('.tables').on('click', '.btnPrintBill', function(){
  var saleCode = $(this).attr("saleCode");
  window.open("extensions/TCPDF-main2/examples/bill.php?code="+saleCode, "_blank");
})

//Dates range
$('#daterange-btn').daterangepicker({
  ranges: {
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
 },
  startDate: moment(),
  endDate  : moment()
},
function (start, end) {
  $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  var initialDate = start.format('YYYY-MM-DD');
  var finalDate = end.format('YYYY-MM-DD');

  var captureRange = $('#daterange-btn span').html();
  localStorage.setItem('captureRange', captureRange);
  console.log('localStorage', localStorage);

  window.location = "index.php?route=manage-sales&initialDate="+initialDate+"&finalDate="+finalDate;

}
)


//Cancel dates range
$('.cancelBtn').on("click", function(){
  localStorage.removeItem('captureRange');
  localStorage.clear();
  window.location = "manage-sales";
})

//Capture today's button
$('.ranges ul li').on('click', function(){
  var todayButton = $(this).attr('data-range-key');
  if(todayButton == "Today"){
    var d = new Date();
    var day = d.getDate();
    var month = d.getMonth()+1;
    var year = d.getFullYear();

    if(month < 10){
      var initialDate = year+"-0"+month+"-"+day;
      var finalDate = year+"-0"+month+"-"+day;
    } else if(day < 10){
      var initialDate = year+"-"+month+"-0"+day;
      var finalDate = year+"-"+month+"-0"+day;
    } else if(month < 10 && day < 10){
      var initialDate = year+"-0"+month+"-0"+day;
      var finalDate = year+"-0"+month+"-0"+day;
    } else {
      var initialDate = year+"-"+month+"-"+day;
      var finalDate = year+"-"+month+"-"+day;
    }

    localStorage.setItem("captureRange", "Today");
    window.location = "index.php?route=manage-sales&initialDate="+initialDate+"&finalDate="+finalDate;
  }
})  

//Edit sale button
$(".tables").on("click", ".btnEditSales2", function(){
  var idSale = $(this).attr("idSale");
  console.log(idSale);
  var data = new FormData();
  data.append("idSale", idSale);

  $.ajax({
    url: "ajax/sales.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      $('#editOnlySalesMemo').val(answer["memo"]);
      $('#idSale').val(answer["id"]);
    }
  })
})

// 仮売りに合計金額を表示
$('#modalKariuri').on('show.bs.modal', function (event) {
  //モーダルを取得
  var modal = $(this);
  //合計金額を取得
  var saleTotalItem = $('#newSaleTotal');
  var saleTotal = saleTotalItem.val();

  // レシートの合計金額
  if($("#receipt_total2")){
    $("#receipt_total2").children().remove();
    $("#receipt_total2").append(      
      '<p>'+saleTotal+'円</p>'
    )
  }else{
    $("#receipt_total2").append(      
      '<p>'+saleTotal+'円</p>'
    )
  }
})

// モーダルに合計金額を表示
$('#addSales').on('show.bs.modal', function (event) {
  //モーダルを取得
  var modal = $(this);
  //合計金額を取得
  var saleTotalItem = $('#newSaleTotal');
  var saleTotal = saleTotalItem.val();

  // レシートの合計金額
  if($("#receipt_total")){
    $("#receipt_total").children().remove();
    $("#receipt_total").append(      
      '<p>                      '+saleTotal+'円</p>'
    )
  }else{
    $("#receipt_total").append(      
      '<p>                      '+saleTotal+'円</p>'
    )
  }
  
  

  //newSellerを取得
  var newSellerItem = $('#newSeller');
  var newSeller = newSellerItem.val();

  //selectCustomerを取得
  var selectCustomerItem = $('#selectCustomer');
  var selectCustomer = selectCustomerItem.val();

  //newSaleを取得
  var newSaleItem = $('#newSale');
  var newSale = newSaleItem.val();

  //productsListを取得
  var productsListItem = $('#productsList');
  var productsList = productsListItem.val();

  //productsList2を取得
  var productsListItem2 = $('#productsList');
  var productsList2 = productsListItem2.val();

  //newTaxPriceを取得
  var newTaxPriceItem = $('#newTaxPrice');
  var newTaxPrice = newTaxPriceItem.val();

  //newNetPriceを取得
  var newNetPriceItem = $('#newNetPrice');
  var newNetPrice = newNetPriceItem.val();

  //listPaymentMethodを取得
  var listPaymentMethodItem = $('#listPaymentMethod');
  var listPaymentMethod = listPaymentMethodItem.val();

  //受け取った値を表示
  modal.find('.modal-body #morau_saleTotal').val(saleTotal) //inputタグの中に合計金額を入れる
  modal.find('.modal-body #morau_saleTotal_value').text(saleTotal).number(true); //単純に表示させるため。上だけだとmodalに金額が表示されない

  modal.find('.modal-body #morau_newSeller').val(newSeller); 
  modal.find('.modal-body #morau_selectCustomer').val(selectCustomer); 
  modal.find('.modal-body #morau_newSale').val(newSale); 
  modal.find('.modal-body #morau_productsList').val(productsList); 
  modal.find('.modal-body #morau_newTaxPrice').val(newTaxPrice); 
  modal.find('.modal-body #morau_newNetPrice').val(newNetPrice); 
  modal.find('.modal-body #morau_listPaymentMethod').val(listPaymentMethod); 

  //レシート
  modal.find('#morau_productsList2').val(productsList2); 
  modal.find('#morau_productsList2').text(productsList2); 
});

$("#newSeller").on("change", function(){
  $('.box-footer').html(
    '<button type="submit" class="btn btn-primary pull-left" data-toggle="modal" data-target="#addSales">支払いへ</button>'
  )
})

// 紹介割ボタン
$(".shokaiwari").on("click", function(){
  document.getElementById("shokaiwari").disabled = true;

  var idService = $(this).attr("idService");
  // $(this).removeClass("btn-danger addServiceSale");
  // $(this).addClass("btn-default");

  var data = new FormData();
  data.append("idService", idService);

  $.ajax({
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      var description = answer["description"];
      var price = answer["selling_price"];

      var idCategory = answer["id_category"];
      var data = new FormData();
      data.append("idCategory", idCategory);
      $.ajax({
        url: "ajax/categories.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
          var categories = answer["Category"];
          
          $(".newProduct").append(      
            '<div class="row" style="padding:0px 15px 30px 0">'+
              
              '<div class="reji-production">'+
                '<button type="button" class="btn btn-danger btn-xs removeProduct" idService ="'+idService+'"><i class="fa fa-times"></i></button>'+
                '<input type="text" style="border:none" class="newProductDescription" idService="'+idService+'" name="addServiceSale" value="'+categories+' '+description+'" required></input>'+          
              '</div>'+

              '<div class="quantityAndPrice ">'+
              
                '<div class="col-xs-5 enterPrice pull-right">'+
                  '<div class="input-group">'+
                    '<input type="number" class="form-control newProductPrice" realPrice="'+price+'" name="newProductPrice" id="newProductPrice" value="'+price+'"  required>'+
                    '<span class="input-group-addon">円</span>'+
                  '</div>'+
                '</div>'+

                '<div class="col-xs-1 X pull-right">'+
                  '✖︎'+
                '</div>'+

                '<div class="col-xs-3 pull-right">'+
                  '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" required>'+
                '</div>'+

              '</div>'+

            '</div>'
            
            )

        // Adding total prices
        addingTotalPrices();

        //Add Tax
        addTax()

        //Group products in json format
        listProducts()

        //Format products price
        $(".newProductPrice").number(true);

        //レシート
        $("#receipt_description").append(      
            '<div idService="'+idService+'">'+categories+' '+description+
            '<br>                   1 x '+price+'円</div>'
        )

        //仮売り
        $("#receipt_description2").append(      
          '<div idService="'+idService+'">'+
            '<div class="price2">'+categories+' '+description+'</div>'+
            '<div class="price1">1 x '+price+'円</div>'+
          '</div>'
        )
    }
      })
    }
  })
});


// 初回15%off割引ボタン
$(".15off").on("click", function(){
  document.getElementById("15%off").disabled = true;

  var totalPrice = $('#newSaleTotal').attr('totalSale');
  var discountPrice = 0 - Number(totalPrice * 0.15);

  var idService = $(this).attr("idService");
  // $(this).removeClass("btn-danger addServiceSale");
  // $(this).addClass("btn-default");

  var data = new FormData();
  data.append("idService", idService);

  $.ajax({
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      var description = answer["description"];
      // var price = answer["selling_price"];

      var idCategory = answer["id_category"];
      var data = new FormData();
      data.append("idCategory", idCategory);
      $.ajax({
        url: "ajax/categories.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(answer){
          var categories = answer["Category"];
          
          $(".newProduct").append(      
            '<div class="row" style="padding:0px 15px 30px 0">'+
              
              '<div class="reji-production">'+
                '<button type="button" class="btn btn-danger btn-xs removeProduct" idService ="'+idService+'"><i class="fa fa-times"></i></button>'+
                '<input type="text" style="border:none" class="newProductDescription" idService="'+idService+'" name="addServiceSale" value="'+categories+' '+description+'" required></input>'+          
              '</div>'+

              '<div class="quantityAndPrice ">'+
              
                '<div class="col-xs-5 enterPrice pull-right">'+
                  '<div class="input-group">'+
                    '<input type="number" class="form-control newProductPrice" realPrice="'+discountPrice+'" name="newProductPrice" id="newProductPrice" value="'+discountPrice+'"  required>'+
                    '<span class="input-group-addon">円</span>'+
                  '</div>'+
                '</div>'+

                '<div class="col-xs-1 X pull-right">'+
                  '✖︎'+
                '</div>'+

                '<div class="col-xs-3 pull-right">'+
                  '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" required>'+
                '</div>'+

              '</div>'+

            '</div>'
            
            )

        // Adding total prices
        addingTotalPrices();

        //Add Tax
        addTax()

        //Group products in json format
        listProducts()

        //Format products price
        $(".newProductPrice").number(true);

        //レシート
        $("#receipt_description").append(      
            '<div idService="'+idService+'">'+categories+' '+description+
            '<br>                   1 x '+discountPrice+'円</div>'
        )

        //仮売り
        $("#receipt_description2").append(      
          '<div idService="'+idService+'">'+
            '<div class="price2" >'+categories+' '+description+'</div>'+
            '<div class="price1">1 x '+discountPrice+'円</div>'+
          '</div>'
        )
    }
      })
    }
  })
});


//レジで削除したらレシートの項目も削除する
$(".box-body").on("click", "button.removeProduct", function(){
  var idService = $(this).attr("idService");
  var idProduct = $(this).attr("idProduct");
  // console.log(idService);
  var elems = document.getElementById('receipt_description').querySelector('[idService="'+idService+'"]');
  var elems2 = document.getElementById('receipt_description').querySelector('[idProduct="'+idProduct+'"]');
  // console.log(elems);
  if(elems){
    elems.remove();
  } else {
    elems2.remove();
  }
})

//レジで削除したらレシートの項目も削除する
$(".box-body").on("click", "button.removeProduct", function(){
  var idService = $(this).attr("idService");
  var idProduct = $(this).attr("idProduct");
  // console.log(idService);
  var elems = document.getElementById('receipt_description2').querySelector('[idService="'+idService+'"]');
  var elems2 = document.getElementById('receipt_description2').querySelector('[idProduct="'+idProduct+'"]');
  console.log(elems);
  if(elems){
    elems.remove();
  } else {
    elems2.remove();
  }
})


