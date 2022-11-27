var regTimeout;

function overlay() {
    let credents = document.getElementById("credents");
    let popupBack = document.createElement('div');
    let popupWin = document.createElement('div');
    popupBack.addEventListener("click", (evt) => {
        document.getElementById("popupBackground").remove();
        document.getElementById("popupWin").remove();
        clearTimeout(regTimeout);
    })
    credents.appendChild(popupBack);
    credents.appendChild(popupWin);
    popupBack.id = 'popupBackground';
    popupBack.className = 'popup';
    popupWin.id = 'popupWin';
    popupWin.className = 'popup';
}

function form(type) {
    let credents = document.getElementById("popupWin");
    let form = document.createElement("form");
    form.id = "loginForm";
    form.action = "javascript:formpost('login.php')";
    form.method = "POST";

    let submit = document.createElement("button");
    let cancel = document.createElement("button");
    submit.textContent = "Submit";
    cancel.textContent = "Cancel";
    cancel.addEventListener("click", (evt) => {
        document.getElementById("popupBackground").remove();
        document.getElementById("popupWin").remove();
    })

    if (type == "farmer") {
        submit.textContent = "Become farmer";
        form.action = "javascript:formpost('become_farmer.php')";

        let labelAddress = document.createElement('label');
        labelAddress.htmlFor = "address";
        labelAddress.textContent = "Address";
        form.appendChild(labelAddress);
        form.appendChild(document.createElement("br"));

        let inputAddress = document.createElement("input");
        inputAddress.type = "text";
        inputAddress.id = "address";
        inputAddress.name = "address";
        form.appendChild(inputAddress);
        form.appendChild(document.createElement("br"));

        let labelIco = document.createElement('label');
        labelIco.htmlFor = "ico";
        labelIco.textContent = "Ico";
        form.appendChild(labelIco);
        form.appendChild(document.createElement("br"));

        let inputIco = document.createElement("input");
        inputIco.type = "text";
        inputIco.id = "ico";
        inputIco.name = "ico";
        form.appendChild(inputIco);
        form.appendChild(document.createElement("br"));

        let labelPhone = document.createElement('label');
        labelPhone.htmlFor = "phone";
        labelPhone.textContent = "Phone";
        form.appendChild(labelPhone);
        form.appendChild(document.createElement("br"));

        let inputPhone = document.createElement("input");
        inputPhone.type = "tel";
        inputPhone.id = "phone";
        inputPhone.name = "phone";
        form.appendChild(inputPhone);
        form.appendChild(document.createElement("br"));

        let labelIban = document.createElement('label');
        labelIban.htmlFor = "iban";
        labelIban.textContent = "IBAN";
        form.appendChild(labelIban);
        form.appendChild(document.createElement("br"));

        let inputIban = document.createElement("input");
        inputIban.type = "text";
        inputIban.id = "iban";
        inputIban.name = "iban";
        form.appendChild(inputIban);
        form.appendChild(document.createElement("br"));
    } else {
        let labelLogin = document.createElement('label');
        labelLogin.htmlFor = "login";
        labelLogin.textContent = "Login";
        form.appendChild(labelLogin);

        form.appendChild(document.createElement("br"));

        let inputLogin = document.createElement("input");
        inputLogin.type = "text";
        inputLogin.id = "login";
        inputLogin.name = "login";
        form.appendChild(inputLogin);

        form.appendChild(document.createElement("br"));

        let labelPasswd = document.createElement('label');
        labelPasswd.htmlFor = "password";
        labelPasswd.textContent = "Password";
        form.appendChild(labelPasswd);

        form.appendChild(document.createElement("br"));

        let inputPasswd = document.createElement("input");
        inputPasswd.type = "password";
        inputPasswd.id = "password";
        inputPasswd.name = "password";
        form.appendChild(inputPasswd);

        form.appendChild(document.createElement("br"));

        if (type == 'register') {
            submit.textContent = "Register";
            form.action = "javascript:formpost('register.php')";

            let labelName = document.createElement("label");
            labelName.htmlFor = "fullname";
            labelName.textContent = "Full Name";
            form.appendChild(labelName);

            let inputName = document.createElement("input");
            inputName.type = "text";
            inputName.id = "fullname";
            inputName.name = "fullname";
            form.appendChild(document.createElement("br"));
            form.appendChild(inputName);
            form.appendChild(document.createElement("br"));

            let labelEmail = document.createElement("label");
            labelEmail.htmlFor = "email";
            labelEmail.textContent = "E-mail";
            form.appendChild(labelEmail);

            let inputEmail = document.createElement("input");
            inputEmail.type = "text";
            inputEmail.id = "email";
            inputEmail.name = "email";
            form.appendChild(document.createElement("br"));
            form.appendChild(inputEmail);
        }
    }
    //divider
    let hr = document.createElement("hr");
    hr.style.width = "40%";
    form.appendChild(hr);
    form.appendChild(submit);
    form.appendChild(cancel);

    credents.appendChild(form);
}

