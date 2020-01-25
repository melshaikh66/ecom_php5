<?php

/*==================================
==== Manage Comments page ===========
==== add | delete | edit ===========
==================================*/

ob_start();
session_start();

$pageTitle = "Comments";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    // start manage page
   
    if ($do == "manage") { // manage page

        $stmt = $con->prepare("SELECT 
                                        comments.*, items.Name AS Item, users.Username AS Username
                                FROM  
                                        comments 
                                INNER JOIN
                                        items
                                ON
                                        items.Item_ID = comments.Item_ID
                                INNER JOIN
                                        users
                                ON
                                        users.UserID = comments.User_ID ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
?>
<h1 class="text-center">Manage Comments</h1>
<div class="container">
    <div class="table-responsive">
        <table class="text-center main-table table table-bordered">
            <tr>
                <th>#id</th>
                <th>Comment</th>
                <th>Item</th>
                <th>User Name</th>
                <th>Added date</th>
                <th>Control</th>
            </tr>
            <?php

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $row['C_ID'] . "</td>";
            echo "<td>" . $row['Comment'] . "</td>";
            echo "<td>" . $row['Item'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['C_Date'] . "</td>";
            echo "<td>
            <a href='comments.php?do=edit&comid=" . $row['C_ID'] . " 'class='btn btn-success btn-sm'><i class='fa fa-edit'></i> Edit</a>
            <a href='comments.php?do=delete&comid=" . $row['C_ID'] . "' class='confirm btn btn-danger btn-sm'><i class='far fa-trash-alt'></i> Delete</a>";

            if ($row['Status'] == 0) {

                echo "<a href='comments.php?do=approve&comid=" . $row['C_ID'] . "' class='btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
            }

            echo "</td>";

            echo "</tr>";
        }
        ?>
        </table>
    </div>
</div>
<?php

    } elseif ($do == "edit") {

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ?");
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {

?>
<h1 class="text-center">Edit Comments</h1>
<div class="container">
    <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="comid" value="<?php echo $comid ?>">
        <!-- start comment feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Comment</label>
            <div class="col-9 col-md-6">
                <textarea name="comment" class="form-control"><?php echo $row['Comment'] ?></textarea>
            </div>
        </div>
        <!-- end comment feild -->
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
        echo "<h1 class='text-center'>Update Comment</h1>";
        echo "<div class ='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $id         = $_POST['comid'];
            $comment    = $_POST['comment'];

            // Validate the form

                // update the database
                $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ?");
                $stmt->execute(array($comment, $id));
                // echo success message

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Updated</div>";
                redirectHome($theMsg, "back");

            
        } else {
            $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
            redirectHome($theMsg);

        }
        echo "</div>";
    } elseif ($do == "delete") {
        // delete member page
        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class ='container'>";

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        // select all data depend on this id
        $check = checkItems("C_ID", "comments", $comid);

        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :comid");
            $stmt->bindParam(":comid", $comid);
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
        echo "<h1 class='text-center'>Approve Comment</h1>";
        echo "<div class ='container'>";

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
// select all data depend on this id
        $check = checkItems("C_ID", "comments", $comid);

        if ($check > 0) {
            $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ?");
            $stmt->execute(array($comid));
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