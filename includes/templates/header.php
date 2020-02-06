<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo $css; ?>front.css">
    <title><?php getTitle()?></title>
</head>
<body>
    <div class="upper-bar">
        <div class="container">
          <?php
          if (isset($_SESSION['member'])) {
            echo "Welcome ". $sessionUser . " " ;
            echo "<a href='profile.php'>My Profile</a> - ";
            echo " <a href='newad.php'>New Ads</a> - ";
            echo " <a href='logout.php'>Logout</a>";
            $userStatus = checkUserStatus($sessionUser);
            if ($userStatus == 1 ){
              // member is not Active
            }
          }else{
           ?>
          <a href="login.php"><span class="float-right">Login | SignUp</span></a>
          <?php } ?>
          <div class="clearfix"></div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Homepage</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="app-nav">
            <ul class="navbar-nav ml-auto">
                    <?php
          foreach (getCats() as $cat) {
              echo "<li class='nav-item active'><a class='nav-link' href='categories.php?pageid=".$cat['ID'] .'&pagename='. str_replace(" ", "-", $cat["Name"]) .  " '>". $cat['Name']. "</a></li>";
          }

         ?>
            </ul>

        </div>
    </div>
</nav>
