<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles.css">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        ._success {
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            text-align: center;
            border-bottom: solid 4px #28a745;
        }
        ._success i {
            font-size: 55px;
            color: #28a745;
        }
        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }
        ._success p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }
        #btn {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            text-decoration: none;
            
        }
    
    </style>
    
</head>
<body>


    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; ">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6">
                <div class="message-box _success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>Your payment was successful</h2>
                    <p>Thank you for your Order. We will <br> be in contact with more details shortly.</p>
                    <a href="track_page.php" id="btn" class="btn btn-primary">Track Your Order</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
