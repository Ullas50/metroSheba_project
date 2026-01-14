// ================= ELEMENTS =================
const from = document.getElementById("from");
const to = document.getElementById("to");
const dateInput = document.getElementById("journey_date");
const totalPrice = document.getElementById("totalPrice");

const qtyInput = document.getElementById("quantity");

// Errors
const fromError = document.getElementById("fromError");
const toError = document.getElementById("toError");
const dateError = document.getElementById("dateError");
const qtyError = document.getElementById("qtyError");

// ================= INITIAL =================
from.innerHTML = `<option value="" disabled selected hidden>Select Departure Station</option>`;
to.innerHTML   = `<option value="" disabled selected hidden>Select Arrival Station</option>`;

// ================= LOAD STATIONS =================
fetch("../controller/GetStations.php")
    .then(res => res.json())
    .then(stations => {
        stations.forEach(s => {
            from.innerHTML += `<option value="${s.id}" data-order="${s.station_order}">${s.station_name}</option>`;
            to.innerHTML   += `<option value="${s.id}" data-order="${s.station_order}">${s.station_name}</option>`;
        });
    });

// ================= PRICE CALC =================
function calculatePrice() {
    if (!from.value || !to.value || from.value === to.value) {
        totalPrice.textContent = "৳0";
        return;
    }

    const f = from.selectedOptions[0].dataset.order;
    const t = to.selectedOptions[0].dataset.order;
    const qty = parseInt(qtyInput.value) || 1;

    totalPrice.textContent = "৳" + Math.abs(f - t) * 10 * qty;
}

[from, to, qtyInput].forEach(el => el.addEventListener("change", calculatePrice));

// ================= QUANTITY VALIDATION =================

// prevent mouse wheel change
qtyInput.addEventListener("wheel", e => e.preventDefault());

// live validation
qtyInput.addEventListener("input", () => {
    qtyError.textContent = "";

    let val = parseInt(qtyInput.value);

    if (isNaN(val) || val < 1) {
        qtyInput.value = 1;
    }

    if (val > 10) {
        qtyInput.value = 10;
        qtyError.textContent = "Maximum 10 tickets allowed";
    }

    calculatePrice();
});

// ================= CLEAR ERRORS =================
function clearErrors() {
    fromError.textContent = "";
    toError.textContent = "";
    dateError.textContent = "";
    qtyError.textContent = "";
}

document.querySelectorAll("select, input").forEach(el => {
    el.addEventListener("input", clearErrors);
});

// ================= SUBMIT =================
document.getElementById("bookingForm").addEventListener("submit", async e => {
    e.preventDefault();
    clearErrors();

    let hasError = false;
    const qty = parseInt(qtyInput.value);

    if (!from.value) {
        fromError.textContent = "From station is required";
        hasError = true;
    }

    if (!to.value) {
        toError.textContent = "To station is required";
        hasError = true;
    }

    if (from.value && to.value && from.value === to.value) {
        toError.textContent = "From and To cannot be the same";
        hasError = true;
    }

    if (!dateInput.value) {
        dateError.textContent = "Journey date is required";
        hasError = true;
    }

    if (isNaN(qty) || qty < 1) {
        qtyError.textContent = "Quantity must be at least 1";
        hasError = true;
    }

    if (qty > 10) {
        qtyError.textContent = "Maximum 10 tickets allowed";
        hasError = true;
    }

    if (hasError) return;

    const formData = new FormData(e.target);

    const res = await fetch("../controller/BookingController.php", {
        method: "POST",
        body: formData
    });

    const result = await res.text();
    if (result !== "OK") {
        alert(result);
        return;
    }

    window.location.href = "ticket_summary.php";
});
