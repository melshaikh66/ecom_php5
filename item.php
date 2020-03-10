<?php
  session_start();
  $pageTitle = "Item Details";
  // incloude the init file
  include "init.php";
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
  $stmt = $con->prepare("SELECT 
                            items.*, categories.Name AS cat_name, users.Username AS user
                         FROM 
                            items 
                          INNER JOIN
                            categories
                          ON
                            categories.ID = items.Cat_ID
                          INNER JOIN 
                            users
                          ON
                            users.UserID = items.Member_ID
                         WHERE 
                            Item_ID = ?
                          AND
                              Approve = 1");
  $stmt->execute(array($itemid));
  $count = $stmt->rowCount();

  if ($count > 0) {
  $item= $stmt->fetch();
  ?>
    <h1 class="text-center text-capitalize"><? echo $item['Name']; ?></h1>
    <div class="container">
      <!-- start item info  -->
      <div class="row">
        <div class="col-lg-3">
          <img class='img-fluid' src='layout/images/avatar.png' alt='avatar' />
        </div>
        <div class="col-lg-9 info">
          <ul class="list-group list-group-flush">
            <h2 class="text-capitalize"><?php echo $item['Name']; ?></h2>
            <p class="text-capitalize"><?php echo $item['Description']; ?></p>
            <li class="list-group-item"><span><i class="fas fa-comment-dollar"></i> Price</span>: $<?php echo $item['Price']; ?></li>
            <li class="list-group-item"><span><i class="far fa-calendar-alt"></i> Adding Date</span>: <?php echo $item['Add_Date']; ?></li>
            <li class="list-group-item"><span><i class="fas fa-globe-americas"></i> Made in</span>: <?php echo $item['Country']; ?></li>
            <li class="list-group-item"><span><i class="fas fa-tag"></i> Category Name</span>:<a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>"> <?php echo $item['cat_name']; ?> </a></li>
            <li class="list-group-item"><span><i class="far fa-user"></i> Item Owner</span>:<a href="#"> <?php echo $item['user']; ?> </a></li>
            <li class="list-group-item"><span><i class="fas fa-tags"></i> Tags</span>:
            <?php 
              $allTags = explode(",", $item['Tags']);
              foreach ($allTags as $tag ):
                $tag = str_replace(" ", "", $tag);
                $lowerTag = strtolower($tag);
                echo "<a href='tags.php?name={$lowerTag}'>" . $tag . "</a> |";
              endforeach  
            ?>
            </li>
          </ul>
        </div>
      </div>
      <!-- end item info  -->
      <hr class="custom-hr">
      <!-- start add comment -->
      <div class="row">
        <div class="offset-lg-3">
          <h3>Add new comment</h3>
          <?php if (isset($_SESSION['member'])){ ?>
            <div class="add-comment">
              <form action="<?php echo $_SERVER['PHP_SELF'] . "?itemid=" . $item['Item_ID'] ?>" method="POST">
                <textarea name="comment" required></textarea>
                <input class="btn btn-info btn-sm" type="submit" value="Add Comment">
              </form>
              <?php 
                if ($_SERVER['REQUEST_METHOD'] == "POST"){
                  $comment  = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                  $userid   = $item['Member_ID'];
                  $itemid   = $item['Item_ID'];

                  if (! empty($comment)){
                    $stmt = $con->prepare("INSERT INTO comments(Comment, Status, C_Date, Item_ID, User_ID) VALUES(:setcomment, 0, NOW(), :setitemid, :setuserid)");
                    $stmt->execute(array(
                      "setcomment"  => $comment,
                      "setitemid"   => $itemid,
                      "setuserid"   => $_SESSION['member_id'],
                    ));
                    if ($stmt){
                      echo "<div class='alert alert-success'> Your comment added successfully</div>";
                    }
                  }else {
                    echo "<div class='alert alert-danger'>Comment field can't be Empty</div>";
                  }
                }
              } else {
                echo "Please <a href='login.php'>Login</a> to add comment";
              } ?>
            </div>
        </div>
      </div>
      <!-- end add comment -->
      <hr class="custom-hr">
      <?php 
           $stmt = $con->prepare("SELECT 
                                          comments.*, users.Username AS Username
                                  FROM  
                                          comments 
                                  INNER JOIN
                                          users
                                  ON
                                          users.UserID = comments.User_ID 
                                  WHERE
                                          Item_ID =$itemid
                                  AND 
                                          Status = 1
                                  ORDER BY 
                                      C_ID DESC");
          $stmt->execute();
          $comments = $stmt->fetchAll();
          ?>
      
    <?php foreach ($comments as $comment) { ?>
      <div class="comment-box">
      <div class="row">
          <div class="col-lg-3 text-center">
          <img class='img-fluid img-thumbnail rounded-circle mx-auto' src='layout/images/avatar.png' alt='avatar' />
            <?php echo $comment['Username'] ?>
          </div>
          <div class="col-lg-9">
            <p class="lead">
            <?php echo $comment['Comment'] ?>
            </p>
          </div>
        </div>
      </div>
      <hr class="custom-hr">
    <?php } ?> 
  </div>
    
  <?php
  } else {
    echo "<div class='container'>";
    echo "<div class='alert alert-danger'>There is no Item with this ID or this item is waiting approval</div>";
    echo "</div>";
  }
  include $tpl . "footer.php";
  ob_end_flush();
?>
