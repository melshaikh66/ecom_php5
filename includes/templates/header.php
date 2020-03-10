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
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <?php
          if (isset($_SESSION['member'])) { ?>
            <div class="dropdown upper-bar ml-auto">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <span><img class='img-fluid rounded-circle img-thumbnail' src='layout/images/avatar.png' alt='avatar'/></span> <?php echo $sessionUser; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="profile.php#my-ads">My Ads</a>
                    <a class="dropdown-item" href="newad.php">Add New Item</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
    <?php }else{  ?>
          <a href="login.php"><span class="float-right">Login | SignUp</span></a>
          <?php } ?>
          <div class="clearfix"></div>
        </div>
    </nav>
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
        $cats = getAll("*", "categories", "WHERE Parent = 0", "", "ID", "ASC");
          foreach ($cats as $cat) {
              echo "<li class='nav-item active'>
                        <a class='nav-link' href='categories.php?pageid=". $cat['ID'] ."'>".  $cat['Name']. "</a></li>";
          }

         ?>
            </ul>

        </div>
    </div>
</nav>
