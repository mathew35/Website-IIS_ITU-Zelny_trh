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
    let submit = document.createElement("button");
    let cancel = document.createElement("button");
    submit.textContent = "Submit";
    cancel.textContent = "Cancel";
    cancel.addEventListener("click", (evt) => {
        document.getElementById("popupBackground").remove();
        document.getElementById("popupWin").remove();
    })
    if (type == 'register') {
        submit.textContent = "Register";
        form.action = "javascript:formpost('register.php')";
        //divider
        let hr = document.createElement("hr");
        hr.style.width = "40%";
        form.appendChild(hr);

        let labelName = document.createElement("label");
        labelName.htmlFor = "fullname";
        labelName.textContent   = "Full Name";
        form.appendChild(labelName);

        let inputName = document.createElement("input");
        inputName.type   = "text";
        inputName.id   = "fullname";
        inputName.name   = "fullname";
    }
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
        if (request.status == 200)
            if (dest == "login.php") {
                if (request.responseText != "" && request.responseText != "error") {
                    if (document.getElementById("popupBackground") != null) document.getElementById("popupBackground").remove();
                    if (document.getElementById("popupWin") != null) document.getElementById("popupWin").remove();
                    sessionStorage.setItem('user', request.readyTest);
                    credents();
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
        credents();
        location.reload();
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
            farmer_view_pick();
        } else if (sessionStorage.getItem('farmer_view') == null) {
            var req = post("farmer.php", null);
            sessionStorage.setItem('farmer_view', "products");
            req.addEventListener("load", () => {
                farmer_view_pick();
                location.reload();
            })
        }
    }
}

function cart() {
    console.log("cart");
}

function orders() {
    if (sessionStorage.getItem('farmer') == null) {
        const request = post("farmer.php", null);
        request.addEventListener("load", (evenr) => {
            if (request.responseText == false) {
                if (sessionStorage.getItem('farmer') != null) sessionStorage.removeItem('farmer');
                //
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
        } else {}
    }
}

function profile() {
    console.log("profile");
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
        let profileButton = document.createElement('button');
        profileButton.onclick = profile;
        profileButton.textContent = "Profile";
        profileButton.id = "profileButton";
        let cartButton = document.createElement('button');
        cartButton.onclick = cart;
        cartButton.textContent = "Cart";
        cartButton.id = "cartButton";
        if (sessionStorage.getItem('farmer_view') != null) {
            cartButton.onclick = orders;
            cartButton.textContent = "Orders";
        }

        let farmerButton = document.createElement('button');
        farmerButton.onclick = farmer;
        farmerButton.textContent = "Farmer";
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
get_own('ownProducts', 'farmer_products.php');
get_own('ownOrders', 'farmer_orders.php');