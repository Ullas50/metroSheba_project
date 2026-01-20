//GLOBAL STAte


  // CACHE ELEMENTS (DO NOT RELY ON GLOBAL IDS)

const form = document.getElementById("registrationForm");
const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const dob = document.getElementById("dob");
const nidNumber = document.getElementById("nidNumber");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");


   //EMAIL AJAX CHECK

email.addEventListener("blur", function () {
  const value = this.value.trim();
  const error = document.getElementById("emailError");

  if (value === "") {
    showError(this, "Email is required");
    emailBlocked = true;
    return;
  }

  if (!/^\S+@\S+\.\S+$/.test(value)) return;

  const formData = new FormData();
  formData.append("email", value);
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


   //ERROR HELPERS

function showError(input, message) {
  const errorEl = document.getElementById(input.id + "Error");
  if (!errorEl) return;

  errorEl.textContent = message;
  input.classList.add("input-error");
}

function clearError(input) {
  const errorEl = document.getElementById(input.id + "Error");
  if (!errorEl) return;

  errorEl.textContent = "";
  input.classList.remove("input-error");
}

function requiredCheck(input, message) {
  if (input.value.trim() === "") {
    showError(input, message);
    return false;
  }
  clearError(input);
  return true;
}


  // BLUR VALIDATION

firstName.addEventListener("blur", () =>
  requiredCheck(firstName, "First name is required")
);

lastName.addEventListener("blur", () =>
  requiredCheck(lastName, "Last name is required")
);

phone.addEventListener("blur", function () {
  const value = this.value.trim();

  if (value === "") {
    showError(this, "Mobile number is required");
    return;
  }

  if (!/^\d{11}$/.test(value)) {
    showError(this, "Mobile number must be exactly 11 digits");
    return;
  }

  clearError(this);
});

dob.addEventListener("blur", () =>
  requiredCheck(dob, "Date of birth is required")
);

nidNumber.addEventListener("blur", function () {
  const value = this.value.trim();

  if (value === "") {
    showError(this, "NID is required");
    return;
  }

  if (!/^\d{10}$/.test(value)) {
    showError(this, "NID must be exactly 10 digits");
    return;
  }

  clearError(this);
});

password.addEventListener("blur", function () {
  if (this.value.trim().length < 6) {
    showError(this, "Password must be at least 6 characters");
  } else {
    clearError(this);
  }
});

confirmPassword.addEventListener("blur", function () {
  if (this.value !== password.value) {
    showError(this, "Passwords do not match");
  } else {
    clearError(this);
  }
});


  // GENDER VALIDATION
document.querySelectorAll("input[name='gender']").forEach(radio => {
  radio.addEventListener("change", () => {
    document.getElementById("genderError").textContent = "";
  });
});


  // FINAL SUBMIT VALIDATION

form.addEventListener("submit", function (e) {
  let valid = true;

  valid &= requiredCheck(firstName, "First name is required");
  valid &= requiredCheck(lastName, "Last name is required");
  valid &= requiredCheck(email, "Email is required");
  valid &= requiredCheck(dob, "Date of birth is required");

  if (phone.value.trim().length === 0) {
  showError(phone, "Mobile number is required");
  valid = false;
} else if (phone.value.trim().length < 11) {
  showError(phone, "Mobile number must be exactly 11 digits");
  valid = false;
} else {
  clearError(phone);
}



  if (nidNumber.value.trim().length === 0) {
  showError(nidNumber, "NID is required");
  valid = false;
} else if (nidNumber.value.trim().length !== 10) {
  showError(nidNumber, "NID must be exactly 10 digits");
  valid = false;
} else {
  clearError(nidNumber);
}



  if (password.value.trim().length < 6) {
    showError(password, "Password must be at least 6 characters");
    valid = false;
  }

  if (confirmPassword.value !== password.value) {
    showError(confirmPassword, "Passwords do not match");
    valid = false;
  }

  if (!valid || emailBlocked) {
    e.preventDefault();
  }
});
