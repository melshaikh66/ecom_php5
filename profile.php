<?php
session_start();
$pageTitle = "My Profile";
// incloude the init file
include "init.php";
if (isset($_SESSION['member'])){
  $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
  $getUser->execute(array($sessionUser));
  $info = $getUser->fetch();
?>
  <h1 class="text-center text-capitalize"><? echo "Welcome: " . $_SESSION['member'];?></h1>
  <div class="information block">
    <div class="container">
      <div class="card bg-light">
        <div class="card-header">
          My Information
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
           <li class="list-group-item"><i class="fa fa-unlock-alt fa-fw"></i><?php echo "<span>Name</span>: " . $info['Username']; ?></li>
           <li class="list-group-item"><i class="fa fa-envelope-open fa-fw"></i><?php echo "<span>Email</span>: " . $info['Email']; ?></li>
           <li class="list-group-item"><i class="fa fa-user fa-fw"></i><?php echo "<span>Full Name</span>: " . $info['FullName']; ?></li>
           <li class="list-group-item"><i class="far fa-calendar-alt fa-fw"></i></i><?php echo "<span>Regester Date</span>: " . $info['Date']; ?></li>
           <li class="list-group-item"><i class="fa fa-tag fa-fw"></i><?php echo "<span>Favourite Category</span>: " . $info['Date']; ?></li>
         </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="my-ads block">
    <div class="container">
      <div class="card bg-light">
        <div class="card-header">
          My Ads
        </div>
        <div class="card-body">
          <div class="row">
            <?php
            if (! empty(getItems("Member_ID", $info['UserID']))){
              foreach (getItems("Member_ID", $info['UserID']) as $item) {
                echo "<div class='col-sm-6 col-lg-3'>";
                  echo "<div class='card item-box'>";
                    echo "<span class='price'>" . $item['Price'] ."</span>";
                    echo "<img class='card-img-top img-fluid' src='layout/images/avatar.png' alt='avatar' />";
                    echo "<div class='card-body'>";
                      echo "<h3 class='card-title'>". $item['Name'] ."</h3>";
                      echo "<p class='card-text'>". $item['Description'] ."</p>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              }
            } else {
              echo "<div>There is no Ads to show . create <a href='newad.php'>New ad</a></div>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="my-comment block">
    <div class="container">
      <div class="card bg-light">
        <div class="card-header">
          Latest Comments
        </div>
        <div class="card-body">
          <?php
              $stmt = $con->prepare("SELECT Comment FROM comments WHERE User_ID = ?  ");
                  $stmt->execute(array($info['UserID']));
                  $comments = $stmt->fetchAll();
                if (! empty($comments)){
                  foreach ($comments as $comment ) {
                    echo  '<ul class="list-group list-group-flush">';
                    echo   '<li class="list-group-item">'.$comment['Comment'] .'</li>';
                    echo '</ul>';
                  }
                }else {
                  echo "There is no comments available";
                }
          ?>
        </div>
      </div>
    </div>
  </div>
<?php
  } else {
    header("Location: login.php");
    exit();
  }
  include $tpl . "footer.php";
  ob_end_flush();
?>
