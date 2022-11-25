function get_own_products() {
    const request = new XMLHttpRequest();
    var data = null;
    request.open("POST", 'farmer_products.php');
    request.send();
    return request
}

function add_prod_post() {
    const request = post('add_prod.php', document.getElementById("addForm"));
    request.addEventListener("load", (event) => {
        console.log("update view");
        console.log(request.responseText);
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
    labelNewCrop.textContent = "newCrop";
    labelNewCrop.style = 'visibility: hidden';
    let inputNewCrop = document.createElement('input');
    inputNewCrop.type = "text";
    inputNewCrop.id = "newCrop";
    inputNewCrop.name = "newCrop";
    inputNewCrop.style = 'visibility: hidden';
    form.appendChild(document.createElement("br"));
    form.appendChild(inputNewCrop);
    form.appendChild(document.createElement("br"));
    selectCrop.addEventListener("change", () => {
        if (selectCrop.selectedIndex == "0") {
            inputNewCrop.style = "visibility: 'visible'";
        } else {
            inputNewCrop.style = 'visibility: hidden';
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
    var form = form_add();
}

function farmer_view() {
    if (sessionStorage.getItem('farmer') == null) {
        console.log("no farmer");
        return;
    }
    console.log("farmer_view");
    let content = document.getElementById("table");
    let table = document.createElement("table");
    let dataRequest = get_own_products();
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
    dataRequest.addEventListener("load", () => {
        let data = dataRequest.responseText.split(',');
        console.log(data.length);
        for (let i = 0; i < data.length; i++) {
            if (tr.childNodes.length % 6 == 0) {
                table.appendChild(tr);
                tr = document.createElement("tr");
            }
            let product = document.createElement("td");
            div = document.createElement("div");
            div.id = "tableItem";
            div.textContent = data[i];
            console.log(data[i]);
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
    })
    table.appendChild(tr);
    content.appendChild(table);
}