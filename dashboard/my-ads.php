<?php
include './includes/session.php';

$showModal = false;
$img="";
$title="";
$message = "";
$button="";

if(isset($_POST['search']) && ! empty($_POST['search']))
{
  $search=trim($_POST['search']);
  
  if($search !="")
  {
      $ads_query=mysqli_query($con,"SELECT * FROM advertisments WHERE author='$customer_role' AND author_mail='$customer_mail' AND title LIKE '%$search%' OR placement LIKE '%$search%' ORDER BY id DESC");
  }
  else
  {
      $ads_query=mysqli_query($con,"SELECT * FROM advertisments WHERE author='$customer_role' AND author_mail='$customer_mail' ORDER BY id DESC");
  }
}
else
{
     $ads_query=mysqli_query($con,"SELECT * FROM advertisments WHERE author='$customer_role' AND author_mail='$customer_mail' ORDER BY id DESC");
}

?>

<?php 

if (isset($_POST['add'])) {

  $title =trim($_POST['title']);
  $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
  $price = $_POST['price'];
  $sale_price = $_POST['sale_price'];
  $discount= $_POST['discount'];
  $category = $_POST['category'];
  $type=$_POST['type'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $district=$_POST['district'];
  $location =mysqli_real_escape_string($con,$_POST['location']);
  
  $find_cat_name=$con->prepare("SELECT id,name FROM category WHERE id=?");
  $find_cat_name->bind_param('i',$category);
  $find_cat_name->execute();
  $result_category=$find_cat_name->get_result();
  
  if($result_category->num_rows > 0)
  {
      $category_row=$result_category->fetch_assoc();
      $categoryName=$category_row['name'];
  }

  $status="pending";

  function nameToSlug($title) {
    // Convert to lowercase
    $slug = strtolower($title);
    
    // Replace spaces and underscores with hyphens
    $slug = preg_replace('/[\s_]+/', '-', $slug);
    
    // Remove non-alphanumeric characters except hyphens
    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
    
    // Trim hyphens from the beginning and end
    $slug = trim($slug, '-');
    
    return $slug;
}

$slug = nameToSlug($title);

  $image_path = null;
  if (!empty($_FILES['image']['name'])) {
      $target_dir = "../assets/images/uploded_ads/";
      $image_path = $target_dir . basename($_FILES['image']['name']);
      if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
          die("Error uploading the image.");
      }
  }
        // Store ad data in an associative array
        $_SESSION['ad_data'] = [
            'title' => trim($_POST['title']),
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'],
            'discount' => $_POST['discount'],
            'category' => $categoryName,
            'type' => $_POST['type'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'location' => mysqli_real_escape_string($con, $_POST['location']),
            'status' => 'pending',
            'author_name' => $customer_name,
            'author_mail' => $customer_mail,
            'image_path' => $image_path,
        ];
        
  $sql = "INSERT INTO advertisments (title, slug, description, image, discount, price, sale_price, type, location, placement, start_date, end_date, category_id, created_at, updated_at,status, author, author_mail)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

  $stmt = $con->prepare($sql);
  $stmt->bind_param("ssssssssssssssssss", $title, $slug, $description, $image_path, $discount, $price, $sale_price, $type, $district, $location, $start_date, $end_date, $category,$current_time,$current_time, $status, $customer_role, $customer_mail);


  if ($stmt->execute()) {
        $showModal = true;
        $img='<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
        $title='<h2 class="text-xl font-semibold text-black">Success</h2>';
        $message ='<p class="mt-4 text-gray-600">Advertisement Successfully Created</p>';
        $button='<a href="verify_ads.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
        
  } 
  else
   {
    $showModal = true;
        $img='<img src="./assets/alarm.gif" alt="" style="width:50px; height:50px;">';
        $title='<h2 class="text-xl font-semibold text-black">Error</h2>';
        $message ='<p class="mt-4 text-gray-600">Advertisement Not Created</p>';
        $button='<button id="closeAlert" class="bg-yah text-white px-4 py-2 rounded-md transition duration-300">OK</button>';
   }
//   echo "<script> location.replace('my-ads.php'); </script>";
//   exit;
}
?>

<?php
if (isset($_POST['edit'])) {

    $edit_id = $_POST['edit_id'];
    $title = trim($_POST['title']);
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $discount = $_POST['discount'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $district= $_POST['district'];
    $location = mysqli_real_escape_string($con, $_POST['location']);

    $find_cat_name = $con->prepare("SELECT id, name FROM category WHERE id=?");
    $find_cat_name->bind_param('i', $category);
    $find_cat_name->execute();
    $result_category = $find_cat_name->get_result();

    if ($result_category->num_rows > 0) {
        $category_row = $result_category->fetch_assoc();
        $categoryName = $category_row['name'];
    }

    $status = "pending";

    function nameToSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    $slug = nameToSlug($title);

    // Initialize $image_path
    $image_path = "";

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/images/uploded_ads/";
        $image_path = $target_dir . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            die("Error uploading the image.");
        }
    }

    $_SESSION['ad_data'] = [
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'sale_price' => $sale_price,
        'discount' => $discount,
        'category' => $categoryName,
        'type' => $type,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'location' => $location,
        'status' => $status,
        'author_name' => $customer_name,
        'author_mail' => $customer_mail,
        'image_path' => $image_path,
    ];

    if (!empty($image_path)) {
        $sql = "UPDATE advertisments 
                SET title=?, slug=?, description=?, image=?, discount=?, price=?, sale_price=?, type=?, location=?, placement=?, start_date=?, end_date=?, category_id=?, updated_at=?, status=?
                WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssssss", 
            $title, 
            $slug, 
            $description, 
            $image_path, 
            $discount, 
            $price, 
            $sale_price, 
            $type,
            $district,
            $location, 
            $start_date, 
            $end_date, 
            $category, 
            $current_time,
            $status, 
            $edit_id
        );
    } else {
        $sql = "UPDATE advertisments 
                SET title=?, description=?, discount=?, price=?, sale_price=?, type=?, location=?, placement=?, start_date=?, end_date=?, category_id=?, updated_at=?, status=? 
                WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssss", 
            $title, 
            $description, 
            $discount, 
            $price, 
            $sale_price, 
            $type, 
            $district,
            $location, 
            $start_date, 
            $end_date, 
            $category, 
            $current_time,
            $status, 
            $edit_id
        );
    }

    if ($stmt->execute()) {
        $showModal = true;
        $img = '<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
        $title = '<h2 class="text-xl font-semibold text-black">Success</h2>';
        $message = '<p class="mt-4 text-gray-600">Advertisement Successfully Updated</p>';
        $button = '<a href="verify_ads.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
    } else {
        $showModal = true;
        $img = '<img src="./assets/alarm.gif" alt="" style="width:50px; height:50px;">';
        $title = '<h2 class="text-xl font-semibold text-black">Error</h2>';
        $message = '<p class="mt-4 text-gray-600">Advertisement Not Updated</p>';
        $button = '<button id="closeAlert" class="bg-yah text-white px-4 py-2 rounded-md transition duration-300">OK</button>';
    }
}

