<?php
include './includes/session.php';

$showModal = false;
$img = "";
$title = "";
$message = "";
$button = "";

$nameError = "";
$phoneError = "";
$addressError = "";
$cityError = "";

if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);

    $isValid = true;

    // Validate phone number
    if (!preg_match('/^\d{10}$/', $phone)) {
        $phoneError = "Invalid phone number. Please enter exactly 10 digits.";
        $isValid = false;
    }

    // Proceed only if all validations pass
    if ($isValid) {
        $update = $con->prepare("UPDATE customer SET name=?, phone=?, address=?, city=?, modified=? WHERE email=?");
        $update->bind_param('ssssss', $name, $phone, $address, $city,$current_time, $customer_mail);

        if ($update->execute()) {
            $showModal = true;
            $img = '<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
            $title = '<h2 class="text-xl font-semibold text-black">Success</h2>';
            $message = '<p class="mt-4 text-gray-600">Profile successfully updated</p>';
            $button = '<a href="logout.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
        } else {
            $phoneError = "An error occurred while updating your profile. Please try again later.";
        }
    }
}


$activeTab = $_POST['activeTab'] ?? 'profile'; // Default to 'profile' if not set
if (isset($_POST['update_pass'])) {
    $activeTab = 'password'; // Stay on the 'password' tab
    $pass = trim($_POST['pass']);
    $rpass = trim($_POST['rpass']);
    $errors = [];

    // Password validation
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,20}$/', $pass)) {
        $errors['pass'] = "Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.";
    }

    if ($pass !== $rpass) {
        $errors['rpass'] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);
        $update = $con->prepare("UPDATE customer SET password=?, modified=? WHERE email=?");
        $update->bind_param('sss', $hashpass,$current_time, $customer_mail);

        if ($update->execute()) {
            echo '<script>
                alert("Password successfully changed. Please log in again.");
                window.location.href = "logout.php";
            </script>';
        } else {
            $errors['general'] = "An error occurred while updating the password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/192x192 logo.png">
    <title>Customer Profile</title>
    <?php include './includes/script.php'; ?>
    <style>
        .password-strength {
      margin-top: 10px;
      font-size: 0.9rem;
      color: #6c757d;
    }
    .strength-bar {
      height: 8px;
      margin-top: 10px;
      border-radius: 4px;
    }
    .strength-bar.weak {
      background: #dc3545;
    }
    .strength-bar.medium {
      background: #ffc107;
    }
    .strength-bar.strong {
      background: #28a745;
    }
     .error {
      color: #dc3545;
      font-size: 0.9rem;
      margin-top: 5px;
    }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Navbar for Mobile and Tablet -->
<?php include './includes/mobiletopbar.php'; ?>

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php include './includes/slidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
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
                <h2 class="text-3xl font-bold text-gray-800">Edit Profile</h2>
                <p class="text-sm text-gray-500">Manage your account settings and personal information</p>
            </div>

            <!-- Profile Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                <!-- Plan Information -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 p-2">Personal Information</h3>
                    <hr width="90%" size="15">
                         <form class="mt-4 space-y-4" method="POST">
                        <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium text-sm">Name</label>
                            <input type="text" name="name" value="<?php echo $customer_name; ?>" class="text-sm w-full px-4 py-2 border rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium text-sm">Email</label>
                            <input type="email" value="<?php echo $customer_mail; ?>" class="w-full px-4 py-2 border rounded-lg text-sm" readonly>
                        </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium text-sm">Address</label>
                            <input type="tel" value="<?php echo $customer_address; ?>" class="w-full px-4 py-2 border rounded-lg text-sm" readonly>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">City</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg text-sm" readonly value="<?php echo $customer_city; ?>">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">Phone</label>
                                <input type="text" name="rpass" class="w-full px-4 py-2 border rounded-lg text-sm" readonly value="<?php echo $customer_phone; ?>">
                            </div>
                        </div>
                        
                    </form>
                    <div class="mt-4">
                        <!-- Ad Card -->
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Membership <?php echo $status; ?></h2>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-orange-500 font-semibold">FREE</span>
                                    <button onclick="openModal()" class="flex items-center space-x-2 px-4 py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]">
                                        <span class="text-sm font-medium">Upgrade Plan</span>
                                    </button>

                                    <!-- Modal -->
                                    <div id="modal" class="fixed top-0 inset-x-0 z-50 hidden mt-3 bg-opacity-75 flex items-start justify-center">
                                        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                                            <!-- Modal Body -->
                                            <div>
                                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                                    <div class="text-green-500">
                                                        <img src="./assets/img/premium-svgrepo-com.svg" width="25" alt="">
                                                    </div>
                                                    <div class="text-md font-medium ml-3">Upgrade to Premium</div>
                                                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="closeModal()">×</button>
                                                </div>
                                                <p class="text-center text-sm font-normal p-2 mt-2 mb-3">Contact us for further details</p>
                                                <center><a href="mailto:activedigitallabs@gmail.com?subject=Premium%20Account%20for%20Advertisement&body=Dear%20Admin,%0A%0AI%20am%20interested%20in%20learning%20more%20about%20the%20premium%20account%20for%20posting%20advertisements.%20Please%20provide%20details.%0A%0AThank%20you!" class="mt-5 w-full px-4 text-sm py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]">Contact us</a></center>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function openModal() {
                                            document.getElementById("modal").classList.remove("hidden");
                                        }

                                        function closeModal() {
                                            document.getElementById("modal").classList.add("hidden");
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="bg-white p-6 rounded-lg shadow-lg">

                        <!-- Tabs -->
    <div class="flex border-b border-gray-200">
      <button
        id="tab-profile"
        class="tab-btn active-tab text-gray-700 py-2 px-4 border-b-2 border-[#F97225] font-semibold focus:outline-none"
        onclick="switchTab('profile')"
      >
        <h3 class="md:text-lg text-md text-gray-800 p-2">Change Profile Information</h3>
      </button>
      <button
        id="tab-password"
        class="tab-btn text-gray-500 py-2 px-4 focus:outline-none"
        onclick="switchTab('password')"
      >
        <h3 class="md:text-lg text-md text-gray-800 p-2">Change Password</h3>
      </button>
    </div>

    <!-- Tab Content -->
    <div class="tab-content mt-4">
      <!-- Profile Info Form -->
      <div id="content-profile" class="content">
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-600"> *</span></label>
                    <input type="text" class="w-full px-4 py-2 border rounded-lg text-sm" required placeholder="Enter your name" id="name" name="name" value="<?php echo htmlspecialchars($customer_name, ENT_QUOTES); ?>">
                    <span class="error"><?php echo $nameError ?? ''; ?></span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Address <span class="text-red-600"> *</span></label>
                    <input type="text" id="email" class="w-full px-4 py-2 border rounded-lg text-sm" required placeholder="Enter your address" name="address" value="<?php echo htmlspecialchars($customer_address, ENT_QUOTES); ?>">
                    <span class="error"><?php echo $addressError ?? ''; ?></span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium text-sm">City <span class="text-red-600"> *</span></label>
                        <input type="text" name="city" placeholder="Enter your city" class="text-sm w-full px-4 py-2 border rounded-lg" required value="<?php echo htmlspecialchars($customer_city, ENT_QUOTES); ?>">
                        <span class="error"><?php echo $cityError ?? ''; ?></span>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium text-sm">Phone <span class="text-red-600"> *</span></label>
                        <input type="tel" name="phone" placeholder="Enter your phone number" class="w-full px-4 py-2 border rounded-lg text-sm" required value="<?php echo htmlspecialchars($customer_phone, ENT_QUOTES); ?>">
                        <span class="error"><?php echo $phoneError ?? ''; ?></span>
                    </div>
                        </div>
                        <br>
          <button
            type="submit" name="update_profile" class="w-full px-4 py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]"
          >
            Save Changes
          </button>
        </form>
      </div>

      <!-- Password Form -->
      <div id="content-password" class="content hidden">
        <form method="POST" id="resetPasswordForm">
            <input type="hidden" name="activeTab" id="activeTab" value="password">
          <!--<div class="mb-4">-->
          <!--  <label for="current-password" class="block text-sm font-medium text-gray-700">Current Password</label>-->
          <!--  <input-->
          <!--    type="password"-->
          <!--    id="current-password"-->
          <!--    class="w-full px-4 py-2 border rounded-lg text-sm" required-->
          <!--    placeholder="Enter your current password"-->
          <!--    minlength="8" maxlength="20"-->
          <!--    name="cpass"-->
          <!--  />-->
          <!--</div>-->
          <div class="mb-0">
            <label for="new-password" class="block text-sm font-medium text-gray-700">New Password<span class="text-red-600"> *</span></label>
            <input
              type="password"
              id="newPassword"
              class="w-full px-4 py-2 border rounded-lg text-sm" required
              placeholder="Enter your new password"
              minlength="8" maxlength="20"
              name="pass"
            />
            <p id="passError" class="text-red-500 text-sm"><?= $errors['pass'] ?? '' ?></p>
          </div>
          
          
          <small class="password-strength">
            Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.
        </small>
        <div class="strength-bar"></div>
        <span id="newPasswordError" class="error"></span>
          
          
          
          
          
          <div class="mt-0">
            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mt-4">Confirm Password<span class="text-red-600"> *</span></label>
            <input
              type="password"
              id="confirmPassword"
              class="w-full px-4 py-2 border rounded-lg text-sm" required
              placeholder="Confirm your new password"
              minlength="8" maxlength="20"
              name="rpass"
            />
            <p id="rpassError" class="text-red-500 text-sm"><?= $errors['rpass'] ?? '' ?></p>
          </div>
          <span id="confirmPasswordError" class="error"></span>
          <button
            type="submit" name="update_pass" class="w-full px-4 py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] mt-8"
          >
            Update Password
          </button>
          <p id="generalError" class="text-red-500 text-sm"><?= $errors['general'] ?? '' ?></p>
        </form>
      </div>
    </div>
                </div>
            </div>
        </main>
        <?php include './assets/footer.php'; ?>
    </div>
</div>
<script>
    // Show the modal if PHP sets the success message
    <?php if ($showModal): ?>
    document.getElementById('alertModal').classList.remove('hidden');
    <?php endif; ?>

    // Close the modal when the close button is clicked
    document.getElementById('closeAlert')?.addEventListener('click', () => {
        document.getElementById('alertModal').classList.add('hidden');
    });
</script>
  <script>
    const passwordField = document.getElementById("pass");
    const confirmPasswordField = document.getElementById("rpass");
    const passError = document.getElementById("passError");
    const rpassError = document.getElementById("rpassError");

    document.getElementById("resetPasswordForm").addEventListener("submit", (e) => {
        let isValid = true;
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        // Password validation
        const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,20}$/;
        if (!passwordRegex.test(password)) {
            passError.textContent = "Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.";
            isValid = false;
        } else {
            passError.textContent = "";
        }

        // Confirm Password validation
        if (password !== confirmPassword) {
            rpassError.textContent = "Passwords do not match.";
            isValid = false;
        } else {
            rpassError.textContent = "";
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
<script>
    const newPasswordInput = document.getElementById("newPassword");
    const confirmPasswordInput = document.getElementById("confirmPassword");
    const newPasswordError = document.getElementById("newPasswordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");
    const strengthBar = document.querySelector(".strength-bar");

    // Password Strength Checker
    newPasswordInput.addEventListener("input", () => {
      const password = newPasswordInput.value;
      const strength = getPasswordStrength(password);

      if (strength === "weak") {
        strengthBar.className = "strength-bar weak";
      } else if (strength === "medium") {
        strengthBar.className = "strength-bar medium";
      } else if (strength === "strong") {
        strengthBar.className = "strength-bar strong";
      }
    });

    // Validate Passwords on Submit
    document.getElementById("resetPasswordForm").addEventListener("submit", (e) => {
      
      let isValid = true;

      // Validate New Password
      const newPassword = newPasswordInput.value;
      if (!isValidPassword(newPassword)) {
        newPasswordError.textContent =
          "Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.";
        isValid = false;
      } else {
        newPasswordError.textContent = "";
      }

      // Validate Confirm Password
      const confirmPassword = confirmPasswordInput.value;
      if (newPassword !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match.";
        isValid = false;
      } else {
        confirmPasswordError.textContent = "";
      }
    });

    // Toggle Password Visibility
    function togglePasswordVisibility(fieldId) {
      const inputField = document.getElementById(fieldId);
      inputField.type =
        inputField.type === "password" ? "text" : "password";
    }

    // Check Password Strength
    function getPasswordStrength(password) {
      const hasUppercase = /[A-Z]/.test(password);
      const hasLowercase = /[a-z]/.test(password);
      const hasNumbers = /[0-9]/.test(password);
      const hasSymbols = /[!@#$%^&*(),.?":{}|<>]/.test(password);

      if (
        password.length >= 8 &&
        hasUppercase &&
        hasLowercase &&
        hasNumbers &&
        hasSymbols
      ) {
        return "strong";
      } else if (password.length >= 6) {
        return "medium";
      } else {
        return "weak";
      }
    }

    // Validate Password Format
    function isValidPassword(password) {
      const regex =
  /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,20}$/;
      return regex.test(password);
    }
  </script>
  
<script>
    // Tab switching logic
// Tab switching logic
function switchTab(tab) {
    // Set the active tab in the hidden input
    document.getElementById("activeTab").value = tab;

    // Reset active states for all tabs
    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.classList.remove("active-tab", "text-gray-700", "font-semibold", "border-[#F97225]", "border-b-2");
        btn.classList.add("text-gray-500", "border-transparent");
    });

    // Activate the selected tab
    const activeTab = document.getElementById(`tab-${tab}`);
    if (activeTab) {
        activeTab.classList.add("active-tab", "text-gray-700", "font-semibold", "border-[#F97225]", "border-b-2");
        activeTab.classList.remove("text-gray-500", "border-transparent");
    }

    // Hide all content
    document.querySelectorAll(".content").forEach((content) => {
        content.classList.add("hidden");
    });

    // Show the selected content
    const tabContent = document.getElementById(`content-${tab}`);
    if (tabContent) {
        tabContent.classList.remove("hidden");
    }
}


// Wait for the page to load before running the script
document.addEventListener("DOMContentLoaded", () => {
    const activeTab = "<?= isset($activeTab) ? $activeTab : 'profile' ?>"; // Default to 'profile' if undefined
    switchTab(activeTab);
});


  </script>
</body>
</html>
