
function search() {
    input = document.getElementById("search_input");
    filter = input.value.toUpperCase();

    items = document.getElementsByClassName("tableItem");
    for (i = 0; i < items.length; i++){
        if (items[i].id.toUpperCase().indexOf(filter) > -1) {
            items[i].style.display = "";
        }
        else{
            items[i].style.display= "none";
        }
    }
}




function do_filter_bar() {
    let filter_bar = document.getElementById("filter");

    let search_block = document.createElement( 'div' );
    filter_bar.appendChild( search_block );
    let search_input = document.createElement("input");
    search_input.type = "text";
    search_input.id = "search_input";
    search_input.name = "search";
    search_input.placeholder = "Zadaj názov plodiny...";
    search_block.appendChild(search_input);
    let search_button = document.createElement('button');
    search_button.onclick = search;
    search_button.textContent = 'Hľadaj';
    search_button.id = "search_button";
    search_block.appendChild(search_button);       

    // avoid the warning window when refreshing
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

}

do_filter_bar() 

