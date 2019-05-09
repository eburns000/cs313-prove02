<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Prove 03 - Eric Burns</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>

    <!-- Navigation -->
    <div class="container">
      <nav class="navbar navbar-expand-md bg-dark fixed-top">
        <h2>Potato Emporium</h2><br>
        <h5>Premium, Organic Potatoes Delivered Fresh to Your Door</h5> 
      </nav>
    </div>

    <!-- Main Content -->	
	<h4>Checkout</h4>
	<br><br>
	<form action="confirm.php" method="post" class="form-checkout">

		<label for="address1">Address 1</label>
		<input class="field-checkout" type="text" placeholder="Address 1" name="address1"><br>

		<label for="address2">Address 2</label>		
		<input class="field-checkout" type="text" placeholder="Address 2" name="address2"><br>

		<label for="city">City</label>		
		<input class="field-checkout" type="text" placeholder="City" name="city"><br>
		
		<label for="state">State</label>
		<input class="field-checkout" type="text" placeholder="State" name="state"><br>
		
		<label for="zip">Zip</label>
		<input class="field-checkout" type="text" placeholder="Zip" name="zip"><br>

		<input class="complete-purchase" type="submit" value="Complete Purchase">

	</form>

	<form action="cart.php" method="post" class="form-submit">
        <input class="view-cart" type="submit" value="Return to Cart">
    </form>	

</body>
</html>

