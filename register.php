
<?php
  session_start();
  if(isset($_SESSION['email']))
  {
      header("location: dashboard.php");
      exit;
  }
  ?>
  
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="style.css" class="css">
    <title>Register | Underdogidols</title>
    <link rel="stylesheet" href="style.css">
   </head>
   <body>
  <img src="assets/img/udi.png" alt="logo">
  <div class="wrapper">
    <h2>Contestant Registration</h2>
    <form action="" method = "POST">
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
        <input type="submit" name="submit" value="Register Now">
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

<?php
include 'connection.php';
if(isset($_POST['submit']))
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
        echo '<script>swal("Warning","Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.", "warning")</script>';
    }else{
        if($pwd != $confpwd)
        {
        echo '<script>swal("Warning","Password and Confirm Password Should be same", "warning")</script>';
        }else{
            $duplicate_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
            if(mysqli_num_rows($duplicate_email)>0){
                echo '<script>swal("Warning","E-mail already exist, please try with different email", "error")</script>';
            }else{
                $pass  = password_hash($pwd, PASSWORD_DEFAULT);
                $query = "INSERT INTO users VALUES (NULL,'$fullname', '$email',DEFAULT, '$pass', current_timestamp())";
                $data  = mysqli_query($conn, $query);
                if($data){
                echo "<script>swal('Thank You','You are Registered Successfully, Welcome to Underdogidols', 'success');
                sleep(5); window.location.href='login.php';</script>";
                }else{
                    echo '<script>swal("Sorry", you could not be registered", "error")</script>';
                }
            }
        }
    }
}
?>