?>

<?php

if(isset($_GET['delid']))
{
  $delid=$_GET['delid'];
  $sql=$con->prepare("DELETE FROM advertisments WHERE id=? ");
  $sql->bind_param('s',$delid);
  if($sql->execute())
  {
        $showModal = true;
        $img='<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
        $title='<h2 class="text-xl font-semibold text-black">Success</h2>';
        $message ='<p class="mt-4 text-gray-600">Your Advertisement Successfully Deleted</p>';
        $button='<a href="verify_ads.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
  }
  else
  {
        $showModal = true;
        $img = '<img src="./assets/alarm.gif" alt="" style="width:50px; height:50px;">';
        $title = '<h2 class="text-xl font-semibold text-black">Error</h2>';
        $message = '<p class="mt-4 text-gray-600">Your Advertisement Not Deleted</p>';
        $button = '<button id="closeAlert" class="bg-yah text-white px-4 py-2 rounded-md transition duration-300">OK</button>';
  }

echo "<script> location.replace('my-ads.php'); </script>";      
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/192x192 logo.png">
  <title>Customer Ads</title>
  <?php include './includes/script.php'; ?>
        <script>
        function setInitialMinDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, "0");
            const day = String(now.getDate()).padStart(2, "0");
            const hours = String(now.getHours()).padStart(2, "0");
            const minutes = String(now.getMinutes()).padStart(2, "0");

            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            
            const startDateTime = document.getElementById("start-datetime");
            startDateTime.min = minDateTime;

            const endDateTime = document.getElementById("end-datetime");
            endDateTime.min = minDateTime;
        }

        function updateEndMinDateTime() {
            const startDateTime = document.getElementById("start-datetime");
            const endDateTime = document.getElementById("end-datetime");

            // Set the min value of the end-datetime input to match the selected start-datetime
            endDateTime.min = startDateTime.value;
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col" onload="setInitialMinDateTime()">

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
      
           <div id="alertModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-96 max-w-sm shadow-lg">
      <div class="flex justify-between items-center">

      </div>
      <div>
        <center>
        <?php echo $img; ?>
        <?php echo $title; ?>
        <?php echo $message; ?>
        <div class="mt-6 flex justify-center">
        <?php echo $button; ?>
      </div>
        </center>
      </div>
    </div>
  </div>
      
      <div>
          <h2 class="text-3xl font-bold text-gray-800">My Ads</h2>
          <p class="text-sm text-gray-500">Manage your ads details and search ads</p>
        </div>
        <div class="text-end mt-3 mb-3">
            <button class="px-4 py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]"  onclick="openModal()">+ Add New</button>
        </div>

        <!-- Modal -->
  <div id="advertisementModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl max-h-[90vh] p-6 rounded-lg shadow-lg overflow-y-auto">
      <!-- Modal Header -->
      <div class="flex justify-between items-center border-b pb-3">
        <h4 class="text-xl font-semibold text-gray-700">Add New Advertisement</h4>
        <button 
          onclick="closeModal()" 
          class="text-gray-400 hover:text-gray-600 focus:outline-none text-2xl">
          &times;
        </button>
      </div>

      <!-- Modal Form -->
      <form class="space-y-6 mt-4" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-600">*</span></label>
          <input 
            type="text" 
            name="title" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
            placeholder="Enter advertisement title" 
            required>
        </div>

        <!-- Description -->
        <div>
  <label for="description" class="block text-sm font-medium text-gray-700">
    Description <span class="text-red-600">*</span>
  </label>
  <textarea 
    id="description"
    name="description" 
    rows="4" 
    maxlength="2000" 
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
    placeholder="Enter advertisement description (Max: 2000 characters)" 
    required
  ></textarea>
  <p id="charCount" class="text-sm text-gray-500 mt-1">0 / 2000 characters</p>
</div>

<script>
  function updateCharCount() {
    const textarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    charCount.textContent = `${textarea.value.length} / 2000 characters`;

    
  }
  
   // Add event listener to textarea for real-time updates
  document.getElementById('description').addEventListener('input', updateCharCount);

  // Initialize count on page load in case of pre-filled text
  document.addEventListener("DOMContentLoaded", updateCharCount);
</script>

        <!-- Image Upload -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700">Image <span class="text-red-600">*</span></label>
          <input 
            type="file" 
            name="image"
            id="imageInput"
            accept=".jpeg, .png, .jpg" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none">
        </div>
        
        <script>
    document.getElementById('imageInput').addEventListener('change', function () {
        const allowedExtensions = ['jpeg', 'png', 'jpg'];
        const file = this.files[0];
        
        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                alert('Invalid file type. Please select a .jpeg, .png, or .jpg file.');
                this.value = ''; // Clear the file input
            }
        } else {
            alert('No file selected. Please choose an image.');
        }
    });
