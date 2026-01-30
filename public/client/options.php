<?php
session_start();
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

if (!isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: ../signin.php");
  exit();
}

if (isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'admin') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: ../signin.php");
} else {
  // client is authenticated, allow access
  $role = $_SESSION['auth_user']['role'];
}
// Fetch articles from the database based on the category
// $category = isset($_GET['category']) ? $_GET['category'] : '';
// $sql = "SELECT * FROM articles WHERE category = '$category'";
// $result = $con->query($sql);
// Fetch all articles from the database
$sql = "SELECT * FROM articles";
$result = $con->query($sql);

$articles = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
  }
}


$con->close();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Options</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css">
  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


  <style>
    /* Scroll bar styles */
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


    /* Scroll bar styles */
    #default-modal::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      background-color: #F5F5F5;
    }

    #default-modal::-webkit-scrollbar {
      width: 5px;
      background-color: #000829;
    }

    #default-modal::-webkit-scrollbar-thumb {
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
        } 

    /* Mobile menu opened - display horizontally */
    #navMenu.menu-open {
      flex-direction: row !important;
      display: flex !important;
      flex-wrap: wrap !important;
      gap: 0.5rem !important;
      padding: 0.5rem !important;
    }

    #navMenu.menu-open .icon-container {
      display: flex !important;
      align-items: center !important;
    }

    #navMenu.menu-open li {
      margin-bottom: 0 !important;
    }

    /* hr style*/

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

    /* Margin for large screens - Now removed from here since it's in main-container */
    .large-margin {
      margin-left: 0;
    }

    .css-14yq2cq {
      user-select: none;
      width: 1em;
      height: 0.9em;
      display: inline-block;
      fill: currentcolor;
      flex-shrink: 0;
      transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
      font-size: 1.7rem;
    }

    /* .mysvggg{
  text-size-adjust: 100%;
  cursor: pointer;
  user-select: none;
  color: inherit;
  box-sizing: inherit;
  height: 80px;
  border-radius: 0px 16px 16px 0px;} */

    /* Style for category buttons */
    .category-button {
      width: 100%;
      margin-bottom: 0.5rem;
      padding: 1rem;
      background-color: #3b82f6;
      /* Blue color */
      color: white;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .category-button:hover {
      background-color: #2563eb;
      /* Darker blue color on hover */
    }

    /* Style for article buttons */
    .article-button {
      width: 100%;
      margin-bottom: 0.5rem;
      padding: 1rem;
      background-color: #d1d5db;
      /* Gray color */
      color: black;
      font-size: 1rem;
      font-weight: bold;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .article-button:hover {
      background-color: #e5e7eb;
      /* Lighter gray color on hover */
    }

    /* Hide the articles container initially */
    #articles-container {
      display: none;
    }

    /* Main container for responsive layout */
    .main-container {
      display: flex;
      flex-direction: row;
      gap: 3rem;
      margin-left: 12rem;
    }

    .categories-section {
      flex: 0 0 auto;
    }

    .articles-section {
      flex: 1;
      min-width: 0;
    }

    /* Mobile responsive adjustments */
    @media screen and (max-width: 1024px) {
      .main-container {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
        margin-left: 0;
      }

      .categories-section {
        width: 100%;
      }

      .articles-section {
        flex: 1;
        width: 100%;
      }

      /* Category buttons responsive */
      .category-button {
        width: 100%;
        max-width: 100%;
      }

      /* Articles responsive */
      #articles {
        margin-left: 0 !important;
        flex-direction: column;
      }

      /* Articles container responsive */
      .articles-container {
        width: 100%;
        margin-left: 0 !important;
      }

      /* Category description responsive */
      .category-text {
        width: 100% !important;
      }
    }

    @media screen and (max-width: 768px) {
      .main-container {
        flex-direction: column;
        gap: 1rem;
        margin-left: 1rem;
        margin-right: 1rem;
      }

      /* Ensure articles display below category */
      #articles {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin-left: 0 !important;
      }

      .w-96 {
        max-width: 100%;
        width: 100%;
      }

      /* Make all buttons full width on mobile */
      .category-button {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0.5rem;
      }

      /* Make category descriptions full width */
      .category-text {
        width: 100% !important;
        margin-left: 0 !important;
      }

      /* Full width articles container */
      .articles-container {
        width: 100%;
        margin-left: 0 !important;
        padding: 0;
        display: flex;
        flex-direction: column;
      }

      /* Make article items full width on mobile */
      .articles-container .w-96 {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
      }

      /* Make default message full width */
      #default-message {
        width: 100%;
        padding: 1rem;
      }
    }

    /* Extra small devices (less than 388px width) */
    @media screen and (max-width: 388px) {
      /* Reduce price text size for very small screens */
      .w-30 span {
        font-size: 0.875rem !important;
      }
    }

/* Modal styles */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

