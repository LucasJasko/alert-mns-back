const form = document.querySelector(".form");
const oneSituation = document.querySelector(".dbl-select__container");

function handleSelectChange(e) {
  const container = e.currentTarget.closest(".dbl-select__container");
  const selects = container.querySelectorAll(".dbl-select");

  const allFilled = Array.from(selects).every((select) => select.value !== "");
  const situations = document.querySelectorAll(".dbl-select__container");
  const isLast = container === situations[situations.length - 1];

  if (allFilled && isLast) {
    const newSituation = oneSituation.cloneNode(true); // Clone le bloc
    const newSelects = newSituation.querySelectorAll(".dbl-select");

    // Réinitialise les valeurs des selects
    newSelects.forEach((select) => {
      select.value = "";
    });

    // Ajoute le nouveau bloc à la fin du formulaire
    container.parentNode.insertBefore(newSituation, container.nextSibling);

    // Ajoute les listeners aux selects du nouveau bloc
    newSelects.forEach((select) => {
      select.addEventListener("change", handleSelectChange);
    });
  }
}

document.querySelectorAll(".dbl-select").forEach((select) => {
  select.addEventListener("change", handleSelectChange);
});
