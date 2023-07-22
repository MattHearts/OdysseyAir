
function performSearch() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("search-input");
    filter = input.value.toLowerCase();
    table = document.querySelector("table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Start from 1 to skip the table header row
        td = tr[i].getElementsByTagName("td");
        var found = false;
        for (j = 0; j < td.length; j++) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        if (found) {
            tr[i].style.display = ""; // Show matching rows
        } else {
            tr[i].style.display = "none"; // Hide non-matching rows
        }
    }
}