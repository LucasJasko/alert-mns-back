const navlink = document.querySelectorAll(".navbar li a");
const pageName = document.querySelector(".target");
const tableLines = document.querySelectorAll(".dashboard tbody tr");
const logOutIcon = document.querySelector(".navbar__container .log-out__btn i");
const logOutCont = document.querySelector(".navbar__container .log-out__btn");

logOutCont.addEventListener("mouseenter", () => {
  logOutIcon.style.color = "red";
});
logOutCont.addEventListener("mouseleave", () => {
  logOutIcon.style.color = "black";
});

// Affichage du tableau modulo
for (let i = 0; i < tableLines.length; i++) {
  if (i % 2 == 0) tableLines[i].style.backgroundColor = "var(--palegreen)";
}

// Affichage de la navigation
console.log(navlink);

navlink.forEach((link) => {
  if (link.innerHTML == pageName.value) link.classList.add("a-active");
});
