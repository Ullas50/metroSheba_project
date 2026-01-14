// ================= NAME =================
const nameValidation = () => {
  const firstName = document.getElementById("firstName").value.trim();
  const lastName = document.getElementById("lastName").value.trim();

  document.getElementById("firstNameError").textContent =
    firstName === "" ? "First name is required" : "";

  document.getElementById("lastNameError").textContent =
    lastName === "" ? "Last name is required" : "";

  return firstName !== "" && lastName !== "";
};

// ================= EMAIL =================
const emailValidation = () => {
  const email = document.getElementById("email").value.trim();
  const error = document.getElementById("emailError");

  if (email === "") {
    error.textContent = "Email is required";
    return false;
  }

  if (!/^\S+@\S+\.\S+$/.test(email)) {
    error.textContent = "Invalid email format";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= PHONE =================
const phoneValidation = () => {
  const phone = document.getElementById("phone").value.trim();
  const error = document.getElementById("phoneError");

  if (!/^[0-9]{11}$/.test(phone)) {
    error.textContent = "Phone must be 11 digits";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= DOB =================
const dobValidation = () => {
  const dob = document.getElementById("dob").value;
  document.getElementById("dobError").textContent =
    dob === "" ? "Date of birth is required" : "";
  return dob !== "";
};

// ================= GENDER =================
const genderValidation = () => {
  const genders = document.getElementsByName("gender");
  const error = document.getElementById("genderError");

  for (let g of genders) {
    if (g.checked) {
      error.textContent = "";
      return true;
    }
  }

  error.textContent = "Select gender";
  return false;
};

// ================= NID =================
const nidValidation = () => {
  const nid = document.getElementById("nidNumber").value.trim();
  const error = document.getElementById("nidNumberError");

  if (!/^[0-9]{10}$/.test(nid)) {
    error.textContent = "NID must be 10 digits";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= PASSWORD =================
const passwordValidation = () => {
  const pass = document.getElementById("password").value.trim();
  const error = document.getElementById("passwordError");

  if (pass.length < 6) {
    error.textContent = "Minimum 6 characters";
    return false;
  }

  error.textContent = "";
  return true;
};

const confirmPasswordValidation = () => {
  const pass = document.getElementById("password").value;
  const cpass = document.getElementById("confirmPassword").value;
  const error = document.getElementById("confirmPasswordError");

  if (pass !== cpass) {
    error.textContent = "Passwords do not match";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= PHOTO =================
const profilePhotoValidation = () => {
  const file = document.getElementById("profile-photo").files[0];
  const error = document.getElementById("profilePhotoError");

  if (!file) {
    error.textContent = "Profile photo required";
    return false;
  }

  const allowed = ["image/jpeg", "image/png", "image/jpg"];
  if (!allowed.includes(file.type)) {
    error.textContent = "Only JPG or PNG allowed";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= TERMS =================
const termsValidation = () => {
  const terms = document.getElementById("terms");
  const error = document.getElementById("termsError");

  if (!terms.checked) {
    error.textContent = "You must accept terms";
    return false;
  }

  error.textContent = "";
  return true;
};

// ================= FINAL =================
const registrationValidation = () => {
  return (
    nameValidation() &&
    emailValidation() &&
    phoneValidation() &&
    dobValidation() &&
    genderValidation() &&
    nidValidation() &&
    passwordValidation() &&
    confirmPasswordValidation() &&
    profilePhotoValidation() &&
    termsValidation()
  );
};

document
  .getElementById("registrationForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    if (registrationValidation()) {
      this.submit();
    }
  });
