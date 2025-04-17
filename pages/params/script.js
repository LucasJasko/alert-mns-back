const paramWindows = document.querySelectorAll(".param-window");
for (let i = 0; i < paramWindows.length; i++) {
  console.log(paramWindows[i].classList[1]);
}

for (let i = 0; i < tableLines.length; i++) {
  const lineId = tableLines[i].children[0].innerHTML;
  const lineName = tableLines[i].children[1].innerHTML;

  const deleteIcon = tableLines[i].querySelector(".btn__delete");

  deleteIcon.addEventListener("click", () => {
    const contextWindow = document.querySelector(".delete-container");
    console.log(contextWindow);

    contextWindow.classList.add("delete-active");
    const wrapper = document.createElement("div");
    wrapper.innerHTML = `
        <p class="delete-window__answer-text">Etes vous sûr de vouloir supprimer ${lineName} <br> ( ID: ${lineId} ) ?</p>
        <p class="delete-window__warning-text">Attention: Cette action est irréversible !</p>
        <div class="delete-window__btn-container">
          <button class="delete-window__btn-cancel valid-button">Annuler</button>
          <a class="delete-window__delete-link" href="../delete.php?form_type=qqchs&class_name=Qqchs&id=${lineId}">Supprimer</a>
    </div>
  `;
    wrapper.classList.add("delete-window");
    contextWindow.appendChild(wrapper);

    const cancelBtn = document.querySelector(".delete-window__btn-cancel");
    cancelBtn.addEventListener("click", () => {
      contextWindow.innerHTML = "";
      contextWindow.classList.remove("delete-active");
    });
  });
}