</script>

       <!-- Price and Sale Price -->
<div class="grid grid-cols-3 gap-4">
  <!-- Price Input -->
  <div>
    <label for="price" class="block text-sm font-medium text-gray-700">
      Price (Rs) <span class="text-red-600">*</span>
    </label>
    <input 
      type="number" 
      name="price" 
      id="price" 
      min="0" step="0.01"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      placeholder="Enter price" 
      required>
  </div>

  <!-- Discount Input -->
  <div>
    <label for="discount" class="block text-sm font-medium text-gray-700">
      Discount (%) <span class="text-red-600">*</span>
    </label>
    <input 
      type="number" 
      name="discount" 
      id="discount" 
      min="0" max="100" step="0.01"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      placeholder="Enter discount"
      required>
  </div>

  <!-- Sale Price (Read-Only) -->
  <div>
    <label for="sale" class="block text-sm font-medium text-gray-700">
      Sale Price (Rs) <span class="text-red-600">*</span>
    </label>
    <input 
      type="text" 
      name="sale_price" 
      id="sale"
      class="w-full mt-1 px-4 py-2 border rounded-lg bg-gray-100 focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      placeholder="Will be calculated"
      readonly>
  </div>
</div>

<!-- JavaScript to Validate & Calculate Sale Price -->
<script>
  const priceInput = document.getElementById('price');
  const discountInput = document.getElementById('discount');
  const saleInput = document.getElementById('sale');

  function validateAndCalculate() {
    let price = parseFloat(priceInput.value) || 0;
    let discount = parseFloat(discountInput.value) || 0;

    // Validation
    if (price < 0) {
      alert("Price cannot be negative!");
      priceInput.value = '';
      return;
    }

    if (discount < 0 || discount > 100) {
      alert("Discount must be between 0 and 100!");
      discountInput.value = '';
      return;
    }

    // Calculate Sale Price
    let salePrice = price - (price * discount / 100);
    
    // Display sale price formatted to two decimal places
    saleInput.value = salePrice;
  }

  // Attach event listeners
  priceInput.addEventListener('input', validateAndCalculate);
  discountInput.addEventListener('input', validateAndCalculate);
