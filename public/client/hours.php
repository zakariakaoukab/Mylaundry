<?php

session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if(!isset($_SESSION['authenticated'])){
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: ../signin.php");
  exit();
}

if(isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'admin') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: ../signin.php");
}else {
 // client is authenticated, allow access
 $role = $_SESSION['auth_user']['role'];

}


// Function to fetch and return the user's street address
function getUserStreetAddress($connection) {
  // Check if the user is logged in and the id_user is set in the session
  if(isset($_SESSION['auth_user']['id_user'])) {
      // Get the user's id from the session
      $userId = $_SESSION['auth_user']['id_user'];

      // Query to fetch the user's street address from the database
      $query = "SELECT street FROM users WHERE id_user = $userId";

      // Execute the query
      $result = mysqli_query($connection, $query);

      // Check if the query executed successfully
      if($result) {
          // Fetch the user's street address from the result
          $row = mysqli_fetch_assoc($result);
          $streetAddress = $row['street'];

          // Return the user's street address
          return $streetAddress;
      } else {
          // Handle the case where the query failed
          return "Error fetching user's street address";
      }
  } else {
      // Handle the case where the user is not logged in
      return "User not logged in";
  }
}
$userStreetAddress = getUserStreetAddress($con);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $address = $_POST['cycle'];
  $pickupDate = $_POST['datetime-input1'];
  $deliveryDate = $_POST['datetime-input2'];

  // Store form data in session variables
  $_SESSION['address'] = $address;
  $_SESSION['pickupDate'] = $pickupDate;
  $_SESSION['deliveryDate'] = $deliveryDate;

  // Redirect to another page
  header("Location: options.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="../../assets/css/style.css">

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Boxicons -->
  <link
   href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <title>Mylaundry</title>
  <style>
       #style-4::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      background-color: #F5F5F5;
    }

    #style-4::-webkit-scrollbar {
      width: 5px;
      background-color: #000829;
    }

    #style-4::-webkit-scrollbar-thumb {
      background-color: #000829;
    }

     /* Existing styles for icon-circle */
     .icon-circle {
      display: inline-flex;
      justify-content: center;
      align-items: center;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      border: 2px solid #0e1a3f;
      transition: background-color 0.3s, border-color 0.3s;
      margin: 0 1px;
    }

    .icon-circle:hover {
      background-color: #f7f7f7;
      border-color: rgba(66, 135, 245,0.5);
    }

    /* SVG icon style */
    nav svg {
      width: 24px;
      height: 24px;
      fill: currentColor;
    }

    /* Increased shadow under the navigation bar */
    nav {
      box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.1), 0px 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

       .icon-container {
            position: relative;
            display: inline-block;
        }

        .icon-container .icon-text {
            visibility: hidden;
            opacity: 0;
            width: 120px;
            background-color: #559BF7;
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            top: 125%; /* Position the text below the icon */
            left: 50%;
            margin-left: -60px;
            transition: opacity 0.3s;
        }

        .icon-container .icon-text::after {
            content: '';
            position: absolute;
            bottom: 100%; /* Arrow will be at the top of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent #559BF7 transparent;
        }

        .icon-container:hover .icon-text {
            visibility: visible;
            opacity: 1;
        }  /* hr style*/

    .css-5t036d {
    margin: 0px;
    flex-shrink: 0;
    border-width: 0px 0px thin;
    border-style: solid;
    border-color: rgba(0, 0, 0, 0.12);
    background-image: linear-gradient(to right, rgb(224, 246, 255), rgb(37, 147, 229));
    height: 4px;
}
hr {
    display: block;
    margin-block-start: 0.5em;
    margin-block-end: 0.5em;
    margin-inline-start: auto;
    margin-inline-end: auto;
    unicode-bidi: isolate;
    overflow: hidden;
    border-style: inset;
    border-width: 1px;
}
.css-14ovxl9 {
    margin: 0px;
    flex-shrink: 0;
    border-width: 0px 0px thin;
    border-style: solid;
    border-color: rgba(0, 0, 0, 0.12);
    background-image: linear-gradient(to left, rgb(224, 246, 255), rgb(37, 147, 229));
    height: 4px;
}

@media screen and (max-width: 640px) {
    .stepper li {
      font-size: 0.8rem; /* Decrease the font size of list items */
    }
  }

    /* New styles for input and date pickers */
    /* main{
      display: flex;
      justify-content: center;
      align-items: center;
      
    }

    .input-container {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    input[type="text"],
    input[type="date"],
    input[type="datetime-local"] {
      border: none;
      background-color: #f1f2f6;
      padding: 12px 16px;
      border-radius: 8px;
      margin-top: 10px;
      font-size: 16px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      width: 30rem;
    }

    input[type="text"]::placeholder,
    input[type="date"]::placeholder,
    input[type="datetime-local"]::placeholder {
      color: #a5a5a5;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="datetime-local"]:focus {
      outline: none;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* New styles for labels
    label {
      margin-top: 10px;
      font-size: 16px;
      font-weight: bold;
    } 
 */

 body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .wrapper {
            min-height: 100%;
            background: linear-gradient(to top, #E8F8FF, #FFFFFF);


        }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

</head>

<body class="h-full" id="style-4">
<div class="wrapper">
<nav class="p-2.5 bg-white shadow-md md:flex md:items-center md:justify-between fixed top-0 w-full z-10 ">
    <div class="flex justify-between items-center cursor-pointer">
      <div class="flex items-end justify-center text-lg font-bold">
        <svg class="mx-2" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="64px" height="64px" fill="#000000">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <path style="fill:#559bf7;" d="M436.959,0H75.041c-16.46,0-29.805,13.343-29.805,29.805v452.391 c0,16.46,13.343,29.805,29.805,29.805h361.918c16.46,0,29.805-13.343,29.805-29.805V29.805C466.764,13.345,453.419,0,436.959,0z"></path>
            <circle style="fill:#d1a2e2;" cx="255.994" cy="303.985" r="172.718"></circle>
            <circle style="fill:#ffffff;" cx="255.994" cy="303.985" r="161.181"></circle>
            <path style="fill:#C0EFFF;" d="M318.161,303.981c0-27.471,9.721-52.67,25.908-72.351c-20.904-25.415-52.592-41.625-88.069-41.625 c-62.947,0-113.976,51.029-113.976,113.976S193.053,417.957,256,417.957c35.476,0,67.165-16.21,88.069-41.625 C327.881,356.651,318.161,331.452,318.161,303.981z"></path>
            <g>
              <polygon style="fill:#ffffff;" points="337.814,84.119 337.814,0 319.75,0 319.75,84.119 192.25,84.119 192.25,0 174.186,0 174.186,84.119 45.236,84.119 45.236,102.183 466.764,102.183 466.764,84.119 "></polygon>
              <rect x="86.648" style="fill:#ffffff;" width="61.683" height="35.415"></rect>
              <rect x="364.488" y="19.268" style="fill:#ffffff;" width="72.253" height="18.064"></rect>
              <rect x="364.488" y="50.989" style="fill:#ffffff;" width="72.253" height="18.064"></rect>
            </g>
            <path style="fill:#E6FAFF;" d="M318.167,303.977c0,10.236,1.349,20.148,3.878,29.589c-11.308,25.206-36.622,42.764-66.043,42.764 c-39.958,0-72.353-32.395-72.353-72.353s32.395-72.353,72.353-72.353c29.421,0,54.735,17.558,66.043,42.776 C319.516,283.83,318.167,293.741,318.167,303.977z"></path>
          </g>
        </svg>
        My<span class="text-lg text-blue-400 ">laundry</span>
        
      </div>

      <span class="text-3xl cursor-pointer mx-2 md:hidden block">
        <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
      </span>

    </div>

    <ul class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-white w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">
    <div class="icon-container">
    <li class="mx-4 md:my-0">
        <!--order now -->
        <a href="hours.php" class="icon-circle" >
        <svg fill="#000000"  viewBox="0 0 24 24" id="laundry-basket" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="secondary" d="M19.07,18.07,20,5H4l.93,13.07a1,1,0,0,0,1,.93H18.07A1,1,0,0,0,19.07,18.07Z" style="fill: #689CF4; stroke-width: 2;"></path><path id="primary" d="M5,12H19m-4,7V5H9V19ZM3,5H21M19.07,18.07,20,5H4l.93,13.07a1,1,0,0,0,1,.93H18.07A1,1,0,0,0,19.07,18.07Z" style="fill: none; stroke: #0a1843; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></g></svg> </a>     </li>
      <span class="icon-text">Order now</span>
    </div>
   


    
    <div class="icon-container">
    <li class="mx-4 md:my-0">
        <!--track -->
        <a href="track_page.php" class="icon-circle">
    <svg  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 8V12L14.5 14.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M5.60423 5.60423L5.0739 5.0739V5.0739L5.60423 5.60423ZM4.33785 6.87061L3.58786 6.87438C3.58992 7.28564 3.92281 7.61853 4.33408 7.6206L4.33785 6.87061ZM6.87963 7.63339C7.29384 7.63547 7.63131 7.30138 7.63339 6.88717C7.63547 6.47296 7.30138 6.13549 6.88717 6.13341L6.87963 7.63339ZM5.07505 4.32129C5.07296 3.90708 4.7355 3.57298 4.32129 3.57506C3.90708 3.57715 3.57298 3.91462 3.57507 4.32882L5.07505 4.32129ZM3.75 12C3.75 11.5858 3.41421 11.25 3 11.25C2.58579 11.25 2.25 11.5858 2.25 12H3.75ZM16.8755 20.4452C17.2341 20.2378 17.3566 19.779 17.1492 19.4204C16.9418 19.0619 16.483 18.9393 16.1245 19.1468L16.8755 20.4452ZM19.1468 16.1245C18.9393 16.483 19.0619 16.9418 19.4204 17.1492C19.779 17.3566 20.2378 17.2341 20.4452 16.8755L19.1468 16.1245ZM5.14033 5.07126C4.84598 5.36269 4.84361 5.83756 5.13505 6.13191C5.42648 6.42626 5.90134 6.42862 6.19569 6.13719L5.14033 5.07126ZM18.8623 5.13786C15.0421 1.31766 8.86882 1.27898 5.0739 5.0739L6.13456 6.13456C9.33366 2.93545 14.5572 2.95404 17.8017 6.19852L18.8623 5.13786ZM5.0739 5.0739L3.80752 6.34028L4.86818 7.40094L6.13456 6.13456L5.0739 5.0739ZM4.33408 7.6206L6.87963 7.63339L6.88717 6.13341L4.34162 6.12062L4.33408 7.6206ZM5.08784 6.86684L5.07505 4.32129L3.57507 4.32882L3.58786 6.87438L5.08784 6.86684ZM12 3.75C16.5563 3.75 20.25 7.44365 20.25 12H21.75C21.75 6.61522 17.3848 2.25 12 2.25V3.75ZM12 20.25C7.44365 20.25 3.75 16.5563 3.75 12H2.25C2.25 17.3848 6.61522 21.75 12 21.75V20.25ZM16.1245 19.1468C14.9118 19.8483 13.5039 20.25 12 20.25V21.75C13.7747 21.75 15.4407 21.2752 16.8755 20.4452L16.1245 19.1468ZM20.25 12C20.25 13.5039 19.8483 14.9118 19.1468 16.1245L20.4452 16.8755C21.2752 15.4407 21.75 13.7747 21.75 12H20.25ZM6.19569 6.13719C7.68707 4.66059 9.73646 3.75 12 3.75V2.25C9.32542 2.25 6.90113 3.32791 5.14033 5.07126L6.19569 6.13719Z" fill="#1C274C"></path> </g></svg>  </a>    </li>
      </li>
      <span class="icon-text">Track Orders</span>
    </div>

    <div class="icon-container">
    <li class="mx-4 md:my-0">
        <!--profile -->
        <a href="profile.php" class="icon-circle">
        <svg  viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>profile [#1341]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -2159.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M134,2008.99998 C131.783496,2008.99998 129.980955,2007.20598 129.980955,2004.99998 C129.980955,2002.79398 131.783496,2000.99998 134,2000.99998 C136.216504,2000.99998 138.019045,2002.79398 138.019045,2004.99998 C138.019045,2007.20598 136.216504,2008.99998 134,2008.99998 M137.775893,2009.67298 C139.370449,2008.39598 140.299854,2006.33098 139.958235,2004.06998 C139.561354,2001.44698 137.368965,1999.34798 134.722423,1999.04198 C131.070116,1998.61898 127.971432,2001.44898 127.971432,2004.99998 C127.971432,2006.88998 128.851603,2008.57398 130.224107,2009.67298 C126.852128,2010.93398 124.390463,2013.89498 124.004634,2017.89098 C123.948368,2018.48198 124.411563,2018.99998 125.008391,2018.99998 C125.519814,2018.99998 125.955881,2018.61598 126.001095,2018.10898 C126.404004,2013.64598 129.837274,2010.99998 134,2010.99998 C138.162726,2010.99998 141.595996,2013.64598 141.998905,2018.10898 C142.044119,2018.61598 142.480186,2018.99998 142.991609,2018.99998 C143.588437,2018.99998 144.051632,2018.48198 143.995366,2017.89098 C143.609537,2013.89498 141.147872,2010.93398 137.775893,2009.67298" id="profile-[#1341]"> </path> </g> </g> </g> </g></svg>  </a>    </li>
      <span class="icon-text">Profile</span>
    </div>


    <li class="mx-4 md:my-0">
            <!-- Question -->
            <div class="icon-container">
                <a href="home.php" class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" aria-hidden="true" focusable="false" class="MuiSvgIcon-root MuiSvgIcon-colorSecondary MuiSvgIcon-fontSizeMedium css-7v2xkf">
                        <path fill="currentColor" d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"></path>
                    </svg>
                </a>
                <span class="icon-text">Question</span>
            </div>
        </li>
        <li class="mx-4 md:my-0">
            <!-- Logout -->
            <div class="icon-container">
                <a href="../logout.php" class="icon-circle" style="margin-right:1.2rem;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.125 12C16.125 11.5858 15.7892 11.25 15.375 11.25L4.40244 11.25L6.36309 9.56944C6.67759 9.29988 6.71401 8.8264 6.44444 8.51191C6.17488 8.19741 5.7014 8.16099 5.38691 8.43056L1.88691 11.4306C1.72067 11.573 1.625 11.7811 1.625 12C1.625 12.2189 1.72067 12.427 1.88691 12.5694L5.38691 15.5694C5.7014 15.839 6.17488 15.8026 6.44444 15.4881C6.71401 15.1736 6.67759 14.7001 6.36309 14.4306L4.40244 12.75L15.375 12.75C15.7892 12.75 16.125 12.4142 16.125 12Z" fill="#1C274C"></path>
                            <path d="M9.375 8C9.375 8.70219 9.375 9.05329 9.54351 9.3055C9.61648 9.41471 9.71025 9.50848 9.81946 9.58145C10.0717 9.74996 10.4228 9.74996 11.125 9.74996L15.375 9.74996C16.6176 9.74996 17.625 10.7573 17.625 12C17.625 13.2426 16.6176 14.25 15.375 14.25L11.125 14.25C10.4228 14.25 10.0716 14.25 9.8194 14.4185C9.71023 14.4915 9.6165 14.5852 9.54355 14.6944C9.375 14.9466 9.375 15.2977 9.375 16C9.375 18.8284 9.375 20.2426 10.2537 21.1213C11.1324 22 12.5464 22 15.3748 22L16.3748 22C19.2032 22 20.6174 22 21.4961 21.1213C22.3748 20.2426 22.3748 18.8284 22.3748 16L22.3748 8C22.3748 5.17158 22.3748 3.75736 21.4961 2.87868C20.6174 2 19.2032 2 16.3748 2L15.3748 2C12.5464 2 11.1324 2 10.2537 2.87868C9.375 3.75736 9.375 5.17157 9.375 8Z" fill="#1C274C"></path>
                        </g>
                    </svg>
                </a>
                <span class="icon-text">Logout</span>
            </div>
        </li>


     

    </ul>
  </nav>
    
  <!--header-->


 
  
  <div style="margin-top:6rem;">
    <h1 class="text-center text-5xl	 font-bold mt-1 mb-1">My cycle</h1>
  </div>
  <div class="flex justify-center items-center">
 
 <div class="w-3/4">

 <ol  class="pointer-events-none	 stepper flex items-center p-3 space-x-2 text-sm font-medium text-center text-gray-500 shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse">
 <li class="flex items-center text-blue-600 dark:text-blue-500">
     <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
         1
     </span>
     Adresse/Dates
     <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
     </svg>
 </li>
 <li class="flex items-center">
     <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
         2
     </span>
     Options 
     <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
     </svg>
 </li>
 <li class="flex items-center">
     <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
         3
     </span>
     Finish !
 </li>
</ol>
 </div>
  </div>
    
  
  <main>
 
  <div class="flex justify-center items-center">
 
    <div class="w-3/4">

      <form  id="orderForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="flex flex-col mt-2">
          <label for="Adresse" class="text-lg font-bold">Adresse :</label>
          <input type="text" name="cycle" id="cycle"  class="h-14 border border-gray-200 p-2" style="background-color: #DFF6FF; border-radius: 9999px;" value="<?php echo $userStreetAddress; ?>" required>
        </div>&nbsp;<hr class="css-5t036d">

        <div class="flex items-center p-4 mt-1.5 text-base text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 inline  me-3"
        width="28px" height="28px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#2593E5;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><line class="cls-1" x1="10.09" y1="13.89" x2="13.91" y2="13.89"></line><polyline class="cls-1" points="10.09 8.16 12 8.16 12 13.89"></polyline><path class="cls-1" d="M1.5,5.3v9.54a3.82,3.82,0,0,0,3.82,3.82H7.23v2.86L13,18.66h5.73a3.82,3.82,0,0,0,3.82-3.82V5.3a3.82,3.82,0,0,0-3.82-3.82H5.32A3.82,3.82,0,0,0,1.5,5.3Z"></path><line class="cls-1" x1="11.05" y1="5.3" x2="12.95" y2="5.3"></line></g>
        </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">Info !</span> Choose collection and return dates for laundry (count 4 days for bed sheets).
  </div>
</div>&nbsp;<hr class="css-14ovxl9">

        <div class="flex flex-col mt-5">
        <label for="pick up date" class="text-lg font-bold">Pick Up Date :</label>
          
        <input type="text" id="datetime-input1" name="datetime-input1" class="h-14 border-1 border-gray-200 p-2"  placeholder="Select Date and Time of collection" style="background-color: #DFF6FF; border-radius: 9999px;" data-input>
    
        </div>
    <div class="flex flex-col mt-5">
    <label for="return date" class="text-lg font-bold">return Date :</label>
    <input type="text" id="datetime-input2" name="datetime-input2" placeholder="Select Date and Time of return" class="h-14 border-1 border-gray-200 p-2" style="background-color: #DFF6FF; border-radius: 9999px;" data-input>
    </div>
    &nbsp;<hr class="css-5t036d">
    
        <div class="flex items-center p-4 mt-1.5 text-base text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 inline  me-3"
        width="28px" height="28px"  viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#2593E5;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><line class="cls-1" x1="10.09" y1="13.89" x2="13.91" y2="13.89"></line><polyline class="cls-1" points="10.09 8.16 12 8.16 12 13.89"></polyline><path class="cls-1" d="M1.5,5.3v9.54a3.82,3.82,0,0,0,3.82,3.82H7.23v2.86L13,18.66h5.73a3.82,3.82,0,0,0,3.82-3.82V5.3a3.82,3.82,0,0,0-3.82-3.82H5.32A3.82,3.82,0,0,0,1.5,5.3Z"></path><line class="cls-1" x1="11.05" y1="5.3" x2="12.95" y2="5.3"></line></g></svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">Info !</span> Mylaundry guarantees that your Groom will arrive at the scheduled time, +/- 30 minutes..
  </div>
</div>&nbsp;<hr class="css-14ovxl9">
    <div class="flex justify-center mt-5 mb-10">
        <button type="submit" class="font-bold text-white bg-[#050708] hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 rounded-lg text-xl px-8 py-2.5 text-center inline-flex items-center dark:focus:ring-[#050708]/50 dark:hover:bg-[#050708]/30 me-2 mb-2">
           <span class="font-mono mr-2" >Let's go</span> 
            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M9 6L15 12L9 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>        
        </button>
    </div>
        
      </form>
    </div>
  </div>
  

   
  
</main>

</div>

<!-- footer -->
<footer class=" bg-gray-800 text-white py-10 "  id="footer">
  <div class="container mx-auto px-4 " style="padding-top:4rem; padding-bottom:1rem;">
    
    <div class="footbar">
      <div class="flex flex-wrap justify-between items-center">
        <div class="w-full lg:w-8/12 md:w-full sm:w-full mb-4 lg:mb-0 text-center lg:text-left">
          <div class="social-media flex justify-center lg:justify-start space-x-4 ">
            <a href="#" class="p-2 mr-2 flex items-center justify-center border-2 border-white  text-gray-800 " style="border-radius: 30px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#1877F2';" onmouseout="this.style.backgroundColor='transparent';">
            <svg width="20px" height="20px" viewBox="-5 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>facebook [#ffffff]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-385.000000, -7399.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M335.821282,7259 L335.821282,7250 L338.553693,7250 L339,7246 L335.821282,7246 L335.821282,7244.052 C335.821282,7243.022 335.847593,7242 337.286884,7242 L338.744689,7242 L338.744689,7239.14 C338.744689,7239.097 337.492497,7239 336.225687,7239 C333.580004,7239 331.923407,7240.657 331.923407,7243.7 L331.923407,7246 L329,7246 L329,7250 L331.923407,7250 L331.923407,7259 L335.821282,7259 Z" id="facebook-[#ffffff]"> </path> </g> </g> </g> </g></svg>
            </a>
            <a href="#" class="p-2 mr-4  flex items-center justify-center border-2 border-white  text-gray-800 " style="border-radius: 30px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#1DA1F2';" onmouseout="this.style.backgroundColor='transparent';">
            <svg width="20px" height="20px" viewBox="0 -2 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>twitter [#ffffff]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-60.000000, -7521.000000)" fill="#ffffff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M10.29,7377 C17.837,7377 21.965,7370.84365 21.965,7365.50546 C21.965,7365.33021 21.965,7365.15595 21.953,7364.98267 C22.756,7364.41163 23.449,7363.70276 24,7362.8915 C23.252,7363.21837 22.457,7363.433 21.644,7363.52751 C22.5,7363.02244 23.141,7362.2289 23.448,7361.2926 C22.642,7361.76321 21.761,7362.095 20.842,7362.27321 C19.288,7360.64674 16.689,7360.56798 15.036,7362.09796 C13.971,7363.08447 13.518,7364.55538 13.849,7365.95835 C10.55,7365.79492 7.476,7364.261 5.392,7361.73762 C4.303,7363.58363 4.86,7365.94457 6.663,7367.12996 C6.01,7367.11125 5.371,7366.93797 4.8,7366.62489 L4.8,7366.67608 C4.801,7368.5989 6.178,7370.2549 8.092,7370.63591 C7.488,7370.79836 6.854,7370.82199 6.24,7370.70483 C6.777,7372.35099 8.318,7373.47829 10.073,7373.51078 C8.62,7374.63513 6.825,7375.24554 4.977,7375.24358 C4.651,7375.24259 4.325,7375.22388 4,7375.18549 C5.877,7376.37088 8.06,7377 10.29,7376.99705" id="twitter-[#ffffff]"> </path> </g> </g> </g> </g></svg>            </a>
            <a href="#" class="p-2 mr-4  flex items-center justify-center border-2 border-white rounded-full text-gray-800"  style="border-radius: 30px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#C8307F';" onmouseout="this.style.backgroundColor='transparent';">
           <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#ffffff"></path> <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#ffffff"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#ffffff"></path> </g></svg>
          </a>
          </div>
        </div>
        <div class="w-full lg:w-4/12 md:w-full sm:w-full text-center lg:text-right">
          <div class="copyright">
            <p> &copy; 2024 - all rights reserved</p>
          </div>
        </div>
      </div>
    </div>  
  </div>
</footer>
  
  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <script src="script.js"></script>
  
  

  <script>
    function Menu(e) {
      let list = document.querySelector('ul');
      e.name === 'menu' ? (e.name = "close", list.classList.add('top-[80px]'), list.classList.add('opacity-100')) : (e.name = "menu", list.classList.remove('top-[80px]'), list.classList.remove('opacity-100'))
    }
  </script>

</body>

</html>