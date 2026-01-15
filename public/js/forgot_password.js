document.getElementById("forgotForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Clear previous errors
    document.querySelectorAll(".error-text").forEach(el => el.textContent = "");
    document.querySelectorAll(".form-group").forEach(el => el.classList.remove("error"));

    fetch("../controller/forgot_password_controller.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "error") {
            for (let field in data.errors) {
                const errorEl = document.querySelector(`[data-error="${field}"]`);
                if (errorEl) {
                    errorEl.textContent = data.errors[field];
                    errorEl.closest(".form-group").classList.add("error");
                }
            }
        }

        if (data.status === "success") {
            alert("Password reset successful");
            window.location.href = "login.php";
        }
    });
});
