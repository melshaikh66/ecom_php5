<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");

}
// incloude the init file
include "init.php";
// no nav bar variable
$noNavbar = "";
// page title variable 
$pageTitle = "Login";
// check if user coming from HTTP Post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $hashedPass = sha1($password);
// chech if user exist in database
    $stmt = $con->prepare("SELECT 
                                UserID,  Username, Password 
                            FROM 
                                users 
                            WHERE 
                                Username = ? 
                            AND 
                                Password = ? 
                            AND 
                                GroupID = 1
                            LIMIT 1"
                        );
    $stmt->execute(array($username, $hashedPass));
    $row  = $stmt->fetch();
    $count = $stmt->rowCount();

//    If count > 0 this mean the database contain record for this username
    if ($count > 0) {
        $_SESSION['username'] = $username;   //register session user name
        $_SESSION['ID'] = $row["UserID"];    // register session ID
        header("Location: dashboard.php");
        exit();
    }

}

?>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" class="login" method="POST">

    <h4 class="text-center">Admin Login</h4>
    <input class="form-control input-lg" type="text" name="user" placeholder="User Name" autocomplete="off" />
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block" type="submit" value="Login" />
</form>




<?php include $tpl . "footer.php";?>