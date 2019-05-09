<?php

	session_start();

	$address1 = $_POST["address1"];
	$address2 = $_POST["address2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];

	echo $address1 . $address2 . $city . $state . $zip;

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

	<div class="container-fluid main">

		<h4>Purchase Confirmation</h4>	
		<p>
			Thank you for your purchase today from Potatoes Emporium. Your complete satisfaction is our Number 1 concern. If you are not satisfied for any reason, you any unused potatoes for a full refund.
		</p>
		<br>

		<h6>Order Summary</h6>

		<table class="order-confirm-table">

			<tr class="order-confirm-table-header">
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
					<tr class="order-confirm-table-row">
						<td>';

					echo $_SESSION["cart" . $i][0];

					echo '</td>
						<td>';

					echo $_SESSION["cart" . $i][1];	

					echo '</td>
						<td>';

					echo $_SESSION["cart" . $i][2];


					echo '</td>
						<td>';

					echo $_SESSION["cart" . $i][3];

					echo '</td>							
					</tr>';

				}

			}

			?>

			<tr class="order-confirm-table-row">
				<td>Total</td>
				<td></td>
				<td></td>
				<td><?php echo '$' . $totalCost; ?></td>
			</tr>

		</table>

		<br><br>

		<h6>Shipping Information</h6>
		<p>
			Your items will be shipped within 24 hours to the address below. If the address is incorrect, please contact customer service immediatly so your shipment can be re-routed. Additional text.
		</p>

		<!-- Address Summary -->
		<p>
			 
		<?php

			echo 'Address: ' . $address1 . '<br>';
			echo 'City: ' . $city . '<br>';
			echo 'State: ' . $state . '<br>';
			echo 'Zip: ' . $zip . '<br';

		?>
		</p>

		<h6>Thank you for shopping at Potatoes Emporium</h6>

		<!-- Include here a button to return to home page and if so, reset the session information -->

	</div>

</body>
</html>