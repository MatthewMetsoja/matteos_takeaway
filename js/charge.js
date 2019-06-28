// Create a Stripe client.
var stripe = Stripe('pk_test_kg7L4DC0CijlPfn9nvWVGxM000cxKrPcEe');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// style button with bootstrap
document.querySelector('#payment-form button').classList = 'btn btn-success btn-block mt-4';

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();


 // my form validation goes here
  var first_name = document.getElementById('first_name').value;
  var first_name_error = document.getElementById('first_name_alert');
  var last_name = document.getElementById('last_name').value;
  var last_name_error = document.getElementById('last_name_alert');
  var delivery_address = document.getElementById('delivery_address').value;
  var delivery_address_error = document.getElementById('delivery_address_alert');
  var postcode = document.getElementById('postcode').value;
  var postcode_error = document.getElementById('postcode_alert');
  var phone_number = document.getElementById('phone_number').value;
  var phone_number_error = document.getElementById('phone_number_alert');
  var email = document.getElementById('email').value;
  var email_error = document.getElementById('email_alert');

 


    stripe.createToken(card).then(function(result) {
      if (result.error) {  
        // Inform the user if there was an error with stripe.
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } 
    
      // my form validation goes here or will stripe submit with card number filled out but empty details
      if(first_name.trim() == "" ){
        first_name_error.innerHTML =  "Please Enter Your First Name ";
      }
    
      if(last_name.trim() == ""){
        last_name_error.innerHTML = "Please Enter your Last Name" ;
      }
    
      if(delivery_address.trim() == "" ){
        delivery_address_error.innerHTML = "Please Enter Your delivery address";
      }
    
      if(postcode.trim() == "" ){
        postcode_error.innerHTML = "Please Enter Your Postcode";
      }
    
      if(phone_number[0] !== "0"){
        phone_number_error.innerHTML = "Phone number must start with 0";
      }
    
      if(phone_number.trim() == "" ){
        phone_number_error.innerHTML = "Please Enter your phone number";
      }
    
      if(email.trim() == "" ){
        email_error.innerHTML = "Please enter your email";
      }
      
      
      
      else if (first_name.trim() !== "" &&  last_name.trim() !== "" && delivery_address.trim() !== "" &&
      postcode.trim() !== "" && phone_number[0] == "0" && email.trim() !== "" ){
        // Send the token to your server (by using the function below)
        stripeTokenHandler(result.token);
      }

      else{ return false; }
    });
  


});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);


    // Submit the form
    form.submit();
  

}
