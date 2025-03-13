<?php
session_start();
require_once 'db/connection.php'; 

if(isset($_GET['slug']))
{
    $slug=$_GET['slug'];

    $find_cat=mysqli_query($con,"SELECT * FROM category WHERE slug='$slug' ");
    if(mysqli_num_rows($find_cat) > 0)
    {
        $cat_row=mysqli_fetch_array($find_cat);
        $cat_id=$cat_row['id'];
        $cat_title=$cat_row['name'];
        $cat_description=$cat_row['description'];
    }
    else
    {
        echo "<script> location.replace('404.php'); </script>";
    }
}
else
{
    echo "<script> location.replace('categories.php'); </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="description" content="Explore a wide range of categories on HotOffers.lk. Find the best deals on electronics, fashion, food, travel, and more. Shop smarter with our curated discounts!">
    <meta name="keywords" content="categories, best deals, electronics, fashion, food, travel, HotOffers.lk">
    <meta name="author" content="HotOffers.lk">
   <title><?php echo ucfirst($cat_title); ?></title>
<link rel="icon" href="assets/images/192x192 logo.png">

  <?php include './assets/links.php'; ?>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <style>
   .ad-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .ad-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .badge-discount {
      position: absolute;
      top: 15px;
      left: 15px;
      background: #f97225;
      color: #fff;
      font-size: 0.9rem;
      font-weight: bold;
    }
    .card-img-top {
      object-fit: cover;
      height: 200px;
    }
    a:hover{
        color: #000;
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

   .mobileh1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 20px;
        margin-bottom: 10px;
        text-transform: capitalize;
    }

    /* For devices smaller than 768px (Tablets and mobile devices) */
    @media (max-width: 768px) {
        .mobileh1 {
            font-size: 1.25rem;  /* Slightly smaller font for better readability */
            margin-top: 15px;
            margin-bottom: 8px;
        }
    }

    /* For mobile devices smaller than 480px */
    @media (max-width: 480px) {
        .mobileh1 {
            font-size: 1rem;  /* Even smaller font for small screens */
            margin-top: 12px;
            margin-bottom: 6px;
        }
    }

    /* For very large screens (Desktops or large screens) */
    @media (min-width: 1200px) {
        .mobileh1 {
            font-size: 2rem;  /* Larger font for large screens */
            margin-top: 30px;
            margin-bottom: 15px;
        }
    }


    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">

           <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade">
     
<div style="height: 70vh; background-image: url('./assets/images/banner3.png'); background-size: cover; background-position: center;" class="position-relative w-100">
  <div class="position-absolute text-white d-flex flex-column align-items-start justify-content-center" style="top: 0; right: 0; bottom: 0; left: 0; ">
    <div class="container">
      <div class="col-md-8 p-0">
       <h3 class="mobileh1" style="
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 20px;
    margin-bottom: 10px;
    text-transform: capitalize;
    "><?php echo ucfirst($cat_title); ?></h3>
    <p style="font-size:12px;"><?php echo ucfirst($cat_description); ?></p>
      </div>
    </div>
  </div>
</div>
    
<?php

$sql=$con->prepare("SELECT a.id AS Ads_ID,
    a.title,
    a.description,
    a.image,
    a.discount,
    a.price,
    a.sale_price,
    a.category_id,
    a.status,AVG(r.rating) AS avg_rating, r.id, count(r.id) AS tot_rating, r.rating, c.id, c.name AS category_name
FROM advertisments AS a LEFT JOIN review AS r ON a.id = r.ads_id INNER JOIN category AS c ON a.category_id=c.id
WHERE 
    a.status = 'Active' AND a.category_id=?
GROUP BY 
    a.id
ORDER BY 
    a.id DESC");
    $sql->bind_param('i',$cat_id);
    $sql->execute();
    $sql_result=$sql->get_result();
    ?>

</div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">
<div class="container py-5">
    <div class="row g-4">
         <?php
if ($sql_result->num_rows > 0) {
    echo '<h2 class="text-3xl fw-bold text-center mt-2 mb-2 text-capitalize p-3">Hurry Limited Time Only!</h2>';
    while ($result_row = $sql_result->fetch_assoc()) {
        $result_row['image'] = str_replace('../', './', $result_row['image']);
        $Ads_ID = $result_row['Ads_ID'];

        // Check if avg_rating is not null and round it
        $avg_rating = isset($result_row['avg_rating']) && is_numeric($result_row['avg_rating']) ? round($result_row['avg_rating'], 1) : 0.0;
        
        $tot_rating = $result_row['tot_rating'];
        
        if($result_row['price'] !=0)
        {
            $rupees="Rs";
            
            if($result_row['price'] > $result_row['sale_price'] && $result_row['sale_price'] !=0 )
            {
                $price = number_format($result_row['sale_price'], 2, '.', ','); // Ensures 2 decimal places
            }
            else
            {
                $price = number_format($result_row['price'], 2, '.', ','); // Ensures 2 decimal places
            }
        }
        else
        {
            $rupees="";
            $price="";
        }


        ?>


    <div class="col-md-4">
        <div class="card h-100 ad-card">
        <a href="ads-details.php?title=<?php echo $Ads_ID; ?>">
          <div class="position-relative">
            <span class="badge badge-discount"><?php echo $result_row['category_name']; ?></span>
            <img src="<?php echo $result_row['image']; ?>" class="card-img-top" alt="Ad Image">
          </div>
          <div class="card-body">
            <h5 class="card-title fw-bold"><?php echo $result_row['title']; ?></h5>
            <!-- <p class="card-text text-muted">Short description of the ad to attract users.</p> -->
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <!--<span class="text-muted">Only </span>-->
                <span class="fw-normal"> <?php echo $rupees." ".$price; ?></span>
              </div>
              <a>
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                      <i class="bi bi-star<?php echo $i <= $avg_rating ? '-fill text-warning' : ' text-muted'; ?>"></i>
                    <?php } ?> (<?php echo $tot_rating; ?>)
                  </a>
            </div>
          </div>
         </a>
        </div>
      </div>

<?php
      }}
       else
    {
      echo '<h2 class="text-3xl fw-bold text-center mt-2 mb-2 text-capitalize p-3">No advertisements found...</h2>';
    }
    ?>

    </div>
</div>
    

    </section><!-- /Starter Section Section -->

  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>
</body>

</html>