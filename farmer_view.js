function get_own(what, from) {
    const request = new XMLHttpRequest();
    request.open("POST", from);
    request.send();
    request.addEventListener("load", () => {
        let newData = request.responseText.split(',');
        console.log("update");
        sessionStorage.setItem(what, newData);
        farmer_view_pick();
    })
}

function add_prod_post() {
    const request = post('add_prod.php', document.getElementById("addForm"));
    request.addEventListener("load", (event) => {
        let response = request.responseText;
        sessionStorage.setItem('ownProducts', sessionStorage.getItem('ownProducts') + "," + response);
        farmer_view_pick();
    })
}

function form_add() {
    let popup = document.getElementById("popupWin");
    let form = document.createElement("form");
    form.id = "addForm";
    form.action = "javascript:add_prod_post()";
    form.method = "POST";

    let labelCat = document.createElement('label');
    labelCat.htmlFor = "category";
    labelCat.textContent = "Kategoria";
    form.appendChild(labelCat);

    form.appendChild(document.createElement("br"));

    let selectCat = document.createElement("select");
    selectCat.selectedIndex = 1;
    selectCat.id = "category";
    selectCat.name = "category";

    let categories = post('categories.php', null);
    categories.addEventListener("load", () => {
        var item = categories.responseText;
        item = item.split(',');
        for (let i = 0; i < item.length; i++) {
            let option = document.createElement('option');
            option.value = item[i];
            option.textContent = item[i];
            selectCat.appendChild(option);
        }
    })
    form.appendChild(selectCat);

    form.appendChild(document.createElement("br"));

    let labelCrop = document.createElement('label');
    labelCrop.htmlFor = "crop";
    labelCrop.textContent = "Plodina";
    form.appendChild(labelCrop);

    form.appendChild(document.createElement("br"));

    let selectCrop = document.createElement("select");
    selectCrop.id = "crop";
    selectCrop.name = "crop";
    form.appendChild(selectCrop);
    let addNew = document.createElement('option');
    addNew.textContent = "Pridaj novu";
    addNew.value = "addNew";
    selectCrop.appendChild(addNew);
    let crops = post('crops.php', null);
    crops.addEventListener("load", () => {
        var item = crops.responseText;
        item = item.split(',');
        for (let i = 0; i < item.length; i++) {
            let option = document.createElement('option');
            option.value = item[i];
            option.textContent = item[i];
            selectCrop.appendChild(option);
        }
        selectCrop.selectedIndex = "1";
    })
    let labelNewCrop = document.createElement('label');
    labelNewCrop.htmlFor = "newCrop";
    labelNewCrop.textContent = "Nazov novej plodiny";
    labelNewCrop.style = 'display:none';
    let inputBr = document.createElement("br");
    inputBr.style = 'display:none';
    let labelBr = document.createElement("br");
    labelBr.style = 'display:none';
    let inputNewCrop = document.createElement('input');
    inputNewCrop.type = "text";
    inputNewCrop.id = "newCrop";
    inputNewCrop.name = "newCrop";
    inputNewCrop.style = 'display: none';
    form.appendChild(document.createElement("br"));
    form.appendChild(labelNewCrop);
    form.appendChild(labelBr);
    form.appendChild(inputNewCrop);
    form.appendChild(inputBr);

    selectCrop.addEventListener("change", () => {
        if (selectCrop.selectedIndex == "0") {
            inputNewCrop.style = '';
            inputBr.style = '';
            labelNewCrop.style = '';
            labelBr.style = '';
        } else {
            inputNewCrop.style = 'display:none';
            inputBr.style = 'display:none';
            labelNewCrop.style = 'display:none';
            labelBr.style = 'display:none';
        }
    })


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

    popup.appendChild(form);
}

function new_product() {
    overlay();
    form_add();
}

