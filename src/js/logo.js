// document.getElementById("credents").addEventListener("DOMNodeRemoved", () => {
//     console.log("update on logo");
// });
let logo = document.getElementById('logo');
let redirect = document.createElement('a');
redirect.href = "../php_script/index.php";
redirect.textContent = "Zelny trh";
logo.appendChild(redirect);