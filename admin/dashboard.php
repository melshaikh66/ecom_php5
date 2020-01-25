<?php
ob_start();  // output buffering start
session_start();
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    // page title variable
    $pageTitle = "Dashboard";
// the latest users registered to the site
    $numUsers = 5;

    $latestUsers = getLatest("*", "users", "UserID", $numUsers);

    $numItems = 5;

    $latestItems = getLatest("*", "items", "Item_ID", $numItems);

    $numComments = 5;

    $latestComments = getLatest("*", "comments", "C_ID", $numComments);

    ?>
<div class="home-stats text-center">
    <div class="container ">
        <h1 class="">Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                	<i class="fa fa-users"></i>
                    <div class="info">
                    Total Members
                    <span><a href="members.php"><?php echo countItems("UserID", "users") ?></a></span>
                    </div>
                    <div class='clearfix'></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                	<i class="fa fa-user-plus"></i>
                   <div class="info">
                    Pending Members
                    <span><a href="members.php?do=manage&page=pending"><?php echo checkItems("RegStatus", "users", 0) ?></a></span>
                    </div>
                    <div class='clearfix'></div>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                <i class="fa fa-tag"></i>
                    <div class="info">
                    Total Items
                    <span><a href="items.php"><?php echo countItems("Item_ID", "items") ?></a></span>
                    </div>
                    <div class='clearfix'></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                	<i class="fa fa-comments"></i>
                    <div class="info">
                    Total Comments
                    <span><?php echo countItems("C_ID", "comments") ?></span>
                    </div>
                    <div class='clearfix'></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="latest">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><i class="fa fa-user"></i> Latest <?php echo $numUsers ?> users registered
                        <span class="float-right toggle-info"><i class="fa fa-minus fa-lg"></i> </span>
                        </h5>
                        <ul class="list-group list-group-flush latest-users">
                            <?php
                              foreach ($latestUsers as $user) {
                                  echo "<li class='list-group-item text-capitalize'>";
                                     echo $user["Username"] ;
                                     echo "<a href='members.php?do=edit&userid="
                                   . $user['UserID']."'>  ";
                                       echo "<span class='btn btn-success btn-sm float-right'>";
                                           echo "<i class='fa fa-edit'></i>  Edit";
                                           if ($user['RegStatus'] == 0) {

                                               echo "<a href='members.php?do=approve&userid=" . $user['UserID'] . "' class='float-right btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
                                           }
                                        echo "</span>";
                                      echo "</a>";
                                   echo "</li>";
                              }
                              ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-tag"></i> Latest <?php echo $numUsers ?> Items Added <span class="float-right toggle-info"><i class="fa fa-minus fa-lg"></i> </span></h5>
                            <ul class="list-group list-group-flush latest-users">
                            <?php
                              foreach ($latestItems as $item) {
                                  echo "<li class='list-group-item text-capitalize'>";
                                        echo $item["Name"] ;
                                         echo "<a href='items.php?do=edit&itemid="
                                            . $item["Item_ID"]."'>  ";
                                       echo "<span class='btn btn-success btn-sm float-right'>";
                                           echo "<i class='fa fa-edit'></i>  Edit";
                                           if ($item['Approve'] == 0) {

                                               echo "<a href='items.php?do=approve&itemid=" . $item["Item_ID"]. "' class='float-right btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
                                           }
                                        echo "</span>";
                                      echo "</a>";
                                   echo "</li>";
                              }
                              ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-6">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-comments"></i> Latest <?php echo $numUsers ?> Comments <span class="float-right toggle-info"><i class="fa fa-minus fa-lg"></i> </span></h5>
                            <ul class="list-group list-group-flush latest-users">
                    <?php
                      $stmt = $con->prepare("SELECT 
                                                        comments.*, users.Username AS Username
                                                FROM  
                                                        comments 
                                                INNER JOIN
                                                        users
                                                ON
                                                        users.UserID = comments.User_ID");
                        $stmt->execute();
                        $comments = $stmt->fetchAll();
                        if (!empty($comments)){
                            foreach($comments as $comment){
                                echo '<div class="comment-box">';
                                    echo '<span class="user-name float-left text-center">' .$comment["Username"] . '</span>';
                                    echo '<p class="user-com">' .$comment["Comment"] . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo "There is no comments";
                        }
                    ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}

ob_end_flush(); // output buffering end
?>
