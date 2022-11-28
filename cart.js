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

function update_cart_item(cropid, ammount) {
    var request = new XMLHttpRequest();
    request.open("POST", 'update_cart_item.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send("cropid=" + cropid + "&ammount=" + ammount + "");
    request.addEventListener("load", () => {
        console.log(request.responseText);
        get_own('user_cart_items', 'get_cart_items.php');
        cart_display();
    })
    console.log("updating cart item");
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
        let plusButton = document.createElement('button');
        let minusButton = document.createElement('button');
        plusButton.textContent = "+";
        plusButton.addEventListener("click", () => {
            data[i] = data[i].split(' ');
            update_cart_item(data[i][1], Number(data[i][0]) + 1);
            data[i] = data[i].join(' ');
        })
        minusButton.textContent = "-";
        minusButton.addEventListener("click", () => {
            data[i] = data[i].split(' ');
            update_cart_item(data[i][1], Number(data[i][0]) - 1);
            data[i] = data[i].join(' ');
        })
        content.append(plusButton, minusButton);
        content.appendChild(document.createElement('br'));
    }

    let sendButton = document.createElement('button');
    let cancelButton = document.createElement('button');
    sendButton.textContent = "Objednať";
    cancelButton.textContent = "Vyprázdniť košík";
    content.appendChild(document.createElement('hr'));
    content.append(sendButton, cancelButton);
}