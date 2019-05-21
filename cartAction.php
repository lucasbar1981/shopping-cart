<?php 
/* - Initialize shopping cart class - */
require_once 'ShoppingCart.class.php'; 
$cart = new ShoppingCart; 
 
/* - Default redirect location - */
$redirect_to = 'index.php'; 
 
/* - Process the request based on the specified action - */
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) { 
    if ($_REQUEST['action'] == 'addToCart' && is_numeric($_REQUEST['id'])) { 
        $prod_id = $_REQUEST['id']; 
        // Get current products
        $products = $cart->available_products();
        if ($products) {
            // Set specific product details
            $item_data = $products[$prod_id];
            // Add the item identifier
            $item_data['id']  = $prod_id;   
            // Insert item to cart 
            $insert_item = $cart->insert_item($item_data); 
            // Redirect to cart page 
            $redirect_to = $insert_item?'viewCart.php':'index.php'; 
        }
    } elseif($_REQUEST['action']=='removeCartItem' && isset($_REQUEST['id'])) { 
        // Remove item from cart 
        $deleteItem = $cart->remove_item($_REQUEST['id']); 
        // Redirect to cart page 
        $redirect_to = 'viewCart.php'; 
    } elseif($_REQUEST['action']=='removeAllItems') {
        // Destroy the session
        $cart->destroy();
    }
} 
 
// Redirect to the specific page 
header("Location: $redirect_to"); 
exit();