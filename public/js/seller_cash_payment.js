document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    if (!form) return;

    const input = form.querySelector("input[name='received_amount']");
    const errorBox = form.querySelector(".cash-error");

    form.addEventListener("submit", async e => {
        e.preventDefault();

        clearError();

        const res = await fetch(form.action, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (data.status === "error") {
            showError(data.message);
            return;
        }

        window.location.href = data.redirect;
    });

    function showError(msg) {
        errorBox.textContent = msg;
        input.classList.add("input-error");
    }

    function clearError() {
        errorBox.textContent = "";
        input.classList.remove("input-error");
    }
});
