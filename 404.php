<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>404 Not Found - HotOffersLK</title>
<link rel="icon" href="assets/images/192x192 logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="description" content="Have questions? Find answers to frequently asked questions about HotOffers.lk, including how to find deals, how to redeem offers, and more.">
    <meta name="keywords" content="FAQ, frequently asked questions, HotOffers.lk, help, support">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>
  .error-container {
            text-align: center;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Responsive Adjustments */
        /* Mobile view adjustments for the sidebar */
@media (max-width: 768px) {
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


    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">
       <div class="page-title dark-background" data-aos="fade">
           </div>
    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">
        <div class="container">

    <div class="max-w-3xl mx-auto bg-white p-6">
      <div class="space-y-4">

        <div>
 <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="error-container">
                    <div class="error-code">404</div>
                    <p class="error-message">Oops! The page you're looking for doesn't exist.</p>
                    <a href="index.php" class="btn btn-primary">Go Back Home</a>
                </div>
            </div>
        </div>
    </div>
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