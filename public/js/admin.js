// ADMIN DASHBOARD 
    //Search, delete actions and revenue refresh handled

  // PASSENGER SEARCH
const searchInput = document.getElementById("searchInput");
if (searchInput) {
    searchInput.addEventListener("keyup", () => {
        const keyword = searchInput.value.toLowerCase();

        // Passenger rows always start with id="p"
        document.querySelectorAll('tr[id^="p"]').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ""
                : "none";
        });
    });
}


//Seller search
const sellerSearch = document.getElementById("sellerSearch");

if (sellerSearch) {
    sellerSearch.addEventListener("keyup", () => {
        const keyword = sellerSearch.value.toLowerCase();

        // Seller rows always start with id="s"
        document.querySelectorAll('tr[id^="s"]').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword)
                ? ""
                : "none";
        });
    });
}



  // Delete a passenger booking
   //Uses AJAX to avoid page submit
function deleteBooking(id) {
    if (!confirm("Delete this passenger booking?")) return;

    const fd = new FormData();
    fd.append("booking_id", id);

    fetch("../controller/AdminController.php", {
        method: "POST",
        body: fd
    })
    .then(res => res.text())
    .then(res => {
        if (res === "OK") {
            window.location.reload(); 
        } else {
            alert("Delete failed");
        }
    })
    .catch(() => alert("Server error"));
}


//DELETE SELLER SALE RECORD
function deleteSellerSale(id) {
    if (!confirm("Delete this seller sale?")) return;

    const fd = new FormData();
    fd.append("seller_sale_id", id);

    fetch("../controller/AdminController.php", {
        method: "POST",
        body: fd
    })
    .then(res => res.text())
    .then(res => {
        if (res === "OK") {
            window.location.reload(); 
        } else {
            alert("Delete failed");
        }
    })
    .catch(() => alert("Server error"));
}


//REFRESH REVENUE TABLE
function refreshRevenue() {
    fetch("../controller/AdminController.php?refresh=1")
        .then(res => res.json())
        .then(data => {
            const revenueTable = document.getElementById("revenueTable");
            const grandTotalEl = document.getElementById("grandTotal");

            if (!revenueTable || !grandTotalEl) return;

            revenueTable.innerHTML = "";

            data.routes.forEach(r => {
                revenueTable.innerHTML += `
                    <tr>
                        <td>${r.from_station} → ${r.to_station}</td>
                        <td>${r.tickets_sold}</td>
                        <td>৳${r.revenue}</td>
                    </tr>
                `;
            });

            grandTotalEl.innerText = "৳" + data.total;
        })
        .catch(() => alert("Failed to refresh revenue"));
}
