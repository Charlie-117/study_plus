<?php

    require("database.php");
    session_start();
    if(!(isset($_SESSION['course']))) {
        echo "<script>alert('Select a course first.')</script>";
        echo "<script>window.location.replace('studentHome.php')</script>";
    }
    $ccode = $_SESSION['course'];
    $mail = $_SESSION['mail'];

    $quizID = $_SESSION['quizID'];
    $quizName = $_SESSION['quizName'];
    $quizPlayed = $_SESSION['quizPlayed'];

    if(!(isset($_SESSION['quizNCA']))) {
        // NCA = NumberOfCorrectAnswers
        $_SESSION['quizNCA'] = 0;
    }
    if(!(isset($_SESSION['quizQAC']))) {
        // QAC = QuizAttemptedCount
        $_SESSION['quizQAC'] = 1;
    }
    $qr = "SELECT * FROM eduQuiz WHERE course_code='$ccode' AND quiz_id='$quizID' ORDER BY quiz_qstn_id";
    $result = mysqli_query($con,$qr);

    // QTN = QuestionTotalNum
    $_SESSION['quizQTN'] = mysqli_num_rows($result);

    // Seek to the current question row and store result
    mysqli_data_seek($result,$_SESSION['quizQAC']-1);
    $row = mysqli_fetch_array($result);

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
                        <a class="nav-link" href="studentHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="studentVideo.php">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="studentFlashCard.php">Flash Cards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="studentQuiz.php">Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="studentScoreboard.php">Score</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="studentHelp.html">Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
         </div>
      </nav>


      <!-- content -->

      <?php

        if($_SESSION['quizQTN'] == 0) {
            echo "<script>alert('No Questions are added in the quiz yet')</script>";
            echo "<script>window.location.replace('studentQuiz.php')</script>";
        }

      ?>

      <section class="ms-5">
        <?php echo "<h2>Playing Quiz - " . $_SESSION['quizName'] . "</h2>"; ?>
        <br><br>
        <section class="ms-5">
            <div class="container">
                <div class="row ">
                    <div class="col-12">
            <?php
                echo '<div class="card border border-primary shadow-0 text-white" style="background-color:#2e3436;">';
                    echo "<div class='card-header'>Question: {$_SESSION['quizQAC']} of {$_SESSION['quizQTN']}</div>";
                        echo '<div class="card-body">';
                            echo "<h5 class='card-title text-center'>" . stripslashes($row['quiz_qstn']) . "</h5>";
                                echo '<p class="card-text">';
                                    echo '<div class="card  text-white" style="background-color:#5f5d5d;">';
                                        echo '<div class="card-body">';
                                            echo '<p class="card-text">';
                                                echo '<form method="post" action="studentQuizQstn.php" enctype="multipart/form-data">';
                                                echo "<legend>Select answer: </legend>";
                                                echo '<div class="form-check form-check-inline">';
                                                    echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_a" value="opt_a" checked>';
                                                    echo "<label class='form-check-label' for='opt_a'>" . stripslashes($row['opt_a']) . "</label>";
                                                echo '</div>';
                                                echo '<br><br>';
                                                echo '<div class="form-check form-check-inline">';
                                                    echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_b" value="opt_b">';
                                                    echo "<label class='form-check-label' for='opt_b'>" . stripslashes($row['opt_b']) . "</label>";
                                                echo '</div>';
                                                echo '<br><br>';
                                                echo '<div class="form-check form-check-inline">';
                                                    echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_c" value="opt_c">';
                                                    echo "<label class='form-check-label' for='opt_c'>" . stripslashes($row['opt_c']) . "</label>";
                                                echo '</div>';
                                                echo '<br><br>';
                                                echo '<div class="form-check form-check-inline">';
                                                    echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_d" value="opt_d">';
                                                    echo "<label class='form-check-label' for='opt_d'>" . stripslashes($row['opt_d']) . "</label>";
                                                echo '</div>';
                                            echo '</p>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</p>';
                                echo '<div class="text-center">';
                                    echo "<button type='submit' class='btn btn-primary' name='playQuiz' value='{$row['quiz_qstn_id']}'>Submit</button>";
                                echo '</div';
                                echo '</form>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                        // Answer handling code
                        if(isset($_POST['playQuiz'])) {
                            $questionToCheck = $_POST['playQuiz'];
                            $userAns = $_POST['quiz_ans'];
                            if($row['quiz_ans'] == $userAns) {
                                echo "<script>alert('Correct answer.')</script>";
                                $_SESSION['quizNCA']++;
                                // increase score by 5 for each correct answer if quiz hasn't been played earlier
                                if($quizPlayed == 0) {
                                    $qr2 = "UPDATE studScore SET score=score+5 WHERE email='$mail' AND course_code='$ccode'";
                                    mysqli_query($con,$qr2);
                                }
                            }
                            else {
                                echo "<script>alert('Wrong answer.')</script>";
                            }

                            if($_SESSION['quizQAC'] < $_SESSION['quizQTN']) {
                                $_SESSION['quizQAC']++;
                                echo "<script>window.location.replace('studentQuizQstn.php')</script>";
                            }
                            else {
                                echo "<script>alert('You scored {$_SESSION['quizNCA']} out of {$_SESSION['quizQTN']}')</script>";
                                echo "<script>window.location.replace('studentQuiz.php')</script>";
                            }
                        }
            ?>

                    </div>
                </div>
            </div>


        </section>
      </section>



      <!-- Footer -->
      <div class="container">
         <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0">© 2022 Tony</p>
            <ul class="nav col-md-4 justify-content-end">
               <li class="nav-item"><a href="studentHome.php" class="nav-link px-2">Home</a></li>
               <li class="nav-item"><a href="logout.php" class="nav-link px-2">Logout</a></li>
            </ul>
         </footer>
      </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

   </body>

</html>
