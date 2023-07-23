<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
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
     <title>BlogPosts</title>
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
                        <h1><i class="fa-solid fa-blog" style="color: #27aae1;"></i> Blog Posts </h1>
                    </div>
                    <div class="col-lg-3 mb-2 d-grid gap-2">
                        <a href="AddNewPost.php" class="btn btn-primary btn-block">
                            <i class="fa-solid fa-edit"></i> Add New Post
                        </a>
                    </div>
                    <div class="col-lg-3 mb-2 d-grid gap-2">
                        <a href="Categories.php" class="btn btn-info btn-block">
                            <i class="fa-solid fa-folder-plus"></i> Add New Category
                        </a>
                    </div>
                    <div class="col-lg-3 mb-2 d-grid gap-2">
                        <a href="Admins.php" class="btn btn-warning btn-block">
                            <i class="fa-solid fa-user-plus"></i> Add New Admin
                        </a>
                    </div>
                    <div class="col-lg-3 mb-2 d-grid gap-2">
                        <a href="Comments.php" class="btn btn-success btn-block">
                            <i class="fa-solid fa-check"></i> Approve Comments
                        </a>
                    </div>

                </div>
            </div>
        </header>

        <!-- HEADER END -->

        <!-- MAIN AREA -->
        <section class="container py-2 mb-4">
            <div class="row">
                <div class="col-lg-12">
                <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th>Sr.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>DateTime</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                        </thead>
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT * FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $sr = 0;
                        while($DataRows = $stmt->fetch()) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $PostTitle = $DataRows["title"];
                            $Category = $DataRows["category"];
                            $Admin = $DataRows["author"];
                            $Image = $DataRows["image"];
                            $PostText = $DataRows["post"];
                            $sr++;
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>
                                <?php 
                                if(strlen($PostTitle)>20){
                                    $PostTitle=substr($PostTitle,0,15).'..';
                                }
                                echo $PostTitle; 
                                ?></td>
                            <td>
                                <?php 
                                if(strlen($Category)>10){
                                   $Category= substr($Category,0,10).'..';
                                }
                                echo $Category; 
                                ?>
                                </td>
                            <td>
                            <?php 
                                if(strlen($DateTime)>11){
                                    $DateTime=substr($DateTime,0,11).'..';
                                }
                                echo $DateTime; 
                                ?>
                                </td>
                            <td>
                            <?php 
                                if(strlen($Admin)>8){
                                   $Admin= substr($Admin,0,8).'..';
                                }
                                echo $Admin; 
                                ?>
                            </td>
                            <td><img src="upload/<?php echo $Image; ?>" width="170px" height="50px"></td>
                            <td>
                            <?php 
                                        $Total=CommentBadgesSuccess($Id);
                                        if($Total>0){
                                        ?>
                                        <span class="badge bg-success">
                                            <?php
                                        echo $Total;
                                        ?>
                                        </span>
                                       <?php } ?>
                                    <?php 
                                    $Total=CommentBadgesDanger($Id);
                                        if($Total>0){
                                            ?>
                                            <span class="badge bg-danger">
                                            <?php
                                        echo $Total;
                                        ?>
                                       <?php }
                                        ?>
                            </td>
                            <td>
                                <a href="EditPost.php?id=<?php echo $Id ?>"><span class="btn btn-outline-success">Edit</span></a>
                                <a href="DeletePost.php?id=<?php echo $Id ?>"><span class="btn btn-outline-danger">Delete</span></a>
                        </td>
                            <td><a href="FullPost.php?id=<?php echo $Id ?>" target="_blank"><span class="btn btn-outline-primary">Live Preview</span></a></td>
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