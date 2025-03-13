<?php
// Get the current file name to determine the active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside id="sidebar" class="bg-[#F97225] text-white w-64 fixed md:relative top-0 left-0 h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
      <div class="p-6 space-y-6">
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-bold"><img src="../assets/images/logo_white.png" alt="hotofferslk"></h2>
          <button onclick="toggleSidebar()" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <nav class="space-y-4">
        <a href="home.php" id="menu-projects" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'home.php') ? 'bg-white text-[#F97225] font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/dashboard-1-svgrepo-com.svg" width="20" alt="" class="mr-2"> Dashboard</a>
        <a href="profile.php" id="menu-profile" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'profile.php') ? 'bg-white text-[#F97225] font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/user-svgrepo-com.svg" width="20" alt="" class="mr-2"> Profile</a>
        <a href="my-ads.php" id="menu-plans" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'my-ads.php') ? 'bg-white text-[#F97225] font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/album-svgrepo-com.svg" width="20" alt="" class="mr-2"> My Ads</a>
        <a href="message.php" id="menu-billings" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'message.php') ? 'bg-white text-[#F97225] font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/message-svgrepo-com.svg" width="20" alt="" class="mr-2"> Messages</a>
        <a href="settings.php" id="menu-templates" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'settings.php') ? 'bg-white text-[#F97225] font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/gear-svgrepo-com.svg" width="20" alt="" class="mr-2"> Settings</a>
        <a href="logout.php" id="menu-faqs" class="menu-item flex items-center py-3 px-4 rounded-lg <?php echo ($current_page == 'logout.php') ? 'bg-[#F97225] text-white font-bold' : 'text-black hover:bg-[#fe8745] hover:text-white'; ?>"><img src="./assets/img/logout-svgrepo-com.svg" width="20" alt="" class="mr-2"> Logout</a>
        
        <a href="../index.php" target="_blank" class="bg-[#fe8745] text-black border-2 border-black flex items-center py-3 px-3 rounded-lg transition duration-300"><img src="./assets/link.png" width="20" alt="" class="mr-2"> Visit Website</a>
        </nav>
      </div>
    </aside>