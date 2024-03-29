<?php

    require("database.php");
    session_start();
    if(!(isset($_SESSION['course']))) {
        echo "<script>alert('Select a course first.')</script>";
        echo "<script>window.location.replace('studentHome.php')</script>";
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
                        <a class="nav-link" href="studentHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="studentVideo.php">Videos</a>
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
        <?php echo "<h2>Hello, " . $_SESSION['name'] . "</h2>"; ?>
        <section class="ms-5">
            <?php echo "<h5>Videos in course: " . $_SESSION['course'] . " - " . stripslashes($_SESSION['courseName']) . "</h5>"; ?>

            <div class="container">

                <?php 
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduVid WHERE course_code='$ccode' ORDER BY video_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    $i = 1;
                    if($n == 0) {
                        echo "<h3 class='text-center'>No videos available</h3>";
                    }
                    else {
                        while($i <= $n) {
                            echo '<div class="row justify-content-center">';
                                for($card=0;$card<3 && $i<=$n;$card++, $row = mysqli_fetch_array($result)) {
                                    // video - watched or not
                                    $qr2 = "SELECT * FROM studVid WHERE email='$mail' AND course_code='$ccode' AND video_id='{$row['video_id']}'";
                                    $result2 = mysqli_query($con,$qr2);

                                    echo '<div class="col-lg-4 col-md-6">';
                                        echo '<div class="card text-center border border-primary shadow-0 text-white" style="background-color:#2e3436;">';
                                        echo '<div class="card-body">';
                                            echo "<h5 class='card-title'>$i - " . stripslashes($row['video_name']) . "</h5>";
                                            echo '<br>';
                                            $watched = (mysqli_num_rows($result2) > 0)?1:0;
                                            if($watched == 1) {
                                                echo '<span class="badge bg-success w-75">Watched';
                                            }
                                            else {
                                                echo '<span class="badge bg-danger w-75">Not watched';
                                            }
                                            echo '<br>';
                                            echo '<br>';
                                            echo "<button class='w-100 btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#Video{$row['video_id']}'>Watch</button></span>";
                                            echo "<div class='modal fade' id='Video{$row['video_id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='VideoLabel{$row['video_id']}' aria-hidden='true'>";
                                                echo '<div class="modal-dialog">';
                                                    echo '<div class="modal-content">';
                                                        echo '<div class="modal-header">';
                                                            echo "<h5 class='modal-title text-dark' id='VideoLabel{$row['video_id']}'>{$row['video_name']}</h5>";
                                                            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                        echo "</div>";
                                                        echo '<div class="modal-body">';
                                                            echo '<div class="embed-responsive embed-responsive-4by3">';
                                                                echo "<iframe width='100%' height='320' class='embed-responsive-item' src='https://www.youtube.com/embed/{$row['video_url']}' allowfullscreen=''></iframe>";
                                                            echo '</div>';
                                                        echo '</div>';
                                                        echo '<div class="modal-footer">';
                                                            // if video is not present in student_video table show button to mark as watched
                                                            if(!(mysqli_num_rows($result2) > 0)) {
                                                                echo '<form method="post" action="studentVideo.php">';
                                                                    echo "<button type='submit' class='btn btn-primary' name='markWatched' value='{$row['video_id']}'>Mark as watched</button>";
                                                                echo '</form>';
                                                                if(isset($_POST['markWatched'])) {
                                                                    $videoToMark = $_POST['markWatched'];
                                                                    $qr3 = "INSERT INTO studVid (email,course_code, video_id) VALUES ('$mail','$ccode','$videoToMark')";
                                                                    if(mysqli_query($con,$qr3)) {
                                                                        $qr4 = "UPDATE studScore SET score=score+5 WHERE email='$mail' AND course_code='$ccode'";
                                                                        mysqli_query($con,$qr4);
                                                                        unset($_POST['markWatched']);
                                                                        echo "<script>window.location.replace('studentVideo.php')</script>";
                                                                    }
                                                                }
                                                            }
                                                            mysqli_free_result($result2);
                                                            echo "<button type='button' class='btn btn-primary' data-bs-dismiss='modal'>Close</button>";
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        $i++;
                                        echo '</div>';
                                }
                            echo '</div>';
                            echo '<br>';
                            echo '<br>';
                        }
                    }
                ?>

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
