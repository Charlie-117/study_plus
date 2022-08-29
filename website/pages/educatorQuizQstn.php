<?php

    require("database.php");
    session_start();
    if(!(isset($_SESSION['course']))) {
        echo "<script>alert('Select a course first.')</script>";
        echo "<script>window.location.replace('educatorHome.php')</script>";
    }

    $ccode = $_SESSION['course'];
    $quizName = $_SESSION['quizName'];
    $quizID = $_SESSION['quizID'];

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
                  <a class="nav-link active" aria-current="page" href="educatorHome.php">Home</a>
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
                  <a class="nav-link" href="educatorHelp.html">Help</a>
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
            <?php echo "<h5>Viewing Quiz: " . $quizName . "</h5>"; ?>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 50%;" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question ID</th>
                        <th scope="col">View question</th>
                        <th scope="col">View options</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM educator_quiz WHERE course_code='$ccode' AND quiz_id='$quizID' ORDER BY quiz_qstn_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                            echo '<th scope="row">' . $i . '</th>';
                            echo '<th scope="row">' . $row['quiz_qstn_id'] . '</th>';
                            // begin - Quiz Question view
                            echo '<td>';
                                echo "<button class='w-100 btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#quiz{$row['quiz_qstn_id']}'>View</button>";
                                echo "<div class='modal fade' id='quiz{$row['quiz_qstn_id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='quizLabel{$row['quiz_qstn_id']}' aria-hidden='true'>";
                                    echo '<div class="modal-dialog">';
                                        echo '<div class="modal-content">';
                                            echo '<div class="modal-header">';
                                                echo "<h5 class='modal-title' id='quizLabel{$row['quiz_qstn_id']}'>Question Number: {$row['quiz_qstn_id']}</h5>";
                                                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                echo "</div>";
                                                echo '<div class="modal-body">';
                                                    echo "{$row['quiz_qstn']}";
                                                echo '</div>';
                                                echo '<div class="modal-footer">';
                                                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</td>';
                            // end - quiz question view
                            // begin - quiz options view
                            echo '<td>';
                                echo "<button class='w-100 btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#optn{$row['quiz_qstn_id']}'>View</button>";
                                echo "<div class='modal fade' id='optn{$row['quiz_qstn_id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='optnLabel{$row['quiz_qstn_id']}' aria-hidden='true'>";
                                    echo '<div class="modal-dialog">';
                                        echo '<div class="modal-content">';
                                            echo '<div class="modal-header">';
                                                echo "<h5 class='modal-title' id='optnLabel{$row['quiz_qstn_id']}'>Question Number: {$row['quiz_qstn_id']}</h5>";
                                                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                echo "</div>";
                                                echo '<div class="modal-body">';
                                                    echo "Option A: ";
                                                    echo "{$row['opt_a']}";
                                                    echo "<br><br>";
                                                    echo "Option B: ";
                                                    echo "{$row['opt_b']}";
                                                    echo "<br><br>";
                                                    echo "Option C: ";
                                                    echo "{$row['opt_c']}";
                                                    echo "<br><br>";
                                                    echo "Option D: ";
                                                    echo "{$row['opt_d']}";
                                                echo '</div>';
                                                echo '<div class="modal-footer">';
                                                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</td>';
                            // end - quiz options view
                            // begin - quiz answer
                            echo '<td>';
                                $checkOption = $row['quiz_ans'];
                                switch($checkOption) {
                                    case "opt_a":
                                        echo "A";
                                        break;
                                    case "opt_b":
                                        echo "B";
                                        break;
                                    case "opt_c":
                                        echo "C";
                                        break;
                                    case "opt_d":
                                        echo "D";
                                        break;
                                }
                            echo '</td>';
                            //end - quiz answer
                            echo '<td>';
                                echo '<form method="post" action="educatorQuizQstn.php">';
                                echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='deleteQuizQstn' value='{$row['quiz_qstn_id']}'>Delete</button>";
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>

            <form method="post" action="educatorQuizQstn.php" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="addQuizQstn">Add new Question</button>
           </form>

            <?php

                if(isset($_POST['deleteQuizQstn'])) {
                    $quizToDelete = $_POST['deleteQuizQstn'];
                    $qr = "DELETE FROM educator_quiz WHERE course_code='$ccode' AND quiz_id='$quizID' AND quiz_qstn_id='$quizToDelete'";
                    if(mysqli_query($con,$qr)) {
                        echo "<script>alert('Quiz question deleted.')</script>";
                        echo "<script>window.location.replace('educatorQuizQstn.php')</script>";
                    }
                }

                if(isset($_POST['addQuizQstn']) || isset($_POST['quizQstnAdded'])) {
                    echo '<form class="form-signin w-100 m-auto" id="addQuizQstn" method="post" action="educatorQuizQstn.php" enctype="multipart/form-data">';
                        echo '<div class="form-floating">';
                            echo "<input type='number' class='form-control' id='floatingInput' placeholder='Question ID' name='qstnID' required>";
                            echo "<label class='text-muted' for='floatingInput'>Question ID</label>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='quiz_qstn' placeholder='Quiz Question' form='addQuizQstn' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='opt_a' placeholder='Option A' form='addQuizQstn' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='opt_b' placeholder='Option B' form='addQuizQstn' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='opt_c' placeholder='Option C' form='addQuizQstn' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='opt_d' placeholder='Option D' form='addQuizQstn' required></textarea>";
                        echo '</div>';
                        echo "<br>";
                        echo "<legend>Select answer: </legend>";
                        echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_a" value="opt_a" checked>';
                            echo '<label class="form-check-label" for="opt_a">A</label>';
                        echo '</div>';
                        echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_b" value="opt_b">';
                            echo '<label class="form-check-label" for="opt_b">B</label>';
                        echo '</div>';
                        echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_c" value="opt_c">';
                            echo '<label class="form-check-label" for="opt_c">C</label>';
                        echo '</div>';
                        echo '<div class="form-check form-check-inline">';
                            echo '<input class="form-check-input" type="radio" name="quiz_ans" id="opt_d" value="opt_d">';
                            echo '<label class="form-check-label" for="opt_d">D</label>';
                        echo '</div>';
                        echo '<br><br><button class="btn btn-sm btn-primary" type="submit" name="quizQstnAdded">Add question</button>';
                    echo '</form>';

                    if(isset($_POST['quizQstnAdded'])) {
                        $addedQstnId = $_POST['qstnID'];
                        $addedQstn = $_POST['quiz_qstn'];
                        $addedOptA = $_POST['opt_a'];
                        $addedOptB = $_POST['opt_b'];
                        $addedOptC = $_POST['opt_c'];
                        $addedOptD = $_POST['opt_d'];
                        $addedQstnAns = $_POST['quiz_ans'];

                        $qr = "INSERT INTO educator_quiz (course_code,quiz_id,quiz_qstn_id,quiz_qstn,opt_a,opt_b,opt_c,opt_d,quiz_ans) VALUES ('$ccode', '$quizID', '$addedQstnId', '$addedQstn', '$addedOptA', '$addedOptB', '$addedOptC', '$addedOptD', '$addedQstnAns')";
                        if(mysqli_query($con,$qr)) {
                            echo "<script>alert('Quiz question Added.')</script>";
                            echo "<script>window.location.replace('educatorQuizQstn.php')</script>";
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
