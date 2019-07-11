$(document).ready(function () {
    
    // ADD TO BASKET BUTTON CLICK & (green plus one sign)
    $('.add_to_basket_btn').click(function(){
    
      // get values from the item that was clicked 
      var the_id = $(this).attr('rel');
      var the_name = $(this).attr('value');
      var the_price = $(this).attr('data');

      // make object to post
      var data = 
      {
        id : the_id,
        name : the_name,
        price : the_price
      };


      // post object
        $.ajax({
            type: "post",
            url: "/matteos_takeaway/Add_to_basket.php",
            // dataType: "html",
            data: data,
            success: function() {

            location.reload();

            },
            error: function(){
            alert('something went wrong');   
            }
        });
            
    }); 

    $('.minus_1').click(function(){
    
      // get values from the item that was clicked 
      var the_id = $(this).attr('rel');
      var the_name = $(this).attr('value');
      var the_price = $(this).attr('data');

      // make object to post
      var data = 
      {
        minus_id : the_id,
        minus_name : the_name,
        minus_price : the_price
      };

      // post object
      $.ajax({
        type: "post",
        url: "/matteos_takeaway/Add_to_basket.php",
        // dataType: "html",
        data: data,
        success: function() {

        location.reload();

        },
        error: function(){
        alert('something went wrong');   
        }
    });
     
            
    }); 

    $('.remove_all').click(function(){
    
      // get values from the item that was clicked 
      var the_id = $(this).attr('rel');
      var the_name = $(this).attr('value');
      var the_price = $(this).attr('data');

      // make object to post
      var data = 
      {
        delete_id : the_id,
        delete_name : the_name,
        delete_price : the_price
      };

      // post object
      $.ajax({
        type: "post",
        url: "/matteos_takeaway/Add_to_basket.php",
        // dataType: "html",
        data: data,
        success: function() {

        location.reload();

        },
        error: function(){
        alert('something went wrong');   
        }
    });
     
            
    }); 


    // remove added to basket banner   
      setTimeout(function(){
         $(".login_banner").fadeOut('slow');

      },2000);



});








