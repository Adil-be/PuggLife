const addFormToCollection = (e) => {
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );

  let item = document.createElement("li");

  let protoName = collectionHolder.dataset.prototypeName;

  var regex = new RegExp(protoName, "g");

  const title = document.createElement("h3");
 
  item.innerHTML += collectionHolder.dataset.prototype.replace(
    regex,
    collectionHolder.dataset.index
  );

  collectionHolder.appendChild(item);
  collectionHolder.dataset.index++;

  addChildFormDeleteLink(item);

  initEvents(item);
};

const addChildFormDeleteLink = (item) => {
  const removeFormButton = document.createElement("button");
  removeFormButton.innerText = "Supprimer";
  removeFormButton.classList.add("btn");
  removeFormButton.classList.add("btn-danger");

  item.append(removeFormButton);

  removeFormButton.addEventListener("click", (e) => {
    e.preventDefault();
    // remove the li for the tag form
    item.remove();
  });
};

const initEvents = function (item) {
  item.querySelectorAll("[data-collection-element]").forEach((element) => {
    addChildFormDeleteLink(element);
  });
  item.querySelectorAll(".add_item_link").forEach((btn) => {
    btn.removeEventListener("click", addFormToCollection);
    btn.addEventListener("click", addFormToCollection);
  });
};

initEvents(document);
