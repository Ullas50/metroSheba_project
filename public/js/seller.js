// ================= ELEMENTS =================
const from = document.getElementById("from");
const to = document.getElementById("to");
const dateInput = document.getElementById("journey_date");
const qtyInput = document.getElementById("quantity");
const payBtn = document.getElementById("payBtn");

// Summary
const sFrom = document.getElementById("sFrom");
const sTo = document.getElementById("sTo");
const sQty = document.getElementById("sQty");
const sDist = document.getElementById("sDist");
const sTotal = document.getElementById("sTotal");

// Field errors (NEW — must exist in HTML)
const fromError = document.getElementById("fromError");
const toError   = document.getElementById("toError");
const dateError = document.getElementById("dateError");
const qtyError  = document.getElementById("qtyError");

const PRICE_PER_STATION = 10;

// ================= INIT =================
from.innerHTML = `<option value="" disabled selected hidden>Select Departure Station</option>`;
to.innerHTML   = `<option value="" disabled selected hidden>Select Arrival Station</option>`;

// ================= LOAD STATIONS =================
fetch("../controller/GetStations.php")
    .then(res => res.json())
    .then(stations => {
        stations.forEach(s => {
            const opt = `<option value="${s.id}" data-order="${s.station_order}">
                ${s.station_name}
            </option>`;
            from.innerHTML += opt;
            to.innerHTML += opt;
        });
    });

// ================= SUMMARY =================
function updateSummary() {
    if (!from.value || !to.value || from.value === to.value) {
        sFrom.textContent = "—";
        sTo.textContent = "—";
        sQty.textContent = "0";
        sDist.textContent = "0 stations";
        sTotal.textContent = "0";
        return;
    }

    const f = from.selectedOptions[0];
    const t = to.selectedOptions[0];

    const distance = Math.abs(
        parseInt(t.dataset.order) - parseInt(f.dataset.order)
    );

    const qty = parseInt(qtyInput.value) || 0;
    const total = distance * PRICE_PER_STATION * qty;

    sFrom.textContent = f.text;
    sTo.textContent = t.text;
    sQty.textContent = qty;
    sDist.textContent = `${distance} stations`;
    sTotal.textContent = total;
}

[from, to, qtyInput].forEach(el =>
    el.addEventListener("change", updateSummary)
);

// ================= SUBMIT =================
payBtn.addEventListener("click", async (e) => {
    e.preventDefault();

    // clear errors
    fromError.textContent = "";
    toError.textContent = "";
    dateError.textContent = "";
    qtyError.textContent = "";

    let hasError = false;
    const qty = parseInt(qtyInput.value, 10);

    if (!from.value) {
        fromError.textContent = "From station required";
        hasError = true;
    }

    if (!to.value) {
        toError.textContent = "To station required";
        hasError = true;
    }

    if (from.value && to.value && from.value === to.value) {
        toError.textContent = "From and To cannot be the same";
        hasError = true;
    }

    if (!dateInput.value) {
        dateError.textContent = "Journey date required";
        hasError = true;
    }

    if (isNaN(qty) || qty < 1) {
        qtyError.textContent = "Quantity must be at least 1";
        hasError = true;
    } else if (qty > 10) {
        qtyError.textContent = "Maximum 10 tickets allowed";
        hasError = true;
    }

    if (hasError) return;

    const fd = new FormData(document.getElementById("sellerForm"));

    const res = await fetch("../controller/SellerPaymentInit.php", {
        method: "POST",
        body: fd
    });

    const result = await res.text();

    if (result !== "OK") {
        // backend fallback
        if (result.includes("From")) fromError.textContent = result;
        else if (result.includes("To") || result.includes("station")) toError.textContent = result;
        else if (result.includes("date")) dateError.textContent = result;
        else qtyError.textContent = result;
        return;
    }

    window.location.href = "seller_cash_payment.php";
});
