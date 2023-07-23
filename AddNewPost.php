<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
if(isset($_POST["submit"])){
    $PostTitle = $_POST["posttitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["image"]["name"];
    $Target = "upload/".basename($_FILES["image"]["name"]);
    $PostText = $_POST["PostDescription"];
    $Admin = $_SESSION["Username"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"]="Title can't be empty!!";
        Redirect_to("AddNewPost.php");
    }
    elseif(strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"]="Post title should be greater than 5 characters";
        Redirect_to("AddNewPost.php");
    }
    elseif(strlen($PostTitle)>49){
        $_SESSION["ErrorMessage"]="Post title should be less than 50 characters";
        Redirect_to("AddNewPost.php");
    }
    elseif(strlen($PostText)>999){
        $_SESSION["ErrorMessage"]="Post Description should be less than 1000 characters";
        Redirect_to("AddNewPost.php");
    }
    else{
    //query to insert post in db when everything is fine
    global $ConnectingDB;
    $sql = "Insert into posts(datetime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue('dateTime',$DateTime);
    $stmt->bindValue(':postTitle',$PostTitle);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':postDescription',$PostText);
    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["image"]["tmp_name"],$Target);
    if($Execute){
        $_SESSION["SuccessMessage"]="Post with id : " .$ConnectingDB->lastInsertId()." added Successfully";
        Redirect_to("AddNewPost.php");
       }
       else{
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("AddNewPost.php");
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
     <title>Add new post</title>
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
                        <h1><i class="fa-solid fa-edit" style="color: #27aae1;"></i> Add New Post</h1>
                    </div>

                </div>
            </div>
        </header>

        <!-- HEADER END -->

        <!-- MAIN AREA -->
        <section class="container py-2 mb-4">
            <div class="row" >
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group pt-3">
                            <label for="title"><span class="fieldInfo"> Post Title: </span></label>
                            <input class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here">
                        </div>
                        <div class="form-group pt-3">
                            <label for="Categorytitle"><span class="fieldInfo"> Choose Category </span></label>
                            <select class="form-control" id="Categorytitle" name="Category">
                                <?php
                                //fetching all the categories from category table
                                global $ConnectingDB;
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB->query($sql);
                                while($DataRows = $stmt->fetch()) {
                                    $Id = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];
                                ?>
                                <option><?php echo $CategoryName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group pt-3">
                            <label for="imageSelect"><span class="fieldInfo"> Select Image </span></label>
                            <div class="input-group">
                                <input class="form-control" type="file" name="image" id="imageSelect" >
                                <label for="imageSelect" class="input-group-text"></label>
                            </div>
                        </div>
                        <div class="form-group pt-3">
                            <label for="Post"><span class="fieldInfo"> Post </span></label>
                            <textarea class="form-control" name="PostDescription" id="Post" cols="30" rows="10"></textarea>
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