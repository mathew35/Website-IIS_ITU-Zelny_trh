function profile_view() {
    // if (get_profile == null) {
    //     get_profile = setInterval(get_own, 5000, 'profile', 'get_profile.php');
    // }
    const request = new XMLHttpRequest();
    request.open("POST", "get_acc.php");
    request.send();
    request.addEventListener("load", () => {
        newData = request.responseText;
        sessionStorage.setItem('profile_data', newData);
        console.log("profile");
        profile_form();
    });
    // console.log(sessionStorage.getItem('profile'));
}


function generateLableInput(parent, name, data) {
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
}

function update_profile() {
    const request = new XMLHttpRequest();
    request.open("POST", "update_acc.php");
    request.send();
    request.addEventListener("load", () => {
        newData = request.responseText.split(',');
        profile_form();
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
    form.action = "javascript:update_profile()";
    let div = document.createElement("div");
    div.style.width = "100%";
    div.style.display = "inline-flex";
    div.appendChild(form);
    content.appendChild(div);

    // generateLableInput(form, "login", sessionStorage.getItem('user'));
    generateLableInput(form, "fullname", newData[0]);
    generateLableInput(form, "email", newData[1]);
    if (sessionStorage.getItem('farmer') != null) {
        let hr = document.createElement("hr");
        // hr.style.width = "40%";
        form.appendChild(hr);
        generateLableInput(form, "address", newData[2]);
        generateLableInput(form, "ICO", newData[3]);
        generateLableInput(form, "phone", newData[4]);
        generateLableInput(form, "IBAN", newData[5]);

    }
    let hr = document.createElement("hr");
    // hr.style.width = "40%";
    form.appendChild(hr);

    let update = document.createElement("button");
    let restore = document.createElement("button");
    update.textContent = "Update";
    update.type = "submit";
    restore.textContent = "Restore";
    restore.addEventListener("click", (evt) => {
        profile_form();
    })
    form.appendChild(update);
    form.appendChild(restore);

}