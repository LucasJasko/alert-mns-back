const form = document.querySelector(".form");
const addButton = document.querySelector(".plus-btn");
let allDblSelectors = document.querySelectorAll(".dbl-select__container");

if (addButton != null) {
  addButton.addEventListener("click", (e) => {
    e.preventDefault();
    allDblSelectors = document.querySelectorAll(".dbl-select__container");
    let index = allDblSelectors.length - 1;
    let isFilled = true;

    allDblSelectors.forEach((dblSelector) => {
      Array.from(dblSelector.children).forEach((selector) => {
        if (selector.value == "") {
          isFilled = false;
          addButton.textContent = "Veuillez remplir tous les champs";
          addButton.classList.add("not-filled");
          setTimeout(() => {
            addButton.textContent = "Ajouter une situation";
            addButton.classList.remove("not-filled");
          }, 2000);
        }
      });
    });

    if (isFilled) {
      const newDblSelect = document.querySelector(".dbl-select__container").cloneNode(true);
      index++;

      Array.from(newDblSelect.children).forEach((children) => {
        children.value = "";
      });

      newDblSelect.children[0].name = "situation_id[" + index + "][post_id]";
      newDblSelect.children[1].name = "situation_id[" + index + "][department_id]";

      form.insertBefore(newDblSelect, addButton);
    }
  });

  allDblSelectors.forEach((selector) => {
    selector.addEventListener("click", () => {
      if (selector.children[0].value == "") {
        selector.children[0].required == true;
      }
      if (selector.children[0].value == "") {
        selector.children[0].reqired == true;
      }
    });
  });
}
