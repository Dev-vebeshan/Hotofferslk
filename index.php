<?php
session_start();
require_once 'db/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Best Deals & Discounts in Sri Lanka | HotOffers.lk</title>
    <meta name="description" content="Discover the best deals and discounts in Sri Lanka on HotOffers.lk. Explore offers from various categories and brands. Save big on your favorite products and services!">
    <meta name="keywords" content="deals in Sri Lanka, discounts, HotOffers, online offers, shopping deals">
    <link rel="icon" href="assets/images/192x192 logo.png">
    <meta name="author" content="HotOffers.lk">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>
  
.square-badge {
    width: 22px; /* Fixed width */
    height: 22px; /* Fixed height */
    line-height: 40px; /* Vertically center the text */
    font-size: 10px; /* Adjust font size */
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
    .search-box input {
        font-size: 0.8rem; /* Decrease font size */
        padding: 11px 15px; /* Adjust padding for better fit */
    }

    .search-box button {
        font-size: 0.9rem; /* Decrease font size */
        padding: 12px 20px; /* Adjust padding */
    }

    /* Adjust h1 headline */
    .mobileh1 {
        font-size: 1.6rem; /* Decrease font size */
        line-height: 1.2; /* Adjust line height for better spacing */
    }
}
@media (max-width: 992px) {
    .search-box input {
        font-size: 0.9rem; /* Slightly increase font size */
        padding: 12px 18px; /* Adjust padding for better fit */
    }

    .search-box button {
        font-size: 1rem; /* Keep it readable */
        padding: 14px 25px; /* Adjust button padding */
    }
}

