<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/16x16 logo.png">
  <title>Privacy Policy</title>
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

  <!-- Privacy Policy Content -->
    <section class="content">
    <div class="container mt-4">
        <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;padding top:40px;
            ">Privacy Policy</span></h1>
      <h3 style="margin-top: 30px;">Effective Date: December 10, 2024</h3>
      <p>Your privacy is important to us at Hotoffers.lk. This Privacy Policy explains how we collect, use, and protect your personal information.</p>

      <h5>1. Information We Collect</h5>
      <ul>
        <li>**Personal Information:** Name, email, phone number, and location when you register or contact us.</li>
        <li>**Usage Data:** Information on how you access and use our website, including device information and browsing activities.</li>
        <li>**Cookies and Tracking Data:** To enhance user experience and analyze website performance.</li>
      </ul>

      <h5>2. How We Use Your Information</h5>
      <ul>
        <li>To provide, maintain, and improve our services.</li>
        <li>To send promotional offers and updates.</li>
        <li>To respond to your inquiries and support requests.</li>
        <li>To ensure website security and prevent fraud.</li>
      </ul>

      <h5>3. Sharing Your Information</h5>
      <p>We do not sell or share your personal information with third parties except:</p>
      <ul>
        <li>When required by law or government authorities.</li>
        <li>To trusted service providers assisting in our operations.</li>
      </ul>

      <h5>4. Data Security</h5>
      <p>We use advanced security measures to protect your data. However, no method is 100% secure, and we cannot guarantee absolute security.</p>

      <h5>5. Your Rights</h5>
      <p>You have the right to access, update, or delete your personal data. Contact us at <a href="mailto:info@hotoffers.lk">info@hotoffers.lk</a> for assistance.</p>

      <h5>6. Changes to This Privacy Policy</h5>
      <p>We may update this Privacy Policy. Changes will be notified on this page with the updated effective date.</p>

      <h5>7. Contact Us</h5>
      <p>If you have questions or concerns, contact us at <a href="mailto:info@hotoffers.lk">info@hotoffers.lk</a> or call 1300 37 37 90.</p>
    </div>
  </section>


<?php include './assets/footer.php'; ?>

<?php include './assets/scripts.php'; ?>
</body>
</html>
