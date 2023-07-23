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
     <title>Comments Page</title>
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
                        <h1><i class="fa-solid fa-comments" style="color: #27aae1;"></i> Manage Comments </h1>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER END -->
            <section class="container py-2 mb-4">
                <div class="row" style="min-height: 30px;">
                <div class="col-lg-12" style="min-height: 400px;">
                <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM comments WHERE  status='OFF' ORDER BY id desc";
                $Execute =$ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                    $CommentId = $DataRows["id"];
                    $DateTimeOfComment = $DataRows["datetime"];
                    $CommenterName = $DataRows["name"];
                    $CommentContent = $DataRows["comment"];
                    $CommentPostId = $DataRows["post_id"];
                    $SrNo++;

                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td><a class="btn btn-outline-success" href="ApproveComment.php?id=<?php echo $CommentId; ?>">Approve</a></td>
                        <td><a class="btn btn-outline-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                        <td><a class="btn btn-outline-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>

                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM comments WHERE  status='ON' ORDER BY id desc";
                $Execute =$ConnectingDB->query($sql);
                $SrNo = 0;
                while($DataRows=$Execute->fetch()){
                    $CommentId = $DataRows["id"];
                    $DateTimeOfComment = $DataRows["datetime"];
                    $CommenterName = $DataRows["name"];
                    $CommentContent = $DataRows["comment"];
                    $CommentPostId = $DataRows["post_id"];
                    $SrNo++;

                ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td><a class="btn btn-outline-secondary" href="DisapproveComment.php?id=<?php echo $CommentId; ?>">Disapprove</a></td>
                        <td><a class="btn btn-outline-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                        <td><a class="btn btn-outline-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>

                </div>

                </div>

            </section>
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