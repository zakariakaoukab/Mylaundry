<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css">
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <title>Login</title>
  <style>
    #style-4::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      background-color: #F5F5F5;
    }

    #style-4::-webkit-scrollbar {
      width: 7px;
      background-color: #000829;
    }

    #style-4::-webkit-scrollbar-thumb {
      background-color: #000829;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    .wrapper {
      min-height: 100%;
      background: linear-gradient(to top, #E8F8FF, #FFFFFF);
    }
    .relative {
      position: relative;
    }



    .inset-y-0 {
      top: 20px;
      bottom: 0;
    }

    .right-0 {
      right: 0;
    }

    .pr-10 {
      padding-right: 2.5rem;
    }

    .pr-3 {
      padding-right: 0.75rem;
    }

    .flex {
      display: flex;
    }

    .items-center {
      align-items: center;
    }
  </style>
</head>

<body class="h-full" id="style-4">
  <div class="wrapper">

    <nav class="p-5 bg-white shadow md:flex md:items-center md:justify-between ">
      <div class="flex justify-between items-center ">
        <div class="flex items-end justify-center text-2xl font-bold">
          <svg class="mx-2" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="26px" height="26px" fill="#000000">
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
          My<span style="color:#559BF7;">laundry</span>
        </div>

        <span class="text-3xl cursor-pointer mx-2 md:hidden block">
          <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
        </span>
      </div>

      <ul class="md:flex md:items-center z-10 md:z-auto md:static absolute bg-white w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">

        <li class="mx-4 my-6 md:my-0">
          <a href="home.php" class="text-base hover:text-cyan-500 duration-500">Question?</a>
        </li>

        <a href="signup.php">
        <button  class="bg-cyan-400 text-white font-[Poppins] duration-500 px-6 py-2 mx-4 hover:bg-cyan-500 rounded ">
          Sign Up
        </button>
        </a>
      </ul>
    </nav>

    <!-- Main -->

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

      <?php if (isset($_SESSION['status']) && !empty($_SESSION['status'])) : ?>
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-4" role="alert">
          <div class="flex">
            <div class="py-1">
              <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
              </svg>
            </div>
            <div>
              <p class="font-bold"><?php echo $_SESSION['status']; ?></p>
              <?php unset($_SESSION['status']);
              ?>
            </div>
          </div>
        </div>
      <?php endif; ?>


      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-3xl font-bold leading-9 tracking-tight text-gray-900 ">Sign in to your Account</h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="login.php" method="POST">
          <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" type="email" autocomplete="email" required class=" block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Enter your email">
            </div>
          </div>



          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
              <div class="text-sm">
                <a href="reset-password.php" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
              </div>
            </div>
            <div class="relative mt-2 h-4">
  <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Enter your password">
  <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility()">
    <svg id="eye-icon" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
      <g id="SVGRepo_iconCarrier">
        <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      </g>
    </svg>
  </span>
</div>

          </div>

          <div>
            <button type="submit" name="login" style="margin-top:4rem;" class=" flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
          </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
          don't have an account yet?
          <a href="signup.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign Up</a>
        </p>
      </div>
    </div>


  </div>

  <!-- footer -->
<footer class="bg-gray-800 text-white py-10" id="footer">
  <div class="container mx-auto px-4 " style="padding-top:4rem; padding-bottom:1rem;">
    <div class="flex flex-wrap justify-center">
      <div class="w-full lg:w-5/12 md:w-full sm:w-full px-4 mb-8">
        <div class="widget-footer">
          <h4 class="text-xl font-semibold mb-4 text-center">Contact info</h4>
          <div class="adress-info mb-4">
            <div class="flex items-start mb-4 justify-center">
              <div class="w-4 h-6 mr-4"> 
                <img src="../assets/images/marker-icon_white.png" alt="address-info" class="w-full h-full object-contain" />    
              </div>
              <div>
                <span class="block font-semibold">Location Info</span>
                <h5 class="text-lg">Quartier Agdal, Av 12 , R113</h5>
              </div>
            </div>
          </div>
          <div class="phone-info mb-4">
            <div class="flex items-start mb-4 justify-center">
              <div class="w-6 h-6 mr-4"> 
                <img src="../assets/images/call-icon_white.png" alt="phone-info" class="w-full h-full object-contain" /> 
              </div>
              <div>
                <span class="block font-semibold">Have a question? Call us now</span>
                <h4 class="text-xl">0694-828963</h4>
              </div>
            </div>
          </div>
          <div class="hours-info">
            <div class="flex items-start justify-center">
              <div class="w-6 h-6 mr-4"> 
                <img src="../assets/images/clock-icon_white.png" alt="hours-info" class="w-full h-full object-contain" />
              </div>
              <div>
                <span class="block font-semibold">We are open Monday - Friday</span>
                <h5 class="text-lg">08:00 - 17:00</h5>
              </div>
            </div>
          </div>     
        </div>   
      </div>
      <!-- Services widget -->
      <div class="w-full lg:w-3/12 md:w-4/12 sm:w-full px-4 mb-8">
        <div class="widget-footer text-center">
          <h4 class="text-xl font-semibold mb-4">Services</h4>
          <ul class="space-y-2">
            <li><a href="#services" class="text-white hover:underline">Laundry Services</a></li>
            <li><a href="#services" class="text-white hover:underline">Dry Cleaning</a></li>
            <li><a href="#services" class="text-white hover:underline">Carpet Cleaning</a></li>
            <li><a href="#services" class="text-white hover:underline">Shoes Cleaning</a></li>
            <li><a href="#services" class="text-white hover:underline">Ironing Only</a></li>
          </ul>
        </div>
      </div>
      <!-- Links widget -->
      <div class="w-full lg:w-3/12 md:w-4/12 sm:w-full px-4 mb-8">
        <div class="widget-footer text-center">
          <h4 class="text-xl font-semibold mb-4">Our Links</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-white hover:underline">Terms &amp; Conditions</a></li>
            <li><a href="#" class="text-white hover:underline">Cookies &amp; Privacy</a></li>
            <li><a href="#" class="text-white hover:underline">Contact Us</a></li>
            <li><a href="#" class="text-white hover:underline">Price Lists</a></li>
            <li><a href="#" class="text-white hover:underline">Faqs</a></li>
            <li><a href="#" class="text-white hover:underline">News</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footbar mt-8">
      <div class="flex flex-wrap justify-between items-center">
        <div class="w-full lg:w-8/12 md:w-full sm:w-full mb-4 lg:mb-0 text-center lg:text-left">
          <div class="social-media flex justify-center lg:justify-start space-x-4 ">
            <a href="#" class="p-2 mr-4 flex items-center justify-center border-2 border-white  text-gray-800 " style="border-radius: 30px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#1877F2';" onmouseout="this.style.backgroundColor='transparent';">
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

  <script>
    function Menu(e) {
      let list = document.querySelector('ul');
      e.name === 'menu' ? (e.name = "close", list.classList.add('top-[80px]'), list.classList.add('opacity-100')) : (e.name = "menu", list.classList.remove('top-[80px]'), list.classList.remove('opacity-100'))
    }
    function togglePasswordVisibility() {
  const passwordInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eye-icon');
  
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyeIcon.innerHTML = `
      <path d="M2 2L22 22" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
    `;
  } else {
    passwordInput.type = 'password';
    eyeIcon.innerHTML = `
      <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
    `;
  }
}

  </script>
</body>

</html>