function post(dest, form) {
    const request = new XMLHttpRequest();
    var data = null;
    if (form != null) {
        data = new FormData(form);
    }
    request.open("POST", dest);
    request.send(data);
    return request;
}

function formpost(dest) {
    const request = post(dest, document.getElementById("loginForm"));
    request.addEventListener("load", (event) => {
        if (dest == "login.php") {
            if (request.responseText != "" && request.responseText != "error") {
                get_own('ownProducts', 'farmer_products.php');
                get_own('ownOrders', 'farmer_orders.php');
                get_own('user_cart', 'get_cart.php');
                get_own('user_cart_items', 'get_cart_items.php');
                get_own('profile', 'get_profile.php');
                if (document.getElementById("popupBackground") != null) document.getElementById("popupBackground").remove();
                if (document.getElementById("popupWin") != null) document.getElementById("popupWin").remove();
                sessionStorage.setItem('user', request.responseText);
                credents();
                const request2 = post("farmer.php", null);
                post("farmer.php", null);
                request2.addEventListener("load", (evenr) => {
                        if (request2.responseText == false) {
                            // if (sessionStorage.getItem('farmer') != null) sessionStorage.removeItem('farmer');
                        } else if (request2.responseText == true) {
                            sessionStorage.setItem('farmer', sessionStorage.getItem('user'));
                            // sessionStorage.setItem('farmer_view', "products");
                            credents();
                        }
                        // farmer_view_pick();
                        // location.reload();
                    })
                    // const request3 = post("farmer.php", null);
                    // post("farmer.php", null);
                    // request3.addEventListener("load", (evenr) => {
                    //     sessionStorage.setItem('user_cart', request3.responseText);
                    //     farmer_view_pick();
                    //     // location.reload();
                    // })
            } else {
                let form = document.getElementById("loginForm");
                let error = document.createElement("p");
                error.textContent = "Wrong login or password";
                if (form != null) form.appendChild(error);
            }
            return;
        }
        if (dest == "register.php") {
            if (request.responseText == "ok") {
                document.getElementById("loginForm").remove();
                let popup = document.getElementById("popupWin");
                let msg = document.createElement("p");
                msg.textContent = "New account created successfuly.";
                popup.appendChild(msg);
                regTimeout = setTimeout(() => {
                    document.getElementById("popupBackground").remove();
                    document.getElementById("popupWin").remove();
                }, 5000);
            } else {
                console.log("problem with registraion");
                console.log(request.responseText);
            }
        }
        if (dest == "become_farmer.php") {
            if (request.responseText != "" && request.responseText != "USER NOT FOUND") {
                if (document.getElementById("popupBackground") != null) document.getElementById("popupBackground").remove();
                if (document.getElementById("popupWin") != null) document.getElementById("popupWin").remove();
                sessionStorage.setItem('farmer', sessionStorage.getItem('user'));
            }
            credents();
            console.log(request.responseText);
            return;
        }
    })
}

