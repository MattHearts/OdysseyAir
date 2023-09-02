document.addEventListener("DOMContentLoaded", function() {
    var oneWayRadio = document.getElementById("one-way");
    var returnRadio = document.getElementById("return");
    var returnDateInput = document.getElementById("date2");

    // Initially disable the "Return" date field
    returnDateInput.disabled = true;

    // Event listener to the radio buttons
    oneWayRadio.addEventListener("change", function() {
        returnDateInput.disabled = true;
    });

    returnRadio.addEventListener("change", function() {
        returnDateInput.disabled = false;
    });
});
