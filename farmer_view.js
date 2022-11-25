function get_own_products() {
    return "";
}

function form_add() {
    let content = document.getElementById("table");
    let form = document.createElement("form");
    form.id = "addForm";
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
    form.appendChild(submit);
    form.appendChild(cancel);

    content.appendChild(form);
    return form;
}

function new_product() {
    overlay();
    var form = form_add();
}

function farmer_view() {
    console.log("farmer_view");
    let content = document.getElementById("table");
    let table = document.createElement("table");
    let data = get_own_products();
    let tr = document.createElement("tr");
    let addProduct = document.createElement("td");
    addProduct.id = "addProduct";
    // addProduct.textContent = "Pridaj novy produkt";
    let div = document.createElement("div");
    div.id = "tableItem";
    div.textContent = "Pridaj novy produkt";
    div.addEventListener("click", (event) => {
        new_product();
    });
    addProduct.appendChild(div);
    tr.appendChild(addProduct);
    for (const row in data) {
        if (tr.childNodes.length % 6 == 0) {
            table.appendChild(tr);
            tr = document.createElement("tr");
        }
        let product = document.createElement("td");
        div = document.createElement("div");
        div.id = "tableItem";
        div.textContent = row['CROP'];
        product.appendChild(div);
        tr.appendChild(product);
    }
    if (tr.childNodes.length % 6 != 0) {
        let n = tr.childNodes.length % 6;
        for (let i = 6; i > n; i--) {
            let dummy = document.createElement("td");
            let dummydiv = document.createElement("div");
            dummydiv.id = "tableItem";
            dummydiv.style = "visibility: hidden";
            dummydiv.textContent = "Place holder";
            dummy.appendChild(dummydiv);
            tr.appendChild(dummy);
        }
    }
    table.appendChild(tr);
    content.appendChild(table);
}