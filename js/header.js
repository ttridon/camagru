// Sign-in

// When the user clicks on <div>, open the popup

var btnSi = document.getElementById("myBtnSi");

btnSi.onclick = function() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

// - - - - - -

// Register

// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btnRe = document.getElementById("myBtnRe");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[1];

// When the user clicks on the button, open the modal
btnRe.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// - - - - - -

// New password

var modal_pwd = document.getElementById("myModal_pwd")

var link = document.getElementById("myLink");

var span_pwd = document.getElementsByClassName("close")[0];

link.onclick = function() {
  modal_pwd.style.display = "block";
}

span_pwd.onclick = function() {
  modal_pwd.style.display = "none";
}
