<h5 class="text-center">Add a new staff member</h5>

<div class="menu_form"> 
<form method="post" action="" enctype="multipart/form-data">

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> First Name</u> </b> </label>
    <div class="col-sm-12">
    <div class="alert-danger">  <?= $msg['first_name']; ?>  </div>
        <input type="text" value="<?= isset($first_name) ? trim($first_name) : ''; ?>"  pattern="[a-zA-Z ]*" class="form-control" name="first_name" placeholder="Enter first name">
    </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Last Name</u> </b> </label>
    <div class="col-sm-12">
    <div class="alert-danger">  <?= $msg['last_name']; ?>  </div>
        <input type="text" pattern="[a-zA-Z ]*" value="<?= isset($last_name) ? trim($last_name) : ''; ?>" class="form-control" name="last_name" placeholder="Enter last name">
    </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Email</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['email']; ?> </div>
        <input type="email" value="<?= isset($email) ? $email: '';?>" class="form-control" name="email" placeholder="Enter email">
    </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Mobile Number</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['mobile_number']; ?> </div>
        <input type="number" pattern="['0-9]'"  value="<?= isset($mobile_number) ? $mobile_number: '';?>" class="form-control" name="mobile_number"  placeholder="Enter Mobile Number">
    </div>
 </div>



<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Password</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['password']; ?> </div>
        <input type="password" class="form-control" name="password" placeholder="Enter password">
    </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Password Confirm</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['password_confirm']; ?> </div>
        <input type="password" class="form-control" name="password_confirm" placeholder="Re-Enter password">
    </div>
</div>

<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u>Picture</u>  </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['picture']; ?> </div>
        <input type="file" class="form-control"  name="picture">
    </div>
</div>


<div class="form-group row">
    <label for="inputName" class="col-sm-12 col-form-label"> <b> <u> Role </u> </b>  </label>
    <div class="col-sm-12">
    <div class="alert-danger"> <?= $msg['role'] ?></div>
    Admin    <input type="radio" <?php if(isset($role) && $role == "admin"){echo "checked";} ?>  value="admin" name="role" >  &nbsp; &nbsp; 
    Staff <input type="radio"  <?php if(isset($role) && $role == "staff"){echo "checked";} ?>  value="staff" name="role">
  
    </div>
</div>

 <button type="submit" name="submit" class="btn btn-block btn-success">Add new staff member</button>

</form>

</div>