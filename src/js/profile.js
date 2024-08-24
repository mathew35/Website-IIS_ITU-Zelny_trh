function profile_view() {
    // if (get_profile == null) {
    //     get_profile = setInterval(get_own, 5000, 'profile', 'get_profile.php');
    // }
    const request = new XMLHttpRequest();
    request.open("POST", "../php_ajax/get_acc.php");
    request.send();
    request.addEventListener("load", () => {
        newData = request.responseText;
        sessionStorage.setItem('profile_data', newData);
        console.log("profile");
        // remove anything in table
        let table = document.getElementById('table');
        table.innerHTML = '';
        profile_form();
    });
    // console.log(sessionStorage.getItem('profile'));
}


function generateLableInput(parent, name, data, limit) {
    let label = document.createElement("label");
    label.htmlFor = name;
    parent.appendChild(label);
    parent.appendChild(document.createElement("br"));
    let input = document.createElement("input");
    input.type = "text";
    input.id = name;
    input.name = name;
    name = name.split('');
    name[0] = name[0].toUpperCase();
    name = name.join('');
    label.textContent = name;
    input.value = data;
    parent.appendChild(input);
    parent.appendChild(document.createElement("br"));
    input.size = 20;
    if (limit != null) {
        input.maxLength = limit;
        input.size = limit;
    }
}

function update_profile() {
    const request = new XMLHttpRequest();
    request.open("POST", "../php_ajax/update_acc.php");
    var form = document.getElementById("profileForm")
    var data = null;
    if (form != null) {
        data = new FormData(form);
    }
    request.send(data);
    request.addEventListener("load", () => {
        console.log(request.responseText);
        newData = request.responseText.split(',');
        profile_view();
    })
    console.log("updating profile");
}

function profile_form() {
    let newData = sessionStorage.getItem('profile_data').split(';');
    console.log(newData);
    let content = document.getElementById("tableItems");
    if (content != null) content.remove();
    content = document.createElement("div");
    content.id = "tableItems";
    let table = document.getElementById("table");
    table.appendChild(content);
    let form = document.createElement("form");
    form.id = "profileForm";
    form.action = "javascript:update_profile()";
    let div = document.createElement("div");
    div.style.width = "100%";
    div.style.display = "inline-flex";
    div.style.padding = "10px";
    div.style.justifyContent = "center";
    div.appendChild(form);
    content.appendChild(div);

    // generateLableInput(form, "login", sessionStorage.getItem('user'));
    generateLableInput(form, "fullname", newData[0], 32);
    generateLableInput(form, "email", newData[1], 32);
    if (sessionStorage.getItem('farmer') != null) {
        let hr = document.createElement("hr");
        // hr.style.width = "40%";
        form.appendChild(hr);
        generateLableInput(form, "address", newData[2], 32);
        generateLableInput(form, "ICO", newData[3], 8);
        generateLableInput(form, "phone", newData[4], 13);
        generateLableInput(form, "IBAN", newData[5], 32);

    }
    let hr = document.createElement("hr");
    // hr.style.width = "40%";
    form.appendChild(hr);

    let update = document.createElement("button");
    let restore = document.createElement("button");
    update.textContent = "Aktualizovať";
    update.type = "submit";
    restore.textContent = "Obnoviť";
    restore.type = "button";
    restore.addEventListener("click", (evt) => {
        profile_view();
    })
    form.appendChild(update);
    form.appendChild(restore);

}