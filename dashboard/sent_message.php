<?php
include './includes/session.php';

$showModal = false;
$img="";
$title="";
$message = "";
$button="";
?>

<?php

// if(isset($_GET['delid']))
// {
//   $delid=$_GET['delid'];
//   $sql=$con->prepare("DELETE FROM inbox WHERE id=? ");
//   $sql->bind_param('s',$delid);
//   if($sql->execute())
//   {
//         $showModal = true;
//         $img='<img src="./assets/verified.gif" alt="" style="width:50px; height:50px;">';
//         $title='<h2 class="text-xl font-semibold text-black">Success</h2>';
//         $message ='<p class="mt-4 text-gray-600">Message Successfully Deleted</p>';
//         $button='<a href="sent_message.php" class="bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745] px-4 py-2 rounded-md transition duration-300">OK</a>';
//   }
//   else
//   {
//         $showModal = true;
//         $img='<img src="./assets/alarm.gif" alt="" style="width:50px; height:50px;">';
//         $title='<h2 class="text-xl font-semibold text-black">Error</h2>';
//         $message ='<p class="mt-4 text-gray-600">Message Not Deleted</p>';
//         $button='<button id="closeAlert" class="bg-yah text-white px-4 py-2 rounded-md transition duration-300">OK</button>';
//   }

// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/192x192 logo.png">
  <title>Sent Messages</title>
  <?php include './includes/script.php'; ?>
