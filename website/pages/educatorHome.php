<?php

    require("database.php");
    session_start();
    if(isset($_GET['selCourse'])) {
        $_SESSION['course'] = $_GET['selCourse'];
        $_SESSION['courseName'] = stripslashes($_GET['selCourseName']);
    }
    
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
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduCode WHERE email='$mail'";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                        echo '<tr>';
                            echo '<th scope="row">' . $i . '</th>';
                            echo '<td>' . $row['code'] . '</td>';
                            echo '<td>' . stripslashes($row['course']) . '</td>';
                            echo '<td>';
                                echo '<form method="get" action="educatorHome.php">';
                                echo '<input type="hidden" name="selCourseName" value="' . $row['course'] . '" required>';
                                echo '<button class="w-100 btn btn-sm btn-primary" type="submit" name="selCourse" value=' . $row['code']. '>Select</button>';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
                </tbody>
            </table>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="createCourse">Add new course</button>
            </form>

            <?php
                if(isset($_POST['createCourse']) || isset($_POST['courseCreated'])) {
                    echo '<form class="form-signin w-100 m-auto" method="post" action="educatorHome.php" enctype="multipart/form-data" id="addCourse">';
                        echo '<div class="form-floating">';
                            echo '<input type="number" class="form-control" id="floatingInput" placeholder="Code" name="code" required>';
                            echo '<label class="text-muted" for="floatingInput">Code</label>';
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo '<input type="text" class="form-control" id="floatingInput" placeholder="Course Name" name="course" required>';
                            echo '<label class="text-muted" for="floatingInput">Course Name</label>';
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<textarea name='courseDesc' placeholder='Course Description' form='addCourse' required></textarea>";
                        echo '</div>';
                        echo '<button class="btn btn-sm btn-primary" type="submit" name="courseCreated">Add</button>';
                    echo '</form>';

                    if(isset($_POST['courseCreated'])) {
                        // check if code already in use
                        $ccode = $_POST['code'];
                        $qr = "SELECT code from eduCode where code='$ccode'";
                        $result = mysqli_query($con,$qr);

                        if(mysqli_num_rows($result) > 0) {
                            echo "<script>alert('The course code already exists.')</script>";
                            mysqli_free_result($result);
                        }
                        else {
                            $cmail = $_SESSION['mail'];
                            $ccourse = mysqli_real_escape_string($con,$_POST['course']);
                            $course_desc = mysqli_real_escape_string($con,$_POST['courseDesc']);
                            $qr = "INSERT INTO eduCode (email,code,course,course_desc) VALUES ('$cmail','$ccode','$ccourse','$course_desc')";
                            mysqli_query($con,$qr);
                            echo "<script>alert('Course added successfully.')</script>";
                            echo "<script>window.location.replace('educatorHome.php')</script>";
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
               <li class="nav-item"><a href="educatorHome.php" class="nav-link px-2">Home</a></li>
               <li class="nav-item"><a href="logout.php" class="nav-link px-2">Logout</a></li>
            </ul>
         </footer>
      </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

   </body>

</html>
