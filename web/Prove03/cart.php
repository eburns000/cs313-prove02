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
	<h4>Shopping Cart</h4>
	<br><br>
	<div class="container-fluid main">

		<div class="row shopping-cart">

			<table class="shopping-cart-table">

				<tr class="cart-table-header">
					<th>Item</th>
					<th>Quantity (lbs)</th>
					<th>Price (lb)</th>
					<th>Total Price</th>
				</tr>

				<?php

				echo $_SESSION["numItems"];

				$length = $_SESSION["numItems"];

				for ($i = 0; $i < $length; $i++) {

					if(array_key_exists("cart" . $i, $_SESSION)) {

						echo '
						<tr class="cart-table-row">
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

			</table>

		</div>

	</div>

</body>
</html>
