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
     <title>Dashboard</title>
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
                        <h1><i class="fa-solid fa-cog" style="color: #27aae1;"></i> Dashboard </h1>
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
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <!-- left side area start -->
                <div class="col-lg-2 d-none d-md-block">
                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Posts</h1>
                            <h4 class="display-8">
                                <i class="fa-brands fa-readme"></i>
                                <?php
                                TotalPosts();
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Categories</h1>
                            <h4 class="display-8">
                                <i class="fa-solid fa-folder"></i>
                                <?php
                                TotalCategories();
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Admins</h1>
                            <h4 class="display-8">
                                <i class="fa-solid fa-users"></i>
                                <?php
                                TotalAdmins();
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card text-center bg-dark text-white mb-3">
                        <div class="card-body">
                            <h1 class="lead">Comments</h1>
                            <h4 class="display-8">
                                <i class="fa-solid fa-comments"></i>
                                <?php
                                TotalComments();
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- left side area end -->

                <!-- right side area start -->
                <div class="col-lg-10">
                    <h1>Top Posts</h1>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No. </th>
                                <th>Title</th>
                                <th>Date&Time</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <?php
                        global $ConnectingDB;
                        $SrNo = 0;
                        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $PostId= $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $Author = $DataRows["author"];
                            $Title = $DataRows["title"];
                            $SrNo++;
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($Title); ?></td>
                                <td><?php echo htmlentities($DateTime); ?></td>
                                <td><?php echo htmlentities($Author); ?></td>
                                <td>
                                        <?php 
                                        $Total=CommentBadgesSuccess($PostId);
                                        if($Total>0){
                                        ?>
                                        <span class="badge bg-success">
                                            <?php
                                        echo $Total;
                                        ?>
                                        </span>
                                       <?php } ?>
                                    <?php 
                                    $Total=CommentBadgesDanger($PostId);
                                        if($Total>0){
                                            ?>
                                            <span class="badge bg-danger">
                                            <?php
                                        echo $Total;
                                        ?>
                                       <?php }
                                        ?>
                                </td>
                                <td><a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">Preview</span></a></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>

                <!-- right side area end -->
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