let emailBlocked = false;

// EMAIL AJAX CHECK
document.getElementById("email").addEventListener("blur", function () {
  const email = this.value.trim();
  const error = document.getElementById("emailError");

  if (!/^\S+@\S+\.\S+$/.test(email)) return;

  const formData = new FormData();
  formData.append("email", email);
  formData.append("ajax", "check_email");

  fetch("../controller/registerController.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.status === "error") {
        error.textContent = data.message;
        this.classList.add("input-error");
        emailBlocked = true;
      } else {
        error.textContent = "";
        this.classList.remove("input-error");
        emailBlocked = false;
      }
    });
});

document.getElementById("registrationForm").addEventListener("submit", function (e) {
  if (emailBlocked) {
    e.preventDefault();
    document.getElementById("emailError").textContent = "Email already registered";
  }
});
