<?php
    require("database.php");
    session_start();
    session_unset();

    if(isset($_POST['submit'])) {

        // grab data from form

        $mail = $_POST['email'];
        $mail = stripslashes($mail);
        $mail = mysqli_real_escape_string($con,$mail);

        $pass = $_POST['password'];
        $pass = stripslashes($pass);
        $pass = mysqli_real_escape_string($con,$pass);

        // check if email is not in db
        $qr = "SELECT email from educator where email='$mail'";
        $result = mysqli_query($con,$qr);

        if(mysqli_num_rows($result) == 0) {
            echo "<script>alert('Please register first.')</script>";
            mysqli_free_result($result);
        }

        // continue if mail is registered
        else {
            mysqli_free_result($result);
            $qr = "SELECT * from educator where email='$mail'";
            if($result = mysqli_query($con,$qr)) {
               $row = mysqli_fetch_row($result);
               // check if password is correct
               if($row[2] == $pass) {
                  // set session vars for future use
                  $_SESSION['name'] = $row[1];
                  $_SESSION['mail'] = $mail;
                  header("location: educatorHome.php");
               }
               else {
                  // if pass is wrong then alert user
                  echo "<script>alert('Wrong password, contact admin if you don\'t remember the password.')</script>";
               }
            }
            else {
               echo "<script>alert('DB error.')</script>";
            }
        }
    }
?>

<!doctype html>
<html lang="en">

   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Study+</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
      <!-- login css -->
      <link href="../assets/css/login.css" rel="stylesheet">
   </head>

   <body class="bg-dark text-white">

      <!-- navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-dark">
         <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Study+</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../index.html">Home</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Login
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item" href="studentLogin.php">Student login</a></li>
                     <li><a class="dropdown-item" href="educatorLogin.php">Educator login</a></li>
                  </ul>
               <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
               </li>
            </div>
         </div>
      </nav>


      <!-- content -->
      <form class="form-signin w-100 m-auto" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
         <h1 class="h3 mb-3 fw-normal">Educator login</h1>
         <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
            <label class="text-muted" for="floatingInput">Email address</label>
         </div>
         <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
            <label class="text-muted" for="floatingPassword">Password</label>
         </div>
         <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Login</button>
      </form>
      <h5 align="center"><a href="educatorRegister.php">Don't have an account? Register here</a></h5>



      <!-- Footer -->
      <div class="container">
         <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0">© 2022 Tony</p>
            <ul class="nav col-md-4 justify-content-end">
               <li class="nav-item"><a href="../index.html" class="nav-link px-2">Home</a></li>
               <li class="nav-item"><a href="about.html" class="nav-link px-2">About</a></li>
            </ul>
         </footer>
      </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

   </body>

</html>