<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
if(isset($_SESSION["User_ID"])){
    Redirect_to("Dashboard.php");
}
if(isset($_POST["submit"])){
    $UserName=$_POST["Name"];
    $Password=$_POST["Password"];
    if(empty($UserName)||empty($Password)){
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        Redirect_to("Login.php");
    }
    else{
        $Found_Account=Login_Attempt($UserName,$Password);
        if($Found_Account){
            $_SESSION["User_ID"]=$Found_Account["id"];
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["AdminName"]=$Found_Account["aname"];
            $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["Username"]."!";
            if(isset($_SESSION["TrackingURL"])){
                Redirect_to($_SESSION["TrackingURL"]);
            }else{
            Redirect_to("Dashboard.php");
            }
        }
        else{
            $_SESSION["ErrorMessage"]="Incorrect Username/Password";
            Redirect_to("Login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/15650c5a67.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" >
    <link rel="stylesheet" href="css/styles.css" type="text/css">
     <title>Login Page</title>
</head>
<body>
        <!-- NAVBAR -->
        <div style="height: 10px; background: #27aae1;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container" >
                <a href="#" class="navbar-brand"> CONTENTSYSTEM.COM </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;"></div>
        <!-- NAVBAR END -->

        <!-- HEADER -->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       
                    </div>
                </div>
            </div>
        </header>

        <!-- HEADER END -->
        <!-- Main Area Start -->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="offset-3 col-sm-6" style="min-height:370px;">
                <br><br>
                <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h4>Welcome Back !</h4>
                            </div>
                            <div class="card-body bg-dark">
                            <form action="Login.php" method="post">
                            <label for="floatingInputGroup1"><span class="fieldInfo">UserName:</span></label>
                                    
                                <div class=" input-group mb-2">
                
                                    <span class="input-group-text bg-info"><i class="fa-solid fa-user "></i></span>
                                    <input class="form-control" id="floatingInputGroup1" type="text" name="Name" placeholder="UserName">
                                </div>
                                <label for="floatingInputGroup2"><span class="fieldInfo">Password:</span></label>
                                <div class=" input-group mb-2">
                                    
                                    
                                    <span class="input-group-text bg-info"><i class="fa-solid fa-lock "></i></span>
                                    <input class="form-control" id="floatingInputGroup2" type="password" name="Password" placeholder="Password">
                                </div>
                                <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="submit" class="btn btn-info btn-block login-btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Main Area End -->


        <!-- FOOTER -->
        <footer class="bg-dark text-white">
            <div class="container">
                <div class="row" >
                    <div class="col">
                    <p class="lead text-center">Theme By | Prachi Singh | <span id="year"></span> &copy; ----All right Reserved</p>
                    <p class="text-center small">
                        <a  href="#" target="_blank" style="color: white; text-decoration: none; cursor: pointer;">This site is made for the content management purpose. CONTENTSYSTEM.COM have all the rights.</a>
                    </p>
                    </div>
                </div>
            </div>
        </footer>
        <div style="height: 10px; background: #27aae1;"></div>
        <!-- FOOTER END -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
     <script>
        var dt=new Date();
        $('#year').text(dt.getFullYear());
     </script>
</body>
</html>