<style>
  h1 {
    font-size: 30px;
    font-weight: 300;
    text-align: center;
    margin-bottom: 15px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  .table-wrapper {
    overflow-x: auto; /* Enables horizontal scrolling */
    width: 100%;
  }

  .tbl-header thead {
    background-color: #F97225;
    position: sticky;
    top: 0;
    z-index: 2; /* Ensures header stays above content */
  }

  th {
    padding: 20px 15px;
    text-align: left;
    font-weight: 500;
    font-size: 14px;
    color: #fff;
    text-transform: uppercase;
  }

  td {
    padding: 15px;
    text-align: left;
    vertical-align: middle;
    font-weight: 300;
    font-size: 12px;
    color: #000;
    border-bottom: 1px solid #ddd;
    word-wrap: break-word;
    overflow-wrap: break-word;
  }
  th:nth-child(1), td:nth-child(1) { width: 10%; }
  th:nth-child(2), td:nth-child(2) { width: 25%; }
  th:nth-child(3), td:nth-child(3) { width: 25%; }
  th:nth-child(4), td:nth-child(4) { width: 15%; }
  th:nth-child(5), td:nth-child(5) { width: 15%; }
  th:nth-child(6), td:nth-child(6) { width: 10%; }

    /* Ensure proper word wrapping in the Title column */
  td:nth-child(2), th:nth-child(2) {
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    max-width: 200px; /* Prevents excessive stretching */
  }

  /* Add spacing between Title and Message columns */
  td:nth-child(2), th:nth-child(2) {
    padding-right: 20px;
  }

  /* Add spacing between Date and Status columns */
  td:nth-child(4), th:nth-child(4) {
    padding-left: 20px;
  }

  /* Custom scrollbar */
  ::-webkit-scrollbar {
    height: 6px; /* Horizontal scrollbar height */
  }
  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  }
  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  }
  td:nth-child(3) textarea {
  width: 100%; /* Make it fill the column */
  max-width: 100%; /* Prevents overflow */
  resize: none; /* Prevents manual resizing */
  border: none; /* Optional: Removes border for cleaner look */
  background: transparent; /* Optional: Matches background */
}
    /* Ensure horizontal scroll is available for screens below 500px */
   @media (max-width: 500px) {
    .main-content {
      overflow-x: auto;
      width: 100vw;
    }
    .table-wrapper {
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }
    table {
      width: 100%;
      min-width: 600px;
      display: block;
    }
    thead {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
    tbody {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
    th, td {
      white-space: nowrap;
      text-align: left;
      min-width: 100px;
      word-break: normal;
    }
    th:nth-child(5), td:nth-child(5) {
      text-align: center;
    }
    th:nth-child(4) {
      text-align: center;
    }
    th:nth-child(3){
        text-align: left;
    }
    td:nth-child(4), th:nth-child(4) {
    white-space: normal; /* Allow wrapping */
    text-align: center;
    line-height: 1.3;
  }
  th:nth-child(6) {
    text-align: left;
    padding-left: 5px; /* Adjust as needed */
  }
  
  /* Align Action column data slightly to the left */
  td:nth-child(6) {
    padding-left: 10px; /* Adjust as needed */
  }

  /* Force a line break in date content */
  td:nth-child(4)::after {
    content: "\A"; /* New line */
    white-space: pre; /* Preserve new line */
  }
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
    <div class="flex-1 flex flex-col main-content">
      <!-- Header -->
      <?php include './includes/header.php'; ?>
      <!-- Dashboard Content -->
      <main class="p-4 md:p-6 flex-1 overflow-y-auto">
        <div class="container">
          <div class="bg-white shadow-lg rounded-lg p-6">
            <section class="mb-4">
              <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Sent Messages</h2>
                <p class="text-sm text-gray-500">Manage your Sent messages here</p>
              </div>
              <div class="flex flex-col sm:flex-row justify-end items-center gap-3 mt-3 mb-3">
                <a href="message.php" class="px-4 py-2 bg-[#F97225] text-white text-center rounded-lg hover:bg-[#fe8745] flex items-center justify-center h-[42px] w-full sm:w-auto">Inbox Messages</a>
              </div>
  
              <div class="table-container">
                <div class="table-wrapper">
                  <table class="tbl-header">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <!--<th>Action</th>-->
                      </tr>
                    </thead>
                  </table>
                  <div class="tbl-content">
                    <table>
                      <tbody>
                           <?php 
        $x=1;
        $sql=$con->prepare("SELECT * FROM inbox WHERE sender=? ORDER BY id DESC");
        $sql->bind_param('s',$customer_mail);
        $sql->execute();
        $result=$sql->get_result();
        if($result->num_rows > 0) {
          while($row=$result->fetch_assoc()) {
            $del_id=$row['id'];
            $start_date = new DateTime($row['created_at'], new DateTimeZone('UTC'));
            $start_date_format = $start_date->format('D, d M Y \a\t g:i A');
            $text = str_replace("\r\n", ' ', $row['message']);
            $status = $row['status'] === 1
              ? '<span class="inline-flex items-center rounded-full bg-orange-100 text-orange-600 px-3 py-1 text-xs font-medium">Unread</span>'
              : '<span class="inline-flex items-center rounded-full bg-green-100 text-green-600 px-3 py-1 text-xs font-medium">Read</span>';
        ?>
                        <tr>
          <td><?php echo $x; ?></td>
          <td><?php echo $row['title']; ?></td>
          <td><textarea rows="3" readonly><?php echo htmlspecialchars($text); ?></textarea></td>
          <td><?php echo $start_date_format; ?></td>
          <td><?php echo $status; ?></td>
          </tr>
           <?php
                            $x++;
                        }
                    } else {
                        echo '<tr><td colspan="5">
            <div class="no-messages-container">
                <img src="./assets/img/4532229-200.png" class="no-category-logo" alt="No Messages Available">
                <p class="no-category-text">No Messages Found...</p>
            </div>
          </td></tr>';
                    }
                    ?>
                  <style>
    .no-messages-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 300px; /* Adjust height as needed */
        text-align: center;
    }

    .no-category-logo {
        width: 200px; /* Adjust logo size as needed */
        height: auto;
        margin-bottom: 10px;
    }

    .no-category-text {
        font-size: 18px;
        font-weight: bold;
        color: #555;
    }
</style>

          <!--<td>-->
          <!--  <button class="text-blue-600 hover:text-blue-800 hover:underline" onclick="opendel('del<?php echo $del_id; ?>')">-->
          <!--    <img src="./assets/img/delete-3-svgrepo-com.svg" width="20" style="filter: invert(33%) sepia(86%) saturate(6488%) hue-rotate(357deg) brightness(100%) contrast(104%);" alt="Delete Icon">-->
          <!--  </button>-->
          <!--</td>-->

                        <!--del  Modal -->
<!--<div-->
<!--   id="del<?php echo $del_id; ?>"-->
<!--   class="fixed top-0 inset-x-0 z-50 hidden mt-3  bg-opacity-50 flex items-start justify-center"-->
<!--   >-->
<!--   <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">-->
      <!-- Modal Body -->
<!--      <div>-->
<!--         <div class="flex items-center justify-center space-x-2 text-gray-600">-->
<!--            <div class="text-green-500">-->
<!--               <img src="./assets/img/delete-3-svgrepo-com.svg" width="25" alt="">-->
<!--            </div>-->
<!--         </div>-->
<!--         <h5 class="text-center text-sm font-normal p-2 mt-2 mb-3">Are you sure delete <?php echo $row['title']; ?>  message ?</h5>-->
<!--        <center><a href="sent_message.php?delid=<?php echo $del_id; ?>" class="mt-5 px-4 text-sm py-2 bg-[#F97225] text-white rounded-lg hover:bg-[#fe8745]">Delete</a> <button onclick="closedel('del<?php echo $del_id; ?>')" class="mt-5 px-4 text-sm py-2 bg-black text-white rounded-lg hover:bg-black-400">Cancel</button></center>-->
<!--      </div>-->
<!--   </div>-->
<!--</div>-->

<!-- del model -->

<script>
  function opendel(delId) {
      document.getElementById(delId).classList.remove("hidden");
    }

    function closedel(delId) {
      document.getElementById(delId).classList.add("hidden");
    }
</script>

                      </tbody>
                    </table>
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
</body>
</html>
