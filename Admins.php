<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
if(isset($_POST["submit"])){
    $UserName=$_POST["Username"];
    $Name=$_POST["Name"];
    $Password=$_POST["Password"];
    $ConfirmPassword=$_POST["confirmPassword"];
    $Admin = $_SESSION["Username"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($UserName) || empty($Password) || empty($ConfirmPassword)){
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        Redirect_to("Admins.php");
    }
    elseif(strlen($Password)<5){
        $_SESSION["ErrorMessage"]="Pasword should be greater than 5 characters";
        Redirect_to("Admins.php");
    }
    elseif($Password != $ConfirmPassword){
        $_SESSION["ErrorMessage"]="Password and Confirm Password should match";
        Redirect_to("Admins.php");
    }
    elseif(CheckUserNameExistOrNot($UserName)){
        $_SESSION["ErrorMessage"]="Username Exists. Try Another One!";
        Redirect_to("Admins.php");
    }
    else{
    //query to insert new admin in db when everything is fine
    global $ConnectingDB;
    $sql = "Insert into admins(datetime,username,password,aname,addedby)";
    $sql .= "VALUES(:datetime,:username,:password,:aname,:adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':datetime',$DateTime);
    $stmt->bindValue(':username',$UserName);
    $stmt->bindValue(':password',$Password);
    $stmt->bindValue(':aname',$Name);
    $stmt->bindValue(':adminName',$Admin);
    $Execute=$stmt->execute();
    if($Execute){
        $_SESSION["SuccessMessage"]="New Admin added Successfully";
        Redirect_to("Admins.php");
       }
       else{
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("Admins.php");
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
     <title>Admins</title>
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
                <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user text-success"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="Logout.php" class="nav-link text-danger" ><i class="fa-solid fa-user-times"></i> Logout</a></li>
                </ul>
            </div>
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;"></div>
        <!-- NAVBAR END -->

        <!-- HEADER -->
        <header class="bg-dark  text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1><i class="fa-solid fa-user" style="color: #27aae1;"></i> Manage Admins</h1>
                    </div>

                </div>
            </div>
        </header>

        <!-- HEADER END -->

        <!-- MAIN AREA -->
        <section class="container py-2 mb-4">
            <div class="row" >
            <div class="offset-lg-1 col-lg-10" style="min-height: 300px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="Admins.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header">
                        <h1>Add New Admin</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="username"><span class="fieldInfo"> Username: </span></label>
                            <input class="form-control" type="text" name="Username" id="username" >
                        </div>
                        <div class="form-group">
                            <label for="Name"><span class="fieldInfo"> Name: </span></label>
                            <input class="form-control" type="text" name="Name" id="Name" >
                            <small class="text-muted">Optional</small>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="fieldInfo"> Password: </span></label>
                            <input class="form-control" type="password" name="Password" id="password" >
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword"><span class="fieldInfo"> Confirm Password: </span></label>
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" >
                        </div>
                        <div class="row pt-3">  
                            <div class="d-grid gap-2 col-lg-6 mb-2" >
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fa-solid fa-arrow-left"></i> Back To Dashboard </a>
                            </div>
                            <div class="d-grid gap-2 col-lg-6 mb-2">
                                <button type="submit" name="submit" class="btn btn-success btn-block ">
                                <i class="fa-solid fa-check"></i> Publish 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Username</th>
                            <th>Admin Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM admins ORDER BY id desc";
                $Execute =$ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                    $AdminId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $AdminUsername = $DataRows["username"];
                    $AdminName = $DataRows["aname"];
                    $AddedBy = $DataRows["addedby"];
                    $SrNo++;

                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($DateTime); ?></td>
                        <td><?php echo htmlentities($AdminUsername); ?></td>
                        <td><?php echo htmlentities($AdminName); ?></td>
                        <td><?php echo htmlentities($AddedBy); ?></td>
                        <td><a class="btn btn-outline-danger" href="DeleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>
            </div>

            </div>

        </section>


        <!-- MAIN AREA END -->

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