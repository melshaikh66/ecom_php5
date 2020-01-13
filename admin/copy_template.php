<?php

/*==================================
==== Manage members page ===========
==================================*/
ob_start();
session_start();

$pageTitle = "";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
  
    include $tpl . "footer.php";

 } else {

    header("location: index.php");

    exit();
}
ob_end_flush();
?>
