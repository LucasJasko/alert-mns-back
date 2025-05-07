for (let i = 0; i < tableLines.length; i++) {
  const profileName = tableLines[i].querySelector(".profile_name").innerHTML;
  const profileSurname = tableLines[i].querySelector(".profile_surname").innerHTML;
  const profileId = tableLines[i].querySelector(".profile_id").innerHTML;
  const deleteIcon = tableLines[i].querySelector(".btn__delete");

  deleteIcon.addEventListener("click", () => {
    const contextWindow = document.querySelector(".delete-container");
    contextWindow.classList.add("delete-active");
    const wrapper = document.createElement("div");

    wrapper.innerHTML = `
        <p class="delete-window__answer-text">Etes vous sûr de vouloir supprimer l'utilisateur ${profileName} ${profileSurname} <br> ( ID: ${profileId} ) ?</p>
        <p class="delete-window__warning-text">Attention: Cette action est irréversible !</p>
        <div class="delete-window__btn-container">
          <button class="delete-window__btn-cancel valid-button">Annuler</button>
          <a class="delete-window__delete-link" href="../delete.php?form_type=profile&class_name=profile&id=${profileId}">Supprimer l'utilisateur</a>
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
