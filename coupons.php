<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Exclusive Coupons & Discount Codes | HotOffers.lk</title>
<link rel="icon" href="assets/images/192x192 logo.png">
 <meta name="description" content="Save more with exclusive coupons and discount codes on HotOffers.lk. Browse the latest deals and enjoy additional savings on your favorite products and services.">
    <meta name="keywords" content="coupons, discount codes, savings, HotOffers.lk, online deals, promo codes">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>
        body {
            background-color: #f2f6ff;
            font-family: Arial, sans-serif;
        }
        .coupon-card-link {
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.coupon-card-link:hover .coupon-card {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.coupon-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s ease;
    position: relative;
}

.coupon-header {
    position: relative;
    height: 200px;
    background-size: cover;
    background-position: center;
    border-radius: 20px 20px 0 0;
    overflow: hidden;
}

.coupon-header .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 20px 20px 0 0;
}

.coupon-header img.logo {
    position: absolute;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: white;
    padding: 10px;
    top: 10px;
    left: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.coupon-header .company {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
}

.tags {
    display: inline-block;
    margin: 10px 20px 0;
    padding: 5px 10px;
    font-size: 0.9rem;
    font-weight: bold;
    color: #fff;
    background: #f97225;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 20px;
    text-align: center;
}

.card-title {
    font-size: 1.25rem;
    color: #333;
    font-weight: 700;
    margin-bottom: 10px;
}

.card-title .value {
    color: #6c63ff;
    font-weight: bold;
}

.coupon-title {
    font-size: 1rem;
    color: #666;
    margin: 0;
}

.coupon-card:hover .card-title .value {
    color: #f97225;
}

  .menu-slider {
      display: flex;
      overflow-x: auto;
      scroll-behavior: smooth;
      background-color: #fff; 
      border-radius: 10px;
      padding: 10px;
      gap: 10px;
    }

    .menu-slider::-webkit-scrollbar {
      display: none; 
    }

    .coupon-filter
    {
         flex: 0 0 auto;
      text-align: center;
      padding: 8px;
      border-radius: 10px;
      background-color: #0000; 
      color: #f8f9fa; /* Light font color */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      font-size: 13px;
      cursor: pointer;
      min-width: 100px;
    }


    .coupon-filter:hover {
      background-color: #f97225;
      transform: scale(1.05);
      transform: 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .coupon-filter.active {
      background-color: #f97225;
      transform: scale(1.05);
      transform: 0.3s ease;
      font-weight: bold;
      transition: 0.3s ease-in;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .menu-icon {
      font-size: 1rem;
      width: 30px;
      margin-bottom: 5px;
      color: #f8f9fa;
    }

    @media (max-width: 768px) {
      .menu-item {
        min-width: 100px;
        font-size: 12px;
        padding: 10px;
      }
      .menu-icon {
        font-size: 1.5rem;
      }
    }

    .slider-controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 10px 0;
    }

    .slider-button {
      background: #f97225;
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }

    .slider-button:hover {
      background: #f97225;
    }

    /* Custom styling for the search input group */
.input-group-text {
  background-color: #f97225;
  border: none;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.input-group-text:hover {
  background-color: #f97225;
}

.form-control {
  border: none;
  font-size: 1rem;
  border-radius: 0 8px 8px 0;
  box-shadow: none;
  transition: box-shadow 0.3s ease-in-out;
}

.form-control:focus {
  outline: none;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.input-group {
  border-radius: 10px;
  overflow: hidden;
}

.btn-outline-warning {
    color: #f97225; /* Text color */
    border: 1px solid #f97225; /* Outline color */
    transition: all 0.3s ease; /* Smooth transition */
}

.btn-outline-warning:hover {
    background-color: #f97225; /* Background color */
    color: white; /* Text color on hover */
    border-color: #f97225; /* Maintain border color on hover */
}
  
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
    /* Adjust search bar font size */
    .search-box input {
        font-size: 0.7rem; /* Decrease font size */
        padding: 8px; /* Adjust padding for better fit */
    }

    .search-box button {
        font-size: 0.7rem; /* Decrease font size */
        padding: 8px 15px; /* Adjust padding */
    }

    /* Adjust h1 headline */
    .mobileh1 {
        font-size: 1.4rem; /* Decrease font size */
        line-height: 1.2; /* Adjust line height for better spacing */
    }
}



    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">

           <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
     
<div style="height: 70vh; background-image: url('./assets/images/banner2.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h1 class="mobileh1" style="font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;">Coupons</span></h1>
        <div class="mt-5">
          <!-- hover background-color: white; color: black; -->
          
			 <p class="trending mt-3 mx-2">Discover exclusive coupons and deals just for you and unlock incredible savings on your favorite products! From discounts on fashion and electronics to special offers on home goods and beauty products, there’s always something to help you get more for your money.</p>
        <div class="search-box">
                <input type="text" id="search" placeholder="Save More, Shop Smart—Find Deals Here...">
                <button type="button">Search</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
     
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">


        <div class="container py-5">
        

    <div class="row mt-2">
  <div class="col-12 col-md-6 mx-auto">
   
  </div>
</div>
<br>

     
             

<div class="slider-controls">
    <button id="prevButton" class="slider-button"><i class="bi bi-chevron-left"></i></button>
    <button id="nextButton" class="slider-button"><i class="bi bi-chevron-right"></i></button>
</div>

<div id="categorySlider" class="menu-slider">
    <?php
    $sql = "SELECT c.id AS cat_id,c.name AS cat_name,c.image,c.status,a.id,a.category_id,a.status 
            FROM category AS c 
            INNER JOIN advertisments AS a ON c.id=a.category_id 
            WHERE c.status ='1' AND a.status='Active' 
            GROUP BY a.category_id 
            ORDER BY a.id DESC";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<a href="#" class="text-dark coupon-filter active" data-coupon="' . htmlspecialchars("all") . '"> 
                <div>
                    <button class="btn bg-yah">All</button>
                </div>
              </a>';

        while ($row = $result->fetch_assoc()) {
            $row['image'] = str_replace('../', './', $row['image']);
            echo '<a href="#" class="text-dark coupon-filter" data-coupon="' . htmlspecialchars($row['cat_id']) . '"> 
                    <div>
                        <img src="' . htmlspecialchars($row['image']) . '" class="menu-icon" alt="' . htmlspecialchars($row['cat_name']) . '"> 
                        ' . htmlspecialchars($row['cat_name']) . '
                    </div>
                  </a>';
        }
    } else {
        // No categories available message with centered logo
              echo '<p class="text-center text-danger">No Categories Available...</p>';
    }
    ?>
</div>


  <br>
        <div id="error_msg"></div>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="coupon-cards">
            

    </div>
</div>

    

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
  <script>
    const slider = document.getElementById('categorySlider');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    prevButton.addEventListener('click', () => {
        slider.scrollBy({ left: -200, behavior: 'smooth' });
    });

    nextButton.addEventListener('click', () => {
        slider.scrollBy({ left: 200, behavior: 'smooth' });
    });
</script>


    <!-- AJAX Script -->
    <script>
        $(document).ready(function () {
            const error_msg=document.getElementById('error_msg');
            fetchAdvertisements();

            // Attach event handlers to filters
            $('.coupon-filter').on('click', function (e) {
                e.preventDefault();
                $('.coupon-filter').removeClass('active');
                $(this).addClass('active');

                fetchAdvertisements();
            });

            $('#search').on('change keyup', function () {
                fetchAdvertisements();
            });

            // Fetch Advertisements
            function fetchAdvertisements() {
                const coupon = $('.coupon-filter.active').data('coupon') || '';  

                const search = $('#search').val();

                $.ajax({
                    url: 'fetch_coupons.php', // PHP script to fetch filtered data
                    type: 'POST',
                    data: {
                        coupon: coupon,
                        search: search,


                    },
                    success: function (response) {
                        const ads = JSON.parse(response);
                        renderAdvertisements(ads);
                    },
                    error: function() {
                error_msg.innerHTML = 'No coupons found...';

            }
                });
            }


            // Render advertisements
      // Render advertisements
function renderAdvertisements(ads) {
    const container = $('#coupon-cards');
    container.empty();

    if (ads.length === 0) {
        container.html(`
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; width: 100%; margin-top: 20px;">
    <img src="./assets/images/4532229-200.png" style="width: 200px; height: auto; margin-bottom: 5px; display: block;" alt="No Categories">
    <p style="font-size: 18px; font-weight: bold; color: #555; margin-top: 10px;">No Coupons found...</p>
</div>

        `);
        return;
    }

    ads.forEach((ad) => {
        // Create a URL-friendly title by replacing spaces with dashes and removing special characters
        const seoFriendlyTitle = ad.title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-')        // Replace spaces with dashes
            .trim();

        let starRating = '';
        const rating = parseInt(ad.max_rating);
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                starRating += '<i class="bi bi-star-fill text-warning"></i>';  // Filled star
            } else {
                starRating += '<i class="bi bi-star text-muted"></i>';  // Empty star
            }
        }

        const formattedNetPrice = Number(ad.netprice).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        const adCard = `
            <div class="col-lg-3 col-sm-6 mb-5">
                <a href="ads-details.php?title=${ad.id}" class="coupon-card-link coupon">
                    <div class="coupon-card h-100 bg-white">
                        <div class="coupon-header" style="background-image: url('${ad.image}'); position: relative;">
                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5);"></div>
                            <img loading="lazy" src="${ad.image}" style="width: 100px; height: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" class="logo">
                            <div class="h2 company">${starRating}</div>
                        </div>
                        <div class="tags text-center" style="margin-top: 10px; font-weight: bold;">${ad.coupon}</div>
                        <div class="card-body">
                            <h5 class="card-title" style="color: #6a1b9a;">Save <span class="value purple">${formattedNetPrice}</span> LKR</h5>
                            <p class="card-text py-3 coupon-title">${ad.title}</p>
                        </a>
                        <button class="btn btn-sm btn-dark rounded shadow-md" id="btn" value="${ad.coupon}" onclick="copyToClipboard(this)">Copy Code</button>
                    </div>
                </div>
            </div>
        `;

        container.append(adCard);
    });
}



        });
    </script>

    <script>
       function copyToClipboard(button) {
    const valueToCopy = button.value;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(valueToCopy)
            .then(() => alert("Coupon Code Successfully Copied"))
            .catch(err => alert("Failed to copy: " + err));
    } else {
        // Fallback for older browsers
        const textarea = document.createElement("textarea");
        textarea.value = valueToCopy;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand("copy");
            alert("Coupon Code Successfully Copied");
        } catch (err) {
            alert("Failed to copy: " + err);
        }
        document.body.removeChild(textarea);
    }
}
    </script>
</body>

</html>