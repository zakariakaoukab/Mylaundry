<?php
// client side
session_start();
if(!isset($_SESSION['authenticated'])){
  $_SESSION['status'] = "Please login to access our services!";
  header("Location: signin.php");
  exit();
}

if(isset($_SESSION['auth_user']['role']) && $_SESSION['auth_user']['role'] === 'admin') {
  $_SESSION['status'] = "Not Allowed";
  header("Location: signin.php");
} else {
 // Admin is authenticated, allow access
 $role = $_SESSION['auth_user']['role'];

}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Sign Up</title>
  
  </head>
  <body class="h-full bg-gray-100" >
    <!--header-->
    <nav class="p-5 bg-white shadow md:flex md:items-center md:justify-between relative z-10">
      <div class="flex justify-between items-center ">
      <div class="flex items-end justify-center text-2xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            class="w-6 h-6 text-indigo-600 fill-current">
                            <path
                                d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.4267 20 20 16.4267 20 12C20 7.57333 16.4267 4 12 4C7.57333 4 4 7.57333 4 12C4 16.4267 7.57333 20 12 20ZM12 18C8.68 18 6 15.32 6 12C6 8.68 8.68 6 12 6C15.32 6 18 8.68 18 12C18 15.32 15.32 18 12 18ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10Z">
                            </path>
                        </svg>
                        My<span class="text-indigo-600">Laundry</span>
                    </div>
  
        <span class="text-3xl cursor-pointer mx-2 md:hidden block">
          <ion-icon name="menu" onclick="Menu(this)"></ion-icon>
        </span>
      </div>
  
      <ul id="navMenu" class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-white w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500">

        <li class="mx-4 my-6 md:my-0">
          <a href="home.php" class="text-xl hover:text-cyan-500 duration-500">Question?</a>
        </li>
        <li class="mx-4 my-6 md:my-0">
          <a href="logout.php" class="text-xl hover:text-cyan-500 duration-500">Logout</a>
        </li>
        <button class="bg-cyan-400 text-white font-[Poppins] duration-500 px-6 py-2 mx-4 hover:bg-cyan-500 rounded ">
          Sign in
        </button>
      </ul>
    </nav>



    <!-- Main -->
    
     <!-- footer-->






     
     <!-- Script -->
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