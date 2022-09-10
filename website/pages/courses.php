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
          <h1 class="text-center">Available courses</h1>
          <br><br>

          <div class="container">

            <?php
                $qr = "SELECT * FROM eduCode";
                $result = mysqli_query($con,$qr);
                $n = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $i = 1;
                while($i <= $n) {
                    echo '<div class="row justify-content-center">';
                    for($card=0;$card <3 && $i<=$n;$card++, $row = mysqli_fetch_array($result)) {
                        // educator name
                        $qr2 = "SELECT name FROM edu WHERE email='{$row['email']}'";
                        $result2 = mysqli_query($con,$qr2);
                        $row2 = mysqli_fetch_array($result2);

                        echo '<div class="col-lg-4 col-md-6">';
                            echo '<div class="card text-center border border-primary shadow-0 text-white" style="background-color:#2e3436;">';
                                echo '<div class="card-body">';
                                    echo "<h5 class='card-title'>{$row['course']}</h5>";
                                    echo '<p class="card-text">';
                                        echo "Course code - {$row['code']} <br> Taught by - {$row2['name']} <br><br> {$row['course_desc']}";
                                    echo '</p>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        mysqli_free_result($result2);
                        $i++;
                    }
                    echo '</div>';
                    echo '<br>';
                    echo '<br>';
                }
            ?>

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
