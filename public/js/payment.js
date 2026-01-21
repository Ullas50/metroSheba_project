// 🔒 ADDITION 1 — ensure DOM is ready
document.addEventListener("DOMContentLoaded", () => {

let selectedMethod = null;

document.querySelectorAll(".payment-methods button").forEach(btn => {
    btn.addEventListener("click", () => {
        document
            .querySelectorAll(".payment-methods button")
            .forEach(b => b.classList.remove("active"));

        btn.classList.add("active");
        selectedMethod = btn.dataset.method;

        document.getElementById("proceedBtn").disabled = false;
    });
});

const proceedBtn = document.getElementById("proceedBtn");

if (proceedBtn) {
    proceedBtn.addEventListener("click", async () => {
        showPaymentError("");

        if (!selectedMethod) {
            showPaymentError("Please select a payment method");
            return;
        }

        const res = await fetch("../controller/SelectPaymentMethod.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: "method=" + encodeURIComponent(selectedMethod)
        });

        const result = await res.text();

        if (result === "OK") {
            window.location.href = "payment_form.php";
            return;
        }

        showPaymentError(result);
    });
}

const paymentForm = document.querySelector("form");

if (paymentForm) {
    paymentForm.addEventListener("submit", async e => {
        e.preventDefault();
        e.stopPropagation(); // 🔒 ADDITION 2 — HARD BLOCK reload
        showPaymentError("");

        const res = await fetch(paymentForm.action, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            body: new FormData(paymentForm)
        });

        const data = await res.json();

        if (data.status === "error") {
            showPaymentError(data.message);
            return;
        }

        window.location.href = data.redirect;
    });
}

function showPaymentError(msg) {
    const inputGroup = document.querySelector(".input-group");
    if (!inputGroup) return;

    let box = inputGroup.querySelector(".payment-error");

    if (!box) {
        box = document.createElement("small");
        box.className = "payment-error error";
        inputGroup.appendChild(box);
    }

    box.textContent = msg;
}

});
