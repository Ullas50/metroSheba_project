document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector("form");
    const errorBox = document.querySelector(".form-error");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // stop normal submit

        // clear old error (AJAX case)
        if (errorBox) {
            errorBox.textContent = "";
            errorBox.style.display = "none";
        }

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            body: new FormData(form)
        })
        .then(res => res.json())
        .then(data => {

            if (data.status === "error") {
                showError(data.message);
            }

            if (data.status === "success") {
                window.location.href = data.redirect;
            }

        })
        .catch(() => {
            showError("Something went wrong. Try again.");
        });
    });

    function showError(message) {
        let box = document.querySelector(".form-error");

        // if no error div exists, create one
        if (!box) {
            box = document.createElement("div");
            box.className = "form-error";
            form.prepend(box);
        }

        box.textContent = message;
        box.style.display = "block";
    }

    document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") 
        {
        passwordInput.type = "text";
        this.textContent = "🙈";
    } 
    else 
    {
        passwordInput.type = "password";
        this.textContent = "👁️";
    }
});
});
