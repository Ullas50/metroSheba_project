// handle forgot password form submission
document.getElementById("forgotForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
// Clear any previous error messages
    document.querySelectorAll(".error-text").forEach(el => el.textContent = "");
    document.querySelectorAll(".form-group").forEach(el => el.classList.remove("error"));
// Clear any previous error messages
    fetch("../controller/forgot_password_controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // If there are errors, display them next to the relevant fields
        if (data.status === "error") {
            for (let field in data.errors) {
                const errorEl = document.querySelector(`[data-error="${field}"]`);
                if (errorEl) {
                    errorEl.textContent = data.errors[field];
                    errorEl.closest(".form-group").classList.add("error");
                }
            }
        }
  // If password reset is successful, redirect to login page
        if (data.status === "success") {
            alert("Password reset successful");
            window.location.href = "login.php";
        }
    });
});
