console.log(tableLines);

for (let i = 0; i < tableLines.length; i++) {
  const userName = tableLines[i].querySelector(".user_name").innerHTML;
  const userSurname = tableLines[i].querySelector(".user_surname").innerHTML;
  const userId = tableLines[i].querySelector(".user_id").innerHTML;
  const deleteIcon = tableLines[i].querySelector(".btn__delete");
  deleteIcon.addEventListener("click", () => {
    const contextWindow = document.querySelector(".delete-container");
    contextWindow.classList.add("delete-active");
    const wrapper = document.createElement("div");
    wrapper.innerHTML = `
        <p class="delete-window__answer-text">Etes vous sûr de vouloir supprimer l'utilisateur ${userName} ${userSurname} <br> ( ID: ${userId} ) ?</p>
        <p class="delete-window__warning-text">Attention: Cette action est irréversible !</p>
        <div class="delete-window__btn-container">
          <button class="delete-window__btn-cancel valid-button">Annuler</button>
          <a class="delete-window__delete-link" href="../delete.php?id=${userId}">Supprimer l'utilisateur</a>
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
