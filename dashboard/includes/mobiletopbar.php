<header class="bg-[#F97225] text-white px-4 py-3 flex justify-between items-center shadow-md md:hidden">
    <button onclick="toggleSidebar()" class="text-white focus:outline-none">
      <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>
    <h1 class="text-lg font-bold">Dashboard</h1>
    <div class="relative">
      <img src="<?php echo $customer_profile; ?>" alt="User Avatar" class="w-10 h-10 rounded-full border cursor-pointer" onclick="toggleAvatarMenu()">
      <div id="avatar-menu" class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg w-40 hidden">
        <a href="./profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fa fa-user-circle text-base mr-2"></i> Profile</a>
        <a href="./logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-sign-out-alt text-base mr-2"></i> Logout</a>
      </div>
    </div>
  </header>