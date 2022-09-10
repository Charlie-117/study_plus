<?php

    require("database.php");       
    
?>

<!doctype html>
<html lang="en">

   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Study+</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
   </head>

   <body class="bg-dark text-white">

      <!-- navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xl">
          <a class="navbar-brand">Study+</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="../index.html">Home</a>
              </li>
              <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                 <ul class="dropdown-menu" aria-labelledby="dropdown">
                   <li><a class="dropdown-item" href="studentLogin.php">Student login</a></li>
                   <li><a class="dropdown-item" href="educatorLogin.php">Educator login</a></li>
                 </ul>
               </li>
               <li class="nav-item">
                <a class="nav-link active" href="courses.php">Courses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>


      <!-- content -->
        <section class="ms-5">
          <br><br>
            <div class="text-center mx-5">
              <table class="table table-secondary table-striped table-hover table-bordered" style="width: 90%;" >
                <thead>
                  <tr>
                    <th colspan="4">Available courses</th>
                  </tr>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course code</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Taught by</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $qr = "SELECT * FROM educator_code";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                      $qr2 = "SELECT name FROM educator WHERE email='{$row['email']}'";
                      $result2 = mysqli_query($con,$qr2);
                      $row2 = mysqli_fetch_array($result2);
                      echo '<tr>';
                        echo '<th scope="row">' . $i . '</th>'; 
                        echo '<td>' . $row['code'] . '</td>';
                        echo '<td>' . $row['course'] . '</td>';
                        echo '<td>' . $row2['name'] . '</td>';
                      echo '</tr>';
                    }
                 ?>
                </tbody>
              </table>
            </div>
        </section>

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
