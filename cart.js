function cart_view() {
    if (get_cart == null) {
        get_cart = setInterval(get_own, 5000, 'user_cart', 'get_cart.php');
        get_cart_items = setInterval(get_own, 5000, 'user_cart_items', 'get_cart_items.php');
    }
    cart_display();
    console.log("cart");
    console.log(sessionStorage.getItem('user_cart'));
    console.log(sessionStorage.getItem('user_cart_items'));
}

function interpret(data) {
    return data;
}

function cart_display() {
    let data = sessionStorage.getItem('user_cart_items');
    let content = document.getElementById("tableItems");
    if (content != null) content.remove();
    content = document.createElement("div");
    content.id = "tableItems";
    let table = document.getElementById("table");
    table.appendChild(content);
    if (data == "") {
        content.textContent = "Your cart is empty";
        return;
    }
    data = data.split(',');
    for (let i = 0; i < data.length; i++) {
        let p = document.createElement('p');
        p.textContent = interpret(data[i]);
        content.appendChild(p);
        let sendButton = document.createElement('button');
        let cancelButton = document.createElement('button');
        sendButton.textContent = "+";
        cancelButton.textContent = "-";
        content.append(sendButton, cancelButton);
        content.appendChild(document.createElement('br'));
    }

    let sendButton = document.createElement('button');
    let cancelButton = document.createElement('button');
    sendButton.textContent = "Objednať";
    cancelButton.textContent = "Vyprázdniť košík";
    content.appendChild(document.createElement('hr'));
    content.append(sendButton, cancelButton);
}