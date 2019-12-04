// Michael

utils = {
  submitHiddenForm: () => {
    document.getElementById("hidden-form").submit();
  },
  generateHiddenCartForm: (pid, name, act) => {
    const form = document.createElement("form");
    form.setAttribute("method", "get");
    form.setAttribute("action", "./cart_process.php");
    form.setAttribute("id", "hidden-form");

    const pidInput = document.createElement("input");
    pidInput.setAttribute("type", "hidden");
    pidInput.setAttribute("name", "pid");
    pidInput.setAttribute("value", pid);

    const nameInput = document.createElement("input");
    nameInput.setAttribute("type", "hidden");
    nameInput.setAttribute("name", "name");
    nameInput.setAttribute("value", name);

    const actInput = document.createElement("input");
    actInput.setAttribute("type", "hidden");
    actInput.setAttribute("name", "act");
    actInput.setAttribute("value", act);

    form.appendChild(pidInput);
    form.appendChild(nameInput);
    form.appendChild(actInput);

    document.body.appendChild(form);
  },
  cartButtonAction: (pid, name, act) => {
    utils.generateHiddenCartForm(pid, name, act);
    utils.submitHiddenForm();
  },
  checkEmailMatch: input => {
    const email = document.getElementById("email");
    const emailConfirm = document.getElementById("email_confirm");
    utils.checkInputMatch(email, emailConfirm, input, "Emails");
  },
  checkPasswordMatch: input => {
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("password_confirm");
    utils.checkInputMatch(password, passwordConfirm, input, "Passwords");
  },
  checkInputMatch: (a, b, input, type) => {
    if (a.value !== b.value) {
      input.setCustomValidity(`${type} must be matching.`);
    } else {
      a.setCustomValidity("");
      b.setCustomValidity("");
    }
  },
};
