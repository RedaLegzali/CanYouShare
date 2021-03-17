import * as cyb from "./canyouweb.js";

const menu = document.querySelector(".navbar-burger");
const inputBtn = document.querySelector(".inputbtn");
const inputfile = document.querySelector(".inputfile");
const files_container = document.querySelector(".files");

cyb.dropbtn.addEventListener("click", () => {
  cyb.dropdown.classList.toggle("is-active");
});

window.onload = function () {
  renderFiles();
};

menu.addEventListener("click", (_) => {
  const navbar = document.querySelector(".navbar-menu");
  navbar.classList.toggle("is-active");
});

inputBtn.addEventListener("click", (_) => {
  inputfile.click();
});

inputfile.addEventListener("change", (event) => {
  const file = event.target.files[0];
  upload(file);
});

const removeAllChildNodes = (parent) => {
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
};

const getFiles = async () => {
  let options = {
    method: "GET",
  };
  let response = await fetch(`${cyb.url}/files`, options);
  let data = await response.json();
  return data;
};

const renderFiles = async () => {
  let files = await getFiles();
  removeAllChildNodes(files_container);
  let element = "";
  files.forEach((value) => {
    element += `
    <a
    href=${value["link"]}
    class="button is-large mr-3 mb-3 is-rounded"
    >
    <span class="icon is-medium">
      <img src="images/folder.svg" />
    </span>
    <span>
      ${value["name"]}
    </span>
    </a>`;
  });
  files_container.innerHTML = element;
};

const upload = async (file) => {
  let data = new FormData();
  data.append("archive", file);
  let options = {
    method: "POST",
    body: data,
  };
  try {
    let response = await fetch(`${cyb.url}/upload`, options);
    let data = await response.json();
    inputfile.value = null;
    if (data["status"] == 0) {
      cyb.message.classList.remove("is-danger");
      cyb.message.classList.add("is-success");
      renderFiles();
    } else {
      cyb.message.classList.add("is-danger");
      cyb.message.classList.remove("is-success");
    }
    cyb.message_body.innerHTML = data["message"];
    cyb.message_container.style.display = "block";
    setTimeout(() => {
      cyb.message_container.classList.add("hide");
    }, 3000);
    setTimeout(() => {
      cyb.message_container.classList.remove("hide");
      cyb.message_container.style.display = "none";
    }, 4000);
  } catch (err) {
    console.log(err);
  }
};
