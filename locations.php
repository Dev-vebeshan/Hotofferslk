<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Deals by Location | HotOffers.lk</title>
<link rel="icon" href="assets/images/192x192 logo.png">
  <meta name="description" content="Find the best deals by location on HotOffers.lk. Browse offers available in your city and save on local services and products.">
    <meta name="keywords" content="deals by location, city deals, local offers, HotOffers.lk">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  
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


    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">

           <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
     
<div style="height: 70vh; background-image: url('./assets/images/banner6.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;">Locations</h1>
        <div class="mt-5">
          <!-- hover background-color: white; color: black; -->
			 <p class="trending mt-2">Find stores near you and enjoy the convenience of shopping locally! Whether you're looking for fashion, electronics, groceries, or home goods, discovering nearby stores allows you to browse a variety of options without the hassle of long-distance travel.</p>
        </div>
      </div>
    </div>
  </div>
</div>
     
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

<div class="container mt-3">
    <div class="row">
    <?php 
    $query=$con->prepare("SELECT *,count(id) AS tot_ads FROM advertisments GROUP BY location");
    $query->execute();
    $result=$query->get_result();
    if($result->num_rows > 0)
    {
      while($row=$result->fetch_assoc())
      {
        $location_name=$row['location'];
        ?>
        <div class="col-sm-3 col-sm-2">
        <div class="card rounded-lg">
        <div class="card-body">
                <a href="location.php?slug=<?php echo $row['location']; ?>">
          <center> <img style="width: 30px; height:30px;" src="./assets/images/pin.png" alt="brand_img"></center>
        <p class="text-sm text-black text-capitalize text-center"><?php echo $location_name; ?></p>
        </a>
        </div>
      </div>
    
</div>
<?php } }
else{
  echo "No details found...";
} ?>

       
    </div>
  </div>
    

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
  
</body>

</html>