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
                        <a class="nav-link active" href="educatorQuiz.php">Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="educatorScoreboard.php">Course stats</a>
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
            <?php echo "<h5>Your Quizzes in course: " . $_SESSION['course'] . " - " . $_SESSION['courseName'] . "</h5>"; ?>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 50%;" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quiz ID</th>
                        <th scope="col">Quiz name</th>
                        <th scope="col">View/Modify Quiz</th>
                        <th scope="col">Delete Quiz</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduQzName WHERE course_code='$ccode' ORDER BY quiz_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                            echo '<th scope="row">' . $i . '</th>';
                            echo '<td>' . $row['quiz_id'] . '</td>';
                            echo '<td>' . $row['quiz_name'] . '</td>';
                            echo '<td>';
                                echo '<form method="post" action="educatorQuiz.php">';
                                echo "<input type='hidden' class='form-control' id='floatingInput' name='viewQuizName' value='{$row['quiz_name']}' required>";
                                echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='viewQuiz' value='{$row['quiz_id']}'>View/Modify</button>";
                                echo '</form>';
                            echo '</td>';
                            echo '<td>';
                                echo '<form method="post" action="educatorQuiz.php">';
                                echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='deleteQuiz' value='{$row['quiz_id']}'>Delete</button>";
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>

            <form method="post" action="educatorQuiz.php" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="AddQuiz">Add new Quiz</button>
           </form>

            <?php

                if(isset($_POST['viewQuiz'])) {
                    $_SESSION['quizID'] = $_POST['viewQuiz'];
                    $_SESSION['quizName'] = $_POST['viewQuizName'];
                    echo "<script>window.location.replace('educatorQuizQstn.php')</script>";
                }

                if(isset($_POST['deleteQuiz'])) {
                    $quizToDelete = $_POST['deleteQuiz'];
                    $qr = "DELETE FROM eduQuiz WHERE course_code='$ccode' AND quiz_id='$quizToDelete'";
                    $qr2 = "DELETE FROM eduQzName WHERE course_code='$ccode' AND quiz_id='$quizToDelete'";
                    if(mysqli_query($con,$qr) && mysqli_query($con,$qr2)) {
                        echo "<script>alert('Quiz deleted.')</script>";
                        echo "<script>window.location.replace('educatorQuiz.php')</script>";
                    }
                }

                if(isset($_POST['AddQuiz']) || isset($_POST['quizAdded'])) {
                    echo '<form class="form-signin w-100 m-auto" id="addQuiz" method="post" action="educatorQuiz.php" enctype="multipart/form-data">';
                        echo '<div class="form-floating">';
                            echo "<input type='number' class='form-control' id='floatingInput' placeholder='Quiz ID' name='quizID' required>";
                            echo "<label class='text-muted' for='floatingInput'>Quiz ID</label>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<input type='text' class='form-control' id='floatingInput' placeholder='Quiz Name' name='quizName' required>";
                            echo "<label class='text-muted' for='floatingInput'>Quiz Name</label>";
                        echo '</div>';
                        echo '<br><button class="btn btn-sm btn-primary" type="submit" name="quizAdded">Add Quiz</button>';
                    echo '</form>';

                    if(isset($_POST['quizAdded'])) {
                        $addedQuizName = $_POST['quizName'];
                        $addedQuizId = $_POST['quizID'];
                        $qr = "INSERT INTO eduQzName (course_code, quiz_id, quiz_name) VALUES ('$ccode', '$addedQuizId', '$addedQuizName')";
                        if(mysqli_query($con,$qr)) {
                            echo "<script>alert('Quiz Added.')</script>";
                            echo "<script>window.location.replace('educatorQuiz.php')</script>";
                        }
                    }
                }
            ?>

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
