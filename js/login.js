import * as cyb from "./canyouweb.js";

const group = document.querySelector(".group");
const submit = document.querySelector(".submit");
const input = document.querySelector("input");
const groups = document.querySelectorAll("a");

const login = async (team, password) => {
  try {
    let form = new FormData();
    form.append("team", team);
    form.append("password", password);
    let options = {
      method: "POST",
      body: form,
    };
    let response = await fetch(`${cyb.url}/auth`, options);
    let data = await response.json();
    return data;
  } catch (err) {
    console.log(err);
  }
};

cyb.dropbtn.addEventListener("click", () => {
  cyb.dropdown.classList.toggle("is-active");
});

groups.forEach((item) => {
  item.addEventListener("click", () => {
    group.textContent = item.textContent;
    cyb.dropdown.classList.toggle("is-active");
  });
});

submit.addEventListener("click", async () => {
  let team = group.textContent.replace("Team - ", "").trim().toLowerCase();
  let password = input.value;
  let data = await login(team, password);
  if (data["status"] == 0) {
    cyb.message.classList.remove("is-danger");
    cyb.message.classList.add("is-success");
    window.location.replace(`${cyb.url}`);
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
});
