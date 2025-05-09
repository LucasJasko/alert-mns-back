for (let i = 0; i < tableLines.length; i++) {
  const profileName = tableLines[i].querySelector(".profile_name").innerHTML;
  const profileSurname = tableLines[i].querySelector(".profile_surname").innerHTML;
  const profileId = tableLines[i].querySelector(".profile_id").innerHTML;
  const page = tableLines[i].querySelector(".btn__delete").id;
  const deleteIcon = tableLines[i].querySelector(".btn__delete");

  deleteIcon.addEventListener("click", (e) => {
    e.preventDefault();
    const contextWindow = document.querySelector(".delete-container");
    contextWindow.classList.add("delete-active");
    const wrapper = document.createElement("div");

    wrapper.innerHTML = `
        <p class="delete-window__answer-text">Etes vous sûr de vouloir supprimer l'utilisateur ${profileName} ${profileSurname} <br> ( ID: ${profileId} ) ?</p>
        <p class="delete-window__warning-text">Attention: Cette action est irréversible !</p>
        <div class="delete-window__btn-container">
          <button class="delete-window__btn-cancel valid-button">Annuler</button>
          <a class="delete-window__delete-link" href="../index.php?page=${page}&id=${profileId}&process=delete">Supprimer l'utilisateur</a>
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
