const from = document.getElementById('from');
const to = document.getElementById('to');
const qty = document.getElementById('quantity');
const date = document.getElementById('journey_date');
const payBtn = document.getElementById('payBtn');

const sFrom = document.getElementById('sFrom');
const sTo = document.getElementById('sTo');
const sQty = document.getElementById('sQty');
const sDist = document.getElementById('sDist');
const sTotal = document.getElementById('sTotal');
const errorBox = document.getElementById('serverErr');

const pricePerStation = 10;
let stations = [];

//Load stations 
fetch('../controller/GetStations.php')
    .then(res => res.json())
    .then(data => {
        stations = data;
        from.innerHTML = `<option value="">Select</option>`;
        to.innerHTML = `<option value="">Select</option>`;

        data.forEach(s => {
            from.innerHTML += `<option value="${s.id}" data-order="${s.station_order}">
                ${s.station_name}
            </option>`;
        });
    });

from.addEventListener('change', () => {
    const order = from.selectedOptions[0]?.dataset.order;
    to.innerHTML = `<option value="">Select</option>`;

    stations.forEach(s => {
        if (s.station_order !== order) {
            to.innerHTML += `<option value="${s.id}" data-order="${s.station_order}">
                ${s.station_name}
            </option>`;
        }
    });
    updateSummary();
});

[to, qty].forEach(el => el.addEventListener('change', updateSummary));

function updateSummary() {
    if (!from.value || !to.value) return;

    const f = from.selectedOptions[0];
    const t = to.selectedOptions[0];

    const distance = Math.abs(t.dataset.order - f.dataset.order);
    const total = distance * pricePerStation * qty.value;

    sFrom.textContent = f.text;
    sTo.textContent = t.text;
    sQty.textContent = qty.value;
    sDist.textContent = `${distance} stations`;
    sTotal.textContent = total;
}

//PAYMENT BUTTON SUBMIT 
payBtn.addEventListener('click', () => {
    errorBox.textContent = '';

    if (!from.value || !to.value || !date.value || qty.value < 1) {
        errorBox.textContent = 'Please complete all fields';
        return;
    }

    const fd = new FormData(document.getElementById('sellerForm'));

    fetch('../controller/SellerPaymentInit.php', {
    method: 'POST',
    body: fd
})
.then(res => res.text())
.then(resp => {
    if (resp === 'OK') {
        window.location.href = 'seller_cash_payment.php';
    } else {
        errorBox.textContent = resp;
    }
});

});
