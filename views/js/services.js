// Load dynamic products table
// $.ajax({
//   url: "ajax/datatable-products.ajax.php",
//   success: function(answer){
//     console.log("answer", answer);
//   }
// });

var hiddenProfile = $('#hiddenProfile').val();

$('.servicesTable').DataTable({
  "ajax": "ajax/datatable-services.ajax.php?hiddenProfile="+hiddenProfile,
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
    url: "ajax/services.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      console.log(answer);
      if(!answer){
        var newCode = idCategory + "01";
        $('#newCode').val(newCode);
      } else {
        var newCode = Number(answer["code"]) + 1;
        $('#newCode').val(newCode);
        // console.log(newCode);
      }
    }
  })
})

//Edit product
$(".servicesTable tbody").on("click", "button.btnEditService", function(){
  var idService = $(this).attr('idService');
  // console.log(idService);
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
          console.log("answer", answer);
          $('#editCategory').val(answer["id"]);
          $('#editCategory').html(answer["Category"]);
        }
      })

      $('#editCode').val(answer["code"]);
      $('#editDescription').val(answer["description"]);
      $('#editSellingPrice').val(answer["selling_price"]);
    }
  })
})

//Delete product
$('.servicesTable tbody').on('click', 'button.btnDeleteService', function(){
  var idService = $(this).attr("idService");
  var code = $(this).attr('code');
  // console.log(idService);
  // console.log(code);

  swal({
    title: "本当にこのサービスを削除しますか?",
    text: "今ならまだキャンセルできます!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "キャンセル",
    confirmButtonText: "はい、削除します!"
  }).then(function(result){
    if (result.value){
      window.location = "index.php?route=services&idService="+idService+"&code"+code;
    }
  })
})