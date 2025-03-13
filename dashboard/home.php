<?php
include './includes/session.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/192x192 logo.png">
  <title>Customer Dashboard</title>
  <?php include './includes/script.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Navbar for Mobile and Tablet -->
  <?php include './includes/mobiletopbar.php'; ?>

  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php include './includes/slidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col ">
      <!-- Header -->
      <?php include './includes/header.php'; ?>

        <!-- Dashboard Content -->
      <main class="p-4 md:p-6 flex-1 overflow-y-auto">
        <?php

      $ads_query=mysqli_query($con,"SELECT count(id) AS Total_ads FROM advertisments WHERE author='$customer_role' AND author_mail='$customer_mail' ");
      if(mysqli_num_rows($ads_query) > 0)
      {
       while($ads_row=mysqli_fetch_assoc($ads_query))
       {
        $Total_ads=$ads_row['Total_ads'];
       }
      }
      ?>

      <?php
// Correct query for inbox messages count
$message_query = mysqli_query($con, "SELECT count(id) AS Total_msg FROM inbox WHERE receiver='$customer_mail'");

if (mysqli_num_rows($message_query) > 0) {
    while ($msg_row = mysqli_fetch_assoc($message_query)) {
        $Total_msg = $msg_row['Total_msg'];
    }
} else {
    $Total_msg = 0; // Default to 0 if no messages are found
}
?>
      
      
      <?php
$sent_message_query = mysqli_query($con, "SELECT count(id) AS send_msg FROM inbox WHERE sender='$customer_mail'");
if (mysqli_num_rows($sent_message_query) > 0) {
    while ($sent_row = mysqli_fetch_assoc($sent_message_query)) {
        $send_msg = $sent_row['send_msg'];
    }
} else {
    $send_msg = 0; // Set a default value if no messages are found
}
?>




      <div class="container rounded-lg">
        

          <section class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-white shadow rounded-lg p-4 md:p-6">
            <h3 class="text-sm md:text-lg font-medium text-gray-700">Total Ads</h3>
            <p class="mt-2 text-2xl md:text-3xl font-bold text-[#F97225]"><?php echo $Total_ads; ?></p>
          </div>

          <div class="bg-white shadow rounded-lg p-4 md:p-6">
    <h3 class="text-sm md:text-lg font-medium text-gray-700">Inbox Messages</h3>
    <p class="mt-2 text-2xl md:text-3xl font-bold text-[#F97225]"><?php echo $Total_msg; ?></p>
</div>


          <div class="bg-white shadow rounded-lg p-4 md:p-6">
            <h3 class="text-sm md:text-lg font-medium text-gray-700">Sent Messages</h3>
            <p class="mt-2 text-2xl md:text-3xl font-bold text-[#F97225]"><?php echo $send_msg; ?></p>
          </div>
          
          <div class="bg-white shadow rounded-lg p-4 md:p-6">
            <h3 class="text-sm md:text-lg font-medium text-gray-700">Account Status <?php echo $status; ?></h3>
            <p class="mt-2 text-sm md:text-sm  text-[#F97225] break-words"><?php echo $customer_mail; ?></p>

          </div>
        </section>

      <section class="bg-white shadow rounded-lg p-4 md:p-6">
        <div class="text-end">
          <a href="my-ads.php"class="px-4 py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]">View More</a>
          </div>
          <h2 class="text-lg md:text-xl font-bold mb-4">Recent Ads</h2>
          
          
          <div class="space-y-4">
          <?php
          $author="customer";
          $ads_query=mysqli_query($con,"SELECT * FROM advertisments WHERE author='$author' AND author_mail='$customer_mail' ORDER BY id DESC LIMIT 10");
          if(mysqli_num_rows($ads_query) > 0)
          {
          while($ads_row=mysqli_fetch_assoc($ads_query))
          {
            $start_date = new DateTime($ads_row['created_at']);
            $start_date_format = $start_date->format('F j, Y \a\t g:i A');
            ?>
          
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-gray-50 p-4 rounded-lg shadow-sm">
              <div>
                <h3 class="text-base md:text-lg font-medium text-gray-700"><?php echo $ads_row['title']; ?></h3>
                <p class="text-gray-500 text-sm md:text-base">Posted on: <?php echo $start_date_format; ?></p>
              </div>
              <a href="<?php echo $ads_row['image']; ?>" target="_blank" class="text-[#F97225] hover:underline text-sm md:text-base mt-2 sm:mt-0"><img src="<?php echo $ads_row['image']; ?>" class="w-[320px] h-[125px] object-cover rounded-lg shadow-md"></a>
            </div>
            <?php
            }
          } else {
        // No categories available message with centered logo
        echo '<div class="no-category-container">
                <img src="./assets/img/4532229-200.png" class="no-category-logo" alt="No Ads available">
                <p class="no-category-text">No Ads available</p>
              </div>';
    }
    ?>
</div>

<style>
    #categorySlider {
    display: flex;
    align-items: center;
    justify-content: center;
   
}

.no-category-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}


    .no-category-logo {
        width: 200px; /* Adjust logo size as needed */
        height: auto;
        margin-bottom: 5px;
    }

    .no-category-text {
        font-size: 18px;
        font-weight: bold;
        color: #555;
    }
</style>


      
          </div>
              <?php include './assets/footer.php'; ?>
        </section>
    </div>

      </main>
    </div>
  </div>

</body>
</html>
