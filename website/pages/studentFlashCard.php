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
                        <a class="nav-link" href="studentVideo.php">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="studentFlashCard.php">Flash Cards</a>
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
        <br>
        <section class="ms-5">
            <?php echo "<h5>Flashcards in course: " . $_SESSION['course'] . " - " . $_SESSION['courseName'] . "</h5>"; ?>
            <br>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 90%;">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%">#</th>
                        <th scope="col" class="text-center">Topic</th>
                        <th scope="col" class="text-center" style="width: 20%">Read</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduCard WHERE course_code='$ccode' ORDER BY card_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                            echo '<th class="text-center" scope="row">' . $i . '</th>';
                            echo '<td>' .$row['card_name'] . '</td>';
                            echo '<td>';
                                // read card button
                                echo "<button class='w-100 btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#card{$row['card_id']}'>Read</button>";
                                echo "<div class='modal fade' id='card{$row['card_id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='VideoLabel{$row['video_id']}' aria-hidden='true'>";
                                    echo '<div class="modal-dialog">';
                                        echo '<div class="modal-content">';
                                            echo '<div class="modal-header">';
                                                echo "<h5 class='modal-title' id='cardLabel{$row['card_id']}'>{$row['card_name']}</h5>";
                                                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                echo "</div>";
                                                echo '<div class="modal-body">';
                                                    echo "{$row['card_desc']}";
                                                echo '</div>';
                                                echo '<div class="modal-footer">';
                                                echo '<form method="post" action="studentFlashCard.php">';
                                                        echo "<button type='submit' class='btn btn-primary' name='markRead' data-bs-dismiss='modal'>Close</button>";
                                                    echo '</form>';
                                                    if(isset($_POST['markRead'])) {
                                                        // unset else if condition remains true and points increase for all present cards
                                                        unset($_POST['markRead']);
                                                        $qr2 = "UPDATE studScore SET score=score+5 WHERE email='$mail' AND course_code='$ccode'";
                                                        if(mysqli_query($con,$qr2)){
                                                            echo "<script>window.location.replace('studentFlashCard.php')</script>";
                                                        }
                                                    }
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</td>';
                            // end - read card button
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>

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
