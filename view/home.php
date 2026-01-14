<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Home</title>
    <link rel="stylesheet" href="../public/css/home.css">

</head>
<body>

<?php include 'partials/header.php'; ?>


<main class="container main-section">

    <div class="form-card">
        <h2>
            <span class="blue-text">Book Metro Train</span>
        </h2>
        <p>Quickly book your metro train tickets</p>

        <!-- From -->
        <div class="field">
            <label>From</label>
            <select required>
                <option>Select Departure Station</option>
                <option>Uttara North</option>
                <option>Uttara Center</option>
                <option>Uttara South</option>
                <option>Pallabi</option>
                <option>Mirpur 10</option>
                <option>Mirpur 11</option>
                <option>Shewrapara</option>
                <option>Kazipara</option>
                <option>Agargaon</option>
                <option>Bijoy Sarani</option>
                <option>Farmgate</option>
                <option>Karwan Bazar</option>
                <option>Shahbag</option>
                <option>Dhaka University</option>
                <option>Bangabandhu National Stadium</option>
                <option>Motijheel</option>
            </select>
        </div>

        <!-- To -->
        <div class="field">
            <label>To</label>
            <select>
                <option>Select Arrival Station</option>
                <option>Motijheel</option>
                <option>Bangabandhu National Stadium</option>
                <option>Dhaka University</option>
                <option>Shahbag</option>
                <option>Karwan Bazar</option>
                <option>Farmgate</option>
                <option>Bijoy Sarani</option>
                <option>Agargaon</option>
                <option>Kazipara</option>
                <option>Shewrapara</option>
                <option>Mirpur 11</option>
                <option>Mirpur 10</option>
                <option>Pallabi</option>
                <option>Uttara South</option>
                <option>Uttara Center</option>
                <option>Uttara North</option>
            </select>
        </div>

        <!-- Date -->
        <div class="field date-field">
            <input type="date" id="journey_date" required>
            <label for="journey_date">Choose Journey Date</label>
        </div>

        <button class="search-btn">Search Trains</button>
    </div>

    <div class="image-box">
        <img src="../public/images/homeplatfrom.png" alt="Metro Train">
    </div>

</main>

<section class="steps">
    <div class="container steps-box">

        <div class="step">
            <img class="step-img" src="../public/images/search.jpg" alt="Search">
            <h3>Search</h3>
            <p>
                Search metro routes by selecting stations and journey date.
            </p>
        </div>

        <div class="step">
            <img class="step-img" src="../public/images/book.jpg" alt="Book">
            <h3>Book</h3>
            <p>
                Book your metro ticket instantly with secure payment.
            </p>
        </div>

        <div class="step">
            <img class="step-img" src="../public/images/qr.jpg" alt="QR">
            <h3>QR Code</h3>
            <p>
                Get a QR ticket and scan it directly at the metro gate.
            </p>
        </div>

    </div>
</section>
<section class="how-it-works container">
    <div class="how-wrapper">

        <!-- LEFT IMAGE -->
        <div class="how-image">
            <img src="../public/images/how-it-works.png" alt="How MetroSheba Works">
        </div>

        <!-- RIGHT CONTENT -->
        <div class="how-content">
            <h2>How MetroSheba Works</h2>

            <ul>
                <li>Select your departure and arrival metro stations.</li>
                <li>Choose your journey date and search available trains.</li>
                <li>Book your metro ticket securely using online payment.</li>
                <li>Receive a QR ticket instantly on your device.</li>
                <li>Scan the QR code directly at the metro gate.</li>
            </ul>
        </div>

    </div>
</section>





<?php include 'partials/footer.php'; ?>

</body>
</html>