</script>


        <!-- Select Category -->
        <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-600">*</span></label>
          <select 
            name="category" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
            required>
            <option value="" disabled selected>Select category</option>
            <?php
  
              $query = "SELECT id, name FROM category ORDER BY name ASC";
            $result = mysqli_query($con, $query);
              if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '<option value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</option>';
                  }
              } else {
                  echo '<option value="">No Results found...</option>';
              }
              ?>
          </select>
        </div>

        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Ad Type <span class="text-red-600">*</span></label>
          <select 
            name="type" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
            required>
            <option value=""  selected disabled>Select type</option>
            
            <option value="discount">Discount</option>
            <option value="offer">Offer</option>
            <option value="promotion">Promotion</option>
            <option value="sale">Sale</option>
          </select>
        </div>
        </div>

        <!-- Start Date and End Date -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-red-600">*</span></label>
            <input 
              type="datetime-local" 
              id="start-datetime" onchange="updateEndMinDateTime()"
              name="start_date" 
              class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
              required>
          </div>
          <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date <span class="text-red-600">*</span></label>
            <input 
              type="datetime-local" 
              id="end-datetime"
              name="end_date" 
              class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
              required>
          </div>
        </div>
        
        
           <div class="grid grid-cols-2 gap-4">
          <div>
    <label class="block text-sm font-medium text-gray-700">
      District <span class="text-red-600">*</span>
    </label>
    <select 
      name="district" 
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      required>
      <option value="" disabled selected>Select District</option>
      <option value="Ampara">Ampara</option>
      <option value="Anuradhapura">Anuradhapura</option>
      <option value="Badulla">Badulla</option>
      <option value="Batticaloa">Batticaloa</option>
      <option value="Colombo">Colombo</option>
      <option value="Galle">Galle</option>
      <option value="Gampaha">Gampaha</option>
      <option value="Hambantota">Hambantota</option>
      <option value="Jaffna">Jaffna</option>
      <option value="Kalutara">Kalutara</option>
      <option value="Kandy">Kandy</option>
      <option value="Kegalle">Kegalle</option>
      <option value="Kilinochchi">Kilinochchi</option>
      <option value="Kurunegala">Kurunegala</option>
      <option value="Manner">Manner</option>
      <option value="Matale">Matale</option>
      <option value="Matara">Matara</option>
      <option value="Monaragala">Monaragala</option>
      <option value="Mullaitivu">Mullaitivu</option>
      <option value="Nuwara Eliya">Nuwara Eliya</option>
      <option value="Polonnaruwa">Polonnaruwa</option>
      <option value="Puttalam">Puttalam</option>
      <option value="Ratnapura">Ratnapura</option>
      <option value="Trincomalee">Trincomalee</option>
      <option value="Vavuniya">Vavuniya</option>
    </select>
  </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Location <span class="text-red-600">*</span></label>
            <input 
             type="text" 
              name="location" 
              class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
              placeholder="Enter Location" 
              required>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button 
            type="submit" 
            name="add"
            class="w-full px-4 py-2 bg-[#F97225] text-white font-semibold rounded-lg hover:bg-[#fe8745] focus:ring-2 focus:ring-[#fe8745] focus:outline-none">
            Add Advertisement
          </button>
        </div>
      </form>
     
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById("advertisementModal").classList.remove("hidden");
    }

    function closeModal() {
      document.getElementById("advertisementModal").classList.add("hidden");
    }
  </script>
      <div class="container mx-auto p-6">
  <form method="post" class="mb-5">
    <div class="relative w-full sm:w-4/5 md:w-2/3 lg:w-2/3 mx-auto">
      <input 
        type="search" 
        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#F97225] focus:outline-none" 
        placeholder="Search here" 
        name="search"
        required>
      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0a6 6 0 1112 0 6 6 0 01-12 0zm13 4l-2-2"></path>
        </svg>
      </span>
    </div>
  </form>
