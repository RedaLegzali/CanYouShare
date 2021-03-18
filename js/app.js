import * as cyb from "./canyouweb.js";

const menu = document.querySelector(".navbar-burger");
const uploadBtn = document.querySelector(".uploadbtn");
const uploadfile = document.querySelector(".uploadfile");
const sharedfile = document.querySelector(".sharedfile");
const sharedBtn = document.querySelector(".sharedbtn");
const files_container = document.querySelector(".files");
const shared_container = document.querySelector(".shared");

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

uploadBtn.addEventListener("click", (_) => {
  uploadfile.click();
});

uploadfile.addEventListener("change", (event) => {
  const file = event.target.files[0];
  upload(file, "upload");
});
if (sharedBtn != null) {
  sharedBtn.addEventListener("click", (_) => {
    sharedfile.click();
  });
  sharedfile.addEventListener("change", (event) => {
    const file = event.target.files[0];
    upload(file, "shared");
  });
}

const removeAllChildNodes = (parent) => {
  while (parent.firstChild) {
    parent.removeChild(parent.firstChild);
  }
};

const getShared = async () => {
  let options = {
    method: "GET",
  };
  let response = await fetch(`${cyb.url}/shared`, options);
  let data = await response.json();
  return data;
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
  let shared = await getShared();
  removeAllChildNodes(files_container);
  let element = "";
  files.forEach((value) => {
    if ("link" in value) {
      element += `<a href=${value["link"]} class="button is-large mr-3 mb-3 is-rounded"> 
                <span class="icon is-medium"> <img src="images/folder.svg" />
                </span> <span> ${value["name"]} </span> </a>`;
    } else {
      element += `<a class="button is-large mr-3 mb-3 is-rounded"> 
                <span class="icon is-medium"> <img src="images/folder.svg" />
                </span> <span> ${value["name"]} </span> </a>`;
    }
  });
  files_container.innerHTML = element;
  removeAllChildNodes(shared_container);
  element = "";
  shared.forEach((value) => {
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
  shared_container.innerHTML = element;
};

const upload = async (file, route) => {
  let data = new FormData();
  data.append("archive", file);
  let options = {
    method: "POST",
    body: data,
  };
  try {
    console.log(route);
    let response = await fetch(`${cyb.url}/upload/${route}`, options);
    let data = await response.json();
    uploadfile.value = null;
    sharedfile.value = null;
    cyb.message.classList.remove("is-danger");
    cyb.message.classList.remove("is-success");
    cyb.message.classList.add("is-info");
    cyb.message_container.style.display = "block";
    cyb.message_body.innerHTML = "Uploading...";
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