textarea {
    width: 100%;
    height: 100px;
    margin-top: 10px;
}




    @keyframes slideInRight {
      from {
        transform: translateX(100%);
      }

      to {
        transform: translateX(0);
      }
    }

    @keyframes slideOutRight {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(100%);
      }
    }

    .modal-open {
      animation: slideInRight 0.5s forwards;
    }

    .modal-close {
      animation: slideOutRight 0.6s forwards;
    }




    @media screen and (max-width: 640px) {
      .large-margin {
        margin-left: 4rem;
        /* Change to 6rem for large screens */
      }

      .stepper li {
        font-size: 0.8rem;
        /* Decrease the font size of list items */
      }


    }
    body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .wrapper {
            min-height: 100%;
            background: linear-gradient(to top, #e8f8ff, #FFFFFF);


        }
  </style>

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

    <ul id="navMenu" class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-white w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">
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
        <a href="track_page.php" class="icon-circle">
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
    <h1 class="text-center text-5xl font-bold mt-2 mb-1">My cycle</h1>
  </div>

  <!-- Modal toggle -->



  <main>
    <div class="flex justify-center items-center">
      <div class="w-3/4">

        <ol class="pointer-events-none stepper flex items-center p-3 space-x-2 text-sm font-medium text-center text-gray-500 shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse">
          <li class="flex items-center text-blue-600 dark:text-blue-500">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
              &#10003;
            </span>
            Adresse/Dates
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
            </svg>
          </li>
          <li class="flex items-center text-blue-600 dark:text-blue-500">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
              2
            </span>
            Options
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
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
    <!-- Articles Options buttons  -->
    <div class="main-container mt-4 large-margin phone-margin">
      <div class="categories-section flex flex-col">
        <button onclick="displayArticles('text1','Household linen and bulky items')" class="flex items-center justify-between w-96 mb-5 bg-blue-500 text-white text-left text-xl font-bold  shadow hover:bg-blue-800 focus:bg-blue-600 transition duration-300" style="padding-left: 1rem; border-radius: 20px;">
          <span> Household linen and bulky items</span>
          <svg class="rounded-r-lg" height="70" viewBox="0 0 120 92" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g transform="translate(0, 17.5)">
              <path d="M0,82.3203125 L0,58.7148438 C-2.02906125e-16,57.0579895 1.34314575,55.7148438 3,55.7148438 L138.958984,55.7148438 L138.958984,55.7148438 L138.958984,79.3203125 C138.958984,80.9771667 137.615839,82.3203125 135.958984,82.3203125" id="Path-23" stroke="#000829" stroke-width="2" fill="#79C7FF"></path>
              <path d="M11,65 L131,65 L131,65 L131,78 L9,78 L9,67 C9,65.8954305 9.8954305,65 11,65 Z" id="Rectangle" stroke="none" fill="#000829"></path>
              <path d="M16.3076172,38.4960938 L16.3076172,9 C16.3076172,4.02943725 20.3370544,9.13077564e-16 25.3076172,0 L130.982422,0 L130.982422,0 L130.982422,38.4960938" id="Path-25" stroke="#000829" stroke-width="2" fill="#79C7FF"></path>
              <path d="M24.5605469,38.4960938 C24.5605469,31.0564298 30.5915861,25.0253906 38.03125,25.0253906 L59.5087891,25.0253906 C66.948453,25.0253906 72.9794922,31.0564298 72.9794922,38.4960938 L72.9794922,38.4960938 L72.9794922,38.4960938" id="Path-26" stroke="#000829" stroke-width="2" fill="#FFFFFF"></path>
              <path d="M25,37.8071289 C28.8418674,33.1933611 34.5353081,30.5253906 40.5392066,30.5253906 L55.6360773,30.5253906 C62.1604461,30.5253906 68.4106287,33.1495678 72.9794922,37.8071289 L72.9794922,37.8071289 L72.9794922,37.8071289" id="Path-34" stroke="#000829" stroke-width="2" fill="#000829" stroke-linecap="round"></path>
              <path d="M74,38.4960938 C74,31.0564298 80.0310392,25.0253906 87.4707031,25.0253906 L108.948242,25.0253906 C116.387906,25.0253906 122.418945,31.0564298 122.418945,38.4960938 L122.418945,38.4960938 L122.418945,38.4960938" id="Path-26" stroke="#000829" stroke-width="2" fill="#FFFFFF"></path>
              <path d="M74,37.8071289 C77.8418674,33.1933611 83.5353081,30.5253906 89.5392066,30.5253906 L104.636077,30.5253906 C111.160446,30.5253906 117.410629,33.1495678 121.979492,37.8071289 L121.979492,37.8071289 L121.979492,37.8071289" id="Path-34" stroke="#000829" stroke-width="2" fill="#000829" stroke-linecap="round"></path>
              <path d="M7.06445312,47.1054688 C7.06445313,51.8602953 10.9190016,55.7148438 15.6738281,55.7148438 L20.390625,55.7148438 L20.390625,55.7148438 L44.4453125,55.7148438 L132.314453,55.7148438 L132.314453,38.4960938 L15.6738281,38.4960938 C10.9190016,38.4960938 7.06445312,42.3506422 7.06445312,47.1054688 Z" id="Path-24" stroke="#000829" stroke-width="2" fill="#DFF6FF"></path>
            </g>
          </svg>
        </button>
        <!-- Container for articles of the first category -->
        <div id="articles1" class="articles-container"></div>
        <div id="text1" class="text-blue-950 hidden mb-6 w-96 pl-4 .category-text">We select programs according to the washing label instructions, the laundry is treated by our experts, and it is sanitized. Please allow 96 hours for bed linens, as well as 2 weeks for carpets, leather, and fur.
        </div>

        <button onclick="displayArticles('text2','Laundry by weight (kg)')" class="flex items-center justify-between w-96 mb-5 bg-blue-500 text-white text-left text-xl font-bold  shadow hover:bg-blue-800 focus:outline focus:bg-blue-600 transition duration-300" style="padding-left: 1rem; border-radius: 15px;">
          <span class="mb-6">Laundry by weight (kg)</span>
          <svg class="rounded-r-lg" height="70" width="80" viewBox="0 0 117 83" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g transform="translate(0, 12)">
              <path d="M0,80.8317871 L0,61.8317871 C0,57.4135091 3.581722,53.8317871 8,53.8317871 L30,53.8317871 C34.418278,53.8317871 38,57.4135091 38,61.8317871 L38,80.8317871 C38,83.0409261 36.209139,84.8317871 34,84.8317871 L4,84.8317871 C1.790861,84.8317871 0,83.0409261 0,80.8317871 Z" id="bag" stroke="none" fill="#000829" fill-rule="evenodd"></path>
              <path d="M17.84686,70.7900552 C18.0431434,70.7900552 18.2205534,70.7255985 18.37909,70.5966851 C18.5376266,70.4677716 18.6168949,70.3001842 18.6168949,70.0939227 C18.6168949,69.93186 18.5640493,69.7808471 18.4583583,69.640884 L18.4583583,69.640884 L15.9351559,66.3862381 L18.4017381,64.0828729 C18.5182139,63.9692186 18.5847716,63.8474462 18.601411,63.7175555 L18.6055708,63.6519337 C18.6055708,63.5046041 18.5470633,63.359116 18.4300482,63.2154696 C18.3130331,63.0718232 18.1639332,63 17.9827485,63 C17.7864651,63 17.6015058,63.0847145 17.4278705,63.2541436 L17.4278705,63.2541436 L13.8036624,66.7378202 L13.8041771,63.7292818 C13.8041771,63.5651144 13.7584187,63.4239486 13.666902,63.3057842 L13.6173304,63.2486188 C13.492766,63.1197053 13.3247927,63.0552486 13.1134106,63.0552486 C12.9020284,63.0552486 12.7283931,63.1197053 12.5925046,63.2486188 C12.4566161,63.3775322 12.3886719,63.5377532 12.3886719,63.7292818 L12.3886719,63.7292818 L12.3886719,70.1160221 C12.3886719,70.3075506 12.4528414,70.4677716 12.5811806,70.5966851 C12.7095197,70.7255985 12.8793804,70.7900552 13.0907625,70.7900552 C13.3096939,70.7900552 13.4833293,70.7255985 13.6116684,70.5966851 C13.7400075,70.4677716 13.8041771,70.3075506 13.8041771,70.1160221 L13.8041771,70.1160221 L13.8036624,68.3766951 L14.8753285,67.3756906 L17.3372781,70.5359116 C17.4495749,70.6841621 17.5936615,70.7675529 17.7695381,70.7860843 L17.84686,70.7900552 Z M22.3651527,73 C22.893608,73 23.3880912,72.9134438 23.8486022,72.7403315 C24.3091132,72.5672192 24.6809193,72.2872928 24.9640203,71.9005525 C25.2471214,71.5138122 25.3886719,71 25.3886719,70.359116 L25.3886719,70.359116 L25.3886719,65.441989 C25.3886719,65.2430939 25.3245023,65.0810313 25.1961632,64.9558011 C25.067824,64.8305709 24.9055128,64.7679558 24.7092294,64.7679558 C24.512946,64.7679558 24.3506347,64.8324125 24.2222956,64.961326 C24.0939564,65.0902394 24.0297869,65.2504604 24.0297869,65.441989 L24.0297869,65.441989 L24.0297869,65.5670517 L24.0087241,65.5434254 C23.951651,65.4836096 23.8879344,65.4240884 23.8175743,65.3648619 L23.7070517,65.2762431 C23.514543,65.1289134 23.2861748,65.0073665 23.0219471,64.9116022 C22.7577195,64.8158379 22.4670691,64.7679558 22.1499959,64.7679558 C21.62909,64.7679558 21.1572549,64.8987109 20.7344907,65.160221 C20.3117265,65.4217311 19.9757799,65.7826888 19.726651,66.2430939 C19.477522,66.7034991 19.3529576,67.2357274 19.3529576,67.839779 C19.3529576,68.4364641 19.477522,68.9650092 19.726651,69.4254144 C19.9757799,69.8858195 20.3155011,70.2467772 20.7458147,70.5082873 C21.1761283,70.7697974 21.6592874,70.9005525 22.1952921,70.9005525 C22.4670691,70.9005525 22.7237474,70.854512 22.9653269,70.7624309 C23.2069065,70.6703499 23.4164013,70.558011 23.5938112,70.4254144 C23.7712212,70.2928177 23.9108844,70.1583794 24.0128008,70.0220994 L24.0128008,70.0220994 L24.0297869,69.9974887 L24.0297869,70.5359116 C24.0297869,70.8908421 23.9174823,71.1757606 23.6928732,71.3906671 L23.6221214,71.4530387 C23.3503443,71.6740331 22.9313548,71.7845304 22.3651527,71.7845304 C22.2066161,71.7845304 22.0235441,71.7569061 21.8159367,71.7016575 C21.6083293,71.6464088 21.4177079,71.5856354 21.2440726,71.519337 C21.0704373,71.4530387 20.9458728,71.4088398 20.8703792,71.3867403 C20.7042932,71.3278085 20.5457567,71.3370166 20.3947694,71.4143646 C20.2437822,71.4917127 20.1343165,71.6372007 20.0663722,71.8508287 C20.0135267,72.0128913 20.0305128,72.1657459 20.1173304,72.3093923 C20.2041481,72.4530387 20.3607973,72.572744 20.5872781,72.6685083 C20.7005186,72.7127072 20.8666045,72.7605893 21.085536,72.8121547 C21.3044675,72.8637201 21.534723,72.907919 21.7763025,72.9447514 C22.0178821,72.9815838 22.2141655,73 22.3651527,73 Z M22.3651527,69.6850829 C22.0254315,69.6850829 21.7272317,69.6040516 21.4705534,69.441989 C21.2138751,69.2799263 21.0138171,69.0589319 20.8703792,68.7790055 C20.7269413,68.4990792 20.6552224,68.1860037 20.6552224,67.839779 C20.6552224,67.4861878 20.7269413,67.1694291 20.8703792,66.8895028 C21.0138171,66.6095764 21.2138751,66.388582 21.4705534,66.2265193 C21.7272317,66.0644567 22.0254315,65.9834254 22.3651527,65.9834254 C22.7124233,65.9834254 23.0143978,66.0644567 23.2710761,66.2265193 C23.5277543,66.388582 23.7278124,66.6095764 23.8712503,66.8895028 C24.0146881,67.1694291 24.0864071,67.4861878 24.0864071,67.839779 C24.0864071,68.1860037 24.0146881,68.4990792 23.8712503,68.7790055 C23.7278124,69.0589319 23.5277543,69.2799263 23.2710761,69.441989 C23.0143978,69.6040516 22.7124233,69.6850829 22.3651527,69.6850829 Z" id="Kg" stroke="none" fill="#DFF6FF" fill-rule="nonzero"></path>
              <g id="Group-5" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(23.000000, 0.000000)">
                <path d="M49.0939792,19.8 L44.6675599,10.3452755 C43.714157,8.30883003 44.5921365,5.88507903 46.628582,4.93167615 C46.9232082,4.79374098 47.2333045,4.69161462 47.5522366,4.62748197 L50.686286,3.99726989 C51.7570428,3.78195238 52.8657441,4.09897039 53.6608197,4.84779378 C54.2283804,5.38233751 54.7870459,5.64960938 55.3368164,5.64960938 C57.4343358,5.64960938 58.4398612,2.62025313 60.4328727,2.2434082 C60.7290194,2.18741186 62.1946495,1.890217 64.8297631,1.35182365 C66.7777493,0.953807627 68.6795518,2.21031906 69.0775553,4.1583079 C69.2094967,4.80408228 69.1616174,5.473686 68.9391373,6.09411785 L64.0243569,19.8 L64.0243569,19.8 L49.0939792,19.8 Z" id="Path-10" stroke="#000829" stroke-width="1.8" fill="#DFF6FF" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M47.4220459,16.7598633 C50.4742945,15.4153845 53.5853663,14.6248816 56.7552612,14.3883545 C59.9251562,14.1518274 63.0362279,14.4590784 66.0884766,15.3101074 L64.0243569,19.8 L49.0939792,19.8 L47.4220459,16.7598633 Z" id="Path-20" fill="#000829"></path>
                <path d="M64.1628233,19.8 C73.2105573,19.4815749 80.8033294,26.558078 81.1217545,35.605812 C81.1923011,37.6103238 80.8943727,39.6107632 80.2427739,41.5077249 C80.1556318,41.7614166 80.0684897,42.0151083 79.9813477,42.2688 C79.9813477,42.2688 79.9813477,42.2688 79.9813477,42.2688 C85.1277939,44.1415885 87.7816178,49.8318025 85.9088294,54.9782487 C85.6423583,55.7105145 85.2905025,56.4088185 84.8605444,57.0587077 L83.7,58.8128906 L83.7,58.8128906 L86.4576823,61.5532177 C89.8550598,64.9292141 91.6427312,69.5993194 91.3680176,74.380957 C91.1255339,78.6016033 87.6321995,81.9 83.4045933,81.9 L62.7565733,81.9 L62.7565733,81.9 L28.7545895,81.9 C25.0620099,81.9 22.0685828,78.9065728 22.0685828,75.2139933 C22.0685828,72.6653099 23.5175865,70.3383115 25.8048145,69.2138672 L25.8048145,69.2138672 L25.8048145,69.2138672 L24.3744202,65.8099961 C21.0061285,57.7945622 24.7733816,48.5662294 32.7888154,45.1979377 C33.0690628,45.0801705 33.3526625,44.9705453 33.6392578,44.8692 L33.6392578,44.8692 L33.6392578,44.8692 C29.9308478,35.8451466 34.2400281,25.5234457 43.2640814,21.8150356 C43.6189631,21.669198 43.9785017,21.5349607 44.3421253,21.4125374 L49.131708,19.8 L49.131708,19.8 L64.1628233,19.8 Z" id="Path-21" stroke="#000829" stroke-width="1.8" fill="#DFF6FF" stroke-linejoin="round"></path>
                <path d="M25.8048145,69.2138672 C27.5528744,68.6036133 29.6819824,68.6036133 32.1921387,69.2138672" id="Path-28" stroke="#000829" stroke-width="1.8" stroke-linecap="round"></path>
                <path d="M84.1414612,61.3957144 C82.5024835,59.9840815 80.9364334,59.0086914 79.443311,58.4695444" id="Path-30" stroke="#000829" stroke-width="1.8" stroke-linecap="round" transform="translate(81.792386, 59.932629) scale(1, -1) rotate(3.000000) translate(-81.792386, -59.932629) "></path>
                <path d="M80.3122559,41.4296631 C79.4925293,43.7659424 78.269751,45.5560547 76.6439209,46.8" id="Path-31" stroke="#000829" stroke-width="1.8" stroke-linecap="round"></path>
                <g id="Group-3" transform="translate(54.000000, 18.000000)" stroke="#000829" stroke-width="1.8">
                  <line x1="2.17420568" y1="0" x2="2.17420568" y2="26.463" id="Path-22"></line>
                  <ellipse fill="#FFFFFF" cx="2.14429091" cy="26.4192" rx="2.14429091" ry="2.1504"></ellipse>
                  <line x1="8.60707841" y1="0" x2="8.60707841" y2="17.1762" id="Path-22"></line>
                  <ellipse fill="#FFFFFF" cx="8.57716364" cy="17.1324" rx="2.14429091" ry="2.1504"></ellipse>
                </g>
              </g>
              <path d="M11.3886719,55.0739746 L11.3886719,53.2050781 C11.3886719,48.6735386 15.0622105,45 19.59375,45 C24.1252895,45 27.7988281,48.6735386 27.7988281,53.2050781 L27.7988281,55.0739746 L27.7988281,55.0739746" id="Path-33" stroke="#000829" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
          </svg>
        </button>
        <!-- Container for articles of the second category -->
        <div id="articles2" class="articles-container"></div>
        <div id="text2" class="text-blue-950 hidden mb-6 w-96 pl-4 .category-text">A perfect option <strong>for your sportswear, casual clothes, towels, home wear, and underwear</strong>. Ensure that the laundry is machine-washable and dryable,<strong> separate light colors from darks</strong>, if needed for stain removal, prefer the delicate laundry option.<span class="font-bold text-blue-600"> Do not include: sheets, shirts, sweaters, tablecloths, or aprons </span>in the laundry by weight.
        </div>

        <button onclick="displayArticles('text3','Delicate laundry per piece')" class="flex items-center justify-between w-96 mb-5 bg-blue-500 text-white text-left text-xl font-bold  shadow hover:bg-blue-800 focus:outline focus:bg-blue-600 transition duration-300" style="padding-left: 1rem; border-radius: 15px;">
          <span class="mb-6">Delicate laundry per piece</span>
          <svg class="rounded-r-lg" height="70" width="85" viewBox="0 0 125 92" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g transform="translate(0, 13)">
              <line x1="0.89453125" y1="4" x2="150.195312" y2="4" id="Path-27" stroke="#000829" stroke-width="2" stroke-linecap="round"></line>
              <g id="Group-7" stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(81.894531, 0.000000)">
                <polygon id="Path-42" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round" points="19 14 36.7201172 14 28 24.1772461"></polygon>
                <rect id="Rectangle" fill="#000829" x="20" y="14" width="16" height="2"></rect>
                <path d="M15.0597656,20 C23.5910156,23.8970703 32.1222656,23.8970703 40.6535156,20 C39.1527344,22.7998047 34.8871094,29.206543 27.8566406,39.2202148 L15.0597656,20 Z" id="Path-39" fill="#000829"></path>
                <path d="M1.85039063,31.1337891 L1.85039063,28.6623047 L23.0929688,15.7207031 L23.0929688,11.4199219 L32.4292969,11.4199219 L32.4292969,15.7207031 L53.6748047,28.6623047 L53.6748047,31.1337891 L30.4161715,19.6647508 C28.7432874,18.8398368 26.7819079,18.8398368 25.1090238,19.6647508 L1.85039063,31.1337891 L1.85039063,31.1337891 Z" id="Path-35" stroke="#000829" stroke-width="2" fill="#79C7FF" stroke-linejoin="round"></path>
                <path d="M25,4.35 L25,3.27275391 C25,1.46526183 26.4652618,3.32030907e-16 28.2727539,0 C30.080246,-3.32030907e-16 31.5455078,1.46526183 31.5455078,3.27275391 L31.5455078,4.35 L31.5455078,4.35 L29.1145761,7.47750432 C28.5689571,8.17946798 28.2727539,9.04320354 28.2727539,9.9322778 L28.2727539,11.4199219 L28.2727539,11.4199219" id="Path-36" stroke="#000829" stroke-width="2"></path>
                <path d="M27.7625977,24.6884766 L36.8349609,18.453125 L54.731337,28.0187722 C55.512339,28.4362192 56,29.2498259 56,30.1353913 L56,61.9154297 C56,63.2409131 54.9254834,64.3154297 53.6,64.3154297 L46.33125,64.3154297 L46.33125,64.3154297 L46.33125,38.0941406 L46.33125,72 L27.7625977,72 L27.7625977,24.6884766 Z" id="Path-38" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round"></path>
                <path d="M19,18.453125 L27.8634766,24.8779297 L27.7625977,72 L9.87363281,72 L9.87363281,39.15 L9.87363281,65.6138672 L2.4,65.6138672 C1.0745166,65.6138672 4.28275503e-15,64.5393506 0,63.2138672 L0,30.9913636 C7.8397766e-16,30.1404998 0.45050783,29.3532398 1.18409254,28.9221683 L19,18.453125 L19,18.453125 Z" id="Path-37" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round"></path>
                <polygon id="Path-41" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round" points="27.8566406 23.9682617 30.6888672 29.0512695 36.7201172 19.2314453 36.7201172 14"></polygon>
                <polygon id="Path-41" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round" transform="translate(23.431738, 21.525635) scale(-1, 1) translate(-23.431738, -21.525635) " points="19 23.9682617 21.8322266 29.0512695 27.8634766 19.2314453 27.8634766 14"></polygon>
                <line x1="33.5" y1="38.2202148" x2="41.6535156" y2="38.2202148" id="Path-40" stroke="#000829" stroke-width="2" stroke-linecap="round"></line>
              </g>
              <g id="Group-7" stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(11.894531, 0.000000)">
                <path d="M15.0597656,21.2768555 C23.5910156,25.1739258 32.1222656,25.1739258 40.6535156,21.2768555 C39.1527344,24.0766602 34.8871094,30.4833984 27.8566406,40.4970703 L15.0597656,21.2768555 Z" id="Path-39" fill="#000829"></path>
                <path d="M1.85039063,31.1337891 L1.85039063,28.6623047 L23.0929688,15.7207031 L23.0929688,11.4199219 L32.4292969,11.4199219 L32.4292969,15.7207031 L53.6748047,28.6623047 L53.6748047,31.1337891 L30.4161715,19.6647508 C28.7432874,18.8398368 26.7819079,18.8398368 25.1090238,19.6647508 L1.85039063,31.1337891 L1.85039063,31.1337891 Z" id="Path-35" stroke="#000829" stroke-width="2" fill="#79C7FF" stroke-linejoin="round"></path>
                <path d="M25,4.35 L25,3.27275391 C25,1.46526183 26.4652618,3.32030907e-16 28.2727539,0 C30.080246,-3.32030907e-16 31.5455078,1.46526183 31.5455078,3.27275391 L31.5455078,4.35 L31.5455078,4.35 L29.1145761,7.47750432 C28.5689571,8.17946798 28.2727539,9.04320354 28.2727539,9.9322778 L28.2727539,11.4199219 L28.2727539,11.4199219" id="Path-36" stroke="#000829" stroke-width="2"></path>
                <path d="M26.5898437,38.2202148 L41.4455566,21.2768555 L54.6900624,28.029054 C55.4939223,28.4388709 56,29.264925 56,30.1672224 L56,41.0453613 C56,42.3708447 54.9254834,43.4453613 53.6,43.4453613 L50.0262176,43.4453613 C49.030854,43.4453613 48.1387914,42.8309623 47.7839258,41.9010058 L46.33125,38.0941406 L46.33125,38.0941406 L46.33125,65.6138672 L41.479541,65.6138672" id="Path-38" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round"></path>
                <path d="M14.2400391,21.2768555 L33.9043168,43.8992112 C39.0289954,49.7947902 41.8511719,57.3433442 41.8511719,65.1548858 L41.8511719,65.6138672 L41.8511719,65.6138672 L9.87363281,65.6138672 L9.87363281,39.15 L7.89888732,42.3156168 C7.46052933,43.0183268 6.69083014,43.4453613 5.86260367,43.4453613 L2.4,43.4453613 C1.0745166,43.4453613 -1.88048547e-15,42.3708447 -4.26325641e-15,41.0453613 L-4.26325641e-15,30.9935836 C-4.36760332e-15,30.1415265 0.451762068,29.3533488 1.18697634,28.9226965 L14.2400391,21.2768555 L14.2400391,21.2768555 Z" id="Path-37" stroke="#000829" stroke-width="2" fill="#DFF6FF" stroke-linejoin="round"></path>
              </g>
            </g>
          </svg>
        </button>
        <!-- Container for articles of the third category -->
        <div id="articles3" class="articles-container"></div>
        <div id="text3" class="text-blue-950 hidden mb-6 w-96 pl-4 .category-text">Choose <strong> the High-Quality </strong> service if you need personalized care, enhanced stain removal, meticulous ironing, or treatment for branded garments or specific materials/details. Otherwise, opt for <strong> Careful service:</strong> items are carefully washed and hand-ironed by our experts.
        </div>

        <button class="py-2 rounded-full flex items-center justify-center w-96 mb-5 bg-blue-500 text-white text-base font-bold shadow hover:bg-blue-800 focus:outline focus:bg-blue-600 transition duration-300">
          Have a Comment ?
        </button>
        <button class="py-2 rounded-full flex items-center justify-center w-96 bg-white border-2 border-blue-400 text-blue-500 text-base font-bold  hover:bg-blue-100 focus:outline focus:bg-blue-100 transition duration-300" style="margin-bottom: 12rem;">
          Frequently Asked Questions
        </button>

      </div>
      <!--  div for Articles options for categories -->
      <div id="articles" class="articles-section flex flex-col" style="">
        <!-- Articles -->
        <p id="default-message">Please select a category to see available options</p>

      </div>
    </div>
  </main>


  <div class="fixed bottom-0 left-0 w-full flex justify-between items-center" style="background-color:#000829;">
    <!-- Address and Time -->
    <div class="flex items-center p-3">
      <div class="text-white">
        <p class="mb-2"><i class='bx bx-map' style="padding-right:6px;"></i><?php echo $_SESSION['address']; ?></p>
        <p><i class='bx bxs-calendar' style='color:#ffffff ;padding-right:6px;'></i><?php echo $_SESSION['pickupDate'] . " - " . $_SESSION['deliveryDate']; ?></p>
      </div>
    </div>

    <!-- Articles and Total -->
    <div class="hidden md:flex flex-col text-center text-white p- ml-auto">
      <p class="mb-2 text-xl">Articles</p>
      <p class="text-2xl font-bold">Total</p>
    </div>

    <!-- Quantity and Currency -->
    <div class="hidden md:flex items-center text-white p-1 ml-auto">
      <div class="text-white">
        <!-- number of articles selected  -->
        <p class="mb-2 text-xl font-bold" id="cart-quantity">0</p>
        <!-- total price  -->
        <p class="text-xl font-bold" id="cart-total">0.00 DH</p>
      </div>
    </div>

    <!-- Cart Button -->
    <div class="text-white px-4">
      <button id="cart-button" onclick="displaySelectedArticlesInModal()" data-modal-target="default-modal" data-modal-toggle="default-modal" class="bg-white hover:bg-gray-100 font-bold text-xl py-3 rounded-full w-40" style="color:#000829;">
        My Cart <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class=" css-14yq2cq" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
          <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path>
        </svg>
      </button>
    </div>
  </div>





  <!-- Main Modal -->
  <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 z-50 w-96 h-full rounded-lg shadow " style="background-color:#DDF6FF;">
    <!-- Close Button -->
    <button id="clos-btn" type="button" class="z-50 absolute top-4 right-5 text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-full w-12 h-12 flex items-center justify-center" data-modal-hide="default-modal">
      <svg fill="#5d5c60" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.77 460.77" xml:space="preserve" stroke="#5d5c60" stroke-width="11.058599999999998">
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
          <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"></path>
        </g>
      </svg>
      <span class="sr-only">Close modal</span>
    </button>
    <div class="p-1">
      <div class=" absolute top-6  left-5 ">
        <div class="text-2xl text-blue-900 font-extrabold ">Your Choices</div>

        <div class="mb-8">
          <p class="mt-4 mb-1 text-blue-900 text-base font-normal"><i class='bx bxs-map' style="padding-right:7px;"></i><?php echo $_SESSION['address']; ?></p>
          <p class="text-blue-900 text-base font-normal"><i class='bx bx-calendar' style="padding-right:7px;;"></i><?php echo $_SESSION['pickupDate'] . " - " . $_SESSION['deliveryDate']; ?></p>
        </div>
        <hr class="h-px w-80 my-2 bg-gray-300 border-0 ">
        <div id="modal-content"></div>

        <hr class=" my-2 w-80 bg-gray-300 border-0" style="height:1.5px;">

        <div class="flex justify-between text-lg font-bold text-blue-900" style="margin-top:5rem;">
          <span>Delivery Cost</span>
          <span>Free</span>

        </div>
        <div class="flex justify-between mt-4 text-lg font-bold text-blue-900">
          <span>Total</span>
          <span id="modal-total">0.00 DH</span>

        </div>
        <div class="flex justify-center mb-10" style="margin-top:1rem;">
          <!-- finish the order  -->
          <form id="order-form" action="save_order.php" method="post">
            <input type="hidden" name="cart" id="cart-input">
            <input type="hidden" name="total" id="total-input">
            <button type="submit" class="font-bold text-white bg-[#050708] hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 rounded-full text-xl px-8 py-2.5 text-center inline-flex items-center dark:focus:ring-[#050708]/50 dark:hover:bg-[#050708]/30 me-2 mb-2">
              <span class="font-mono mr-2">Finish the order </span>
              <svg width="30px" height="30px" viewBox="0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" stroke="#000000">
                <g class="pr-8" id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                  <style type="text/css">
                    .st0 {
                      fill: #ffffff;
                    }

                    .st1 {
                      fill: #2B79C2;
                    }
                  </style>
                  <g>
                    <circle class="st0" cx="229.7" cy="111.9" r="72.4"></circle>
                    <polygon class="st1" points="238.5,359.9 279.2,338.8 279.2,251.3 279.2,241.8 279.2,218.3 264.3,218.3 264.3,263.2 195.1,263.2 195.1,218.3 153.2,218.3 152.5,219.8 152.5,472.5 208.5,472.5 208.5,423.2 238.5,423.2 "></polygon>
                    <path class="st0" d="M45.2,287.5l-18.4,37.1l82.4,38.5c9.1,4.2,19.9,0.4,24.2-8.6l5-10.3v-95.3L106.5,315L45.2,287.5z"></path>
                    <polygon class="st0" points="414.5,227.8 414.5,192.9 293.2,192.9 293.2,227.8 368.8,227.8 368.8,255.7 353.8,253.2 306.9,260.9 293.2,263.2 293.2,347.3 252.5,368.4 252.5,423.2 455.2,423.2 455.2,368.4 414.5,347.3 414.5,263.2 398.7,260.6 398.7,227.8 "></polygon>
                    <polygon class="st0" points="469.2,437.2 252.5,437.2 222.5,437.2 222.5,472.5 485.2,472.5 485.2,437.2 "></polygon>
                  </g>
                </g>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>

  </div>


  </div>



  </div>
  <!--Scripts -->
  <script>

    
    // Define articles and currentCategory variables
    const articles = <?php echo json_encode($articles); ?>;
    let currentCategory = '';

    // Define cart array to store selected articles with their quantities
    let cart = [];




    // Function to calculate the total based on the cart items
function calculateTotal() {
  let total = 0;
  cart.forEach(item => {
    total += item.quantity * item.article.price;
  });
  return total.toFixed(2); // Assuming you want to keep two decimal places
}
    // Get the form element
    const orderForm = document.getElementById('order-form');

    // Add event listener to the form submission
    orderForm.addEventListener('submit', function(event) {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Calculate the total
      const total = calculateTotal();

      // Update hidden input fields with cart data and total
      document.getElementById('cart-input').value = JSON.stringify(cart);
      document.getElementById('total-input').value = total;

      // Submit the form
      orderForm.submit();
    });



    function updateModal() {
      const modalContent = document.getElementById('modal-content');
      modalContent.innerHTML = ''; // Clear previous content
      if (cart.length === 0) {
        const emptyMessage = document.createElement('div');
        emptyMessage.className = ' text-base font-normal my-4';
        emptyMessage.textContent = 'Please select a category to see available options';
        modalContent.appendChild(emptyMessage);
      } else {
        cart.forEach(cartItem => {
          const articleElement = document.createElement('div');
          articleElement.className = 'w-80 border-2 rounded-full flex items-center my-4 py-4 h-12';
          articleElement.style.borderColor = 'rgb(186, 226, 250)';

          articleElement.innerHTML = `
        <span class="text-blue-400 font-bold" style="padding-left:20px;">x${cartItem.quantity}</span>
        <div class="text-blue-900 text-sm font-normal flex-grow overflow-hidden whitespace-nowrap" style="padding-left:20px; text-overflow: ellipsis;">${cartItem.article.article_name}</div>
        <div class="flex-shrink-0 flex items-center" style="margin-left:auto;">
          <span style="padding-left:0.5rem;padding-right:1rem;">
            <svg class="cursor-pointer delete-svg"  onclick='deleteFromCart(${JSON.stringify(cartItem.article)})' width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z" fill="#fa0000"></path>
              <path opacity="0.5" d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z" fill="#fa0000"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z" fill="#fa0000"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z" fill="#fa0000"></path>
            </svg>
          </span>
        </div>
      `;

          modalContent.appendChild(articleElement);
        });
      }
    }

    function updateMainPage() {
      const articlesContainer = document.getElementById('articles');
      const defaultMessage = document.getElementById('default-message');

      if (currentCategory === '') {
        articlesContainer.innerHTML = '';
        if (defaultMessage) {
          defaultMessage.style.display = 'block';
        }
        return;
      }

      const filteredArticles = articles.filter(article => article.category === currentCategory);
      articlesContainer.innerHTML = '';

      if (defaultMessage) {
        defaultMessage.style.display = 'none';
      }

      if (filteredArticles.length > 0) {
        filteredArticles.forEach(article => {
          const articleElement = document.createElement('div');
          articleElement.className = 'w-96 border-2 rounded-full py-2 flex items-center mb-4';
          articleElement.style.borderColor = '#BAE2FA';

          const buttonElement = document.createElement('button');
          buttonElement.className = 'rounded-full mx-2 p-2 w-10';
          buttonElement.style.backgroundColor = '#BAE2FA';
          buttonElement.innerHTML = `<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12H20M12 4V20" stroke="#4b8dd2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>`;

          const deleteButtonElement = document.createElement('div');
          deleteButtonElement.className = 'ml-auto';
          deleteButtonElement.innerHTML = `<button class="rounded-full p-2 w-10 h-10 mr-3 border-2 border-red-600 hidden" style="background-color: white;"><svg width="24px" height="24px" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12L18 12" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>`;
          const deleteButton = deleteButtonElement.querySelector('button');

          const priceElement = document.createElement('div');
          priceElement.className = 'w-30 text-right';
          priceElement.innerHTML = `<span class="text-lg font-extrabold ">${article.price} DH</span>`;

          const cartItem = cart.find(item => item.article.article_name === article.article_name);
          if (cartItem) {
            buttonElement.textContent = "x" + cartItem.quantity;
            buttonElement.style.color = '#2593E5';
            buttonElement.style.fontWeight = 'bold';
            buttonElement.style.fontSize = '16px';
            deleteButton.classList.remove('hidden');
            priceElement.innerHTML = `<span class="text-lg font-extrabold ">${(article.price * cartItem.quantity).toFixed(2)} DH</span>`; // Update the price
          }

          // Add click event listener to add the article to the cart
          buttonElement.addEventListener('click', () => addToCart(article, buttonElement, deleteButton, priceElement));
          // Add click event listener to remove the article from the cart
          deleteButton.addEventListener('click', () => removeFromCart(article, buttonElement, deleteButton, priceElement));

          articleElement.appendChild(buttonElement);

          const infoElement = document.createElement('div');
          infoElement.className = 'ml-2 w-40';
          infoElement.innerHTML = `<h3 class="text-sm font-bold" style="color:#4DA7EA;">${article.article_name}</h3><div class="text-blue-900 mt-1 text-xs">${article.description}</div>`;
          articleElement.appendChild(infoElement);

          articleElement.appendChild(priceElement);

          articleElement.appendChild(deleteButtonElement);

          articlesContainer.appendChild(articleElement);
        });
      } else {
        articlesContainer.innerHTML = 'No results found for this category.';
      }

    }


    function displayArticles(category) {
      const articlesContainer = document.getElementById('articles');
      const defaultMessage = document.getElementById('default-message');

      if (currentCategory === category) {
        articlesContainer.innerHTML = '';

        if (defaultMessage) {
          defaultMessage.style.display = 'block';
        }
        currentCategory = '';
        return;
      }

      currentCategory = category;
      articlesContainer.innerHTML = '';
      if (defaultMessage) {
        defaultMessage.style.display = 'none';
      }

      const filteredArticles = articles.filter(article => article.category === category);

      if (filteredArticles.length > 0) {
        filteredArticles.forEach(article => {
          const articleElement = document.createElement('div');
          articleElement.className = 'w-96 border-2 rounded-full py-2 flex items-center mb-4';
          articleElement.style.borderColor = '#BAE2FA';

          const buttonElement = document.createElement('button');
          buttonElement.className = 'rounded-full mx-2 p-2 w-10';
          buttonElement.style.backgroundColor = '#BAE2FA';
          buttonElement.innerHTML = `<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12H20M12 4V20" stroke="#4b8dd2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>`;

          const deleteButtonElement = document.createElement('div');
          deleteButtonElement.className = 'ml-auto';
          deleteButtonElement.innerHTML = `<button class="rounded-full p-2 w-10 h-10 mr-3 border-2 border-red-600 hidden" style="background-color: white;"><svg width="24px" height="24px" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12L18 12" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>`;
          const deleteButton = deleteButtonElement.querySelector('button');

          const priceElement = document.createElement('div');
          priceElement.className = 'w-30 text-right';
          priceElement.innerHTML = `<span class="text-lg font-extrabold ">${article.price} DH</span>`;
          articleElement.appendChild(priceElement);

          const cartItem = cart.find(item => item.article.article_name === article.article_name);
          if (cartItem) {
            buttonElement.textContent = "x" + cartItem.quantity;
            buttonElement.style.color = '#2593E5';
            buttonElement.style.fontWeight = 'bold';
            buttonElement.style.fontSize = '16px';
            deleteButton.classList.remove('hidden');
            priceElement.innerHTML = `<span class="text-lg font-extrabold ">${(article.price * cartItem.quantity).toFixed(2)} DH</span>`; // Update the price
          }

          // Add click event listener to add the article to the cart
          buttonElement.addEventListener('click', () => addToCart(article, buttonElement, deleteButton, priceElement));
          // Add click event listener to remove the article from the cart
          deleteButton.addEventListener('click', () => removeFromCart(article, buttonElement, deleteButton, priceElement));

          articleElement.appendChild(buttonElement);

          const infoElement = document.createElement('div');
          infoElement.className = 'ml-2 w-40';
          infoElement.innerHTML = `<h3 class="text-sm font-bold" style="color:#4DA7EA;">${article.article_name}</h3><div class="text-blue-900 mt-1 text-xs">${article.description}</div>`;
          articleElement.appendChild(infoElement);

          articleElement.appendChild(priceElement);

          articleElement.appendChild(deleteButtonElement);

          articlesContainer.appendChild(articleElement);
        });
      } else {
        articlesContainer.innerHTML = 'No results found for this category.';
      }
    }



    function displaySelectedArticlesInModal() {
      const modalContent = document.getElementById('modal-content');
      modalContent.innerHTML = ''; // Clear previous content

      if (cart.length === 0) {
        // If the cart is empty, display a message
        const emptyMessage = document.createElement('div');
        emptyMessage.className = 'text-blue-900  text-base font-normal my-4';
        emptyMessage.textContent = 'Please select a category to see available options';
        modalContent.appendChild(emptyMessage);
      } else {
        cart.forEach(cartItem => {
          // Create the article element
          const articleElement = document.createElement('div');
          articleElement.className = 'w-80 border-2 rounded-full flex items-center my-4 py-4 h-12';
          articleElement.style.borderColor = 'rgb(186, 226, 250)';

          // Add quantity and article name
          articleElement.innerHTML = `
        <span class="text-blue-400 font-bold" style="padding-left:20px;">x${cartItem.quantity}</span>
        <div class="text-blue-900 text-sm font-normal flex-grow overflow-hidden whitespace-nowrap" style="padding-left:20px; text-overflow: ellipsis;">${cartItem.article.article_name}</div>
        <div class="flex-shrink-0 flex items-center" style="margin-left:auto;">
         
          <span style="padding-left:0.5rem; padding-right:1rem;">
            <svg class="cursor-pointer" onclick='deleteFromCart(${JSON.stringify(cartItem.article)}, this, this.nextElementSibling, this.parentElement.nextElementSibling)' width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z" fill="#fa0000"></path>
              <path opacity="0.5" d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z" fill="#fa0000"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z" fill="#fa0000"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z" fill="#fa0000"></path>
            </svg>
          </span>
        </div>
      `;

          // Append the article element to the modal content
          modalContent.appendChild(articleElement);
        });

        // Update the total cost
        const total = cart.reduce((sum, item) => sum + item.article.price * item.quantity, 0).toFixed(2);
        document.getElementById('modal-total').textContent = `${total} DH`;
        document.getElementById('modal-total').classList = `mb-8 text-blue-400 font-extrabold`;

      }
    }


    document.addEventListener('DOMContentLoaded', () => {
      const modalButton = document.getElementById('cart-button');
      const modal = document.getElementById('default-modal');
      const closeButton = document.getElementById('clos-btn');

      modalButton.addEventListener('click', () => {
        modal.classList.add('modal-open');
        modal.classList.remove('modal-close'); // Ensure modal-close class is removed
      });

      closeButton.addEventListener('click', () => {
        modal.classList.remove('modal-open'); // Remove modal-open class immediately
        modal.classList.add('modal-close');

        modal.addEventListener('animationend', () => {
          modal.classList.remove('modal-close');
        }, {
          once: true
        });
      });
    });



    // Function to update the cart total and number of articles selected
    function updateCartInfo() {
      const cartTotalElement = document.getElementById('cart-total');
      const quantityElement = document.getElementById('cart-quantity');

      // Calculate total price
      const totalPrice = cart.reduce((total, item) => total + parseFloat(item.article.price) * item.quantity, 0);

      // Update total price and number of articles selected
      cartTotalElement.textContent = totalPrice.toFixed(2) + ' DH';
      quantityElement.textContent = cart.reduce((total, item) => total + item.quantity, 0);

      // Ensure correct delete button visibility for all cart items
      document.querySelectorAll('#articles .ml-auto button').forEach(button => {
        const articleName = button.closest('.w-96').querySelector('h3').textContent;
        const cartItem = cart.find(item => item.article.article_name === articleName);
        if (cartItem) {
          button.classList.remove('hidden');
        } else {
          button.classList.add('hidden');
        }
      });
    }

    // Function to add an article to the cart
    function addToCart(article, buttonElement, deleteButtonElement, priceElement) {
      const cartItem = cart.find(item => item.article.article_name === article.article_name);
      if (cartItem) {
        cartItem.quantity += 1;
      } else {
        cart.push({
          article: article,
          quantity: 1
        });
      }
      updateCartInfo();

      const updatedCartItem = cart.find(item => item.article.article_name === article.article_name);
      buttonElement.textContent = "x" + updatedCartItem.quantity;
      buttonElement.style.color = '#2593E5';
      buttonElement.style.fontWeight = 'bold';
      buttonElement.style.fontSize = '16px';
      deleteButtonElement.classList.remove('hidden'); // Show the remove button
      priceElement.innerHTML = `<span class="text-lg font-extrabold text-blue-400">${(article.price * updatedCartItem.quantity).toFixed(2)} DH</span>`; // Update the price
    }

    // Function to remove an article from the cart
    function removeFromCart(article, buttonElement, deleteButtonElement, priceElement) {
      const cartItem = cart.find(item => item.article.article_name === article.article_name);
      if (cartItem) {
        cartItem.quantity -= 1;
        if (cartItem.quantity === 0) {
          cart = cart.filter(item => item.article.article_name !== article.article_name);
          buttonElement.innerHTML = `<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12H20M12 4V20" stroke="#4b8dd2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>`;
          deleteButtonElement.classList.add('hidden'); // Hide the remove button if the article is no longer in the cart
          priceElement.innerHTML = `<span class="text-lg font-extrabold ">${article.price} DH</span>`; // Reset the price to the original value
        } else {
          buttonElement.textContent = "x" + cartItem.quantity;
          priceElement.innerHTML = `<span class="text-lg font-extrabold text-blue-400">${(article.price * cartItem.quantity).toFixed(2)} DH</span>`; // Update the price
        }
      }
      updateCartInfo();
    }
    // Function to delete an article from the cart
    function deleteFromCart(article) {
      // Find the index of the article in the cart
      const articleIndex = cart.findIndex(cartItem => cartItem.article.article_name === article.article_name);

      // Remove the article from the cart if it exists
      if (articleIndex !== -1) {
        cart.splice(articleIndex, 1);
      }

      // Update the modal content and the main page content
      updateModal();
      updateMainPage();
      updateCartInfo();
      const total = cart.reduce((sum, item) => sum + item.article.price * item.quantity, 0).toFixed(2);
      document.getElementById('modal-total').textContent = `${total} DH`;
      document.getElementById('modal-total').classList = `text-blue-400 font-extrabold`;
      if (cart.length === 0) {
        document.getElementById('modal-total').classList = ` font-bold text-blue-900`;
      }

    }

    // Function to display articles of a category
    function displayArticles(textId, category) {
      var textElement = document.getElementById(textId);
      
      // Determine if we're on mobile (< 1024px)
      const isMobile = window.innerWidth < 1024;

      // Get the appropriate container based on screen size
      let articlesContainer;
      if (isMobile) {
        // On mobile, display articles in the category-specific container
        if (textId === 'text1') articlesContainer = document.getElementById('articles1');
        else if (textId === 'text2') articlesContainer = document.getElementById('articles2');
        else if (textId === 'text3') articlesContainer = document.getElementById('articles3');
      } else {
        // On desktop, use the main articles section
        articlesContainer = document.getElementById('articles');
      }
      
      const defaultMessage = document.getElementById('default-message');

      // Check if this category is currently selected
      if (currentCategory === category) {
        // Toggle off - clear articles and hide description
        articlesContainer.innerHTML = '';
        textElement.classList.add('hidden');

        if (defaultMessage && !isMobile) {
          defaultMessage.style.display = 'block';
        }
        
        // Clear all category containers and descriptions
        document.getElementById('articles1').innerHTML = '';
        document.getElementById('articles2').innerHTML = '';
        document.getElementById('articles3').innerHTML = '';
        document.getElementById('text1').classList.add('hidden');
        document.getElementById('text2').classList.add('hidden');
        document.getElementById('text3').classList.add('hidden');
        
        currentCategory = '';
        return;
      }

      // Switching to a new category - First hide all other categories
      // Hide all descriptions
      document.getElementById('text1').classList.add('hidden');
      document.getElementById('text2').classList.add('hidden');
      document.getElementById('text3').classList.add('hidden');
      
      // Clear all articles containers
      document.getElementById('articles1').innerHTML = '';
      document.getElementById('articles2').innerHTML = '';
      document.getElementById('articles3').innerHTML = '';
      
      // Now show the new category
      currentCategory = category;
      textElement.classList.remove('hidden');
      
      // Clear the articles container
      articlesContainer.innerHTML = '';
      
      if (defaultMessage && !isMobile) {
        defaultMessage.style.display = 'none';
      }

      const filteredArticles = articles.filter(article => article.category === category);

      if (filteredArticles.length > 0) {
        filteredArticles.forEach(article => {
          const articleElement = document.createElement('div');
          articleElement.className = 'w-96 border-2 rounded-full py-2 flex items-center mb-4';
          articleElement.style.borderColor = '#BAE2FA';

          const buttonElement = document.createElement('button');
          buttonElement.className = 'rounded-full mx-2 p-2 w-10';
          buttonElement.style.backgroundColor = '#BAE2FA';
          buttonElement.innerHTML = `<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12H20M12 4V20" stroke="#4b8dd2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>`;

          const deleteButtonElement = document.createElement('div');
          deleteButtonElement.className = 'ml-auto';
          deleteButtonElement.innerHTML = `<button class="rounded-full p-2 w-10 h-10 mr-3 border-2 border-red-600 hidden" style="background-color: white;"><svg width="24px" height="24px" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12L18 12" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>`;
          const deleteButton = deleteButtonElement.querySelector('button');

          const priceElement = document.createElement('div');
          priceElement.className = 'w-30 text-right';
          priceElement.innerHTML = `<span class="text-lg font-extrabold ">${article.price} DH</span>`;
          articleElement.appendChild(priceElement);

          const cartItem = cart.find(item => item.article.article_name === article.article_name);
          if (cartItem) {
            buttonElement.textContent = "x" + cartItem.quantity;
            buttonElement.style.color = '#2593E5';
            buttonElement.style.fontWeight = 'bold';
            buttonElement.style.fontSize = '16px';
            deleteButton.classList.remove('hidden');
            priceElement.innerHTML = `<span class="text-lg font-extrabold ">${(article.price * cartItem.quantity).toFixed(2)} DH</span>`; // Update the price
          }

          // Add click event listener to add the article to the cart
          buttonElement.addEventListener('click', () => addToCart(article, buttonElement, deleteButton, priceElement));
          // Add click event listener to remove the article from the cart
          deleteButton.addEventListener('click', () => removeFromCart(article, buttonElement, deleteButton, priceElement));

          articleElement.appendChild(buttonElement);

          const infoElement = document.createElement('div');
          infoElement.className = 'ml-2 w-40';
          infoElement.innerHTML = `<h3 class="text-sm font-bold" style="color:#4DA7EA;">${article.article_name}</h3><div class="text-blue-900 mt-1 text-xs">${article.description}</div>`;
          articleElement.appendChild(infoElement);

          articleElement.appendChild(priceElement);

          articleElement.appendChild(deleteButtonElement);

          articlesContainer.appendChild(articleElement);
        });
      } else {
        articlesContainer.innerHTML = 'No results found for this category.';
      }
    }

    // Function to toggle the mobile menu
    function Menu(e) {
      let list = document.querySelector('ul');
      e.name === 'menu' ? (e.name = "close", list.classList.add('top-[80px]'), list.classList.add('opacity-100'), list.classList.add('menu-open')) : (e.name = "menu", list.classList.remove('top-[80px]'), list.classList.remove('opacity-100'), list.classList.remove('menu-open'))
    }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

</body>

</html>