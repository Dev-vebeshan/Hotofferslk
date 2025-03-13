<?php
include './includes/session.php';

$showModal = false;
$img="";
$title="";
$message = "";
$button="";

if (isset($_POST['delete_profile'])) {

    $query1 = $con->prepare("DELETE FROM customer WHERE email=? ");
    $query1->bind_param("s", $customer_mail);

    $query2 = $con->prepare("DELETE FROM advertisments WHERE author=? AND author_mail=? ");
    $query2->bind_param("ss", $customer_role,$customer_mail);
    
    $query3 = $con->prepare("DELETE FROM inbox WHERE sender=?");
    $query3->bind_param("s",$customer_mail);
    $query3->execute();

    if ($query1->execute() && $query2->execute()) {
        
        $showModal = true;
        $img='<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
        $title='<h2 class="text-xl font-semibold text-black">Success</h2>';
        $message ='<p class="mt-4 text-gray-600">Your Account Successfully Deleted</p>';
        $button='<a href="logout.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
        
    } else {
        $showModal = true;
        $img='<img src="./assets/alarm.gif" alt="" style="width:50px; height:50px;">';
        $title='<h2 class="text-xl font-semibold text-black">Error</h2>';
        $message ='<p class="mt-4 text-gray-600">Your Account Not Deleted</p>';
        $button='<button id="closeAlert" class="bg-yah text-white px-4 py-2 rounded-md transition duration-300">OK</button>';
     
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/192x192 logo.png">
  <title>Customer Settings</title>
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

      <div class="container">
          
               
        
    <div class="bg-white shadow-lg rounded-lg p-6">
        
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
  
      <section class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Account Settings</h2>
        <form class="space-y-4">
          <div>
            <label class="block text-gray-700 font-medium">Name</label>
            <input readonly type="text" class="md:w-1/2 w-full px-4 py-2 border rounded-lg" value="<?php echo  $customer_name; ?>">
          </div>
          <div>
            <label class="block text-gray-700 font-medium">Email</label>
            <input type="email" readonly class="md:w-1/2 w-full px-4 py-2 border rounded-lg" value="<?php echo $customer_mail; ?>">
          </div>
          <br>
          <a href="profile.php" class="bg-[#F97225] text-white px-6 py-2 rounded-lg hover:bg-[#fe8745]">
            Edit Profile
          </a>
        </form>
      </section>

      <!-- Privacy Settings -->
      <section class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Privacy</h2>
        <p>We prioritize the protection of your personal information. Your data is collected only to enhance your experience and is kept secure, confidential, and never shared without your consent.</p>
        <div class="space-y-4">
          <div class="flex items-center">
          <button
               onclick="openModal()" 
               class="bg-black text-white px-6 py-2 rounded-lg hover:bg-black-600 mt-3"
               >
            Delete Profile
            </button>




          <!--del  Modal -->
<div id="modal" class="fixed top-0 inset-x-0 z-50 hidden mt-3 bg-opacity-50 flex items-start justify-center">
   <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
      <!-- Modal Body -->
      <div>
         <div class="flex items-center justify-center space-x-2 text-gray-600">
            <div class="text-green-500">
               <img src="./assets/delete-3-svgrepo-com.svg" width="25" alt="">
            </div>
         </div>
         <h5 class="text-center font-bold p-2 mt-2 mb-3">Delete Profile</h5>
        <center>
           <p class="text-sm">Are you sure you want to delete your profile? This action will permanently delete all your data and cannot be undone.</p>

            <form method="post">
            <input type="submit" value="Delete" name="delete_profile" class="bg-[#F97225] text-white px-6 py-2 rounded-lg hover:bg-[#fe8745]">

            <button class="bg-black text-white px-6 py-2 rounded-lg hover:bg-black-600 mt-3">Cancel</button>
            </form>
        </center>
      </div>
   </div>
</div>



          </div>
        </div>
      </section>
    </div>
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
  
  
  <!-- del model -->

           <script>
    function openModal() {
        document.getElementById("modal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("modal").classList.add("hidden");
    }
</script>
</body>
</html>
