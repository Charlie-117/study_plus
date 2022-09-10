<?php

    require("database.php");
    session_start();

    if(isset($_GET['selCourse'])) {
        $_SESSION['course'] = $_GET['selCourse'];
        $_SESSION['courseName'] = $_GET['selCourseName'];
    }

    $mail = $_SESSION['mail'];

    // student score fetching and calculation
    $qr = "SELECT sum(score) FROM student_score WHERE email='$mail'";
    $result = mysqli_query($con,$qr);
    $row = mysqli_fetch_array($result);
    $score = $row['sum(score)'];
    // level upgrades after every 100 point increase in score
    $level = (int)($score/100);
    $toLvlUp = 100 - ($score%100);
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
      <section class="ms-5">
        <?php
            echo "<h2>Hello, " . $_SESSION['name'] . "</h2>";
            echo "<h4>Your level: $level , score: $score ($toLvlUp points needed to level up) </h4>";
        ?>
        <section class="ms-5">
            <h5>Your Courses</h5>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 50%;" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Course Name</th>
                        <th scope="col">Selection</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $qr = "SELECT * FROM student_code WHERE email='$mail'";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                            echo '<th scope="row">' . $i . '</th>';
                            echo '<td>' . $row['code'] . '</td>';
                            $qr2 = "SELECT course from educator_code where code='{$row['code']}'";
                            $result2 = mysqli_query($con,$qr2);
                            $row2 = mysqli_fetch_array($result2);
                            echo '<td>' .$row2['course'] . '</td>';
                            echo '<td>';
                                echo '<form method="get" action="studentHome.php">';
                                echo '<input type="hidden" name="selCourseName" value="' . $row2['course'] . '" required>';
                                echo '<button class="w-100 btn btn-sm btn-primary" type="submit" name="selCourse" value=' . $row['code']. '>Select</button>';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="enrollCourse">Enroll into new course</button>
            </form>

            <?php
                if(isset($_POST['enrollCourse']) || isset($_POST['courseEnrolled'])) {
                    echo '<form class="form-signin w-100 m-auto" method="post" action="studentHome.php" enctype="multipart/form-data">';
                        echo '<div class="form-floating">';
                            echo '<input type="text" class="form-control" id="floatingInput" placeholder="Code" name="code" required>';
                            echo '<label class="text-muted" for="floatingInput">Code</label>';
                        echo '</div>';
                        echo '<button class="btn btn-sm btn-primary" type="submit" name="courseEnrolled">Add</button>';
                    echo '</form>';

                    if(isset($_POST['courseEnrolled'])) {
                        // check if code exists
                        $ccode = $_POST['code'];
                        $qr = "SELECT code from educator_code where code='$ccode'";
                        $result = mysqli_query($con,$qr);

                        if(mysqli_num_rows($result) > 0) {
                            $qr2 = "SELECT code from student_code where code='$ccode' AND email='$mail'";
                            $result2 = mysqli_query($con,$qr2);
                            if(mysqli_num_rows($result2) > 0) {
                                echo "<script>alert('You are already enrolled in the Course.')</script>";
                            }
                            else {
                                $cmail = $_SESSION['mail'];
                                $qr = "INSERT INTO student_code (email,code) VALUES ('$cmail','$ccode')";
                                $qr2 = "INSERT INTO student_score (email,course_code) VALUES ('$cmail','$ccode')";
                                mysqli_query($con,$qr);
                                mysqli_query($con,$qr2);
                                echo "<script>alert('Enrolled into Course successfully.')</script>";
                                echo "<script>window.location.replace('studentHome.php')</script>";
                            }
                        }
                        else {
                            echo "<script>alert('The course code does not exist.')</script>";
                            mysqli_free_result($result);
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
