var counter = 0;

var rows = document.querySelectorAll(".was-active");
var user = rows[counter];



rows[counter].classList.remove("was-active");



var submitButton = document.querySelectorAll(".btnlike1");
var submitions = 0;

//var likeSubmit = document.getElementsByClassName(".btnlike");

submitButton[submitions].addEventListener("submit", function() {

    rows[counter].classList.add("was-active");
    submitions++;
    counter++;
    rows[counter].classList.remove("was-active");


});