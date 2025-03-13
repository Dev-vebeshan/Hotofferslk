<header class="bg-white shadow px-4 py-3 flex items-center justify-between hidden md:flex">
    <h1 class="text-lg md:text-xl font-semibold">Welcome, <?php echo $customer_name; ?>!</h1>
    <div class="relative">
        <img src="<?php echo $customer_profile; ?>" alt="User Avatar" class="w-10 h-10 rounded-full border cursor-pointer" onclick="toggleAvatarMenu2()">
        <div id="avatar-menu2" class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg w-40 hidden">
            <a href="./profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center">
                <i class="fa fa-user-circle text-base mr-2"></i> Profile
            </a>
            <a href="./logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center">
                <i class="fas fa-sign-out-alt text-base mr-2"></i> Logout
            </a>
        </div>
    </div>
</header>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
