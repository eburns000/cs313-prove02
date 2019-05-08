<?php        

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
        <h4>Products</h4>
    </div>

    <!-- Make your site about potatoes and different kinds of potatoes -->


    <!-- Products Form -->
    <form action="cart.php" method="post" class="form-potatoes">   

        <div class="container-fluid main">

            <!-- Consider using PHP to loop through an array of product inventory to display on different rows -->
            


            <!-- You can do this with the tr tags - just loop through these tags for each item you have -->
            

            <div class="row products">

                <table class="products-table">

                    <tr class="table-header">
                        <th></th>
                        <th>Potato</th>
                        <th>Price</th>                        
                        <th>Quantity</th>
                    </tr>


                    <?php 


                        echo '<tr class="table-row">
                        <td>
                            <img src="images/';

                        $potatoes[0][1];

                        echo '">
                        </td>
                        <td class="description">';

                        $potatoes[0][0];
                        
                        echo '</td>                        
                        <td class="price">';

                        $potatoes[0][2]; 
                        
                        echo '</td>
                        <td>
                            <input type="number" class="quanity" min="0" max="10" step="1" inputmode="number">
                        </td>
                    </tr>';



                    ?>

                    

                </table>

            </div>

        </div>

        <div>
            <input type="submit" value="View Cart">
        </div>

    </form>	

</body>
</html>
