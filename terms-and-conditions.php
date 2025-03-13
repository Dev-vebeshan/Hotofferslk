<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms and Conditions</title>
  <link rel="icon" href="assets/images/192x192 logo.png">
    <?php include './assets/links.php'; ?>

<!-- Main CSS File -->
<link href="assets/css/main.css" rel="stylesheet">
<style type="text/css">
  a{
    color: black;
    font-weight: bold;
  }
  a:hover{
    color: #111;
  }
</style>
</head>
<body class="starter-page-page">

  <!-- /Header Section Section -->
  <?php include './assets/header.php'; ?>
  <!-- /Header Section Section -->

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
      
    </div><!-- End Page Title -->

  <section class="content">
    <div class="container mt-4">
        <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;padding top:40px;
            ">Terms And Conditions</span></h1>
      <h2 style="margin-top: 30px;">Effective Date: December 10, 2024</h2>
      <p>Welcome to Hotoffers.lk! By accessing our website, you agree to the following terms and conditions:</p>

      <h5>1. Use of the Website</h5>
      <ul>
        <li>You must be 18 years or older to use our services.</li>
        <li>All information provided by you must be accurate and truthful.</li>
      </ul>

      <h5>2. User Account Responsibilities</h5>
      <ul>
        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
        <li>Any activity performed under your account is your responsibility.</li>
      </ul>

      <h5>3. Content Ownership</h5>
      <p>All website content, including text, graphics, logos, and images, is the property of Hotoffers.lk and protected by copyright laws. You may not reproduce or distribute content without written permission.</p>

      <h5>4. Advertisements and Offers</h5>
      <ul>
        <li>Offers and discounts are subject to change without prior notice.</li>
        <li>Hotoffers.lk is not liable for inaccuracies in advertiser-provided information.</li>
      </ul>

      <h5>5. Limitation of Liability</h5>
      <p>Hotoffers.lk is not responsible for any damages or losses resulting from your use of the website or its content.</p>

      <h5>6. Termination</h5>
      <p>We reserve the right to terminate or suspend your account for violations of these terms.</p>

      <h5>7. Changes to Terms</h5>
      <p>We may update these terms at any time. Continued use of the website constitutes acceptance of the revised terms.</p>

      <h5>8. Governing Law</h5>
      <p>These terms are governed by the laws of Sri Lanka. Any disputes will be resolved in Sri Lankan courts.</p>

      <h5>9. Contact Us</h5>
      <p>If you have questions or need assistance, contact us at <a href="mailto:info@hotoffers.lk">info@hotoffers.lk</a> or call 1300 37 37 90.</p>
    </div>
  </section>


<?php include './assets/footer.php'; ?>

<?php include './assets/scripts.php'; ?>
</body>
</html>
