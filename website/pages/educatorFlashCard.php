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
                        <a class="nav-link active" href="educatorFlashCard.php">Flash Cards</a>
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
            <?php echo "<h5>Your Flashcards in course: " . $_SESSION['course'] . " - " . $_SESSION['courseName'] . "</h5>"; ?>
            <table class="table table-secondary table-striped table-hover table-bordered" style="width: 50%;" >
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Flashcard ID</th>
                        <th scope="col">View Flashcard</th>
                        <th scope="col">Modify Flashcard</th>
                        <th scope="col">Delete Flashcard</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $mail = $_SESSION['mail'];
                    $qr = "SELECT * FROM eduCard WHERE course_code='$ccode' ORDER BY card_id";
                    $result = mysqli_query($con,$qr);
                    $n = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);

                    if($n == 0) {
                        echo "<tr><td class='text-center' colspan='5'>No Flashcards added</td></tr>";
                    }
                    else {
                        for($i=1;$i <= $n; $i++, $row = mysqli_fetch_array($result)) {
                            echo '<tr>';
                                echo '<th scope="row">' . $i . '</th>';
                                echo '<td>' . $row['card_id'] . '</td>';
                                echo '<td>';
                                    echo "<button class='w-100 btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#Card{$row['card_id']}'>View</button>";
                                    echo "<div class='modal fade' id='Card{$row['card_id']}' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='CardLabel{$row['card_id']}' aria-hidden='true'>";
                                        echo '<div class="modal-dialog">';
                                            echo '<div class="modal-content">';
                                                echo '<div class="modal-header">';
                                                    echo "<h5 class='modal-title' id='CardLabel{$row['card_id']}'>{$row['card_name']}</h5>";
                                                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                                    echo "</div>";
                                                    echo '<div class="modal-body">';
                                                        echo "{$row['card_desc']}";
                                                    echo '</div>';
                                                    echo '<div class="modal-footer">';
                                                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</td>';
                                echo '<td>';
                                    echo '<form method="post" action="educatorFlashCard.php">';
                                    echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='modifyCard' value='{$row['card_id']}'>Modify</button>";
                                    echo '</form>';
                                echo '</td>';
                                echo '<td>';
                                    echo '<form method="post" action="educatorFlashCard.php">';
                                    echo "<button class='w-100 btn btn-sm btn-primary' type='submit' name='deleteCard' value='{$row['card_id']}'>Delete</button>";
                                    echo '</form>';
                                echo '</td>';
                            echo '</tr>';
                        }
                    }
                    
                ?>
                </tbody>
            </table>

            <form method="post" action="educatorFlashCard.php" enctype="multipart/form-data">
                <button class="btn btn-sm btn-primary" type="submit" name="AddCard">Add new Flashcard</button>
           </form>

            <?php

                if(isset($_POST['modifyCard']) || isset($_POST['CardModified'])) {
                    echo '<form class="form-signin w-100 m-auto" method="post" action="educatorFlashCard.php" id="modifyCard" enctype="multipart/form-data">';
                        $cardToModify = $_POST['modifyCard'];
                        echo "Editing flahcard with ID: " . $cardToModify;
                        $qr = "SELECT * FROM eduCard WHERE card_id='{$_POST['modifyCard']}'";
                        $result = mysqli_query($con, $qr);
                        $row = mysqli_fetch_array($result);
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='cardName' placeholder='{$row['card_name']}' form='modifyCard' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='cardDesc' placeholder='{$row['card_desc']}' form='modifyCard' required></textarea>";
                            echo "<input type='hidden' class='form-control' id='floatingInput' name='modifyCard' value='$cardToModify' required>";
                        echo '</div>';
                        echo '<br><button class="btn btn-sm btn-primary" type="submit" name="cardModified">Modify</button>';
                    echo '</form>';

                    if(isset($_POST['cardModified'])) {
                        $modifiedCardName = $_POST['cardName'];
                        $modifiedCardDesc = $_POST['cardDesc'];
                        $cardToModify = $_POST['modifyCard'];
                        $qr = "UPDATE eduCard SET card_name='$modifiedCardName' , card_desc='$modifiedCardDesc' WHERE course_code='$ccode' AND card_id='$cardToModify'";
                        if(mysqli_query($con,$qr)) {
                            echo "<script>window.location.replace('educatorFlashCard.php')</script>";
                        }
                        else {
                            echo "<script>alert('$modifiedCardName $modifiedCardDesc $cardToModify oof.')</script>";
                        }
                    }
                }

                if(isset($_POST['deleteCard'])) {
                    $cardToDelete = $_POST['deleteCard'];
                    $qr = "DELETE FROM eduCard WHERE course_code='$ccode' AND card_id='$cardToDelete'";
                    if(mysqli_query($con,$qr)) {
                        echo "<script>alert('Flashcard deleted.')</script>";
                        echo "<script>window.location.replace('educatorFlashCard.php')</script>";
                    }
                }

                if(isset($_POST['AddCard']) || isset($_POST['cardAdded'])) {
                    echo '<form class="form-signin w-100 m-auto" id="addCard" method="post" action="educatorFlashCard.php" enctype="multipart/form-data">';
                        echo '<div class="form-floating">';
                            echo "<input type='number' class='form-control' id='floatingInput' placeholder='Card ID' name='cardID' required>";
                            echo "<label class='text-muted' for='floatingInput'>Card ID</label>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='cardName' placeholder='Card Name' form='addCard' required></textarea>";
                        echo '</div>';
                        echo '<div class="form-floating">';
                            echo "<br><textarea name='cardDesc' placeholder='Card Description' form='addCard' required></textarea>";
                        echo '</div>';
                        echo '<br><button class="btn btn-sm btn-primary" type="submit" name="cardAdded">Add flashcard</button>';
                    echo '</form>';

                    if(isset($_POST['cardAdded'])) {
                        $addedCardName = $_POST['cardName'];
                        $addedCardDesc = $_POST['cardDesc'];
                        $addedCardId = $_POST['cardID'];
                        $qr = "INSERT INTO eduCard (course_code, card_id, card_name, card_desc) VALUES ('$ccode', '$addedCardId', '$addedCardName', '$addedCardDesc')";
                        if(mysqli_query($con,$qr)) {
                            echo "<script>alert('Flashcard Added.')</script>";
                            echo "<script>window.location.replace('educatorFlashCard.php')</script>";
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
