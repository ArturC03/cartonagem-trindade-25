function Dropdown_content() {
  var dropdown = document.querySelector(".dropdown-content");
  dropdown.classList.toggle("show");
}

window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdown = document.getElementById("dropdown");
    var i;
    if (dropdown.classList.contains('show')) {
      dropdown.classList.remove('show');
    }
  }
};