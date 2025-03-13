<?php
session_start();
require_once 'db/connection.php';


if (isset($_SESSION['customer_role']))
{
    $auth_user_mail=$_SESSION['customer_mail'];
    $user_query=$con->prepare("SELECT name FROM customer WHERE email=?");
    $user_query->bind_param('s',$auth_user_mail);
    $user_query->execute();
    $user_result=$user_query->get_result();
    if($user_result->num_rows > 0)
    {
        $row_user_query=$user_result->fetch_assoc();
        $username=$row_user_query['name'];
        $usernmail=$auth_user_mail;
    }
    else
    {
        $username="";
        $usernmail="";
    }
}
elseif(isset($_SESSION['admin_role'])=="Business user")
{
    $auth_user_mail=$_SESSION['admin_mail'];
    $type="Business user";
    $user_query=$con->prepare("SELECT * FROM user WHERE mail=? AND role=?");
    $user_query->bind_param('ss',$auth_user_mail,$type);
    $user_query->execute();
    $user_result=$user_query->get_result();
    if($user_result->num_rows > 0)
    {
        $row_user_query=$user_result->fetch_assoc();
        $username=$row_user_query['name'];
        $usernmail=$auth_user_mail;
    }
    else
    {
        $username="";
        $usernmail="";
    }
}
else
{
    $username="";
    $usernmail="";
}

