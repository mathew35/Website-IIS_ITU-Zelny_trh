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
    }
    form.appendChild(submit);
    form.appendChild(cancel);

    credents.appendChild(form);
}

function formpost(dest) {
    const request = new XMLHttpRequest();
    const form = new FormData(document.getElementById("loginForm"));
    console.log(dest);
    request.open("POST", dest);
    request.send(form);
    request.addEventListener("load", (event) => {
        if (request.status == 200)
            if (dest == "login.php") {
                if (request.responseText != "" && request.responseText != "error") {
                    document.getElementById("popupBackground").remove();
                    document.getElementById("popupWin").remove();
                    sessionStorage.setItem('user', request.readyTest);
                    credents();
                } else {
                    let form = document.getElementById("loginForm");
                    let error = document.createElement("p");
                    error.textContent = "Wrong login or password";
                    form.appendChild(error);
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
    // console.log(document.getElementById("user").value);
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
        credents();
    })

}

function credents() {
    let credents = document.getElementById("credents");
    if (sessionStorage.getItem('user') == null) {
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
        let logoutButton = document.createElement('button');
        logoutButton.onclick = logout;
        logoutButton.textContent = "Log out";
        logoutButton.id = "logoutButton";
        credents.appendChild(logoutButton);
    }
}
credents();