</div>


        
      </form>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php

      if(mysqli_num_rows($ads_query) > 0) 
      {
        while($ads_row=mysqli_fetch_array($ads_query))
        {
          $start_date = new DateTime($ads_row['start_date']);
          $start_date_format = $start_date->format('F j, Y \a\t g:i A');

          $end_date = new DateTime($ads_row['end_date']);
          $end_date_format = $end_date->format('F j, Y \a\t g:i A');

          $view_id=$ads_row['id'];
          $edit_id=$ads_row['id'];
          $del_id=$ads_row['id'];
          
          

          $cat_id=$ads_row['category_id'];

          $query=mysqli_query($con,"SELECT name FROM category WHERE id=$cat_id");
          $fetch_query=mysqli_fetch_array($query);
          $catname=$fetch_query['name'];

          ?>
          <div class="bg-white shadow-lg rounded-lg overflow-hidden">
         <a href="<?php echo $ads_row['image']; ?>" target="_blank"><img src="<?php echo $ads_row['image']; ?>" class="w-[320px] h-[170px] object-cover rounded-lg shadow-md"></a> 
        <div class="p-4">
          <h2 class="text-lg font-semibold text-gray-800"><?php echo $ads_row['title']; ?></h2>
          <p class="text-gray-600"><?php echo $ads_row['description']; ?></p>
          <div class="mt-4 flex items-center justify-between">
            <!-- Price on the left -->
             <?php
            if($ads_row['status']=="pending")
          {
            echo  '<span class="inline-flex items-center rounded-xl shadow-md bg-orange-600 px-2 py-2 text-xs font-medium text-white ring-1 ring-inset ring-orange-600">Approval in Progress</span>';
          }
          elseif($ads_row['status']=="rejected")
          {
              echo  '<span class="inline-flex items-center rounded-xl shadow-md bg-red-600 px-2 py-2 text-xs font-medium text-white ring-1 ring-inset ring-red-600">Approval Rejected</span>';
          }
          elseif($ads_row['status']=="inactive")
          {
              echo  '<span class="inline-flex items-center rounded-xl shadow-md bg-yellow-600 px-2 py-2 text-xs font-medium text-white ring-1 ring-inset ring-yellow-600">Inactive</span>';
          }
          else
          {
              echo  '<span class="inline-flex items-center rounded-xl shadow-md bg-green-600 px-2 py-2 text-xs font-medium text-white ring-1 ring-inset ring-green-600">Approved</span>';
          }
              ?>
            

            <!-- SVG icons on the right -->
            <div class="flex space-x-2">
               
              
              <button class="text-blue-500 hover:underline" onclick="openview('view<?php echo $view_id; ?>')">
                <img src="./assets/eye-svgrepo-com.svg" width="20" alt="View Icon" style="filter: invert(50%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);">
            </button>
 <?php
                if($ads_row['status']!="pending")
          {
              ?>
            <button class="text-blue-500 hover:underline"  onclick="openedit('edit<?php echo $edit_id; ?>')">
                <img src="./assets/edit-3-svgrepo-com.svg" width="20" alt="Edit Icon"  style="filter: invert(55%) sepia(72%) saturate(381%) hue-rotate(83deg) brightness(92%) contrast(88%);">
            </button>

              <button class="text-blue-500 hover:underline" onclick="opendel('del<?php echo $del_id; ?>')">
  <img src="./assets/delete-3-svgrepo-com.svg" width="20" style="filter: invert(33%) sepia(86%) saturate(6488%) hue-rotate(357deg) brightness(100%) contrast(104%);" alt="Edit Icon">
              </button>
              
              <?php
            
          }
          ?>

            </div>
          </div>

          
        </div>
      </div>



      <!-- Modal view -->
  <div id="view<?php echo $view_id; ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl max-h-[90vh] p-6 rounded-lg shadow-lg overflow-y-auto">
      <!-- Modal Header -->
      <div class="flex justify-between items-center border-b pb-3">
        <h4 class="text-xl font-semibold text-gray-700">View Advertisement</h4>
        <button 
        onclick="closeview('view<?php echo $view_id; ?>')" 
          class="text-gray-400 hover:text-gray-600 focus:outline-none text-2xl">
          &times;
        </button>
      </div>

      <!-- Modal Form -->
      <form class="space-y-6 mt-4" method="post" enctype="multipart/form-data">
        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title : <?php echo $ads_row['title']; ?></label>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea 
            name="description" 
            rows="4" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" disabled><?php echo $ads_row['description']; ?></textarea>
        </div>

        <!-- Image Upload -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
          <center><img src="<?php echo $ads_row['image']; ?>" class="w-[450px] h-[350px]"></center>
        </div>

        <!-- Price and Sale Price -->
        <div class="grid grid-cols-3 gap-4">
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">
            Price : Rs <?php echo number_format($ads_row['price'], 2); ?>
        </label>
    </div>
    <div>
        <label for="sale_price" class="block text-sm font-medium text-gray-700">
            Sale Price : Rs <?php echo number_format($ads_row['sale_price'], 2); ?>
        </label>
    </div>
    <div>
        <label for="discount" class="block text-sm font-medium text-gray-700">
            Discount : <?php echo number_format($ads_row['discount'], 2); ?> %
        </label>
    </div>
</div>


        <!-- Select Category -->
        <div class="grid grid-cols-2 gap-4">
        <div>
          
          <label for="category" class="block text-sm font-medium text-gray-700">Category : <?php echo $catname; ?></label>
        </div>

        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">Ad Type : <?php echo $ads_row['type']; ?></label>
        </div>
        </div>

        <!-- Start Date and End Date -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date : <?php echo $start_date_format; ?></label>
          </div>
          <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date : <?php echo $end_date_format; ?></label>
          </div>
        </div>

        <!-- Location -->
        <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="location" class="block text-sm font-medium text-gray-700">District : <?php echo $ads_row['location']; ?></label>
        </div>
        
        <div>
          <label for="location" class="block text-sm font-medium text-gray-700">Location : <?php echo $ads_row['placement']; ?></label>
        </div>
        </div>
      </form>
     
    </div>
  </div>
  <!-- close view -->


  <!-- Modal edit -->
  <div id="edit<?php echo $edit_id; ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl max-h-[90vh] p-6 rounded-lg shadow-lg overflow-y-auto">
      <!-- Modal Header -->
      <div class="flex justify-between items-center border-b pb-3">
        <h4 class="text-xl font-semibold text-gray-700">Edit Advertisement</h4>
        <button 
        onclick="closeedit('edit<?php echo $edit_id; ?>')" 
          class="text-gray-400 hover:text-gray-600 focus:outline-none text-2xl">
          &times;
        </button>
      </div>

<!-- Modal Form -->
      <form class="space-y-6 mt-4" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
          <input type="hidden" value="<?php echo $edit_id; ?>" name="edit_id">
        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-600">*</span></label>
          <input 
            type="text" 
            name="title" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
            placeholder="Enter advertisement title"
            value="<?php echo $ads_row['title']; ?>"
            required>
        </div>

        <!-- Description -->
<!-- Description -->
<!-- Description -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700">
    Description <span class="text-red-600">*</span>
  </label>
  <textarea 
    id="edit_description_<?php echo $edit_id; ?>"
    name="description" 
    rows="4" 
    maxlength="2000" 
    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
    placeholder="Enter advertisement description (Max: 2000 characters)" 
    required
  ><?php echo htmlspecialchars($ads_row['description']); ?></textarea>
  <p id="charCount_<?php echo $edit_id; ?>" class="text-sm text-gray-500 mt-1">
    0 / 2000 characters
  </p>
</div>

<script>
  function updateCharCount(editId) {
    const textarea = document.getElementById(`edit_description_${editId}`);
    const charCount = document.getElementById(`charCount_${editId}`);
    charCount.textContent = `${textarea.value.length} / 2000 characters`;
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const editId = "<?php echo $edit_id; ?>";
    updateCharCount(editId); // Initialize count

    document.getElementById(`edit_description_${editId}`).addEventListener('input', function () {
      updateCharCount(editId);
    });
  });
</script>



 <!-- Image Upload -->
        <div>
          <label for="image" class="block text-sm font-medium text-gray-700">Image <span class="text-red-600">*</span></label>
          <input 
            type="file" 
            name="image"
            id="imageInput"
            accept=".jpeg, .png, .jpg" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none">
        </div>
        
        
        <script>
    document.getElementById('imageInput2').addEventListener('change', function () {
        const allowedExtensions = ['jpeg', 'png', 'jpg'];
        const file = this.files[0];
        
        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                alert('Invalid file type. Please select a .jpeg, .png, or .jpg file.');
                this.value = ''; // Clear the file input
            }
        } else {
            alert('No file selected. Please choose an image.');
        }
    });
