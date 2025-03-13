<script type="text/javascript">
  (function() {
      var hasAdBlock = false;
      var adBlockTest = document.createElement('div');
      adBlockTest.innerHTML = '&nbsp;';
      adBlockTest.className = 'adsbox';
      document.body.appendChild(adBlockTest);

      if (adBlockTest.offsetHeight === 0) {
          hasAdBlock = true;
      }

      if (hasAdBlock) {
          // Show the message
          alert('Please disable your ad blocker for this site to support us.');
      }
      document.body.removeChild(adBlockTest);
  })();
</script>


<script src="https://cdn.tailwindcss.com"></script>
<style>
  .fixed {
  z-index: 9999;
}
.hidden {
  display: none;
}


.bg-theme
{
  background-color: #F97225;
}

 /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 8px;
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 8px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    /* Smooth Scrolling */
    html {
      scroll-behavior: smooth;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">



  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }

    document.querySelectorAll('.menu-item').forEach(menu => {
  menu.addEventListener('click', function () {
    // Remove active class from all menu items
    document.querySelectorAll('.menu-item').forEach(item => {
      item.classList.remove('bg-[#F97225]', 'text-white');
      item.classList.add('text-gray-600', 'hover:bg-[#ff5713]', 'hover:text-white');
    });

    // Add active class to the clicked menu item
    this.classList.remove('text-gray-600', 'hover:bg-[#ff5713]', 'hover:text-white');
    this.classList.add('bg-[#F97225]', 'text-white');

    // Save the active menu in local storage
    localStorage.setItem('activeMenu', this.id);
  });
});

// Load active menu from local storage on page load
const activeMenu = localStorage.getItem('activeMenu');
if (activeMenu) {
  const menu = document.getElementById(activeMenu);
  if (menu) {
    menu.classList.add('bg-[#F97225]', 'text-white');
    menu.classList.remove('text-gray-600', 'hover:bg-[#ff5713]', 'hover:text-white');
  }
}


    function toggleAvatarMenu() {
      const menu = document.getElementById('avatar-menu');
      menu.classList.toggle('hidden');
    }

    function toggleAvatarMenu2() {
      const menu2 = document.getElementById('avatar-menu2');
      menu2.classList.toggle('hidden');
    }
  </script>

  