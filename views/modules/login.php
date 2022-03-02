<div id="back"></div>

<div class="login-box">
  <div class="login-logo">
    サンプル<br>POSシステム
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">ログインボタンをクリックして、ログインしてください</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="hidden" class="form-control" placeholder="User" name="loginUser" value="sample" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="hidden" class="form-control" placeholder="Password" name="loginPass" value="123" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-10">
          <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
        </div>
      </div>

      <?php 
        $login = new ControllerUsers();
        $login -> ctrUserLogin();
      ?>
      
    </form>
  </div>
</div>