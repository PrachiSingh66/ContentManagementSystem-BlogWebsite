<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
//fetching the existing admin data start
$AdminId = $_SESSION["User_ID"];
global $ConnectingDB;
$sql="SELECT * FROM admins WHERE id='$AdminId'";
$stmt=$ConnectingDB->query($sql);
while ($DataRows=$stmt->fetch()) {
    $ExistingName = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
//fetching the existing admin data end
if(isset($_POST["submit"])){
    $AName = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio = $_POST["Bio"];
    $Image = $_FILES["image"]["name"];
    $Target = "images/".basename($_FILES["image"]["name"]);
    if(strlen($AHeadline)>30){
        $_SESSION["ErrorMessage"]="Headline should be than 30 characters";
        Redirect_to("MyProfile.php");
    }
    elseif(strlen($ABio)>500){
        $_SESSION["ErrorMessage"]="Bio should be less than 500 characters";
        Redirect_to("MyProfile.php");
    }
    else{
    //query to update profile in db when everything is fine
    global $ConnectingDB;
    if(!empty($_FILES["image"]["name"])){
        $sql = "UPDATE admins SET aname='$AName',aheadline='$AHeadline',aimage='$Image',abio='$ABio' where id='$AdminId'";
    }
    else{
        $sql = "UPDATE admins SET aname='$AName',aheadline='$AHeadline',abio='$ABio' where id='$AdminId'";
    }
    $Execute =$ConnectingDB->query($sql);
    move_uploaded_file($_FILES["image"]["tmp_name"],$Target);
    if($Execute){
        $_SESSION["SuccessMessage"]="Details updated Successfully";
        Redirect_to("MyProfile.php");
       }
       else{
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("MyProfile.php");
       }
    }

}//end of main if
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
     <title>Profile</title>
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
                        <h1><i class="fa-solid text-success fa-user me-2" style="color: #27aae1;"></i> @<?php echo htmlentities($ExistingUsername); ?></h1>
                        <small><?php echo htmlentities($ExistingHeadline); ?></small>
                    </div>

                </div>
            </div>
        </header>

        <!-- HEADER END -->

        <!-- MAIN AREA -->
        <section class="container py-2 mb-4">
            <div class="row" >
                <!-- left area start -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo htmlentities($ExistingName); ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="images/<?php echo htmlentities($ExistingImage); ?>" class="block img-fluid mb-2">
                        <div><?php echo htmlentities($ExistingBio); ?></div>
                    </div>
                </div>
            </div>

        <!-- left area end -->

        <!-- right area start -->
            <div class="col-md-9" style="min-height: 400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light ">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group pt-3">
                            <input class="form-control" type="text" name="Name" id="title" placeholder="Your Name"> 
                        </div>
                        <div class="form-group pt-3">
                            <input class="form-control" type="text" name="Headline" id="title" placeholder="Headline">
                            <small class="text-muted"> Add a professional headline like, "Engineer" at XYZ or "Architect"</small>
                            <span class="text-danger">Not more than 30 characters</span>
                        </div>
                        <div class="form-group pt-3">
                            <textarea placeholder="Bio" class="form-control" name="Bio" id="Post" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group pt-3">
                            <label for="imageSelect"><span class="fieldInfo"> Select Image </span></label>
                            <div class="input-group">
                                <input class="form-control" type="file" name="image" id="imageSelect" >
                                <label for="imageSelect" class="input-group-text"></label>
                            </div>
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