function login() {
    overlay();
    form('login');
}

function register() {
    overlay();
    form('register');
}

function logout() {
    const request = new XMLHttpRequest();
    request.open("POST", "logout.php");
    request.send();
    request.addEventListener("load", (evenr) => {
        sessionStorage.removeItem('user');
        sessionStorage.removeItem('farmer');
        sessionStorage.removeItem('farmer_view');
        sessionStorage.removeItem('user_cart');
        location.reload();
        // credents();
    })
}

function farmer() {
    if (sessionStorage.getItem('farmer') == null) {
        const request = post("farmer.php", null);
        request.addEventListener("load", (evenr) => {
            if (request.responseText == false) {
                if (sessionStorage.getItem('farmer') != null) sessionStorage.removeItem('farmer');
            } else {
                sessionStorage.setItem('farmer', sessionStorage.getItem('user'));
                sessionStorage.setItem('farmer_view', "products");
            }
            farmer_view_pick();
            location.reload();
        })
    } else {
        if (sessionStorage.getItem('farmer_view') == "products") {
            var req = post("farmer.php", null);
            sessionStorage.removeItem('farmer_view');
            req.addEventListener("load", () => {
                farmer_view_pick();
                location.reload();
            })
        } else if (sessionStorage.getItem('farmer_view') == "orders") {
            sessionStorage.setItem('farmer_view', 'products');
            credents();
            farmer_view_pick();
        } else if (sessionStorage.getItem('farmer_view') == "profile") {
            sessionStorage.setItem('farmer_view', 'products');
            credents();
            farmer_view_pick();
        } else if (sessionStorage.getItem('farmer_view') == "cart") {
            sessionStorage.setItem('farmer_view', 'products');
            credents();
            farmer_view_pick();
        } else {
            var req = post("farmer.php", null);
            sessionStorage.setItem('farmer_view', "products");
            req.addEventListener("load", () => {
                farmer_view_pick();
                credents();
                location.reload();
            })
        }
    }
}

function become_farmer() {
    overlay();
    form("farmer");
}

function cart() {
    if (sessionStorage.getItem('user') == null) logout();
    if (sessionStorage.getItem('farmer_view') == "orders") {
        sessionStorage.setItem('farmer_view', "cart");
        farmer_view_pick();
    } else if (sessionStorage.getItem('farmer_view') == "products") {
        sessionStorage.setItem('farmer_view', "cart");
        farmer_view_pick();
    } else if (sessionStorage.getItem('farmer_view') == "profile") {
        sessionStorage.setItem('farmer_view', "cart");
        farmer_view_pick();
    } else if (sessionStorage.getItem('farmer_view') == "cart") {
        var req = post("farmer.php", null);
        sessionStorage.removeItem('farmer_view');
        req.addEventListener("load", () => {
            farmer_view_pick();
            location.reload();
        })
    } else {
        var req = post("farmer.php", null);
        sessionStorage.setItem('farmer_view', "cart");
        req.addEventListener("load", () => {
            farmer_view_pick();
            location.reload();
        })
    }
}

function orders() {
    if (sessionStorage.getItem('farmer') == null) {
        const request = post("farmer.php", null);
        request.addEventListener("load", (evenr) => {
            if (request.responseText == false) {
                if (sessionStorage.getItem('farmer') != null) sessionStorage.removeItem('farmer');
            } else {
                sessionStorage.setItem('farmer', sessionStorage.getItem('user'));
                sessionStorage.setItem('farmer_view', "orders");
            }
            farmer_view_pick();
            location.reload();
        })
    } else {
        if (sessionStorage.getItem('farmer_view') == "orders") {
            var req = post("farmer.php", null);
            sessionStorage.removeItem('farmer_view');
            req.addEventListener("load", () => {
                farmer_view_pick();
                location.reload();
            })
        } else if (sessionStorage.getItem('farmer_view') == "products") {
            sessionStorage.setItem('farmer_view', "orders");
            farmer_view_pick();
        } else if (sessionStorage.getItem('farmer_view') == "profile") {
            sessionStorage.setItem('farmer_view', "orders");
            farmer_view_pick();
        } else if (sessionStorage.getItem('farmer_view') == "cart") {
            sessionStorage.setItem('farmer_view', "orders");
            farmer_view_pick();
        } else {
            console.log("order fallthrough");
        }
    }
}

