<?php
include 'connection.php';
  session_start();
  if(isset($_SESSION['email']))
  {
      header("location: dashboard.php");
      exit;
  }
  if(isset($_POST['signup']))
  {
      $fullname = $_POST['name'];
      $email    = $_POST['email'];
      $pwd      = $_POST['pwd'];
      $confpwd  = $_POST['confpwd'];
      $number   = preg_match('@[0-9]@', $pwd);
      $uppercase = preg_match('@[A-Z]@', $pwd);
      $lowercase = preg_match('@[a-z]@', $pwd);
      $specialChars = preg_match('@[^\w]@', $pwd);
      if(strlen($pwd) < 6 || !$number || !$uppercase || !$lowercase || !$specialChars) {
          echo '<script>swal("Warning","Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.", "warning")</script>';
      }else{
          if($pwd != $confpwd)
          {
          echo '<script>swal("Warning","Password and Confirm Password Should be same", "warning")</script>';
          }else{
              $duplicate_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
              if(mysqli_num_rows($duplicate_email)>0){
                  echo '<script>swal("Warning","E-mail already exist, please try with different email", "error")</script>';
              }else{
                  $pass = password_hash($pwd, PASSWORD_DEFAULT);
                  $query =  "INSERT INTO users VALUES (NULL,'$fullname', '$email',DEFAULT, '$pass', current_timestamp())";
                  $data = mysqli_query($conn, $query);
                  if($data){
                  echo "<script>swal('Thank You','You are Registered Successfully, Welcome to Underdogidols', 'success');
                  sleep(5);
                  window.location.href='login.php';</script>";
                  }else{
                      echo '<script>swal("Sorry", you could not be registered", "error")</script>';
                  }
              }
          }
      }
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Register | Underdogidols</title>
    <link rel="stylesheet" href="style.css">
   </head>
<body>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
            *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            }
            body{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fffff;
            }
            .wrapper{
            position: relative;
            max-width: 430px;
            width: 100%;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            }
            .wrapper h2{
            position: relative;
            font-size: 22px;
            font-weight: 600;
            color: #333;
            }
            .wrapper h2::before{
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 28px;
            border-radius: 12px;
            background: #4070f4;
            }
            .wrapper form{
            margin-top: 30px;
            }
            .wrapper form .input-box{
            height: 52px;
            margin: 18px 0;
            }
            form .input-box input{
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
            }
            .input-box input:focus,
            .input-box input:valid{
            border-color: #4070f4;
            }
            form .policy{
            display: flex;
            align-items: center;
            }
            form h3{
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            margin-left: 10px;
            }
            .input-box.button input{
            color: #fff;
            letter-spacing: 1px;
            border: none;
            background: #4070f4;
            cursor: pointer;
            }
            .input-box.button input:hover{
            background: #0e4bf1;
            }
            form .text h3{
            color: #333;
            width: 100%;
            text-align: center;
            }
            form .text h3 a{
            color: #4070f4;
            text-decoration: none;
            }
            form .text h3 a:hover{
            text-decoration: underline;
            }
            .footer{
                clear: both;
                position: relative;
                height: 200px;
                margin-top: -2000px;
            }

    </style>
  <img src="assets/img/udi.png" alt="logo">
  <div class="wrapper">
    <h2>Contestant Registration</h2>
    <form action="#" method = "POST">
      <div class="input-box">
        <input type="text" name="name" placeholder="Enter Your Full Name" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Enter Your E-Mail" required>
      </div>
      <div class="input-box">
        <input type="password" name="pwd" placeholder="Create Password" required>
      </div>
      <div class="input-box">
        <input type="password" name="confpwd" placeholder="Confirm Password" required>
      </div>
      <div class="policy">
        <input type="checkbox" required>
        <h3>I accept all terms & condition</h3>
      </div>
      <div class="input-box button">
        <input type="submit" name="signup" value="Register Now">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
      <div class="text">
        <h3>Go Back to Home <a href="index.php">Underdogidols</a></h3>
      </div>
    </form>
  </div>
</body>
</html>
