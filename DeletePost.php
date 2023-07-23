<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php Confirm_Login(); ?>
<?php 
$SearchQueryParameter = $_GET['id'];
// fetching existing content according to post
global $ConnectingDB;
            $sql = "SELECT * FROM posts where id='$SearchQueryParameter'";
            $stmt = $ConnectingDB->query($sql);
            while($DataRows = $stmt->fetch()) {
                $PostTitleToBeDeleted = $DataRows["title"];
                $CategoryToBeDeleted = $DataRows["category"];
                $ImageToBeDeleted = $DataRows["image"];
                $PostTextToBeDeleted = $DataRows["post"];
            }
if(isset($_POST["submit"])){
    //query to delete post in db when everything is fine
    global $ConnectingDB;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
    $Execute =$ConnectingDB->query($sql);    
    if($Execute){
        $Target_path_to_delete_image = "upload/$ImageToBeDeleted";
        unlink($Target_path_to_delete_image);
        $_SESSION["SuccessMessage"]="Post Deleted Successfully";
        Redirect_to("Posts.php");
       }
       else{
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("Posts.php");
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
     <title>Delete post</title>
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
                        <a href="Dasboard.php" class="nav-link">Dashboard</a>
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
                        <h1><i class="fa-solid fa-edit" style="color: #27aae1;"></i> Delete Post </h1>
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
            <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group pt-3">
                            <label for="title"><span class="fieldInfo"> Post Title: </span></label>
                            <input disabled class="form-control" type="text" name="posttitle" id="title" placeholder="Type title here" value="<?php echo $PostTitleToBeDeleted; ?>">
                        </div>
                        <div class="form-group pt-3">
                            <span class="fieldInfo">Existing Category: </span>
                            <?php echo $CategoryToBeDeleted; ?>
                        </div>
                        <div class="form-group pt-3">
                        <span class="fieldInfo">Existing Image: </span>
                            <img class="mb-1" src="upload/<?php echo $ImageToBeDeleted; ?>" width="170px"; height="70px"; >
                            
                        </div>
                        <div class="form-group pt-3">
                            <label for="Post"><span class="fieldInfo"> Post </span></label>
                            <textarea disabled class="form-control" name="PostDescription" id="Post" cols="30" rows="10">
                                <?php echo $PostTextToBeDeleted; ?>
                            </textarea>
                        </div>
                        <div class="row pt-3">  
                            <div class="d-grid gap-2 col-lg-6 mb-2" >
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fa-solid fa-arrow-left"></i> Back To Dashboard </a>
                            </div>
                            <div class="d-grid gap-2 col-lg-6 mb-2">
                                <button type="submit" name="submit" class="btn btn-danger btn-block ">
                                <i class="fa-solid fa-trash"></i> Delete 
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
