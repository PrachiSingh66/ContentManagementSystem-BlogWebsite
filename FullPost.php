<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $SearchQueryParameter=$_GET["id"];
if(isset($_POST["submit"])){
    $Name=$_POST["CommenterName"];
    $Email=$_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
    elseif(strlen($Comment)>500){
        $_SESSION["ErrorMessage"]="Comment length should be less than 500 characters";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }
    else{
    //query to insert comment in db when everything is fine
    global $ConnectingDB;
    $sql = "Insert into comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':name',$Name);
    $stmt->bindValue(':email',$Email);
    $stmt->bindValue(':comment',$Comment);
    $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
    $Execute = $stmt->execute();
    if($Execute){
        $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
       }
       else{
        $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
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
     <title>Blog Page</title>
     <style media="screen">
        .heading{
    font-family: Bitter,Georgia, 'Times New Roman', Times, serif;
    font-weight: bold;
    color: #005E90;
}
.heading:hover{
    color: #0090DB;
}
    </style>
     
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
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <form class="row g-3" action="Blog.php">
                        <div class="col">
                            <input class="form-control me-2" type="text" name="Search" placeholder="Search here">
                        </div>
                        <div class="col">
                            <button  class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
            </div>
        </nav>
        <div style="height: 10px; background: #27aae1;"></div>
        <!-- NAVBAR END -->

        <!-- HEADER -->
        <div class="container">
            <div class="row mt-4">
                <!-- main area start -->
                <div class="col-sm-8">
                    <h1>Content Management System Blog</h1>
                    <h1 class="lead">The Complete blog by using PHP</h1>
                    <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                    <?php 
                    global $ConnectingDB;
                    if(isset($_GET["SearchButton"])){
                        $Search = $_GET["Search"];
                        $sql = "SELECT * FROM posts where datetime LIKE :search OR category LIKE :search OR title LIKE :search OR post LIKE :search";
                        $stmt = $ConnectingDB->prepare($sql);
                        $stmt->bindValue(':search','%'.$Search.'%');
                        $stmt->execute();
                    }
                        //default sql query
                       else{
                        $PostIdFromURL=$_GET['id'];
                        if(!isset($PostIdFromURL)){
                            $_SESSION["ErrorMessage"]="Bad Request !!";
                            Redirect_to("Blog.php");
                        }
                        $sql = "SELECT * FROM posts where id=$PostIdFromURL";
                        $stmt = $ConnectingDB->query($sql);
                    }  
                        while($DataRows = $stmt->fetch()) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $PostTitle = $DataRows["title"];
                            $Category = $DataRows["category"];
                            $Admin = $DataRows["author"];
                            $Image = $DataRows["image"];
                            $PostText = $DataRows["post"];
                    ?>
                <div class="card mb-2">
                    <img src="upload/<?php echo htmlentities($Image); ?>" class="img-fluid card-img-top" style="max-height:450px">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                        <small class="text-muted">Category: <span class="text-dark"><?php echo $Category; ?></span> & Written by <span class="text-dark"><?php echo $Admin; ?></span> On <?php echo htmlentities($DateTime); ?></small>
                        <hr>
                        <p class="card-text">
                        <?php echo htmlentities($PostText); ?></p>
                        
                    </div>
                </div>
                <?php } ?>
                <!-- comment part start -->
                <!-- Fetching existing comment start  -->
                
                <span class="fieldInfo">Comments</span>
                <br>
                <br>
                
                            <?php 
                            global $ConnectingDB;
                            $sql="SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                            $stmt=$ConnectingDB->query($sql);
                            while($DataRows=$stmt->fetch()){
                                $CommentDate = $DataRows['datetime'];
                                $CommenterName = $DataRows['name'];
                                $CommentContent = $DataRows['comment'];
                            ?>
                           <div>
                                <div class="media CommentBlock">
                                    <div class="image ">
                                    <img src="images/comment.png" alt="" class="img-fluid rounded float-center" height="50px" width="50px">
                                    </div>
                                <div class="media-body ms-2">
                                        <h6 class="lead"><?php echo $CommenterName; ?></h6>
                                        <p class="small"><?php echo $CommentDate; ?></p>
                                        <p><?php echo $CommentContent; ?></p>
                                </div>
                                </div>
                           </div>
                            <hr>
                            <?php } ?>
                <!-- Fetching existing comment end -->
                
            <form action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="fieldInfo">Share your thoughts about this post</h5>
                    </div>
                    <div class="card-body">
                        <div class=" input-group mb-2">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input class="form-control" id="floatingInputGroup1" type="text" name="CommenterName" placeholder="Name">
                        </div>
                        <div class=" input-group mb-2">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input class="form-control" id="floatingInputGroup2" type="email" name="CommenterEmail" placeholder="Email">
                        </div>
                        <div class="form-group mb-2">
                            <textarea name="CommenterThoughts"  cols="30" rows="6" class="form-control"></textarea>
                        </div>
                        <div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>

            </form>

                </div>
              
 

                <!-- main area end -->

                <!-- side area start -->
                <div class="col-sm-4">
                    <div class="card mt-4">
                        <div class="card-body">
                            <img src="images/BlogImage.jpg" class="d-block img-fluid mb-3">
                            <div class="text-center">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil natus optio quo, odit accusamus vitae omnis! Dolorem architecto et, adipisci, ullam quasi sit cumque ea debitis commodi iure repellat expedita distinctio magnam? Iste quas ad ipsam laborum, temporibus in numquam earum vitae libero, veniam harum quod quisquam commodi facilis minima architecto atque veritatis perspiciatis? Natus a quidem corrupti praesentium quibusdam dolores! Quaerat, temporibus accusantium!
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header bg-dark text-light">
                            <h2 class="lead">Sign Up !</h2>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <input type="button" class="btn btn-success btn-lg btn-block ms-1" value="Join the Forum">
                                <input type="button" class="btn btn-danger btn-lg btn-block ms-5" value="Login">
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Enter your email">
                                <div class="input-group-text">
                                    <button type="button" class="btn btn-primary btn-sm text-center text-white">Subscribe Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header bg-primary text-light">
                            <h2 class="lead">Categories</h2>
                            </div>
                            <div class="card-body">
                                <?php 
                                global $ConnectingDB;
                                $sql = "SELECT * FROM category ORDER BY id desc";
                                $stmt = $ConnectingDB->query($sql);
                                while($DataRows=$stmt->fetch()){
                                    $CategoryId = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];
                                    ?>
                                    <a href="Blog.php?title=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a>
                                    <br>
                               <?php } ?>
                          
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h2 class="lead"> Recent Posts</h2>
                        </div>
                        <div class="card-body">
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                            $stmt = $ConnectingDB->query($sql);
                            while($DataRows = $stmt->fetch()) {
                                $Id = $DataRows["id"];
                                $DateTime = $DataRows["datetime"];
                                $PostTitle = $DataRows["title"];
                                $Image = $DataRows["image"];
                            ?>
                            <div class="card" >
                            <div class="row">
                                    <div class="col align-self-center ms-3">
                                        <img src="upload/<?php echo htmlentities($Image); ?>" class="img-fluid rounded">
                                    </div>
                                    <div class="col">
                                        <div class="card-body">
                                            <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><h6 class="lead"><?php echo htmlentities($PostTitle); ?></h6></a>
                                            <p class="small"><?php echo htmlentities($DateTime); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- side area end -->
                
            </div>
        </div>

        <!-- HEADER END -->
<br>
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