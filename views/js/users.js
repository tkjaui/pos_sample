
// Uploading user Pics
$(".newPics").change(function(){
  var newImage = this.files[0];
  
  // validating image format
  if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png"){
    $(".newPics").val("");

    swal({
      type: "error",
      title: "Error uploading image",
      text: "写真はJPEGかPNG形式です!",
      showConfirmButton: true,
      confirmButtonText: "Close"
    });
  } else if(newImage["size"] > 2000000){
    $(".newpics").val("");

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

// edit user
$(document).on("click", ".btnEditUser", function(){
  var idUser = $(this).attr("idUser");//attr: idUserの値の取得
  var data = new FormData();
  data.append("idUser", idUser);
  
    $.ajax({
    url: "ajax/users.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){
      // console.log('answer', answer);
      $("#EditName").val(answer["name"]);//valueの値を(answer["name"])に変更する
      $("#EditProfile").html(answer["profile"]);
      $("#EditProfile").val(answer["profile"]);
      $("#currentPasswd").val(answer["password"]);
      $("#currentPicture").val(answer["photo"]);
      if(answer["photo"] != ''){
        $('.preview').attr('src', answer["photo"]);
      }
    }
  });
});

// activate user
$(document).on("click", ".btnActivate", function(){
  var userId = $(this).attr("userId");
  var userStatus = $(this).attr("userStatus");

  var datum = new FormData();
  datum.append("activateId", userId);
  datum.append("activateUser", userStatus);

  $.ajax({
    url: "ajax/users.ajax.php",
    method: "POST",
    data: datum,
    cache: false,
    contentType: false,
    processData: false,
    success: function(answer){
      // console.groupCollapsed('answer:', answer);
      if(window.matchMedia("(max-width:767px)").matches){
        swal({
          title: "The user status has been updated",
          type: "success",
          confirmButtonText: "Close"
        }).then(function(result){
          if(result.value){
            window.location = "users";
          }
        })
      }
    }
  })

  if(userStatus == 0){
    $(this).removeClass('btn-success');
    $(this).addClass('btn-danger');
    $(this).html('Deactivated');
    $(this).attr('userStatus', 1);
  } else {
    $(this).addClass('btn-success');
    $(this).removeClass('btn-danger');
    $(this).html('Activated');
    $(this).attr('userStatus', 0);
  }
});

// validate if user already exists
$("#newUser").change(function(){
  $(".alert").remove();

	var user = $(this).val();

	var data = new FormData();
  data.append("validateUser", user);//"validateUser"がkey、userがvalueのセットができる
  
  $.ajax({
    url:"ajax/users.ajax.php",
	  method: "POST",
	  data: data,
	  cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(answer){ 
      // console.log('answer', answer);
      if(answer){
        $("#newUser").parent().after('<div class="alert alert-warning">This user is already taken</div>');	
      	$("#newUser").val('');
      }
    }
  });
});

//delete user
$(document).on('click', '.btnDeleteUser', function(){
  // console.log('cdamwkfrw');
  // var_dump('cmvadlwfj');

  var userId = $(this).attr('userId');
  var userPhoto = $(this).attr('userPhoto');
  var username = $(this).attr('username');

  swal({
    title: "このユーザー本当に削除して良いですか?",
    text: "今ならまだキャンセルできます!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonText: 'キャンセル',
    confirmButtonText: 'はい、削除します!'
  }).then(function(result){
    if (result.value){ 
      window.location = "index.php?route=users&userId="+userId+"&username="+username+"&userPhoto="+userPhoto;
    }
  })
})




