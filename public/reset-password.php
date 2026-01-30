<?php
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Reset Password</title>
</head>
<body>

<nav class="p-5 bg-white shadow md:flex md:items-center md:justify-between relative z-10">
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
  
      <ul id="navMenu" class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-white w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">

        <li class="mx-4 my-6 md:my-0">
          <a href="home.php" class="text-base hover:text-cyan-500 duration-500">Question?</a>
        </li>
      
  
        <button class="bg-cyan-400 text-white font-[Poppins] duration-500 px-6 py-2 mx-4 hover:bg-cyan-500 rounded ">
          <a href="signin.php">
          Login
          </a>
        </button>
        
      </ul>
    </nav>


<!-- main-->

<?php if(isset($_SESSION['status']) && !empty($_SESSION['status'])): ?>
  <div class="mt-4 bg-orange-100 border-t-4 border-orange-300 rounded-b text-orange-800 px-4 py-3 shadow-md mx-auto max-w-md" role="alert">
  <div class="flex items-center">
    <div class="py-1"><svg class="fill-current h-6 w-6 <?php echo $text_color; ?> mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Reset Password Status :</p>
      <p class="text-sm"><?php echo $_SESSION['status']; ?></p>
      <?php unset($_SESSION['status']);?>
    </div>
  </div>
</div>

<?php endif; ?>







    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-xl shadow shadow-slate-300">
        <h1 class="text-4xl font-medium">Reset password</h1>
        <p class="text-slate-500">Fill up the form to reset the password</p>

        <form action="ResetPasswordBack.php" method="POST" class="my-10">
            <div class="flex flex-col space-y-5">
                <label for="email">
                    <p class="font-medium text-slate-700 pb-2">Email address</p>
                    <input id="email" name="email" type="email" class="w-full py-3 border border-slate-200 rounded-lg px-3 focus:outline-none focus:border-slate-500 hover:shadow" placeholder="Enter email address">
                </label>
               
                <button name="password_reset_link" class="w-full py-3 font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg border-indigo-500 hover:shadow inline-flex space-x-2 items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                      </svg>
                      
                      <span>Reset password</span>
                </button>
                <p class="text-center">Not registered yet? <a href="signup.php" class="text-indigo-600 font-medium inline-flex space-x-1 items-center"><span>Register now </span><span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg></span></a></p>
            </div>
        </form>
    </div>

    <script>
        /* Mobile menu opened - display horizontally */
        const style = document.createElement('style');
        style.textContent = `
          #navMenu.menu-open {
            flex-direction: row !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            padding: 0.5rem !important;
          }
          #navMenu.menu-open li {
            margin-bottom: 0 !important;
          }
        `;
        document.head.appendChild(style);

        function Menu(e){
          let list = document.querySelector('ul');
          e.name === 'menu' ? (e.name = "close",list.classList.add('top-[80px]') , list.classList.add('opacity-100'), list.classList.add('menu-open')) :( e.name = "menu" ,list.classList.remove('top-[80px]'),list.classList.remove('opacity-100'), list.classList.remove('menu-open'))
        }
      </script>

</body>
</html>