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

document.getElementById("proceedBtn").addEventListener("click", () => {
    if (!selectedMethod) {
        alert("Please select a payment method");
        return;
    }

    fetch("../controller/SelectPaymentMethod.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "method=" + encodeURIComponent(selectedMethod)
    })
    .then(res => res.text())
    .then(res => {
        if (res === "OK") {
            window.location.href = "payment_form.php";
        } else {
            alert(res);
        }
    });
});
