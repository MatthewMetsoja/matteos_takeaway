

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Are you sure you want to delete "<span id="item_name_modal_head"> </span>" from the database?</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
            <h6>If so then please enter and confirm the master password, then click delete. </h6>  
                <div class="container-fluid">
                    <form method="post" action="">
                        
                        <label for=""> <b>Password: </b> </label> 
                        <div class="col-sm-6 alert-danger"> <?= $msg['password'] ?> </div>
                        <input name="delete_password" class="form-control col-sm-6"  type="password" placeholder="Please enter master password"> 
                        <label for=""> <b>Confirm Password: </b> </label> 
                    
                        <input name="delete_password_confirm" class="form-control col-sm-6"  type="password" placeholder="Please enter master password">  
                      <!-- hidden input so we can pass the id  with js for the delete query  -->
                        <input type="hidden" id="hidden_input" value="" name="id_to_delete">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name="submit_delete" class="btn btn-danger">Delete item</button>
            </div>
            </form>
        </div>
    </div>
</div>

