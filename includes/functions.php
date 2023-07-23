<?php require_once("includes/db.php"); ?>
<?php
function Redirect_to($New_location){
    header("Location:".$New_location);
    exit;
}
function CheckUserNameExistOrNot($UserName){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:username";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':username',$UserName);
    $stmt->execute();
    $Result =$stmt->rowCount();
    if($Result==1){
        return true;
    }
    else{
        return false;
    }
}
function Login_Attempt($UserName,$Password){
    global $ConnectingDB;
        $sql = "SELECT * FROM admins where username=:userName AND password=:passWord LIMIT 1";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':userName',$UserName);
        $stmt->bindValue(':passWord',$Password);
        $stmt->execute();
        $Result =$stmt->rowCount();
        if($Result==1){
           return $Found_Account=$stmt->fetch();
        }
        else{
            return null;
        }
}
function Confirm_Login(){
    if(isset($_SESSION["User_ID"])){
        return true;
    }
    else{
        $_SESSION["ErrorMessage"]="Login Required !";
        Redirect_to("Login.php");
    }
}
function TotalPosts(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts=array_shift($TotalRows);
    echo $TotalPosts;
}
function TotalCategories(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories=array_shift($TotalRows);
    echo $TotalCategories;
}
function TotalAdmins(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins=array_shift($TotalRows);
    echo $TotalAdmins;
}
function TotalComments(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments=array_shift($TotalRows);
    echo $TotalComments;
}
function CommentBadgesSuccess($PostId){
    global $ConnectingDB;
    $sql1 = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
    $stmt1 = $ConnectingDB->query($sql1);
    $TotalRecords = $stmt1->fetch();
    $Total=array_shift($TotalRecords);
    return $Total;
}
function CommentBadgesDanger($PostId){
    global $ConnectingDB;
    $sql2 = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
    $stmt2 = $ConnectingDB->query($sql2);
    $TotalRecords = $stmt2->fetch();
    $Total=array_shift($TotalRecords);
    return $Total;
}
?>