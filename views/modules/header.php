<header class="main-header">

  <!--=====================================
	=           logo        =
	======================================-->
  <a href="home" class="logo">
    <span class="logo-lg" style="font-size:small;">サンプル</span>
  </a>

  <!--=====================================
	=            navigation         =
	======================================-->
  <nav class="navbar navbar-static-top" role="navigation">

    <!-- navigation button -->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <!-- user profile -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
            <?php
              if($_SESSION["photo"] != ""){
                
                echo '<img src="'.$_SESSION["photo"].'"class="user-image">';
              } else {
                echo '<img src="views/img/users/default/anonymous.png" class="user-image">';
              }
            ?>

            <span class="hidden-xs"><?php echo $_SESSION["name"]; ?></span>
          </a>

          <!-- dropdown-toggle -->
          <ul class="dropdown-menu">
            <li class="user-body">
              <div class="pull-right">
                <a href="logout" class="btn btn-default btn-flat">Logout</a>
              </div>
            </li>
          </ul>

        </li>
      </ul>
    </div>

    

  </nav>
</header>