<?php 
// start session 
if(!session_id()){
    session_start();
}

// display errors strict
ini_set('display_errors',E_ALL);

/**
 * Basic Shopping Cart Class
 * 
 * @author Lucas Baranovic
 */

class ShoppingCart {

    private $products;
    private $total_products;
    private $current_cart;
    
    public function __construct() {
        // ######## please do not alter the following code ########
        $products = [
            [ "name" => "Sledgehammer", "price" => 125.75 ],
            [ "name" => "Axe", "price" => 190.50 ],
            [ "name" => "Bandsaw", "price" => 562.131 ],
            [ "name" => "Chisel", "price" => 12.9 ],
            [ "name" => "Hacksaw", "price" => 18.45 ],
        ];
        // ########################################################
        
        // set the products list from the array
        $this->products_list = isset($products)?$products:array();

        // get the shopping cart array from the session
        $this->cart_items = !empty($_SESSION['cart_items'])?$_SESSION['cart_items']:null;
        if ($this->cart_items === null){
            // set some base values
            $this->cart_items = array('cart_total' => 0, 'total_items' => 0);
        }
    }

    /** 
     * Get Available Products: Returns all the available products
     * @return array
     */
    public function getAvailableProducts() {
        $total_products = isset($this->products_list)?count($this->products_list):0;
        if ($total_products > 0) {
            return $this->products_list;
        } else {
            return false;
        }
    }

    /**
     * Get Current Cart: Returns the current cart items
     * @return array
     */
    public function getCurrentCart() {
        // re-order: newest first
        $current_cart = array_reverse($this->cart_items);
        // remove these so they don't create an issue when showing the table
        unset($current_cart['total_items']);
        unset($current_cart['cart_total']);
        return $current_cart;
    }
     
    /**
     * Get Total Items: Returns the total item count
     * @return int
     */
    public function getTotalItems() {
        return $this->cart_items['total_items'];
    }
     
    /**
     * Get Card Total: Returns the total cost
     * @return int
     */
    public function getCartTotal() {
        return $this->cart_items['cart_total'];
    }
     
    /**
     * Insert Item: insert an item into the cart and save it to the session
     * @param  array
     * @return bool
     */ 
    public function insertItem($item = array()) {
        if (!is_array($item) OR count($item) === 0) {
            return false;
        }else{
            if (!isset($item['name'], $item['price'], $item['id'] )) {
                return false;
            } else {
                // format the price
                $item['price'] = (float) $item['price'];
                // create a item unique identifier based on array key
                $rowid = md5($item['id']);
                // get quantity if it's already there
                $old_qtty = isset($this->cart_items[$rowid]['qtty']) ? (int) $this->cart_items[$rowid]['qtty'] : 0;
                // add one more item
                $item['qtty'] = $old_qtty + 1;
                // create again the entry with unique identifier
                $item['rowid'] = $rowid;
                // update cart items
                $this->cart_items[$rowid] = $item;
                // save cart 
                if ($this->saveCart()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
     
    /**
     * Save Cart: save the cart array to the session
     * @return bool
     */
    protected function saveCart() {
        $this->cart_items['total_items'] = $this->cart_items['cart_total'] = 0;
        foreach ($this->cart_items as $key => $val) {
            // validate the array indexes
            if (!is_array($val) OR !isset($val['price'], $val['qtty'])) {
                continue;
            }
            $this->cart_items['cart_total'] += ($val['price'] * $val['qtty']);
            $this->cart_items['total_items'] += $val['qtty'];
            $this->cart_items[$key]['subtotal'] = ($this->cart_items[$key]['price'] * $this->cart_items[$key]['qtty']);
        }
        $_SESSION['cart_items'] = $this->cart_items;
        return true;
    }
     
    /**
     * Remove Single Item: Removes an item from the cart
     * @param  int
     * @return bool
     */
     public function removeSingleItem($row_id) {
        // unset & save
        unset($this->cart_items[$row_id]);
        $this->saveCart();
        return true;
     }
      
    /**
     * Remove All Items: Removes all items from the cart
     * @return void
     */
    public function removeAllItems() {
        $this->cart_items = array('cart_total' => 0, 'total_items' => 0);
        unset($_SESSION['cart_items']);
    }
}
