// document.getElementById("credents").addEventListener("DOMNodeRemoved", () => {
//     console.log("update on logo");
// });
let logo = document.getElementById('logo');
let redirect = document.createElement('a');
redirect.href = "index3.php";
redirect.textContent = "Zelny trh";
logo.appendChild(redirect);