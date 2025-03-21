<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>
    <style>
        
        body{
            background-image:url("coop.png");
            background-size: cover;
        }
        .login-page {
            width: 350px;
            margin: 5% auto;
            margin-top:10%;
            padding: 40px;
            background-color: #f9f9f9;
            border: 1px solid #f2f2f2;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .login-page .text-center {
            margin-bottom: 25px;
            text-align: center;
        }

        .login-page .form-group label {
            color: #555;
        }

        .login-page  {
            background-color: #fff;
            display: block;
            padding: 1rem;
            max-width: 350px;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .login-page  {
            width: 350px;
            margin: 5% auto;
            margin-top:10%;
            padding: 40px;
        }

        .login-page input[type="name"],
        .login-page input[type="password"] {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .login-page button[type="submit"] {
            background-color: #0059b3;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 40px;
        }

        .login-page button:hover {
            background-color: #003366;
        }
        .login-page button[type="submit"] {
            display: block;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  background-color: #4F46E5;
  color: #ffffff;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  width: 100%;
  border-radius: 0.5rem;
  text-transform: uppercase;
        }
        
    </style>
</head>
<body>
    <div class="login-page">
        <div class="text-center">
            <h1>Login Panel</h1>
            <h4>Secangkir Inventory System</h4>
        </div>
        <?php echo display_msg($msg); ?>
        <form method="post" action="auth.php" class="clearfix">
            <div class="form-group">
                <label for="username" class="control-label">Username: </label>
                <input type="name" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="Password" class="control-label">Password: </label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger" >Login</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php include_once('layouts/footer.php'); ?>
