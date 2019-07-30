
<!-- Page Content -->
<div class="container" id="login_contain">

    <div class="form-gap"></div>
   
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-sm"> </div>
            
            <div id="main_div" class="col-xs-12 col-md-6">
                <div class="panel-body">
                    <div class="text-center">

                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                                
                        <h2 id="login_head" class="text-center">Reset Password</h2>
                               
                            <div class="panel-body">

                                <form action="" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <label for="username" class="float-left"> <b> <u> Choose A New Password: </u> </b> </label> <br>
                                        <div class="alert-danger"> <?= $msg['password']; ?> </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="password" name="password" placeholder="enter new password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="username" class="float-left"> <b> <u> Confirm Password: </u>  </b> </label> <br>
                                        <div class="alert-danger"> <?= $msg['password']; ?> </div>
                                        <div class="input-group">         
                                            <span class="input-group-addon"> <span class="glyphicon glyphicon-check"></span> </span>
                                            <input id="password" name="password_confirm" placeholder="confirm new password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="submit" class="btn btn-lg btn-success btn-block" value="Confirm" type="submit">
                                    </div>

                                </form>
                                
                                <div class="alert-success"> <?= $msg['success']; ?>  </div>
                            </div>

                    </div>
                </div>
            </div>  
         
            <div class="col-md-3 hidden-sm"> </div>
        </div>
    </div>

    <hr>
  
</div> <!-- /.container -->

