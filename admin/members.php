<?php

/*==================================
==== Manage members page ===========
==== add | delete | edit ===========
==================================*/
ob_start();
session_start();

$pageTitle = "Members";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    // start manage page
    $query = "";
    if (isset($_GET["page"]) && $_GET['page'] == "pending") {
        $query = "AND RegStatus = 0";
    }

    if ($do == "manage") { // manage page

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");

        $stmt->execute();

        $rows = $stmt->fetchAll();

        ?>
<h1 class="text-center">Manage Members</h1>
<div class="container">
    <div class="table-responsive">
        <table class="text-center main-table table table-bordered">
            <tr>
                <th>#id</th>
                <th>Username</th>
                <th>Email</th>
                <th>FullName</th>
                <th>Registered date</th>
                <th>Control</th>
            </tr>
            <?php

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $row['UserID'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['FullName'] . "</td>";
            echo "<td>" . $row['Date'] . "</td>";
            echo "<td>
            <a href='members.php?do=edit&userid=" . $row['UserID'] . " 'class='btn btn-success btn-sm'><i class='fa fa-edit'></i> Edit</a>
            <a href='members.php?do=delete&userid=" . $row['UserID'] . "' class='confirm btn btn-danger btn-sm'><i class='far fa-trash-alt'></i> Delete</a>";

            if ($row['RegStatus'] == 0) {

                echo "<a href='members.php?do=approve&userid=" . $row['UserID'] . "' class='btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
            }

            echo "</td>";

            echo "</tr>";
        }
        ?>
        </table>
    </div>
    <a href='members.php?do=add' class='btn btn-primary btn-sm'><i class="fa fa-plus"></i> Add new member</a>
</div>
<?php } elseif ($do == "add") { // Add page ?>

<h1 class="text-center">Add Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">
        <!-- start user name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Username</label>
            <div class="col-9 col-md-6">
                <input type="text" name="username" class="form-control" autocomplete="off" required
                    placeholder="Username to login" />
            </div>
        </div>
        <!-- end user name feild -->
        <!-- start password feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Password</label>
            <div class="col-9 col-md-6">
                <input type="password" name="password" class="password form-control" autocomplete="new-password"
                    placeholder="Password to login" required />
                <i class="show-pass fa fa-eye fa-2x"></i>
            </div>
        </div>
        <!-- end password feild -->
        <!-- start Email feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Email</label>
            <div class="col-9 col-md-6">
                <input type="email" name="email" class="form-control" autocomplete="off" required
                    placeholder="Email address" />
            </div>
        </div>
        <!-- end Email feild -->
        <!-- start full name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Full name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="full" class="form-control" autocomplete="off" required
                    placeholder="Type your full name" />
            </div>
        </div>
        <!-- end full name feild -->
        <!-- start submit feild -->
        <div class="form-group row">
            <div class="offset-3 col-sm-10">
                <input type="submit" value="Add Member" class="btn btn-success" />
            </div>
        </div>
        <!-- end submit feild -->
    </form>
</div>

<?php } elseif ($do == "insert") { // insert page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h1 class='text-center'>Add Member</h1>";
            echo "<div class ='container'>";

            //get variables from form
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['full'];
            $hashedPass = sha1($pass);
            // Validate the form

            $formErrors = array();
            if (strlen($user) < 4) {
                $formErrors[] = "User name can't be less than <strong>4 characters</strong>";
            }
            if (strlen($user) > 20) {
                $formErrors[] = " User name can't be more than <strong>20 characters</strong>";
            }

            if (empty($user)) {
                $formErrors[] = " User name can't be <strong>Empty</strong>";
            }
            if (empty($pass)) {
                $formErrors[] = " Password can't be <strong>Empty</strong>";

            }

            if (empty($email)) {
                $formErrors[] = " Email can't be <strong>Empty</strong>";

            }

            if (empty($name)) {
                $formErrors[] = "Full name can't be <strong>Empty</strong>";

            }
            // loop into error array and echo it
            foreach ($formErrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }

            // check if there is no errors update the database
            if (empty($formErrors)) {

                $check = checkItems("Username", "users", $user);
                if ($check == 1) {

                    $theMsg = "<div class='alert alert-danger'>Sorry this username already exist</div>";
                    redirectHome($theMsg, "back");
                } else {
                    // insert the user info to the database
                    $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName,RegStatus, Date)
                                                VALUES(:zuser, :zpass, :zmail, :zname, 1, now())");
                    $stmt->execute(array(
                        "zuser" => $user,
                        "zpass" => $hashedPass,
                        "zmail" => $email,
                        "zname" => $name,
                    ));
                    // echo success message

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Inserted</div>";
                    redirectHome($theMsg, "back");
                }
            }
        } else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
            redirectHome($theMsg, "back");
            echo "</div>";
        }
        echo "</div>";

    } elseif ($do == "edit") {

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
<h1 class="text-center">Edit Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>">
        <!-- start user name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Username</label>
            <div class="col-9 col-md-6">
                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>"
                    autocomplete="off" required />
            </div>
        </div>
        <!-- end user name feild -->
        <!-- start password feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Password</label>
            <div class="col-9 col-md-6">
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>
" />
                <input type="password" name="newpassword" class="form-control" autocomplete="new-password"
                    placeholder="Leave blank if u don't want to change" />
            </div>
        </div>
        <!-- end password feild -->
        <!-- start Email feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Email</label>
            <div class="col-9 col-md-6">
                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>"
                    autocomplete="off" required />
            </div>
        </div>
        <!-- end Email feild -->
        <!-- start full name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Full name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>"
                    autocomplete="off" required />
            </div>
        </div>
        <!-- end full name feild -->
        <!-- start submit feild -->
        <div class="form-group row">
            <div class="offset-3 col-sm-10">
                <input type="submit" value="Save" class="btn btn-success" />
            </div>
        </div>
        <!-- end submit feild -->
    </form>
</div>
<?php
} else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    } elseif ($do == 'Update') { //update page
        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class ='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $id = $_POST['userid'];
            $user = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['full'];

            // password trick
            $pass = empty($_POST["newpassword"]) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

            // Validate the form

            $formErrors = array();
            if (strlen($user) < 4) {
                $formErrors[] = "User name can't be less than <strong>4 characters</strong>";
            }
            if (strlen($user) > 20) {
                $formErrors[] = "User name can't be more than <strong>20 characters</strong>";
            }

            if (empty($user)) {
                $formErrors[] = "User name can't be <strong>Empty</strong>";
            }
            if (empty($email)) {
                $formErrors[] = "Email can't be <strong>Empty</strong>";

            }

            if (empty($name)) {
                $formErrors[] = "Full name can't be <strong>Empty</strong>";

            }
            // loop into error array and echo it
            foreach ($formErrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }

            // check if there is no errors update the database
            if (empty($formErrors)) {
                // update the database
                $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
                $stmt->execute(array($user, $email, $name, $pass, $id));
                // echo success message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Updated</div>";
                redirectHome($theMsg, "back");

            }
        } else {
            $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
            redirectHome($theMsg, "back");

        }
        echo "</div>";
    } elseif ($do == "delete") {
        // delete member page
        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class ='container'>";

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // select all data depend on this id
        $check = checkItems("userid", "users", $userid);

        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
            $stmt->bindParam(":userid", $userid);
            $stmt->execute();
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Deleted</div>";
            redirectHome($theMsg, "back");
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == "approve") {
        // approve page
        echo "<h1 class='text-center'>Approve Member</h1>";
        echo "<div class ='container'>";

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
// select all data depend on this id
        $check = checkItems("userid", "users", $userid);

        if ($check > 0) {
            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
            $stmt->execute(array($userid));
            $theMsg = "<div class='alert alert-success'> Member Activated successfully !</div>";
            redirectHome($theMsg, "back");
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg, "back");
        }
        echo "</div>";

    }
    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}
ob_end_flush();
?>