</script>

        <!-- Price and Sale Price -->
<div class="grid grid-cols-3 gap-4">
  <div>
    <label for="price2" class="block text-sm font-medium text-gray-700">
      Price (Rs) <span class="text-red-600"> *</span>
    </label>
    <input 
      type="number" 
      name="price" 
      id="price2" 
      min="0" step="1"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      placeholder="Enter price" 
      value="<?php echo $ads_row['price']; ?>"
      required
    >
  </div>

  <div>
    <label for="discount2" class="block text-sm font-medium text-gray-700">
      Discount (%) <span class="text-red-600"> *</span>
    </label>
    <input 
      type="number" 
      name="discount" 
      id="discount2" 
      step="1" max="100" min="0"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      placeholder="Enter discount" 
      value="<?php echo $ads_row['discount']; ?>"
      required
    >
  </div>

  <div>
    <label for="sale2" class="block text-sm font-medium text-gray-700">
      Sale Price (Rs) <span class="text-red-600"> *</span>
    </label>
    <input 
      type="number" 
      id="sale2"
      name="sale_price"
      class="w-full mt-1 px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" 
      placeholder="Sale price will be calculated" 
      value="<?php echo $ads_row['sale_price']; ?>" 
      readonly
    >
  </div>
</div>

<script>
  // Get input fields
  const priceInput = document.getElementById('price2');
  const discountInput = document.getElementById('discount2');
  const salePriceInput = document.getElementById('sale2');

  // Function to calculate sale price
  function calculateSalePrice() {
    let price = parseFloat(priceInput.value) || 0;
    let discount = parseFloat(discountInput.value) || 0;

    if (price < 0) {
      alert("Price cannot be negative!");
      priceInput.value = "";
      return;
    }

    if (discount < 0 || discount > 100) {
      alert("Discount must be between 0% and 100%!");
      discountInput.value = "";
      return;
    }

    let salePrice = price - (price * discount / 100);
    salePriceInput.value = salePrice.toFixed(2);
  }

  // Event listeners
  priceInput.addEventListener('input', calculateSalePrice);
  discountInput.addEventListener('input', calculateSalePrice);
