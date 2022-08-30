<?php

    require("database.php");
    session_start();
    if(!(isset($_SESSION['course']))) {
        echo "<script>alert('Select a course first.')</script>";
        echo "<script>window.location.replace('studentHome.php')</script>";
    }
    $ccode = $_SESSION['course'];

    // unset all session variables related to quiz play session for next quiz
    unset($_SESSION['quizNCA']);
    unset($_SESSION['quizQAC']);
    unset($_SESSION['quizQTN']);

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
                  <a class="nav-link active" aria-current="page" href="studentHome.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="studentVideo.php">Videos</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="studentFlashCard.php">Flash Cards</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="studentQuiz.php">Quizzes</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="studentHelp.html">Help</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
               </li>
            </div>
         </div>
      </nav>


      <!-- content -->
      <section class="ms-5">
        <?php echo "<h2>Hello, " . $_SESSION['name'] . "</h2>"; ?>
        <section class="ms-5">
            <?php echo "<h5>Quizzes in course: " . $_SESSION['course'] . " - " . $_SESSION['courseName'] . "</h5><br>"; ?>

            <div class="container">

            <?php 
                $mail = $_SESSION['mail'];
                $qr = "SELECT * FROM educator_quiz_name WHERE course_code='$ccode' ORDER BY quiz_id";
                $result = mysqli_query($con,$qr);
                $n = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $i = 1;
                while($i <= $n) {
                    echo '<div class="row justify-content-center">';
                    for($card=0;$card <3 && $i<=$n;$card++, $row = mysqli_fetch_array($result)) {
                        // quiz - played or not
                        $qr2 = "SELECT * FROM student_quiz WHERE email='$mail' AND course_code='$ccode' AND quiz_id='{$row['quiz_id']}'";
                        $result2 = mysqli_query($con,$qr2);

                        echo '<div class="col-lg-4 col-md-6">';
                            echo '<div class="card text-center border border-primary shadow-0 text-white" style="background-color:#2e3436;">';
                                echo '<div class="card-body">';
                                    echo "<h5 class='card-title'>Quiz - $i</h5>";
                                    echo '<p class="card-text">';
                                        echo "{$row['quiz_name']}";
                                    echo '</p>';
                                    $played = (mysqli_num_rows($result2) > 0)?1:0;
                                    if($played == 1) {
                                        echo '<span class="badge bg-success">Played';
                                    }
                                    else {
                                        echo '<span class="badge bg-danger">Not Played';
                                    }
                                    echo '<br>';
                                    echo '<br>';
                                    echo '<form method="post" action="studentQuiz.php">';
                                        echo "<input type='hidden' name='played' value='$played' required>";
                                        echo "<input type='hidden' name='playQuizName' value='{$row['quiz_name']}' required>";
                                        echo "<button type='submit' class='btn btn-primary' name='playQuiz' value='{$row['quiz_id']}'>Play</button>";
                                    echo '</form>';
                                    echo '</span>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        mysqli_free_result($result2);
                        $i++;
                    }
                    echo '</div>';
                }
            ?>

            </div>


        </section>
      </section>

      <?php

        if(isset($_POST['playQuiz'])) {
            $quizToMark = $_POST['playQuiz'];
            $_SESSION['quizID'] = $quizToMark;
            $_SESSION['quizName'] = $_POST['playQuizName'];
            $_SESSION['quizPlayed'] = $_POST['played'];
            if(!($_SESSION['quizPlayed'])) {
                $qr3 = "INSERT INTO student_quiz (email,course_code,quiz_id) VALUES ('$mail','$ccode','$quizToMark')";
                mysqli_query($con,$qr3);
            }
            echo "<script>window.location.replace('studentQuizQstn.php')</script>";
        }

      ?>



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
