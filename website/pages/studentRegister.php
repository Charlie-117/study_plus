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
                  <a class="nav-link" aria-current="page" href="../index.html">Home</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Login
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item" href="studentLogin.php">Student login</a></li>
                     <li><a class="dropdown-item" href="educatorLogin.php">Educator login</a></li>
                  </ul>
               <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
               </li>
            </div>
         </div>
      </nav>


      <!-- content -->
      <form class="form-signin w-100 m-auto">
         <h1 class="h3 mb-3 fw-normal">Student registration</h1>
         <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="Name" required>
            <label class="text-muted" for="floatingInput">Name</label>
         </div>
         <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label class="text-muted" for="floatingInput">Email address</label>
         </div>
         <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label class="text-muted" for="floatingPassword">Password</label>
         </div>
         <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="Code" required>
            <label class="text-muted" for="floatingInput">Code</label>
         </div>
         <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
      </form>
      <h5 align="center"><a href="studentLogin.php">Already have an account? Login here</a></h5>



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