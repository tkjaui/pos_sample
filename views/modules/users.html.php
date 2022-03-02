
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      User Management
    </h1>
    <ol class="breadcrumb">
      <li><a href="home"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">User Management</li>
    </ol>
  </section>


  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUser">
          Add user
        </button>       
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Name</th>
              <th>Username</th>
              <th>Photo</th>
              <th>Profile</th>
              <th>Status</th>
              <th>Last login</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Admin user</td>
              <td>admin</td>
              <td><img src="views/img/users/default/anonymous.png" class="img-thumbnail" width="40px"></td>
              <td>Administrator</td>
              <td><button class="btn btn-success btn-xs">Activate</button></td>
              <td>2017-12-11 12:05:23</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                </div>
              </td>
            </tr>

            <tr>
              <td>2</td>
              <td>Admin user</td>
              <td>admin</td>
              <td><img src="views/img/users/default/anonymous.png" class="img-thumbnail" width="40px"></td>
              <td>Administrator</td>
              <td><button class="btn btn-success btn-xs">Activate</button></td>
              <td>2017-12-11 12:05:23</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div id="addUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add User</h4>       
        </div>
      
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="newName" placeholder="Insert name" required>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="newUser" placeholder="Insert username" required>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="newPassword" placeholder="Insert password" required>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="newProfile">
                  <option value="">Select profile</option>
                  <option value="administrator">Administrator</option>
                  <option value="special">Special</option>
                  <option value="seller">Seller</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="panel">Upload image</div>
              <input class="newPics" type="file" name="newPhoto">
              <p class="help-block">Maximum size 2Mb</p>
              <img src="views/img/users/default/anonymous.png" class="thumbnail preview" width="100px">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>  
    </div>
  </div>
</div>