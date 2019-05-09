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
	<h4>Checkout</h4>
	<br><br>
	<form action="confirm.php" method="post" class="form-checkout">

	<div class="container-fluid main">

		<div class="row row-checkout">

			Address 1: <input class="field-checkout" type="text" name="address1"><br><br>
			Address 2: <input class="field-checkout" type="text" name="address2"><br><br>
			City: <input class="field-checkout" type="text" name="city"><br><br>
			State: <input class="field-checkout" type="text" name="state"><br><br>
			Zip: <input class="field-checkout" type="text" name="zip"><br><br>

		</div>

		<div class="row row-checkout">
			<input class="complete-purchase" type="submit" value="Complete Purchase">
		</div>

	</div>

	</form>

	<form action="cart.php" method="post" class="form-submit">
        <input class="view-cart" type="submit" value="Return to Cart">
    </form>	

</body>
</html>

