<?php 
// initialize shopping cart class 
require_once 'ShoppingCart.class.php'; 
$cart = new ShoppingCart; 
 
// default redirection
$redirect_to = 'index.php'; 
 
// process the request based on the specified action 
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) { 
    if ($_REQUEST['action'] == 'addToCart' && is_numeric($_REQUEST['id'])) { 
        $prod_id = $_REQUEST['id']; 
        // get current products
        $products = $cart->getAvailableProducts();
        if ($products) {
            // set specific product details
            $item_data = $products[$prod_id];
            // add the item identifier
            $item_data['id']  = $prod_id;   
            // insert item to cart 
            $insert_item = $cart->insertItem($item_data); 
            // redirect to cart page 
            $redirect_to = $insert_item?'viewCart.php':'index.php'; 
        }
    } elseif ($_REQUEST['action']=='removeCartItem' && isset($_REQUEST['id'])) { 
        // remove item from cart 
        $deleteItem = $cart->removeSingleItem($_REQUEST['id']); 
        // redirect to cart page 
        $redirect_to = 'viewCart.php'; 
    } elseif ($_REQUEST['action']=='removeAllItems') {
        // remove all items from the session
        $cart->removeAllItems();
    }
} 
 
// redirect to the specific page 
header("Location: $redirect_to"); 
exit();
