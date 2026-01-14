let selectedMethod = null;

document.querySelectorAll(".payment-methods button").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".payment-methods button")
            .forEach(b => b.classList.remove("active"));

        btn.classList.add("active");
        selectedMethod = btn.dataset.method;

        document.getElementById("payBtn").disabled = false;
    });
});
