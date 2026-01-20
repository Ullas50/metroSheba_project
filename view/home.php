<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MetroSheba | Home</title>
    <link rel="stylesheet" href="../public/css/home.css">

</head>
<body>
<!--common header-->
<?php include 'partials/header.php'; ?>
<main class="container main-section">

    <div class="form-card">
        <h2>
            <span class="blue-text">Book Metro Train</span>
        </h2>
        <p>Quickly book your metro train tickets</p>
        <!--from-->
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
        <!--to-->
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
        <!--journey date-->
        <div class="field date-field">
            <input type="date" id="journey_date" required>
            <label for="journey_date">Choose Journey Date</label>
        </div>
        <!--search train-->
        <button class="search-btn" onclick="window.location.href='login.php'">
    Search Trains
</button>
<!--image section -->
    </div>
    <div class="image-box">
        <img src="../public/images/homeplatfrom.png" alt="Metro Train">
    </div>
</main>
<!--showing work process-->
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

        <!--left image-->
        <div class="how-image">
            <img src="../public/images/how-it-works.png" alt="How MetroSheba Works">
        </div>
        <!--instruction show-->
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
<!--common footer-->
<?php include 'partials/footer.php'; ?>

</body>
</html>