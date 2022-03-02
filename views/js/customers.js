$(".tables").on("click", "tbody .btnEditCustomer", function(){
  var idCustomer = $(this).attr("idCustomer");
  var data = new FormData();
  data.append("idCustomer", idCustomer);

  $.ajax({
    url: "ajax/customers.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      $('#idCustomer').val(answer["id"]);
      $('#editCustomer').val(answer["name"]);
      $('#editSex').val(answer["sex"]);
      $('#editEmail').val(answer["email"]);
      $('#editPhone').val(answer["phone"]);
      $('#editAddress').val(answer["address"]);
      $('#editBirthdate').val(answer["birthdate"]);
      $('#editMemo').val(answer["memo"]);
    }
  })
})

$(".tables").on("click", "tbody .btnDeleteCustomer", function(){
  var idCustomer = $(this).attr('idCustomer');
  swal({
    title: "本当にこのお客様を削除しますか?",
    text: "今ならまだキャンセルできます!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "キャンセル",
    confirmButtonText: "はい、削除します!"
  }).then(function(result){
    if(result.value){
      window.location = "index.php?route=customers&idCustomer="+idCustomer;
    }
  })
})

// customer detailsのお客様編集ボタン
$("h4").on("click", ".btnEditCustomer2", function(){
  var idCustomer = $(this).attr("idCustomer");
  var data = new FormData();
  data.append("idCustomer", idCustomer);

  $.ajax({
    url: "ajax/customers.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      $('#editOnlyCustomersMemo').val(answer["memo"]);
    }
  })
})