function profile() {
    if (sessionStorage.getItem('user') == null) logout();
    if (sessionStorage.getItem('farmer_view') == "orders") {
        sessionStorage.setItem('farmer_view', "profile");
        farmer_view_pick();
    } else if (sessionStorage.getItem('farmer_view') == "products") {
        sessionStorage.setItem('farmer_view', "profile");
        farmer_view_pick();
    } else if (sessionStorage.getItem('farmer_view') == "profile") {
        var req = post("farmer.php", null);
        sessionStorage.removeItem('farmer_view');
        req.addEventListener("load", () => {
            farmer_view_pick();
            location.reload();
        })
    } else if (sessionStorage.getItem('farmer_view') == "cart") {
        sessionStorage.setItem('farmer_view', "profile");
        farmer_view_pick();
    } else {
        var req = post("farmer.php", null);
        sessionStorage.setItem('farmer_view', "profile");
        req.addEventListener("load", () => {
            farmer_view_pick();
            location.reload();
        })
    }
}

function credents() {
    let credents = document.getElementById("credents");
    if (sessionStorage.getItem('user') == null) {
        if (document.getElementById("profileButton") != null) document.getElementById("profileButton").remove();
        if (document.getElementById("cartButton") != null) document.getElementById("cartButton").remove();
        if (document.getElementById("farmerButton") != null) document.getElementById("farmerButton").remove();
        if (document.getElementById("logoutButton") != null) document.getElementById("logoutButton").remove();
        let loginButton = document.createElement('button');
        let registerButton = document.createElement('button');
        loginButton.onclick = login;
        registerButton.onclick = register;
        loginButton.textContent = 'Login';
        registerButton.textContent = 'Register';
        loginButton.id = "loginButton";
        registerButton.id = "registerButton";
        credents.appendChild(loginButton);
        credents.appendChild(registerButton);
    } else {
        if (document.getElementById("loginButton") != null) document.getElementById("loginButton").remove();
        if (document.getElementById("registerButton") != null) document.getElementById("registerButton").remove();
        if (document.getElementById("profileButton") != null) document.getElementById("profileButton").remove();
        if (document.getElementById("cartButton") != null) document.getElementById("cartButton").remove();
        if (document.getElementById("farmerButton") != null) document.getElementById("farmerButton").remove();
        if (document.getElementById("logoutButton") != null) document.getElementById("logoutButton").remove();
        let profileButton = document.createElement('button');
        profileButton.onclick = profile;
        profileButton.textContent = "Profile";
        profileButton.id = "profileButton";
        let cartButton = document.createElement('button');
        cartButton.onclick = cart;
        cartButton.textContent = "Cart";
        cartButton.id = "cartButton";
        if (sessionStorage.getItem('farmer_view') == "orders", sessionStorage.getItem('farmer_view') == "products") {
            cartButton.onclick = orders;
            cartButton.textContent = "Orders";
        }

        let farmerButton = document.createElement('button');
        if (sessionStorage.getItem('farmer') == null) {
            farmerButton.onclick = become_farmer;
            farmerButton.textContent = "Become farmer";
        } else {
            farmerButton.onclick = farmer;
            farmerButton.textContent = "My products";
        }
        farmerButton.id = "farmerButton";
        let logoutButton = document.createElement('button');
        logoutButton.onclick = logout;
        logoutButton.textContent = "Log out";
        logoutButton.id = "logoutButton";

        credents.append(profileButton, cartButton, farmerButton, logoutButton);
    }
}
credents();
if (sessionStorage.getItem('user') == null) formpost('login.php');

//init farmer_view