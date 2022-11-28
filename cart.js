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
    console.log("updating cart item");
    return request;
}

function place_order() {
    var request = new XMLHttpRequest();
    request.open("POST", 'place_order.php');
    request.send();
    request.addEventListener("load", () => {
        console.log(request.responseText);
        cart_display();
    })
    console.log("creating order");
    return request;
}

function empty_cart() {
    var request = new XMLHttpRequest();
    request.open("POST", 'empty_cart.php');
    request.send();
    request.addEventListener("load", () => {
        get_own('user_cart_items', 'get_cart_items.php');
        cart_display();
    })
    console.log("emptying cart");
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
            let ret = update_cart_item(data[i][1], Number(data[i][0]) + 1);
            console.log(ret);
            ret.addEventListener("load", () => {
                console.log(ret.responseText);
                if (ret.responseText == "fail") {
                    let err = document.createElement("p");
                    err.style.color = "red";
                    err.textContent = "Nedostatok produktu na sklade";
                    content.appendChild(err);
                } else {
                    get_own('user_cart_items', 'get_cart_items.php');
                    cart_display();
                }
            })
            data[i] = data[i].join(' ');
        })
        minusButton.textContent = "-";
        minusButton.addEventListener("click", () => {
            data[i] = data[i].split(' ');
            let ret = update_cart_item(data[i][1], Number(data[i][0]) - 1);
            ret.addEventListener("load", () => {
                console.log(ret.responseText);
                if (ret.responseText == "fail") {
                    console.log("returning fail");
                    return "fail";
                }
                get_own('user_cart_items', 'get_cart_items.php');
                cart_display();
            })

            data[i] = data[i].join(' ');
        })
        content.append(plusButton, minusButton);
        content.appendChild(document.createElement('br'));
    }

    let sendButton = document.createElement('button');
    let cancelButton = document.createElement('button');
    sendButton.textContent = "Objednať";
    sendButton.addEventListener("click", () => {
        place_order();
    });
    cancelButton.textContent = "Vyprázdniť košík";
    cancelButton.addEventListener("click", () => {
        empty_cart();
    });
    content.appendChild(document.createElement('hr'));
    content.append(sendButton, cancelButton);
}