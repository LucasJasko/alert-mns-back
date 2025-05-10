for (let i = 0; i < tableLines.length; i++) {
  const groupName = tableLines[i].querySelector(".group_name").innerHTML;
  const groupId = tableLines[i].querySelector(".group_id").innerHTML;
  const deleteIcon = tableLines[i].querySelector(".btn__delete");

  deleteIcon.addEventListener("click", (e) => {
    e.preventDefault();
    const contextWindow = document.querySelector(".delete-container");

    contextWindow.classList.add("delete-active");
    const wrapper = document.createElement("div");

    wrapper.innerHTML = `
        <p class="delete-window__answer-text">Etes vous sûr de vouloir supprimer le groupe ${groupName} <br> ( ID: ${groupId} ) ?</p>
        <p class="delete-window__warning-text">Attention: Cette action est irréversible ! Tous les messages associés à ce groupe seront perdus !</p>
        <div class="delete-window__btn-container">
          <button class="delete-window__btn-cancel valid-button">Annuler</button>
          <a class="delete-window__delete-link" href="../index.php?page=group&id=${groupId}&process=delete">Supprimer le groupe</a>
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
