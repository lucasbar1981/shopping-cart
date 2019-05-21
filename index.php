<?php 
/* - Initialize shopping cart class - */
include_once 'ShoppingCart.class.php'; 
$cart = new ShoppingCart; 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Basic Shopping Cart</title>
        <meta charset="utf-8">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body style="margin-top: 100px;">
        <div class="container">
            
            <!-- Cart info -->
            <div class="row col-lg-6">
                <a href="viewCart.php" class="btn btn-secondary btn-block <?php echo ($cart->total_items() == 0)?'disabled':''; ?>" title="View Cart"><?php echo ($cart->total_items() > 0)?'You have '.$cart->total_items().' items in your shopping cart (click to view)':'Your shopping cart is empty'; ?></a>
            </div>
            <br />
            <h2>Products</h2>

            <!-- Product list -->
            <div class="row col-lg-6">
                <?php if ($cart->available_products()){ ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php    
                        // Get availale products
                        $cartProducts = $cart->available_products(); 
                        foreach($cartProducts as $key => $product){ 
                    ?>
                        <tr>
                            <td><?=$product['name'];?></td>
                            <td>$<?=number_format($product['price'],2);?></td>
                            <td><a href='cartAction.php?action=addToCart&id=<?=$key;?>' class="btn btn-success">Add</a></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
                <?php } else { ?>
                <p>There are no products.</p>
                <?php } ?>
            </div>
        </div>
    </body>
</html>