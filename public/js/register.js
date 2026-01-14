// ================= UTIL =================
const setError = (id, message) => {
  document.getElementById(id).textContent = message;
};

const clearError = id => {
  document.getElementById(id).textContent = "";
};

// ================= NAME =================
const validateName = () => {
  let ok = true;

  const first = document.getElementById("firstName").value.trim();
  const last  = document.getElementById("lastName").value.trim();

  if (!first) {
    setError("firstNameError", "First name is required");
    ok = false;
  } else clearError("firstNameError");

  if (!last) {
    setError("lastNameError", "Last name is required");
    ok = false;
  } else clearError("lastNameError");

  return ok;
};

// ================= EMAIL =================
const validateEmail = () => {
  const email = document.getElementById("email").value.trim();
  const regex = /^\S+@\S+\.\S+$/;

  if (!email) {
    setError("emailError", "Email is required");
    return false;
  }

  if (!regex.test(email)) {
    setError("emailError", "Invalid email format");
    return false;
  }

  clearError("emailError");
  return true;
};

// ================= PHONE =================
const validatePhone = () => {
  const phone = document.getElementById("phone").value.trim();

  if (!/^[0-9]{11}$/.test(phone)) {
    setError("phoneError", "Phone must be 11 digits");
    return false;
  }

  clearError("phoneError");
  return true;
};

// ================= DOB =================
const validateDOB = () => {
  const dob = document.getElementById("dob").value;

  if (!dob) {
    setError("dobError", "Date of birth is required");
    return false;
  }

  clearError("dobError");
  return true;
};

// ================= GENDER =================
const validateGender = () => {
  const genders = document.getElementsByName("gender");

  for (let g of genders) {
    if (g.checked) {
      clearError("genderError");
      return true;
    }
  }

  setError("genderError", "Select gender");
  return false;
};

// ================= NID =================
const validateNID = () => {
  const nid = document.getElementById("nidNumber").value.trim();

  if (!/^[0-9]{10}$/.test(nid)) {
    setError("nidNumberError", "NID must be 10 digits");
    return false;
  }

  clearError("nidNumberError");
  return true;
};

// ================= PASSWORD =================
const validatePassword = () => {
  const pass = document.getElementById("password").value;

  if (pass.length < 6) {
    setError("passwordError", "Minimum 6 characters");
    return false;
  }

  clearError("passwordError");
  return true;
};

const validateConfirmPassword = () => {
  const pass  = document.getElementById("password").value;
  const cpass = document.getElementById("confirmPassword").value;

  if (pass !== cpass) {
    setError("confirmPasswordError", "Passwords do not match");
    return false;
  }

  clearError("confirmPasswordError");
  return true;
};

// ================= PHOTO =================
const validatePhoto = () => {
  const file = document.getElementById("profile-photo").files[0];
  const allowed = ["image/jpeg", "image/png", "image/jpg"];

  if (!file) {
    setError("profilePhotoError", "Profile photo required");
    return false;
  }

  if (!allowed.includes(file.type)) {
    setError("profilePhotoError", "Only JPG or PNG allowed");
    return false;
  }

  clearError("profilePhotoError");
  return true;
};

// ================= TERMS =================
const validateTerms = () => {
  const terms = document.getElementById("terms");

  if (!terms.checked) {
    setError("termsError", "You must accept terms");
    return false;
  }

  clearError("termsError");
  return true;
};

// ================= FINAL =================
const validateForm = () => {
  return (
    validateName() &&
    validateEmail() &&
    validatePhone() &&
    validateDOB() &&
    validateGender() &&
    validateNID() &&
    validatePassword() &&
    validateConfirmPassword() &&
    validatePhoto() &&
    validateTerms()
  );
};

// ================= SUBMIT =================
document.getElementById("registrationForm").addEventListener("submit", e => {
  if (!validateForm()) {
    e.preventDefault();
  }
});

// ================= LIVE CLEAR =================
document.querySelectorAll("input, select").forEach(el => {
  el.addEventListener("input", () => {
    document.querySelectorAll(".error").forEach(err => err.textContent = "");
  });
});
