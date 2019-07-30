<!-- Page Content -->
<div class="container" id="login_contain">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-sm"> </div>
            <div id="main_div" class="col-xs-12 col-md-6">
                <div class="">
                    <div class="">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 id="login_head" class="text-center">Forgotton Password?</h2>
                            <p> <b>  You can reset your password here.  </b> </p>
                            
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <label for="">Please Enter Your Email</label> <br>
                                        <div class="alert-danger" > <?= $msg['email']; ?> </div>   
                                        <div class="input-group"> 
                                            <input  id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div> 
                                    </div>
                                    
                                    <div class="form-group">
                                        <input name="forgot_submit" class="btn btn-lg btn-success btn-block" value="Reset Password" type="submit">
                                    </div>

                                </form>

                                <div class="alert-success" > <?= $msg['password']; ?> </div>   

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>   
                       
            <div class="col-md-3 hidden-sm"> </div>
        </div>
    </div>

    <hr>

</div> 




