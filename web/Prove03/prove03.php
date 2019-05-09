<?php

    session_start();

    $potatoes = array 
        (
        array("Bintje", "bintje.jpg", 5),
        array("Dore", "dore.jpg", 7),
        array("Duke of York", "dukeofyork.jpg", 4),
        array("Gunda", "gunda.jpg", 3),
        array("Kennebeck", "kennebeck.jpg", 8),
        array("Kerr Pink", "kerrpink.jpg", 7),
        array("King Edwards", "kingedward.jpg", 9),
        array("Laura", "laura.jpg", 8),
        array("Melody", "melody.jpg", 5),
        array("Russet", "russet.jpg", 2),
        array("Vitelot", "vitelot.jpg", 5),
        array("Yukon Gold", "yukongold.jpg", 4)    
        );

    $length = count($potatoes);

    $_SESSION["numItems"] = $length;
    
    for ($i = 0; $i < $length; $i++) {

        if(isset($_POST['item' . $i])) {

            $tmpqty = intval($_POST['qty' . $i]);

            $existingQty = 0;

            if(array_key_exists("cart" . $i, $_SESSION)) {
                $existingQty = $_SESSION["cart" . $i][1];
            }

            $existingQty += $tmpqty;

            $_SESSION["cart" . $i] = array($potatoes[$i][0], $existingQty, $potatoes[$i][2], $existingQty * $potatoes[$i][2]);
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

    <!-- NAV BAR -->


    <!-- Intro Paragraph or heading information on products -->
    <div class="intro">
        <h4>Premium Potatoes</h4>
        <p>We only slect premium grade potatoes from our co-op of organic farmers. All of our potatoes come to you fresh from the farm.</p>
    </div>

    <!-- Make your site about potatoes and different kinds of potatoes -->


    <!-- Products Form -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-potatoes">   

        <div class="container-fluid main">

            <div class="row products">

                <table class="products-table">

                    <tr class="table-header">
                        <th></th>
                        <th>Variety</th>
                        <th>Price (lb)</th>                        
                        <th>Quantity</th>
                    </tr>


                    <?php 

                    $length = count($potatoes);

                    for ($row = 0; $row < $length; $row++) {

                        echo '
                        <tr class="table-row">
                            <td>
                                <img src="images/';

                        echo $potatoes[$row][1];

                        echo '">
                            </td>
                            <td class="description">';

                        echo $potatoes[$row][0];
                        
                        echo '</td>                        
                            <td class="price">$';

                        echo $potatoes[$row][2]; 
                        
                        echo '</td>
                            <td>
                                <input class="quantity" type="number" name="qty';

                        echo $row;

                        echo '" min="0" max="10" step="1" inputmode="number">
                            </td>
                            <td>
                                <input class="add-button" type="submit" name="item';

                        echo $row;    

                        echo '" value="Add to Cart">
                            </td>
                        </tr>';

                    }

                    ?>                    

                </table>

            </div> 

        </div>

    </form>
    <br><br>
    <form action="cart.php" method="post" class="form-submit">
        <input class="view-cart" type="submit" value="View Cart">
    </form>	

</body>
</html>
