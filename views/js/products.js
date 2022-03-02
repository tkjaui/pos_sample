// Load dynamic products table
// $.ajax({
//   url: "ajax/datatable-products.ajax.php",
//   success: function(answer){
//     console.log("answer", answer);
//   }
// });

var hiddenProfile = $('#hiddenProfile').val();

$('.productsTable').DataTable({
  "ajax": "ajax/datatable-products.ajax.php?hiddenProfile="+hiddenProfile,
  "deferRender": true,
  "retrieve": true,
  "processing": true
});

// // Getting category to assign a code
$('#newCategory').change(function(){
  var idCategory = $(this).val();
  // console.log(idCategory);
  var data = new FormData();
  data.append("idCategory", idCategory);

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
      if(!answer){
        var newCode = idCategory + "01";
        $('#newCode_p').val(newCode);
      } else {
        var newCode = Number(answer["code"]) + 1;
        $('#newCode_p').val(newCode);
        console.log(newCode);
      }
    }
  })
})

//Adding selling price
// $("#newBuyingPrice, #editBuyingPrice").change(function(){

// 	if($(".percentage").prop("checked")){

// 		var valuePercentage = $(".newPercentage").val();
		
// 		var percentage = Number(($("#newBuyingPrice").val()*valuePercentage/100))+Number($("#newBuyingPrice").val());

// 		var editPercentage = Number(($("#editBuyingPrice").val()*valuePercentage/100))+Number($("#editBuyingPrice").val());

// 		$("#newSellingPrice").val(percentage);
// 		$("#newSellingPrice").prop("readonly",true);

// 		$("#editSellingPrice").val(editPercentage);
// 		$("#editSellingPrice").prop("readonly",true);

// 	}

// })

//Percentage change
// $(".newPercentage").change(function(){

// 	if($(".percentage").prop("checked")){

// 		var valuePercentage = $(this).val();
		
// 		var percentage = Number(($("#newBuyingPrice").val()*valuePercentage/100))+Number($("#newBuyingPrice").val());

// 		var editPercentage = Number(($("#editBuyingPrice").val()*valuePercentage/100))+Number($("#editBuyingPrice").val());

// 		$("#newSellingPrice").val(percentage);
// 		$("#newSellingPrice").prop("readonly",true);

// 		$("#editSellingPrice").val(editPercentage);
// 		$("#editSellingPrice").prop("readonly",true);

// 	}

// })

// $(".percentage").on("ifUnchecked",function(){

// 	$("#newSellingPrice").prop("readonly",false);
// 	$("#editSellingPrice").prop("readonly",false);

// })

// $(".percentage").on("ifChecked",function(){

// 	$("#newSellingPrice").prop("readonly",true);
// 	$("#editSellingPrice").prop("readonly",true);

// })


//Edit product
$(".productsTable tbody").on("click", "button.btnEditProduct", function(){
  var idProduct = $(this).attr('idProduct');
  // console.log(idProduct);
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
      console.log("answer", answer);

      var categoryData = new FormData();
      categoryData.append("idCategory", answer["id_category"]);

      $.ajax({
        url:"ajax/categories.ajax.php",
        method: "POST",
        data: categoryData,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success:function(answer){
          // console.log("answer", answer);
          $('#editCategory').val(answer["id"]);
          $('#editCategory').html(answer["Category"]);
        }
      })

      $('#editCode').val(answer["code"]);
      $('#editDescription').val(answer["description"]);
      $('#editStock').val(answer["stock"]);
      $('#editBuyingPrice').val(answer["buying_price"]);
      $('#editSellingPrice').val(answer["selling_price"]);
      $('#currentImage').val(answer["image"]);
      if(answer["image"] != ''){
        $('.preview').attr('src', answer["image"]);
      }
    }
  })
})

//Delete product
$('.productsTable tbody').on('click', 'button.btnDeleteProduct', function(){
  var idProduct = $(this).attr("idProduct");
  var code = $(this).attr('code');
  var image = $(this).attr('image');
  // console.log(idProduct);

  swal({
    title: "本当にこの商品を削除しますか?",
    text: "今ならまだキャンセルできます!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "キャンセル",
    confirmButtonText: "はい、削除します!"
  }).then(function(result){
    if (result.value){
      window.location = "index.php?route=products&idProduct="+idProduct+"&code"+code;
    }
  })
})

// Uploading product Pics
$(".newImage").change(function(){
  var newImage = this.files[0];
  
  // validating image format
  if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png"){
    $(".newImage").val("");

    swal({
      type: "error",
      title: "Error uploading image",
      text: "写真はJPEGかPNG形式です!",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
  } else if(newImage["size"] > 2000000){
    $(".newImage").val("");

    swal({
      type: "error",
      title: "Error uploading image",
      text: "写真のサイズが大きすぎます。2Mb以下でお願いします!",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
  } else {
    var imgData = new FileReader;
    imgData.readAsDataURL(newImage);

    $(imgData).on("load", function(event){
      var routeImg = event.target.result;
      $(".preview").attr("src", routeImg);//srcの属性にrouteImgを入れるということ
    });
  }

})