</script>


        <!-- Select Category -->
        <!-- Select Category -->
<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-600">*</span></label>
        <select 
            name="category" 
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
            required>
            <option value="" disabled>Select category</option>
            <?php
            // Fetch categories from the database
            $query = "SELECT id, name FROM category ORDER BY name ASC";
            $result = mysqli_query($con, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Check if the current category matches $cat_id
                    $selected = ($row['id'] == $cat_id) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</option>';
                }
            } else {
                echo '<option value="">Error fetching categories</option>';
            }
            ?>
        </select>
    </div>

        <div>
    <label for="type" class="block text-sm font-medium text-gray-700">Ad Type <span class="text-red-600">*</span></label>
    <select 
        name="type" 
        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
        required style="text-transform: capitalize;">
        <!-- Placeholder for default selection -->
        <option value="" disabled>Select type</option>
        <?php
        // Define the ad types
        $ad_types = ["discount", "offer", "promotion", "sale"];
        
        // Loop through ad types and render options dynamically
        foreach ($ad_types as $type) {
            $selected = ($ads_row['type'] === $type) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '</option>';
        }
        ?>
    </select>
</div>


        </div>

       <!-- Start Date and End Date -->
<div class="grid grid-cols-2 gap-4">
  <div>
    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-red-600"> *</span></label>
    <input 
      type="datetime-local" 
      id="start_date"
      name="start_date" 
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      value="<?php echo $ads_row['start_date']; ?>"
      required
      min="<?php echo date('Y-m-d\TH:i'); ?>">
  </div>
  
  <div>
    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date <span class="text-red-600"> *</span></label>
    <input 
      type="datetime-local" 
      id="end_date"
      name="end_date" 
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
      value="<?php echo $ads_row['end_date']; ?>"
      required
      min="<?php echo date('Y-m-d\TH:i'); ?>">
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const startDateInput = document.getElementById("start_date");
    const endDateInput = document.getElementById("end_date");

    function validateDates() {
      const startDate = new Date(startDateInput.value);
      const endDate = new Date(endDateInput.value);

      if (endDate <= startDate) {
        alert("End date and time must be after the start date and time!");
        endDateInput.value = ""; // Clear invalid selection
      }
    }

    startDateInput.addEventListener("change", function() {
      // Ensure end date cannot be before start date
      endDateInput.min = startDateInput.value;
      
      if (endDateInput.value) {
        validateDates(); // Validate existing end date
      }
    });

    endDateInput.addEventListener("change", validateDates);
  });