if (isset($_GET['title'])) {
    $title = (int) $_GET['title']; // Ensure it's an integer
    $ad_status = "active";

    // Fetch advertisement details, including total ratings and average rating
    $query = $con->prepare("SELECT a.*, 
        IFNULL(AVG(r.rating), 0) AS avg_rating, 
        COUNT(r.id) AS tot_rating 
        FROM advertisments AS a 
        LEFT JOIN review AS r ON a.id = r.ads_id 
        WHERE a.id = ? AND a.status = ?");
        
        $query->bind_param('is', $title, $ad_status);
        $query->execute();
        $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch total views
        $tota_view_query = $con->prepare("SELECT COUNT(v.id) AS total_views FROM views AS v WHERE v.ads_id = ?");
        $tota_view_query->bind_param("i", $title);
        $tota_view_query->execute();
        $result_view = $tota_view_query->get_result();
        $view_row = $result_view->fetch_assoc();
        $total_views = $view_row['total_views'] ?? 0;
        
        if (is_null($row['start_date']) || is_null($row['end_date']) || is_null($row['image'])
            ) {
                echo "<script> location.replace('404.php'); </script>";
                exit;
            }

        // Extract ad details
        $advertisment_id = $row['id'];
        $ad_title = $row['title'];
        $ad_info = $row['description'];
        $ad_rating = round($row['avg_rating']); // Rounded to 1 decimal
        $tot_rating = $row['tot_rating'];
        
        if($row['sale_price'] > 0)
        {
            $price=$row['sale_price'];
        }
        else
        {
            $price=$row['price'];
        }

        $start_date = new DateTime($row['start_date']);
        $start = $start_date->format('F j, Y \a\t g:i A');

        $end_date = new DateTime($row['end_date']);
        $end = $end_date->format('F j, Y \a\t g:i A');

        $row['image'] = str_replace('../', './', $row['image']);
        $ad_img = $row['image'];

        if (!empty($row['placement']) && !empty($row['latitude']) && !empty($row['longitude'])) {
             $placement=$row['placement'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
        } else {
            $placement=$row['placement'];
             $latitude = $row['latitude'];
             $longitude = $row['longitude'];
        }

        $brand_id = $row['brand_id'];
        $cat_id = $row['category_id'];

        // Insert view
        $current_time = date('Y-m-d H:i:s'); // Fix undefined variable
        $insert_views = $con->prepare("INSERT INTO views (ads_id, brand_id, category_id, created_at) VALUES (?, ?, ?, ?)");
        $insert_views->bind_param('iiis', $title, $brand_id, $cat_id, $current_time);
        $insert_views->execute();

        // Fetch brand details
        if ($brand_id != 0) {
            $brand = $con->prepare("SELECT * FROM brands WHERE id = ?");
            $brand->bind_param('i', $brand_id);
            $brand->execute();
            $result_brand = $brand->get_result();

            if ($result_brand->num_rows > 0) {
                $row_brand = $result_brand->fetch_assoc();
                $brand_name = $row_brand['name'];
                $brand_slug = $row_brand['slug'];
                $brand_img = str_replace('../', './', $row_brand['logo']);
                $email = $row_brand['email'];
                $phone = $row_brand['phone'];
                $website = $row_brand['website'];
            }
        } else {
            $brand_img = "";
            $brand_name = "";
            $email = "";
            $phone = "";
            $website="";
        }

        // Fetch category details
        $cat = $con->prepare("SELECT * FROM category WHERE id = ?");
        $cat->bind_param('i', $cat_id);
        $cat->execute();
        $result_cat = $cat->get_result();

        if ($result_cat->num_rows > 0) {
            $row_cat = $result_cat->fetch_assoc();
            $cat_name = $row_cat['name'];
            $cat_slug = $row_cat['slug'];
            $cat_img = str_replace('../', './', $row_cat['image']);
        } else {
            $cat_name = "";
            $cat_slug = "";
            $cat_img = "";
        }
    } else {
        echo "<script> location.replace('404.php'); </script>";
        exit;
    }
} else {
    echo "<script> location.replace('404.php'); </script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Exclusive Offers & Promotions | HotOffers.lk</title>
<link rel="icon" href="assets/images/192x192 logo.png">
  <meta name="description" content="Browse exclusive ads and promotions on HotOffers.lk. Get detailed information about discounts, valid dates, and how to avail the best offers.">
    <meta name="keywords" content="exclusive offers, promotions, discounts, HotOffers.lk, ads details">
    <meta name="author" content="HotOffers.lk">
    
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <?php include './assets/links.php'; ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXkId06l9I1w5AZyxDGB-6FEjNI7Ri6Mw&"></script>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
  <style>

a:hover{
    color:#f97225;
}
    
    .brand-link {
    text-decoration: underline;
    color: #000; /* Default color */
}

.brand-link:hover {
    text-decoration: underline;
    color: #000; /* Change hover color */
}
.contact-item {
    display: inline-flex;
    align-items: center;
    gap: 5px; /* Adds space between icon and text */
    white-space: nowrap; /* Prevents line breaks */
}

.contact-item i {
    font-size: 16px;
}

.contact-item a {
    text-decoration: none;
    color: #000; /* Adjust color as needed */
}

  .star-rating {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            font-size: 25px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s;
        }
        .star-rating label.active {
            color: #f39c12;
        }


    </style>
</head>

<body class="starter-page-page">

  <?php include './assets/header.php'; ?>

  <main class="main">
<div class="flex flex-col md:flex-row min-h-screen mt-5">
         <div class="md:w-2/3 w-full h-screen overflow-y-auto bg-white border-r">
            <div class="p-2 md:p-2  border-1 rounded-lg m-2 shadow-md">
               <!-- Ad Details -->
               <div class="md:p-2 p-1">
			   <a href="<?php echo $ad_img; ?>" target="_blank"><img src="<?php echo $ad_img; ?>" style="aspect-ratio: 16 / 9;
  object-fit: fill; height:400px; width:450px;" alt="ads Image"></a>
  <div class="d-flex justify-content-space p-2 md:text-sm text-md">
  <?php for ($i = 1; $i <= 5; $i++) { ?>
                           <i class="bi bi-star<?php echo $i <= $ad_rating ? '-fill text-warning' : ' text-muted'; ?>"></i>
                           <?php } ?> (<?php echo $tot_rating; ?>) <p class="ml-3"> Start on  <span class="text-danger fw-bold"> <?php echo $start; ?> </span> </p>  <p class="ml-3"> Expire on  <span class="text-danger fw-bold"> <?php echo $end; ?> </span> </p> <p class="ml-3 text-md"><i class="bi bi-eye"></i> <?php echo $total_views; ?> </p> </div> 
                  <h2 class="md:text-3xl text-xl font-bold text-gray-800 mb-1"><?php echo $ad_title; ?></h2>
                  
                  <p class="md:text-md text-sm text-gray-600 mt-2"><?php echo $ad_info; ?></p>
               </div>
               
                <br>

               
              <?php
if ($phone == "" && $email == "" && $website == "") {
    $amount = ($row['sale_price'] != 0) ? $row['price'] : "";

    echo '<table width="100%" class="table table-bordered">
        <tbody>
            <tr>
                <td>Price</td>
                <td>
                    <p> 
                        <span class="price text-xl fw-bold">
                            Rs ' . number_format((float) $price, 2) . '
                        </span>';
                        
                        // Hide old price if discount is 0
                        if ($row['discount'] > 0) {
                            echo '<span class="old-price">' . number_format((float) $amount, 2) . '</span>';
                        }
                        
    echo            '</p>
                </td>
            </tr>';
            
    // Hide discount row if it's 0
    if ($row['discount'] > 0) {
        echo '<tr>
                <td>Discount </td>
                <td>' . htmlspecialchars($row['discount'], ENT_QUOTES, 'UTF-8') . ' %</td>
              </tr>';
    }
    
    echo '<tr>
                <td>Category </td>
                <td>
                    <a href="category.php?slug=' . urlencode($cat_slug) . '">' . htmlspecialchars($cat_name, ENT_QUOTES, 'UTF-8') . '</a>
                </td>
          </tr>
          <tr>
                <td>Location</td> 
                <td>
                    <a href="https://www.google.com/maps/search/?api=1&query=' . urlencode($placement) . '" 
                       target="_blank" 
                       class="brand-link">
                        ' . htmlspecialchars($placement, ENT_QUOTES, 'UTF-8') . '
                    </a>
                </td>
          </tr>
        </tbody>
    </table>';
} else {
    $amount = ($row['sale_price'] != 0) ? $row['price'] : "";

    echo '<table width="100%" class="table table-bordered">
        <tbody>
            <tr>
                <td>Price</td>
                <td>
                    <p> 
                        <span class="price text-xl fw-bold">
                            Rs ' . number_format((float) $price, 2) . '
                        </span>';
                        
                        // Hide old price if discount is 0
                        if ($row['discount'] > 0) {
                            echo '<span class="old-price">' . number_format((float) $amount, 2) . '</span>';
                        }
                        
    echo            '</p>
                </td>
            </tr>';
            
    // Hide discount row if it's 0
    if ($row['discount'] > 0) {
        echo '<tr>
                <td>Discount </td>
                <td>' . htmlspecialchars($row['discount'], ENT_QUOTES, 'UTF-8') . ' %</td>
              </tr>';
    }

    echo '<tr>
                <td>Category </td>
                <td>
                    <a href="category.php?slug=' . urlencode($cat_slug) . '">' . htmlspecialchars($cat_name, ENT_QUOTES, 'UTF-8') . '</a>
                </td>
          </tr>
          <tr>
                <td>Brand </td>
                <td>
                    <a href="brand.php?slug=' . urlencode($brand_slug) . '">' . htmlspecialchars($brand_name, ENT_QUOTES, 'UTF-8') . '</a>
                </td>
          </tr>
          <tr>
                <td>Location</td> 
                <td>
                    <a href="https://www.google.com/maps/search/?api=1&query=' . urlencode($placement) . '&query_place_id=' . urlencode($latitude . ',' . $longitude) . '" 
                       target="_blank" 
                       class="brand-link">
                        ' . htmlspecialchars($placement, ENT_QUOTES, 'UTF-8') . '
                    </a>
                </td>
          </tr>
          <tr>
                <td>Contact </td>
                <td>';
                    if ($phone) {
                        echo '<i class="brand-link bi bi-telephone-fill text-sm"></i> 
                              <a href="tel:+' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '</a><br>';
                    }
                    if ($email) {
                        echo '<i class="brand-link bi bi-envelope-open text-sm"></i> 
                              <a href="mailto:' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '" style="text-transform: lowercase;">' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</a><br>';
                    }
                    if ($website) {
                        echo '<span class="contact-item"><i class="brand-link bi bi-globe text-sm"></i> 
                              <a href="' . htmlspecialchars($website, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="text-transform: lowercase;">' . htmlspecialchars($website, ENT_QUOTES, 'UTF-8') . '</a></span><br>';
                    }
    echo        '</td>
          </tr>
        </tbody>
    </table>';
}
?>


			   <br>
            </div>
            <div class="container my-5">
               <h3 class="text-xl font-semibold text-center mb-4">Customer Reviews</h3>
               <div class="reviews">
                  <?php
                     $query = "SELECT * FROM review WHERE ads_id = $advertisment_id  ORDER BY created_at DESC LIMIT 15";
                     $result = $con->query($query);
                     
                     if ($result->num_rows > 0) {
                         while ($row = $result->fetch_assoc()) {
                             $name = htmlspecialchars($row['name']);
                             $rating = intval($row['rating']);
                             $review = htmlspecialchars($row['review']);
                             $date = date("F j, Y", strtotime($row['created_at']));
                     ?>
                  <!-- Single Review -->
                  <div class="card mb-3">
                     <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                           <h5 class="card-title mb-0"><?php echo $name; ?></h5>
                           <small class="text-muted"><?php echo $date; ?></small>
                        </div>
                        <!-- Star Rating -->
                        <div class="mb-2">
                           <?php for ($i = 1; $i <= 5; $i++) { ?>
                           <i class="bi bi-star<?php echo $i <= $rating ? '-fill text-warning' : ' text-muted'; ?>"></i>
                           <?php } ?>
                        </div>
                       <p class="card-text"><?php echo nl2br(htmlspecialchars_decode(stripslashes($review))); ?></p>




                     </div>
                  </div>
                  <?php
                     }
                     } else {
                     echo "<p class='text-center text-muted'>No reviews yet. Be the first to review this ad!</p>";
                     }
                     ?>
               </div>
            </div>
         </div>
         <div class="md:w-1/3 w-full md:p-6 p-3 mt-3">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
               <h2 class="text-2xl font-bold text-gray-800 mb-4">Review & Rating</h2>
               <div id="alertContainer"></div>
               <form method="POST" class="space-y-4" id="reviewForm">
                  <input type="hidden" id="ads_id" name="ads_id" value="<?php echo $advertisment_id; ?>">
                  <input type="hidden" id="brand_id" name="brand_id" value="<?php echo $brand_id; ?>">
                  <input type="hidden" id="cat_id" name="cat_id" value="<?php echo $cat_id; ?>">
                  <div>
                     <label for="name" class="block text-gray-700 font-medium">Your Name</label>
                     <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $username; ?>">
                  </div>
                  <div>
                     <label for="email" class="block text-gray-700 font-medium">Your Email</label>
                     <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $usernmail; ?>">
                  </div>
                  <div>
                     <label class="form-label" class="block text-gray-700 font-medium">Rating</label>
                        <div class="star-rating">
                            <input type="checkbox" id="star1" value="1" name="rating" onclick="updateStars(1)"><label for="star1">&#9733;</label>
                            <input type="checkbox" id="star2" value="2" name="rating" onclick="updateStars(2)"><label for="star2">&#9733;</label>
                            <input type="checkbox" id="star3" value="3" name="rating" onclick="updateStars(3)"><label for="star3">&#9733;</label>
                            <input type="checkbox" id="star4" value="4" name="rating" onclick="updateStars(4)"><label for="star4">&#9733;</label>
                            <input type="checkbox" id="star5" value="5" name="rating" onclick="updateStars(5)"><label for="star5">&#9733;</label>
                        </div>
                  </div>
                  <div>
                     <label for="review" class="block text-gray-700 font-medium">Your Review</label>
                     <textarea id="reviewText" name="review" rows="4" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                  </div>
                  <button type="submit" id="submitButton" class="w-full bg-yah text-white py-2 rounded-lg flex items-center justify-center">
                  <span id="submitText">Submit Review</span>
                  <span id="spinner" class="loading-spinner ml-2 hidden"></span>
                  </button>
               </form>
            </div>
         </div>
  </main>

  <?php include './assets/footer.php'; ?>

  <?php include './assets/scripts.php'; ?>
  
  <script>
    function updateStars(selectedStar) {
        // Loop through all stars
        for (let i = 1; i <= 5; i++) {
            let starInput = document.getElementById("star" + i);
            let starLabel = document.querySelector("label[for='star" + i + "']");

            // Activate all previous stars
            if (i <= selectedStar) {
                starInput.checked = true;
                starLabel.classList.add("active");
            } else {
                starInput.checked = false;
                starLabel.classList.remove("active");
            }
        }
    }
</script>

  <script>
            document.getElementById('reviewForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitButton = document.getElementById('submitButton');
                const submitText = document.getElementById('submitText');
                const spinner = document.getElementById('spinner');
                const alertContainer = document.getElementById('alertContainer');
            
            
                spinner.classList.remove('hidden');
                submitText.textContent = "Submitting...";
            
                fetch('review.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
            
                    submitText.textContent = "Submit Review";
                    spinner.classList.add('hidden');
            
                    alertContainer.innerHTML = `
                        <div class="alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show" role="alert">
                            ${data.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
            
                    if (data.success) {
                        document.getElementById('reviewForm').reset();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
            
                    submitText.textContent = "Submit Review";
                    spinner.classList.add('hidden');
            
                    alertContainer.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            An error occurred while submitting your review. Please try again later.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
                });
            });
         </script>
<script src="https://cdn.tailwindcss.com"></script>
</body>

</html>