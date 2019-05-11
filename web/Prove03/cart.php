<?php 

	session_start();

	$length = intval($_SESSION["numItems"]);

	for ($i = 0; $i < $length; $i++) {

		if(isset($_POST['remove' . $i]) && array_key_exists("cart" . $i, $_SESSION)) {
			$_SESSION["cart" . $i][1] = 0;
			$_SESSION["cart" . $i][3] = 0;
			// TODO: set keys in prove03php file for session array to be QTY vs 1
		}

	}

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

		<h4>Shopping Cart</h4>
		<br>

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-cart">

			<div class="row shopping-cart">

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
								<td>
								<input class="add-button" type="submit" name="remove';

							echo $i;

							echo '" value="Remove Item">
								</td>
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

			</div>		

		</form>

		<br><br>
	    
	    <form action="prove03.php" method="post" class="form-submit">
	        <input class="add-button" type="submit" value="Keep Shopping">
	    </form>
	    <br>
	    
	    <form action="checkout.php" method="post" class="form-submit">
	        <input class="add-button" type="submit" value="Checkout Now">
	    </form>

    </div>		

</body>
</html>
