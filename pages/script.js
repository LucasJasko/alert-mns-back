const navlink = document.querySelectorAll(".navbar li a");
const pageName = document.querySelector(".target");
const tableLines = document.querySelectorAll(".dashboard tbody tr");

// Affichage du tableau modulo
for (let i = 0; i < tableLines.length; i++) {
  if (i % 2 == 0) tableLines[i].style.backgroundColor = "rgb(215, 225, 215)";
}

// Affichage de la navigation
navlink.forEach((link) => {
  if (link.innerHTML == pageName.value) link.classList.add("a-active");
});
