<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Stripe · Client Tool</title>
<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron text-center">
    <h1>Stripe · Client Tool</h1> 
</div>
<div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="payment-form">
    <div class="form-group">
      <label for="cc" class="col-form-label">Sample Credit Card Number</label>
      <select data-stripe="number" id="cc" class="form-control" size="14">
        <option value="4242424242424242" selected>Visa</option>
        <option value="4012888888881881">Visa</option>
        <option value="4000056655665556">Visa (debit)</option>
        <option value="5555555555554444">Mastercard</option>
        <option value="5200828282828210">Mastercard (debit)</option>
        <option value="5105105105105100">Mastercard (prepaid)</option>
        <option value="378282246310005">American Express</option>
        <option value="371449635398431">American Express 2</option>
        <option value="6011111111111117">Discover</option>
        <option value="6011000990139424">Discover 2</option>
        <option value="30569309025904">Diners Club</option>
        <option value="38520000023237">Diners Club 2</option>
        <option value="3530111333300000">JCB</option>
        <option value="3566002020360505">JCB 2</option>
      </select>
    </div>
    <div class="form-group">
      <label for="cvv" class="col-xs-2 col-form-label">CVV</label>
      <input type="text" class="form-control" placeholder="Enter CVV number" size="4" id="cvv" data-stripe="cvc" value="313" />
    </div>
    <div class="form-group">
      <label for="exp_mm" class="col-xs-12 col-form-label">Expiration (MM/YY)</label>
      <input type="text" id="exp_mm" class="form-control" size="2" data-stripe="exp_month" value="12" style="width:10%;float: left;"  />
      <label for="exp_yy" class="col-form-label" style="font-size: 26px;width:5%; float:left">&nbsp;/ </label>
      <input type="text" id="exp_yy" class="form-control" size="2" data-stripe="exp_year" value="22" style="width:10%;float:left" />
    </div>
    <div class="form-group" style="clear:both">
      <label for="exampleTextarea" class="col-form-label">Address: </label>
      <textarea class="form-control" id="exampleTextarea" rows="3"  size="6" data-stripe="address_zip">H.no 123, 678 Lane, ABC Street, XYZ Country</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Payment</button>
  </form>
</div>
<?php if (!empty($_POST)){ ?>
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title" id="myModalLabel1">Stripe Token:</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" value="<?= $_POST['stripeToken']; ?>" readonly/>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>
<?php }?>
<script type="text/javascript">
  Stripe.setPublishableKey('Your key here');

 $("#cvv").val(Math.floor(Math.random()*100) + 100);

$(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});

function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};
</script>
</body>
</html>