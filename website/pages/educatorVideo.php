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
                        <a class="nav-link active" href="educatorVideo.php">Videos</a>
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
            <?php echo "<h5>Your Videos in course: " . $_SESSION['course'] . " - " . $_SESSION['courseName'] . "</h5>"; ?>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 90%;" >
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%">#</th>
                        <th scope="col" class="text-center" style="width: 5%">Video ID</th>
                        <th scope="col" class="text-center">Video name</th>
                        <th scope="col" class="text-center">Video url</th>
                        <th scope="col" class="text-center">Modify video</th>
                        <th scope="col" class="text-center">Delete video</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduVid WHERE course_code='$ccode' ORDER BY video_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);

                    if($n == 0) {
                        echo "<tr><td class='text-center' colspan='6'>No Videos added</td></tr>";
                    }
                    else {
                        for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                            echo '<tr>';
                                echo '<th scope="row" class="text-center">' . $i . '</th>';
                                echo '<td class="text-center">' . $row['video_id'] . '</td>';
                                echo '<td>' . stripslashes($row['video_name']) . '</td>';
                                echo '<td>https://www.youtube.com/watch?v=' . $row['video_url'] . '</td>';
                                echo '<td>';
                                    echo '<form method="post" action="educatorVideo.php">';
                                    echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='modifyVideo' value='{$row['video_id']}'>Modify</button>";
                                    echo '</form>';
                                echo '</td>';
                                echo '<td>';
                                    echo '<form method="post" action="educatorVideo.php">';
                                    echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='deleteVideo' value='{$row['video_id']}'>Delete</button>";
                                    echo '</form>';
                                echo '</td>';
                            echo '</tr>';
                        }
                    }
                ?>
                </tbody>
            </table>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="AddVideo">Add new video</button>
           </form>

            <?php

                if(isset($_POST['modifyVideo']) || isset($_POST['videoModified'])) {
                    echo '<form class="form-signin w-100 m-auto" method="post" id="modifyVideo" action="educatorVideo.php" enctype="multipart/form-data">';
                        $videoToModify = $_POST['modifyVideo'];
                        echo "Editing video with ID: " . $videoToModify;
                        $qr = "SELECT * FROM eduVid WHERE course_code='$ccode' AND video_id='$videoToModify'";
                        $result = mysqli_query($con, $qr);
                        $row = mysqli_fetch_array($result);
                        echo '<div class="form-floating">';
                            echo "<textarea name='videoName' placeholder='" . stripslashes($row['video_name']) . "' form='modifyVideo' cols='25' rows='3' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<textarea name='videoURL' placeholder='{$row['video_url']}' form='modifyVideo' cols='25' rows='3' required></textarea>";
                            echo "<input type='hidden' class='form-control' id='floatingInput' name='modifyVideo' value='$videoToModify' required>";
                        echo '</div>';
                        echo '<button class="btn btn-sm btn-primary" type="submit" name="videoModified">Modify</button>';
                    echo '</form>';

                    if(isset($_POST['videoModified'])) {
                        $modifiedVideoName = mysqli_real_escape_string($con,$_POST['videoName']);
                        $yt_regex_str = "/https:\/\/www.youtube.com\/watch\?v=/";
                        $modifiedVideoUrl = $_POST['videoURL'];
                        if (preg_match($yt_regex_str, $modifiedVideoUrl)) {
                            $modifiedVideoUrl = preg_replace($yt_regex_str, "", $modifiedVideoUrl);
                            $videoToModify = $_POST['modifyVideo'];
                            $qr = "UPDATE eduVid SET video_name='$modifiedVideoName' , video_url='$modifiedVideoUrl' WHERE course_code='$ccode' AND video_id='$videoToModify'";
                            if(mysqli_query($con,$qr)) {
                                echo "<script>window.location.replace('educatorVideo.php')</script>";
                            }
                        }
                        else {
                            echo "<script>alert('Enter valid YouTube URL.')</script>";
                        }
                    }
                }

                if(isset($_POST['deleteVideo'])) {
                    $videoToDelete = $_POST['deleteVideo'];
                    $qr = "DELETE FROM eduVid WHERE course_code='$ccode' AND video_id='$videoToDelete'";
                    if(mysqli_query($con,$qr)) {
                        echo "<script>alert('Video deleted.')</script>";
                        echo "<script>window.location.replace('educatorVideo.php')</script>";
                    }
                }

                if(isset($_POST['AddVideo']) || isset($_POST['videoAdded'])) {
                    echo '<form class="form-signin w-100 m-auto" method="post" action="educatorVideo.php" enctype="multipart/form-data">';
                        echo '<div class="form-floating">';
                            echo "<input type='number' class='form-control' id='floatingInput' placeholder='Video ID' name='videoID' required>";
                            echo "<label class='text-muted' for='floatingInput'>Video ID</label>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<input type='text' class='form-control' id='floatingInput' placeholder='Video Name' name='videoName' required>";
                            echo "<label class='text-muted' for='floatingInput'>Video name</label>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<input type='text' class='form-control' id='floatingInput' placeholder='Video URL' name='videoURL' required>";
                            echo "<label class='text-muted' for='floatingInput'>Video URL</label>";
                        echo '</div>';
                        echo '<button class="btn btn-sm btn-primary" type="submit" name="videoAdded">Add video</button>';
                    echo '</form>';

                    if(isset($_POST['videoAdded'])) {
                        $addedVideoName = mysqli_real_escape_string($con,$_POST['videoName']);
                        $yt_regex_str = "/https:\/\/www.youtube.com\/watch\?v=/";
                        $addedVideoUrl = $_POST['videoURL'];
                        if (preg_match($yt_regex_str, $addedVideoUrl)) {
                            $addedVideoUrl = preg_replace($yt_regex_str, "", $addedVideoUrl);
                            $addedVideoId = $_POST['videoID'];
    
                            $qr = "SELECT video_id FROM eduVid WHERE video_id='$addedVideoId' AND course_code='$ccode'";
                            $result = mysqli_query($con,$qr);
                            $n = mysqli_num_rows($result);
                            if($n > 0) {
                                echo "<script>alert('Video ID already exists.')</script>";
                                echo "<script>window.location.replace('educatorVideo.php')</script>";
                            }
                            else {
                                $qr = "INSERT INTO eduVid (course_code, video_id, video_name, video_url) VALUES ('$ccode', '$addedVideoId', '$addedVideoName', '$addedVideoUrl')";
                                if(mysqli_query($con,$qr)) {
                                    echo "<script>alert('Video Added.')</script>";
                                    echo "<script>window.location.replace('educatorVideo.php')</script>";
                                }
                            } 
                        }
                        else {
                            echo "<script>alert('Enter valid YouTube URL.')</script>";
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
