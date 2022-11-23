document.addEventListener("click", (evt) => {
    const flyoutEl = document.getElementById("popupWin");
    let targetEl = evt.target; // clicked element      
    do {
        if (targetEl == flyoutEl) {
            // This is a click inside, does nothing, just return.
            // document.getElementById("popupWin").textContent = "Clicked inside!";
            return;
        }
        // Go up the DOM
        targetEl = targetEl.parentNode;
    } while (targetEl);
    // This is a click outside.      
    // document.getElementById("popupWin").textContent = "Clicked outside!";
    var newURL = new URL(window.location.href);
    var params = new URLSearchParams(newURL.search);
    params.delete("action");
    var pars = params.toString();
    newURL.search = pars;
    window.location.href = newURL;

});