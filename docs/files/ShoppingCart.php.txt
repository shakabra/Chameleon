<?php
/**
 * A Generic Virtual Shopping Cart
 *
 */
class ShoppingCart
{
    /**
     * Id of $this Shopping Cart.
     *
     * @var string
     */
    private $id;

    /**
     * A container for CartItems.
     *
     * @var array
     */
    private $items = [];

    /**
     * todo: A place to store the cart for later.
     */ 

    public function __construct($id) {
        $this->id = $id;
    }

    public function add_item(CartItem $item) {
        array_push($this->items, $item);
    }

    public function __toString() {
      $str = 'id: '.$this->id.",\n";
      if (!empty($this->items)) {
          return;
      }
      return $str;
    }
}

