<?php

	session_start();

	$address1 = htmlspecialchars($_POST["address1"]);
	$address2 = htmlspecialchars($_POST["address2"]);
	$city = htmlspecialchars($_POST["city"]);
	$state = htmlspecialchars($_POST["state"]);
	$zip = htmlspecialchars($_POST["zip"]);

	$address = empty($address2) ? $address1 : $address1 . ", " . $address2;

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
        <h2>Potato Emporium</h2>
      </nav>
    </div>

    <!-- Main Content -->
	<div class="container-fluid main">

		<h4>Purchase Confirmation</h4>	
		<p>
			Thank you for your purchase today from Potatoes Emporium. Your complete satisfaction is our Number One concern. If you are not satisfied for any reason, you any unused potatoes for a full refund.
		</p>
		<br>

		<h6>Order Summary</h6>

		<table class="shopping-cart-table">

			<tr class="cart-table-header">
				<th>Item</th>
				<th>Quantity (lbs)</th>
				<th>Price/lb</th>
				<th>Price</th>
			</tr>

			<?php

			$length = intval($_SESSION["numItems"]);

			$totalCost = 0;

			for ($i = 0; $i < $length; $i++) {

				if(array_key_exists("cart" . $i, $_SESSION) && $_SESSION["cart" . $i][1] > 0) {

					$totalCost += $_SESSION["cart" . $i][3];

					echo '
					<tr class="cart-table-row">
						<td>';

					echo $_SESSION["cart" . $i][0];

					echo '</td>
						<td>';

					echo $_SESSION["cart" . $i][1];	

					echo '</td>
						<td>$';

					echo $_SESSION["cart" . $i][2];


					echo '</td>
						<td>$';

					echo $_SESSION["cart" . $i][3];

					echo '</td>							
					</tr>';

				}

			}

			?>

			<tr class="cart-table-row-footer">
				<td>Total</td>
				<td></td>
				<td></td>
				<td><?php echo '$' . $totalCost; ?></td>
			</tr>

		</table>

		<br><br>

		<h6>Shipping Information</h6>
		<p>
			Your items will be shipped within 24 hours to the address below. If the address is incorrect, please contact customer service immediatly so your shipment can be re-routed.
		</p>

		<!-- Address Summary -->
		<p>
			 
		<?php

			echo 'Address: ' . $address . '<br>';
			echo 'City: ' . $city . '<br>';
			echo 'State: ' . $state . '<br>';
			echo 'Zip: ' . $zip . '<br';

		?>
		</p>

		<h6>Thank you for shopping at Potatoes Emporium</h6>

		<?php
			// remove all session variables
			session_unset();

			// destroy the session
			session_destroy();
		?>

		<form action="prove03.php" method="post" class="form-submit">
        	<input class="add-button" type="submit" value="Return to Home">
    	</form>	

	</div>

</body>
</html>