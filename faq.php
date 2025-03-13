<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Frequently Asked Questions | HotOffers.lk</title>
<link rel="icon" href="assets/images/192x192 logo.png">
  <meta name="description" content="Have questions? Find answers to frequently asked questions about HotOffers.lk, including how to find deals, how to redeem offers, and more.">
    <meta name="keywords" content="FAQ, frequently asked questions, HotOffers.lk, help, support">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>
  
.square-badge {
    width: 22px; /* Fixed width */
    height: 22px; /* Fixed height */
    line-height: 40px; /* Vertically center the text */
    font-size: 12px; /* Adjust font size */
    border-radius: 4px; /* Slightly rounded corners */
    text-align: center; /* Center text */
    display: inline-flex; 
    align-items: center;
    justify-content: center;
}


 /* Search Box */
        .search-box {
            max-width: 500px;
            display: flex;
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 15px 20px;
            font-size: 1rem;
            outline: none;
        }

        .search-box button {
            background-color: #f97225;
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .search-box button:hover {
            background-color: #fe8745;
        }

        .card-img-top {
          object-fit: cover;
          height: 200px;
        }

        /* Trending Text */
        .trending {
            font-weight: 700;
        }

        .trending span {
            font-weight: normal;
            color: #f8f9fa;
        }

        /* Responsive Adjustments */
        /* Mobile view adjustments for the sidebar */
@media (max-width: 768px) {
	
    .category-filter-container,
    .brand-filter-container,
    .location-filter-container {
        display: none; /* Hide filters initially */
    }
    .sidebar-toggle {
        display: block;
        cursor: pointer;
    }
   

    .sidebar-content {
        display: none;
    }

    .sidebar-content.active {
        display: block;
    }

    
    

    .category-filter,
    .brand-filter,
    .location-filter {
        margin-bottom: 3px;
    }

    .toggle-header {
        background-color: #f97225;
        color: white;
        padding: 5px;
        cursor: pointer;
        border: none;
        width: 100%;
        text-align: center;
        border-radius: 5px;
        font-size: 1.3rem;
				font-weight: 600;
    }
}

@media (max-width: 424px) {
    .search-box {
        max-width: 100%; /* Make the search box take the full width of the screen */
        flex-direction: row; /* Stack input and button vertically */
        box-shadow: none; /* Optional: Remove the box-shadow for a cleaner mobile look */
    }

    .search-box input {
        width: 100%; /* Make input take the full width */
        padding: 10px; /* Adjust padding for better fit */
        font-size: 0.9rem; /* Adjust font size for smaller screens */
    }

    .search-box button {
        
        padding: 10px; /* Adjust padding for better fit */
        font-size: 0.9rem; /* Adjust font size for smaller screens */
       
    }
}



    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">

           <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
     
<div style="height: 70vh; background-image: url('./assets/images/hero_banner.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;">Frequently Asked Questions</span></h1>
        <div class="mt-5">
          <!-- hover background-color: white; color: black; -->
			 <p class="trending mt-3 mx-2">Find answers to common questions below and get the information you need quickly and easily! Whether you're looking for details about shipping, returns, payment methods, or product availability, we’ve got you covered.</span></p>
        </div>
      </div>
    </div>
  </div>
</div>
     
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

     <div class="container p-3">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
      <div class="space-y-4">

        <div>
          <button onclick="toggleAccordion('faq1')" 
                  class="w-full text-left text-lg font-semibold text-gray-800 focus:outline-none flex justify-between items-center">
            <span>1. How do I register?</span>
            <span class="text-gray-600">+</span>
          </button>
          <div id="faq1" class="mt-2 hidden text-gray-600">
            You can register by clicking the "Sign Up" button and filling out the registration form.
          </div>
        </div>

        <div>
          <button onclick="toggleAccordion('faq2')" 
                  class="w-full text-left text-lg font-semibold text-gray-800 focus:outline-none flex justify-between items-center">
            <span>2. How do I reset my password?</span>
            <span class="text-gray-600">+</span>
          </button>
          <div id="faq2" class="mt-2 hidden text-gray-600">
            Use the "Forgot Password" link on the login page to reset your password.
          </div>
        </div>

        <div>
          <button onclick="toggleAccordion('faq3')" 
                  class="w-full text-left text-lg font-semibold text-gray-800 focus:outline-none flex justify-between items-center ">
            <span>3. How can I contact support?</span>
            <span class="text-gray-600">+</span>
          </button>
          <div id="faq3" class="mt-2 hidden text-gray-600 ">
            Use the "Contact Us" page to send us your queries or issues.
          </div>
        </div>
      </div>
    </div>
  </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
  <script>
    function toggleAccordion(id) {
      const content = document.getElementById(id);
      content.classList.toggle("hidden");
    }
  </script>
<script src="https://cdn.tailwindcss.com"></script>
</body>

</html>