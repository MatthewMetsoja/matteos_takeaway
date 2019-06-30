$(document).ready(function () {
    
   
   $('.delete_item_from_menu_btn').click(function(){

        var title = $(this).attr('rel');
        var id_to_delete = $(this).val();

        // set hidden input value to the id that we want to delete
        $('#hidden_input').val(id_to_delete);

        $('#item_name_modal_head').html(title);

        $('#delete_modal').modal('show');


   });
   

      // remove added to basket banner   
      setTimeout(function(){
         $(".login_banner").fadeOut('slow');

      },3000);





});




