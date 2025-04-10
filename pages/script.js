const navlink = document.querySelectorAll(".navbar li a");
const pageName = document.querySelector(".target");

switch (pageName.value) {
  case "user":
    navlink[1].classList.add("a-active");
    break;
  case "group":
    navlink[0].classList.add("a-active");
    break;
  case "params":
    navlink[2].classList.add("a-active");
    break;
}

console.log(navlink[0]);
console.log(navlink[1]);
console.log(navlink[2]);
