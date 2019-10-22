utils = {
  submitHiddenForm: () => document.getElementById("hidden-form").submit(),
  checkEmailMatch: input => {
    let email = document.getElementById("email");
    let emailConfirm = document.getElementById("email_confirm");
    utils.checkInputMatch(email, emailConfirm, input);
  },
  checkPasswordMatch: input => {
    let password = document.getElementById("password");
    let passwordConfirm = document.getElementById("password_confirm");
    utils.checkInputMatch(password, password_confirm, input);
  },
  checkInputMatch: (a, b, input) => {
    if (a.value !== b.value) {
      input.setCustomValidity("Emails must be matching.");
    } else {
      a.setCustomValidity("");
      b.setCustomValidity("");
    }
  }
};
