function cart_view() {
    if (get_cart == null) {
        get_cart = setInterval(get_own, 5000, 'user_cart', 'get_cart.php');
        get_cart_items = setInterval(get_own, 5000, 'user_cart_items', 'get_cart_items.php');
    }
    console.log("cart");
    console.log(sessionStorage.getItem('user_cart'));
    console.log(sessionStorage.getItem('user_cart_items'));
}
//