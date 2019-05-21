<?php 
/* - Initialize shopping cart class - */
include_once 'ShoppingCart.class.php'; 
$cart = new ShoppingCart; 

if ($cart->total_items() == 0) { 
    // If cart is empty, redirect to home page
    header("Location: index.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>View Cart - Basic Shopping Cart</title>
        <meta charset="utf-8">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body style="margin-top: 100px;">
        <div class="container">

            <!-- Remove all cart items -->
            <div class="row col-lg-6">
                <button class="btn btn-warning btn-block" onclick="return confirm('Are you sure?')?window.location.href='cartAction.php?action=removeAllItems':false;">Remove all items</button>
            </div>
            <br />

            <!-- Manage cart items -->
            <h2>Shopping Cart</h2>
            <div class="row col-lg-6">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="45%">Product</th>
                                <th width="10%">Price</th>
                                <th width="15%">Quantity</th>
                                <th class="text-right" width="20%">Total</th>
                                <th width="10%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($cart->total_items() > 0){ 
                                // Get cart items from session and show them
                                $cartItems = $cart->current_cart(); 
                                foreach($cartItems as $item){ 
                            ?>
                            <tr>
                                <td><?=$item["name"];?></td>
                                <td>$<?=number_format($item["price"],2);?></td>
                                <td><?=$item["qtty"];?></td>
                                <td class="text-right">$<?=number_format($item["subtotal"],2);?></td>
                                <td class="text-right"><button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')?window.location.href='cartAction.php?action=removeCartItem&id=<?=$item['rowid'];?>':false;">Remove</button></td>
                            </tr>
                            <?php } } ?>
                            <?php if($cart->total_items() > 0){ ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><strong>Total</strong></td>
                                <td class="text-right"><strong>$<?=number_format($cart->cart_total(),2);?></strong></td>
                                <td></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Continue shopping -->
            <div class="row col-lg-6">
                <a href="index.php" class="btn btn-secondary btn-block">Continue Shopping</a>
            </div>

        </div>
    </body>
</html>