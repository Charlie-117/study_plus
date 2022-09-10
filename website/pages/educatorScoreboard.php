<?php

    require("database.php");
    session_start();
    if(!(isset($_SESSION['course']))) {
        echo "<script>alert('Select a course first.')</script>";
        echo "<script>window.location.replace('educatorHome.php')</script>";
    }
    $ccode = $_SESSION['course'];        
    
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
                        <a class="nav-link" href="educatorHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="educatorVideo.php">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="educatorFlashCard.php">Flash Cards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="educatorQuiz.php">Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="educatorScoreboard.php">Course stats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="educatorHelp.html">Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
         </div>
      </nav>


      <!-- content -->
      <section class="ms-5">
         <?php echo "<h2>Hello, " . $_SESSION['name'] . "</h2>"; ?>
         <section class="ms-5">

               <br><br><br>
               <div class="text-center mx-5">

                <?php

                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM studScore WHERE course_code='$ccode' ORDER BY score DESC";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);

                ?>

               <table class="table table-secondary table-striped table-hover table-bordered" style="width: 90%;" >
                  <thead>
                     <tr>
                        <th colspan="3"><?php echo $_SESSION['course'] . " - " . $_SESSION['courseName']; ?></th>
                     </tr>
                     <tr>
                        <th colspan="3"><?php echo "Number of students enrolled: " . $n; ?></th>
                     </tr>
                     <tr>
                           <th scope="col">Rank</th>
                           <th scope="col">Name</th>
                           <th scope="col">Score</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $row = mysqli_fetch_array($result);
                        for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                              echo '<tr>';
                                 echo '<th scope="row">' . $i . '</th>';
                                 $qr2 = "SELECT name from stud WHERE email='{$row['email']}'";
                                 $result2 = mysqli_query($con,$qr2);
                                 $row2 = mysqli_fetch_array($result2); 
                                 echo '<td>' . $row2['name'] . '</td>';
                                 echo '<td>';
                                 echo "{$row['score']}";
                                 echo '</td>';
                              echo '</tr>';
                        }
                     ?>
                  </tbody>
               </table>
               </div>
         

         </section>
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