</script>





        <div class="grid grid-cols-2 gap-4">
          <div>
    <label for="type" class="block text-sm font-medium text-gray-700">District <span class="text-red-600">*</span></label>
    <select 
        name="district" 
        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
        required>
        <!-- Placeholder for default selection -->
        <option value="" disabled>Select District</option>
        <?php
        // Define the ad types
        $ad_types = ["Ampara", "Anuradhapura", "Badulla", "Batticaloa","Colombo", "Galle", "Gampaha", "Hambantota","Jaffna", "Kalutara", "Kandy", "Kegalle",
        "Kilinochchi", "Kurunegala", "Manner", "Matale","Matara", "Monaragala", "Mullaitivu", "Nuwara Eliya","Polonnaruwa","Puttalam","Ratnapura","Trincomalee","Vavuniya"];
        // Loop through ad types and render options dynamically
        foreach ($ad_types as $type) {
            $selected = ($ads_row['location'] === $type) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '</option>';
        }
        ?>
    </select>
</div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Location <span class="text-red-600">*</span></label>
            <input 
             type="text" 
              name="location" 
              class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#fe8745] focus:outline-none" 
              placeholder="Enter Location" 
              value="<?php echo $ads_row['placement']; ?>"
              required>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button 
            type="submit" 
            name="edit"
            class="w-full px-4 py-2 bg-[#F97225] text-white font-semibold rounded-lg hover:bg-[#fe8745] focus:ring-2 focus:ring-[#fe8745] focus:outline-none">
            Update Advertisement
          </button>
        </div>
      </form>
     
    </div>
  </div>


          <!--del  Modal -->
<div
   id="del<?php echo $del_id; ?>"
   class="fixed top-0 inset-x-0 z-50 hidden mt-3  bg-opacity-50 flex items-start justify-center"
   >
   <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
      <!-- Modal Body -->
      <div>
         <div class="flex items-center justify-center space-x-2 text-gray-600">
            <div class="text-green-500">
               <img src="./assets/delete-3-svgrepo-com.svg" width="25" alt="">
            </div>
         </div>
         <h5 class="text-center text-sm font-normal p-2 mt-2 mb-3">Are you sure delete <?php echo $ads_row['title']; ?>  ad ?</h5>
        <center><a href="my-ads.php?delid=<?php echo $del_id; ?>" class="mt-5 px-4 text-sm py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]">Delete</a> <button onclick="closedel('del<?php echo $del_id; ?>')" class="mt-5 px-4 text-sm py-2 bg-black text-white rounded-lg hover:bg-black-400">Cancel</button></center>
      </div>
   </div>
</div>

<!-- del model -->
      <script>
    function openview(viewId) {
      document.getElementById(viewId).classList.remove("hidden");
    }

    function closeview(viewId) {
      document.getElementById(viewId).classList.add("hidden");
    }

    function openedit(editId) {
    document.getElementById(editId).classList.remove("hidden");
  }

  function closeedit(editId) {
    document.getElementById(editId).classList.add("hidden");
  }

    function opendel(delId) {
      document.getElementById(delId).classList.remove("hidden");
    }

    function closedel(delId) {
      document.getElementById(delId).classList.add("hidden");
    }
  </script>

      <?php
        }
        echo "</div>";
      }
      else
      {
          echo '<div class="parent-container">
    <div class="no-category-container">
        <img src="./assets/img/4532229-200.png" class="no-category-logo" alt="No Ads available">
        <p class="no-category-text">No Ads available</p>
    </div>
</div>';
      }
    ?>
         <style>
    
.parent-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%; /* Ensure it spans the full width */
}

.no-category-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin: auto;
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
      </main>
       <?php include './assets/footer.php'; ?>
    </div>
  </div>

<script>
    // Show the modal if PHP shows success message
    <?php if ($showModal): ?>
      const alertModal = document.getElementById('alertModal');
      alertModal.classList.remove('hidden');
    <?php endif; ?>

    // Close the modal when 'X' or OK button is clicked
    document.getElementById('closeAlert').addEventListener('click', () => {
      document.getElementById('alertModal').classList.add('hidden');
    });

    document.getElementById('okBtn').addEventListener('click', () => {
      document.getElementById('alertModal').classList.add('hidden');
    });
  </script>
</body>
</html>
