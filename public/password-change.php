<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="styles.css">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>
    <title>Change Password</title>
</head>
<body>
<section>
<?php
// Check if the status is set
if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    $color = "";
    // Set color based on status
    if (strpos($status, 'Password updated successfully') !== false) {
        $color = "bg-green-100";
        $border_color = "border-green-300";
        $text_color = "text-green-800";
    } else if (strpos($status, 'We sent you an email with a reset password link') !== false) {
        $color = "bg-orange-100";
        $border_color = "border-orange-300";
        $text_color = "text-orange-800";
    } else {
        $color = "bg-red-100";
        $border_color = "border-red-300";
        $text_color = "text-red-800";
    }
?>
<div class="mt-4 <?php echo $color; ?> border-t-4 <?php echo $border_color; ?> rounded-b <?php echo $text_color; ?> px-4 py-3 shadow-md mx-auto max-w-md" role="alert">
  <div class="flex items-center">
    <div class="py-1"><svg class="fill-current h-6 w-6 <?php echo $text_color; ?> mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Update Password Status :</p>
      <p class="text-sm"><?php echo $_SESSION['status']; ?></p>
    </div>
  </div>
</div>
<?php
// Unset the session variable after displaying the status
unset($_SESSION['status']);
}
?>
  <?php
// Check if $show_success_div is not set or is false
if (!isset($show_success_div) || !$show_success_div) {
?>
<main id="content" role="main" class="w-full h-screen max-w-md p-6 mx-auto">
    <div class="bg-white border shadow-lg mt-7 rounded-xl">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <div class="flex items-end justify-center mb-8 text-2xl font-bold">
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
                <h1 class="block text-2xl font-bold text-gray-800">Reset Password</h1>
            </div>

            <div class="mt-5">
                <form method="POST" action="ResetPasswordBack.php">
                    <div class="grid gap-y-4">
                    <input hidden type="text" id="token" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];}  ?>"  >
                    <div>
                            <label for="confirmn_new_password"
                                class="block mb-2 ml-1 text-xs font-semibold ">Email</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}  ?>"
                                    class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required 
                                    placeholder="Your Email.">
                            </div>
                        </div>

                        <div>
                            <label for="new_password" class="block mb-2 ml-1 text-xs font-semibold ">New
                                password</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password"
                                    class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required aria-describedby="new-password-error"
                                    placeholder="Enter a new password">
                            </div>
                            <p class="hidden mt-2 text-xs text-red-600" id="new-password-error">Please include a
                                password that
                                complies with the rules to ensure security</p>
                        </div>
                        <div>
                            <label for="confirmn_new_password"
                                class="block mb-2 ml-1 text-xs font-semibold ">Confirm new password</label>
                            <div class="relative">
                                <input type="password" id="confirmn_new_password" name="confirmn_new_password"
                                    class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required aria-describedby="confirmn_new-password-error"
                                    placeholder="Enter a new password">
                            </div>
                            <p class="hidden mt-2 text-xs text-red-600" id="confirmn_new-password-error">Please
                                include a password that
                                complies with the rules to ensure security</p>
                        </div>
                        <button type="submit" name="password_update"
                            class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition-all bg-indigo-500 border border-transparent rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Reset
                            my password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php
}
?>
</section>


</body>
</html>