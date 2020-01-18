<?php
ob_start();  // output buffering start
session_start();
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    // page title variable
    $pageTitle = "Dashboard";
// the latest users registered to the site
    $latestUser = 5;

    $theLatest = getLatest("*", "users", "UserID", $latestUser);

    ?>
<div class="home-stats text-center">
    <div class="container ">
        <h1 class="">Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    Total Members
                    <span><a href="members.php"><?php echo countItems("UserID", "users") ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    Pending Members
                    <span><a
                            href="members.php?do=manage&page=pending"><?php echo checkItems("RegStatus", "users", 0) ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    Total Items
                    <span>100</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    Total Comments
                    <span>50</span>
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
                        <h5 class="card-title text-center text-capitalize"><i class="fa fa-user"></i> Latest <?php echo $latestUser ?> users registered
                        </h5>
                        <ul class="list-group list-group-flush latest-users">
                            <?php
                              foreach ($theLatest as $user) {
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
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-tag"></i> Latest Itemss </h5>
                        <div class="card-tex">
                            test
                        </div>
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
