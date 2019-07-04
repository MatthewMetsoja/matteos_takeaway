
<div class="container" id="login_contain">
    <div class="row">
        <div class="col-sm-12">
            
                    
        <div id="login_title"> <h1 class="text-center">  Staff Login</h1>  </div>

            <div class="row">
                <div class="col-1"></div>
                
                <div class="col-10">
                 <div id="login_form">
                    <form method="post" action="">
                                <div class="form-group row">
                                    <label for="number" class="col-sm-12 col-form-label"> <b>  <u>Email:</u> </b> </label>
                                    <div class="col-sm-12">
                                        <div class="text-danger"><?= $msg['email'] ?></div>
                                        <input type="email" class="form-control" name="email" value="<?= isset($email) ? trim($email) : '' ?>" placeholder="Please enter email address">
                                    </div>
                                </div>
                          
                                <div class="form-group row">
                                    <label for="number" class="col-sm-12 col-form-label"> <u> <b> Password </b> </u>  </label>
                                    <div class="col-sm-12">
                                     <div class="text-danger"> <?= $msg['password'] ?></div>
                                        <input type="password" class="form-control" name="password" placeholder="Please enter password">
                                        <div class="mt-2"> <a class="text-light" href="forgot.php">Click here to reset, if you've forgotton </a> </div>
                                    </div>
                                  
                                </div>

                                <button type="submit" name="submit" class="btn btn-block btn-success">Login</button>
                              
                        </form>
                     
                    </div>   
                </div>

                <div class="col-1"></div>
           </div>


        </div>
    </div>
</div>



