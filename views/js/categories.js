//Edit category
$(".tables").on("click", ".btnEditCategory", function(){
  var idCategory = $(this).attr('idCategory');
  var data = new FormData();
  data.append('idCategory', idCategory);

  $.ajax({
    url: "ajax/categories.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log(answer);
      $('#editCategory').val(answer["Category"]);
      $('#idCategory').val(answer["id"]);
    }
  })
})

//Delete category
$(".tables").on('click', '.btnDeleteCategory', function(){
  var idCategory = $(this).attr('idCategory');
  swal({
    title: "本当にこのカテゴリーを消しますか?",
    text: "今ならまだキャンセルができます!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: "#d33",
    cancelButtonText: "キャンセル",
    confirmButtonText: "はい、削除します!"
  }).then(function(result){
    if(result.value){
      window.location = "index.php?route=categories&idCategory="+idCategory;
    }
  })
})