@media (max-width: 424px) {
    /* Adjust search bar font size */
    .search-box input {
        font-size: 0.7rem; /* Adjust font size */
        padding: 10px 12px; /* Adjust padding */
    }

    .search-box button {
        font-size: 0.8rem;
        padding: 10px 15px; /* Adjust padding */
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
     
<div style="height: 70vh; background-image: url('./assets/images/hero_banner.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h1 class="mobileh1" style="font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;">Unlock Exclusive <span style="color:#000;">Deals</span> & <br>Irresistible Offers <span style="color:#000;"> in Sri Lanka </span></h1>
        <div class="mt-5">
          <!-- hover background-color: white; color: black; -->
          <div class="search-box">
                <input type="text" id="search" placeholder="Save More, Shop Smart-Find Deals Here...">
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

<div class="text-center p-2">
  <h2 class="text-center fw-bold text-uppercase">All Advertisements and deals</h4>
  <p>Showing advertisements and deals in all the locations, brands and categories.</p>
</div>


 <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div style="  background-color: #fff;
  padding: 15px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h4 class="fw-bold text-capitalize p-2">I'm looking for</h4>
                <hr>

          <div class="d-flex align-items-center gap-3">
  <a class="btn btn-outline-warning btn-md text-white" id="opening" style="font-size:14px;">Menu</a>
  <select name="filter" id="filter" class="form-select" style="font-size:14px;">
    <option value="" >All</option>
    <option value="promotion">Promotions</option>
    <option value="discount">Discounts</option>
    <option value="offer">Offers</option>
    <option value="sale">Sale</option>
  </select>
</div>
<h4 class="fw-bold text-capitalize mt-3 toggle-header" id="category-toggle">Categories</h4>
<div class="sidebar-content category-filter-container">
    <ul class="list-unstyled">
    <?php
                    $categories = mysqli_query($con, "SELECT a.*, count(a.id) AS c_tot, c.name AS cat_name, c.id AS cat_id FROM advertisments AS a INNER JOIN category AS c ON a.category_id=c.id WHERE a.status='active' GROUP BY c.name ORDER BY a.category_id DESC LIMIT 5");
                    while ($category = mysqli_fetch_assoc($categories)) {
                        echo '<li class="d-flex justify-content-between align-items-center" style="font-size:14px;">
                        <a href="#" class="category-filter text-decoration-none text-dark p-1" data-category="' . $category['cat_id'] . '">' . $category['cat_name'] . '</a>
                        <span class="badge btn-outline-warning square-badge">' . $category['c_tot'] . '</span>
                        </li>';
                    }
                    ?>

                    <li class="mt-2">
    <a href="categories.php" class="text-uppercase text-warning text-decoration-none">Show All Categories</a>
  </li>
                </ul>
</div>

<h4 class="fw-bold text-capitalize mt-3 toggle-header" id="location-toggle">Locations</h4>
<div class="sidebar-content location-filter-container">
    <ul class="list-unstyled">
   <?php
                    $locations = mysqli_query($con, "SELECT count(id) AS tot,location FROM advertisments WHERE status='active' GROUP BY location ORDER BY id DESC LIMIT 5");
                    while ($location = mysqli_fetch_assoc($locations)) {
                        echo '<li class="d-flex justify-content-between align-items-center" style="font-size:14px;">
                        <a href="#" class="location-filter text-decoration-none text-dark p-1" data-location="' . $location['location'] . '">' . $location['location'] . '</a>
                        <span class="badge btn-outline-warning square-badge">' . $location['tot'] . '</span>
                        </li>';
                    }
                    ?>
  <li class="mt-2">
    <a href="locations.php" class="text-uppercase text-warning text-decoration-none">Show All Locations</a>
  </li>
</ul>
                </div>


<h4 class="fw-bold text-capitalize mt-3 toggle-header" id="brand-toggle">Brands</h4>
<div class="sidebar-content brand-filter-container">
    <ul class="list-unstyled">
                    <?php
                    $brands = mysqli_query($con, "SELECT a.*, count(a.id) AS b_tot, b.name AS brand_name, b.id AS brand_id FROM advertisments AS a LEFT JOIN brands AS b ON a.brand_id=b.id WHERE a.status='active' AND NOT a.brand_id=0 GROUP BY a.brand_id ORDER BY a.brand_id DESC LIMIT 5");

                    while ($brand = mysqli_fetch_assoc($brands))
                     {
                        $brandName=$brand['brand_name'];
                        $brandId=$brand['id'];



                            if($brandName !="" && $brandId !="")
                            {
                                $brandName = $brand['brand_name'];
                                $brandId = $brand['brand_id'];    
                                
                            }
                            else
                            {
                                $brandName = "Others";
                                $brandId = "";  
                            }
                            

    echo '<li class="d-flex justify-content-between align-items-center" style="font-size:14px;">
        <a href="#" class="brand-filter text-decoration-none text-dark p-1" data-brand="' . $brandId . '">' . $brandName . '</a>
        <span class="badge badge-sm btn-outline-warning square-badge">' . $brand['b_tot'] . '</span>
    </li>';
}

                    ?>

                    <li class="mt-2">
    <a href="brands.php" class="text-uppercase text-warning text-decoration-none">Show All Brands</a>
  </li>
                </ul>
                </div>
                <div class="d-flex align-items-center gap-3">
  <select name="price" id="price" class="form-select" style="font-size:14px;">
    <option value="" >Price</option>
    <option value="low">Low to high</option>
    <option value="high">High to low</option>
  </select>

  <select name="rating" id="rating" class=" form-select" style="font-size:14px;">
    <option value="" >Rating</option>
    <option value="low">Low to high</option>
    <option value="high">High to low</option>
  </select>
</div>

<button id="reset-filters" class="btn btn-outline-new shadow-sm rounded form-control mt-3 btn-sm mb-2" style="font-size:14px;">Reset Filters</button>
            </div>
        </div>

            <!-- Main Content -->
            <div class="col-md-9">
            

			<!-- row 
                <div class="row g-3">
                   
                    <div class="col-md-4">
                        <label for="start-date" class="form-label">Start Date</label>
                        <input type="date" id="start-date" class="form-control">
                    </div>

                   
                    <div class="col-md-4">
                        <label for="end-date" class="form-label">End Date</label>
                        <input type="date" id="end-date" class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Type to search">
                            <button type="button" class="btn btn-outline-warning text-white">Search</button>
                        </div>
                    </div>
                </div>
				-->

                <!-- Advertisement Cards -->
               <div id="ads-container" class="row"></div>
        <nav>
            <ul id="pagination" class="pagination justify-content-center"></ul>
        </nav>

                

                
            </div>
        </div>
    </div>

        

    

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
  <script>
      $(document).ready(function () {

         // Attach event handlers to filters
            $('.category-filter').on('click', function (e) {
                e.preventDefault();
                $('.category-filter').removeClass('active');
                $(this).addClass('active');

                $('.brand-filter').removeClass('active');
                $('.location-filter').removeClass('active');

                fetchAds();
            });

            $('.brand-filter').on('click', function (e) {
                e.preventDefault();
                $('.brand-filter').removeClass('active');
                $(this).addClass('active');

                 $('.category-filter').removeClass('active');
                $('.location-filter').removeClass('active');

                fetchAds();
            });

            $('.location-filter').on('click', function (e) {
                e.preventDefault();
                $('.location-filter').removeClass('active');
                $(this).addClass('active');

                 $('.category-filter').removeClass('active');
                    $('.brand-filter').removeClass('active');

                fetchAds();
            });

            $('#start-date, #end-date, #search, #filter, #price, #rating').on('change keyup', function () {
                fetchAds();
            });

             $('#reset-filters').on('click', function (e) {
        e.preventDefault();

        $('#start-date').val('');
        $('#end-date').val('');
        $('#search').val('');
        $('#filter').val('');
        $('#price').val('');
        $('#rating').val('');

        $('.category-filter').removeClass('active');
        $('.brand-filter').removeClass('active');
        $('.location-filter').removeClass('active');

        setTimeout(function () {
            fetchAds(); 
           
        }, 10);
    });

                

function fetchAds(page = 1) {
    const category = $('.category-filter.active').data('category') || '';
    const brand = $('.brand-filter.active').data('brand') || '';
    const location = $('.location-filter.active').data('location') || '';
    const start_date = $('#start-date').val();
    const end_date = $('#end-date').val();
    const search = $('#search').val();
    const filter = $('#filter').val();
    const price = $('#price').val();
    const rating = $('#rating').val();

    $.ajax({
        url: 'fetch_ads.php', // Backend script
        method: 'POST',
        data: {
            page: page,
            category: category,
            brand: brand,
            start_date: start_date,
            end_date: end_date,
            search: search,
            filter: filter,
            price: price,
            location: location,
            rating: rating,
        },
        dataType: 'json',
        success: function (response) {
    const adsContainer = $('#ads-container');
    const pagination = $('#pagination');

    // Clear previous content
    adsContainer.empty();
    pagination.empty();

    if (response.data.length === 0) {
        // No ads found, show message
        adsContainer.html(`
            <div class="text-center my-5">
                <h4 class="text-muted mt-6">😞 Sorry... We couldn't find any ads matching your search...</h4>
            </div>
        `);
        return;
    }

    // Render ads
    response.data.forEach(ad => {
        let starRating = '';
        const rating = parseInt(ad.avg_rating);
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                starRating += '<i class="bi bi-star-fill text-warning"></i>';  // Filled star
            } else {
                starRating += '<i class="bi bi-star text-muted"></i>';  // Empty star
            }
        }

        const price = parseFloat(ad.price) || 0;
        const sale_price = parseFloat(ad.sale_price) || 0;
        let finalprice = sale_price && sale_price < price ? sale_price : price;

        // Format prices
        const formattedFinalPrice = finalprice.toLocaleString('en-US', { minimumFractionDigits: 2 });

        adsContainer.append(`
            <div class="col-md-4 mb-2 deal-card">
                <a href="ads-details.php?title=${ad.id}" style="color:black;">
                    <div class="card h-100 text-decoration-none text-dark">
                        <img src="${ad.image}" class="card-img-top" alt="${ad.title}">
                        <div class="card-body">
                            <h6 class="card-title" style="font-size:14px;">${ad.title}</h6>
                            <div class="d-flex justify-content-between">
                                <span class="price">Rs. ${formattedFinalPrice}</span>
                                <a>
                                    ${starRating}
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `);
    });

    // Render pagination only if total pages > 1 and ads count is more than 6
    if (response.totalPages > 1) {
    for (let i = 1; i <= response.totalPages; i++) {
        pagination.append(`
            <li class="page-item ${i === response.currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
            `);
        }
    }
}
,
        error: function (xhr, status, error) {
            console.error('Error fetching ads:', error);
        }
    });
}


    // Initial fetch
    fetchAds();

    // Handle pagination click
    $('#pagination').on('click', 'a', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchAds(page);
    });
});

$(document).ready(function () {
    
    // Toggle for Categories, Brands, and Locations on Mobile
    $('#category-toggle').on('click', function () {
        $('.category-filter-container').toggleClass('active');
    });

    $('#brand-toggle').on('click', function () {
        $('.brand-filter-container').toggleClass('active');
    });

    $('#location-toggle').on('click', function () {
        $('.location-filter-container').toggleClass('active');
    });


    // Add more event handlers as needed to filter the results when clicking on the filter options
    $('.category-filter-link').on('click', function (e) {
        e.preventDefault();
        const category = $(this).data('category');
        // Handle the category filter logic here
        fetchAds();
    });

    $('.brand-filter-link').on('click', function (e) {
        e.preventDefault();
        const brand = $(this).data('brand');
        // Handle the brand filter logic here
        fetchAds();
    });

    $('.location-filter-link').on('click', function (e) {
        e.preventDefault();
        const location = $(this).data('location');
        // Handle the location filter logic here
        fetchAds();
    });
	
});


    </script>
</body>

</html>