function updateOnOrder(status, id) {
    var request = new XMLHttpRequest();
    request.open("POST", 'update_order.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send("status=" + status + "&id=" + id + "");
    request.addEventListener("load", () => {
        console.log("status " + status + " changed " + id);
        console.log(request.responseText);
    })
}

// function find(param) {
//     let params = location.href.split('?');
//     if (params.length <= 1) return null;
//     params = params[1].split('&');
//     for (let i = 0; i < params.length; i++) {
//         let actual = params[i].split("=");
//         if (actual[0] == param) return i;
//     }
//     return null;
// }

// function isset(parameter) {
//     if (find(parameter) != null) return true;
//     // let params = location.href.split('?');
//     // for (let i = 1; i < params.length; i++) {
//     //     if (params[i].split("=")[0] == parameter) return true;
//     // }
//     return false;
// }

// if (sessionStorage.getItem('removedParams') == "") sessionStorage.setItem('removedParams', Array(0));
// else console.log(sessionStorage.getItem('removedParams'));

// function store(param) {
//     let removedParams = sessionStorage.getItem("removedParams").split(',');
//     if (removedParams == "") removedParams = Array(0);
//     // else {
//     //     removedParams = removedParams;
//     // }
//     let params = location.href.split('?');
//     if (params.length <= 1) return;
//     pars = params[1].split('&');
//     console.log(pars);
//     console.log(pars[find(param)]);
//     console.log(removedParams);
//     removedParams.push(pars[find(param)]);
//     console.log(removedParams);
//     pars.pop();
//     console.log(pars);
//     if (pars.length > 0) {
//         pars = pars.join('&');
//         params.push(pars);
//     }
//     console.log(pars);
//     console.log(params);
//     if (pars.length < 1) {
//         params = Array(params[0]);
//     } else {
//         params = Array(params[0], pars).join('?');
//     }
//     console.log(params);
//     console.log(removedParams);
//     sessionStorage.setItem("removedParams", removedParams);
//     console.log(sessionStorage.getItem('removedParams'));
//     location.href = params;
// }

// function restoreAll() {
//     let removedParams = sessionStorage.getItem("removedParams");
//     console.log(removedParams);
//     if (removedParams == "") removedParams = Array(0);
//     else {
//         removedParams = Array(removedParams);
//     }
//     console.log(removedParams);
//     let addr = location.href.split('?');
//     console.log(addr);
//     if (removedParams.length == 0) return;
//     if (addr.length > 1) {
//         addr[1] = Array(addr[1], removedParams.join("&")).join('&');
//     } else {
//         addr.push(removedParams.join("&"));
//     }
//     console.log(addr);
//     addr = addr.join('?');
//     console.log(addr);
//     sessionStorage.setItem("removedParams", Array(0));
//     console.log(removedParams);
//     location.href = addr;
// }

function generate_table(type, data) {
    // if (isset("detail")) {
    //     console.log("storing");
    //     store("detail");
    // }
    let scrollTop = 0;
    if (document.getElementById("table") != null && document.getElementById("table").getElementsByTagName("table") != null && document.getElementById("table").getElementsByTagName("table").item(0) != null) {
        scrollTop = document.getElementById("table").getElementsByTagName("table").item(0).scrollTop;
        document.getElementById("table").getElementsByTagName("table").item(0).remove();
    }
    let content = document.getElementById("table");
    let table = document.createElement("table");
    let tr = document.createElement("tr");
    if (type == "farmer_view") {
        let addProduct = document.createElement("td");
        addProduct.id = "addProduct";
        let div = document.createElement("div");
        div.id = "tableItem";
        div.textContent = "Pridaj novy produkt";
        div.addEventListener("click", (event) => {
            new_product();
        });
        addProduct.appendChild(div);
        tr.appendChild(addProduct);
    }
    if (data != null) {
        if (data[0] != "null" && data[0] != "") {
            let cmp1 = 6;
            let cmp2 = 0;
            if (type == "order_view") {
                cmp1 = 2;
                cmp2 = 1
            }
            for (let i = 0; i < data.length; i++) {
                if (tr.childNodes.length % cmp1 == cmp2 && i != 0) {
                    table.appendChild(tr);
                    tr = document.createElement("tr");
                }
                let product = document.createElement("td");
                let div = document.createElement("div");
                div.id = "tableItem";
                if (type == "order_view") {
                    div.style = "width:100%;color:black";
                    let spl = data[i].split(' ');
                    let res = "PROCESSED: " + spl[7] + " CROPID: " + spl[5] +
                        " FARMER: " +
                        spl[4] +
                        " AMOUNT: " + spl[6] +
                        " ID: " + spl[0];
                    div.textContent = res;
                    if (spl[7] == 2) {
                        div.style = "width:100%;color:blue";
                    }
                    if (spl[7] == 1) {
                        div.style = "width:100%;color:green";
                    }
                } else {
                    div.textContent = data[i];
                }
                product.appendChild(div);
                if (type == "order_view") {
                    product.style = 'width:100%';
                    let accButt = document.createElement("button");
                    let decButt = document.createElement("button");
                    accButt.textContent = "Potvrdit";
                    decButt.textContent = "Zrusit";
                    accButt.style = "display:none";
                    decButt.style = "display:none";
                    accButt.addEventListener("click", () => {
                        updateOnOrder(1, div.textContent.split('ID: ')[2]);
                        accButt.style = "display:none";
                        decButt.style = "display:none";
                        div.style = "width:100%;color:green";
                    })
                    decButt.addEventListener("click", () => {
                        updateOnOrder(2, div.textContent.split('ID: ')[2]);
                        accButt.style = "display:none";
                        decButt.style = "display:none";
                        div.style = "width:100%;color:blue";
                    })
                    if (div.style.color != "green" && div.style.color != "blue") {
                        accButt.style = "";
                        decButt.style = "";
                    }
                    product.append(accButt, decButt);
                    product.style = "display:inline-flex;width:100%";
                }
                tr.appendChild(product);
            }
        }
    }
    if (tr.childNodes.length % 6 != 0 && type != "order_view") {
        console.log("adding dummies");
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
    if (table.children.length == 0 && tr.children.length == 0) {
        //no orders 
        let noOrder = document.createElement("p");
        if (type == "order_view") noOrder.textContent = "No orders!";
        if (type == "f") noOrder.textContent = "No orders!";
        if (type == "order_view") noOrder.textContent = "No orders!";
        table.append(noOrder);
    } else {
        table.appendChild(tr);
    }
    content.appendChild(table);
    table.scrollTo(0, scrollTop);

}

let data = null;
// get_own('ownProducts', 'farmer_products.php');
// get_own('ownOrders', 'farmer_orders.php');
// get_own('user_cart', 'get_cart.php')


function farmer_view() {
    if (updateFarmer_view == null) {
        updateFarmer_view = setInterval(farmer_view_pick, 5000);
        get_prods = setInterval(get_own, 5000, 'ownProducts', 'farmer_products.php');
    }
    console.log("farmer_view");
    data = String(sessionStorage.getItem('ownProducts')).split(',');
    generate_table("farmer_view", data);
}

function order_view() {
    if (updateFarmer_view == null) {
        updateFarmer_view = setInterval(farmer_view_pick, 5000);
        get_prods = setInterval(get_own, 5000, 'ownOrders', 'farmer_orders.php');
    }
    console.log("order view");
    data = String(sessionStorage.getItem('ownOrders')).split(',');
    generate_table("order_view", data);


}

function farmer_view_pick() {
    if (sessionStorage.getItem('farmer_view') == "products") {
        farmer_view();
    } else if (sessionStorage.getItem('farmer_view') == "orders") {
        order_view();
    } else if (sessionStorage.getItem('farmer_view') == "cart") {
        cart_view();
    } else if (sessionStorage.getItem('farmer_view') == "profile") {
        profile_view();
    } else {
        // restoreAll();
        clearInterval(updateFarmer_view);
        clearInterval(get_prods);
        clearInterval(get_cart);
        clearInterval(get_cart_items);
        clearInterval(get_profile);
    }
}

let updateFarmer_view; // = setInterval(farmer_view_pick, 5000);
let get_prods; // = setInterval(get_own, 5000, 'ownProducts', 'farmer_products.php');
let get_cart;
let get_cart_items;
let get_profile;