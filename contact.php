<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Contact Us | HotOffers.lk</title>
  <link rel="icon" href="assets/images/192x192 logo.png">
  <meta name="description" content="Get in touch with HotOffers.lk. Have questions or need support? Contact us for assistance with deals, offers, or any inquiries.">
    <meta name="keywords" content="contact HotOffers.lk, customer support, inquiries, help">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">

           <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
     
<div style="height: 70vh; background-image: url('./assets/images/banner5.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;">Contact Us</span></h1>
        <div class="mt-5">
          <!-- hover background-color: white; color: black; -->
         
			 <p class="trending mt-3">We'd love to hear from you! Feel free to reach out using the form below and share your thoughts, questions, or feedback with us. Whether you have inquiries about our products, need assistance with an order, or simply want to tell us how we’re doing, we’re here to help.</span></p>
        </div>
      </div>
    </div>
  </div>
</div>
     
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

 <div class="container mx-auto p-6 mt-2 mb-3">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center mb-6">
      <div class="bg-yah p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-white">Phone Number</h3>
        <p class="text-white"><i class="bi bi-telephone-fill"></i> 1300 37 37 90</p>
      </div>
      <div class="bg-yah p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-white">Email</h3>
        <p class="text-white"><i class="bi bi-envelope-fill"></i> info@hotoffers.lk</p>
      </div>
      <div class="bg-yah p-4 rounded-lg shadow">
        <h3 class="text-lg font-medium text-white">Address</h3>
        <p class="text-white"><i class="bi bi-geo-alt-fill"></i> 12/3, Nelum Mawatha, Aththidiya, Dehiwala</p>
      </div>
    </div>

    <!-- Contact Form and Map -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Contact Form -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <div id="alertContainer"></div>
        <form method="POST" class="space-y-4" id="contact_form">
          <div>
            <label for="name" class="block text-gray-700 font-medium">Name</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div>
            <label for="email" class="block text-gray-700 font-medium">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div>
            <label for="email" class="block text-gray-700 font-medium">Subject</label>
            <input type="text" id="subject" name="subject" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div>
            <label for="message" class="block text-gray-700 font-medium">Message</label>
            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          </div>

           <button type="submit" id="submitButton" class="w-full bg-yah text-white py-2 rounded-lg flex items-center justify-center">
           Send Message
      </button>
        </form>
        <script>
    document.getElementById('contact_form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const alertContainer = document.getElementById('alertContainer');
        const submitButton=document.getElementById('submitButton');

        submitButton.textContent = "Sending Message...";

        fetch('contact_form.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {

          submitButton.textContent = "Send Message";

            alertContainer.innerHTML = `
                <div class="alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
                    ${data.message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;

            if (data.success) {
                document.getElementById('contact_form').reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);

            submitButton.textContent = "Send Message";

            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred while sending your message. Please try again later.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
        });
    });
</script>
      </div>

      <!-- Google Map -->
      <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.418009141071!2d79.88328957404795!3d6.840385419401772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25ae8a9098ebf%3A0x49b6a789c16c3a69!2s12%2C%203%20Nelum%20Mawatha%2C%20Dehiwala-Mount%20Lavinia!5e0!3m2!1sen!2slk!4v1735639555935!5m2!1sen!2slk" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    
    

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>
</body>

</html>