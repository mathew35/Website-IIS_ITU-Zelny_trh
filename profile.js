function profile_view() {
    if (get_profile == null) {
        get_profile = setInterval(get_own, 5000, 'profile', 'get_profile.php');
    }
    profile_form();
    console.log("profile");
    console.log(sessionStorage.getItem('profile'));
}

let newData = null;

function profile_form() {

    let content = document.getElementById("tableItems")
    while (content.hasChildNodes()) {
        content.removeChild(content.lastChild);
    }
    let form = document.createElement("form");

    const request = new XMLHttpRequest();
    request.open("POST", "get_acc.php");
    request.send();
    request.addEventListener("load", () => {
        newData = request.responseText.split(',');
        content.appendChild(form);
        //prefill form with newData;
    })

    let labelLogin = document.createElement("label");
    labelLogin.htmlFor = "login";
    labelLogin.textContent = "Login";
    form.appendChild(labelLogin);
    form.appendChild(document.createElement("br"));
    // let selectLogin = document.createElement("input");
    // selectCat.selecstedIndex = 1;
    // selectCat.id = "category";
    // selectCat.name = "category";
}