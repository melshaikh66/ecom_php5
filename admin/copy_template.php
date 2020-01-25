<?php

/*==================================
==== Manage members page ===========
==== add | delete | edit ===========
==================================*/

session_start();

$pageTitle = "Members";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    if ($do == "manage") {

    } elseif ($do == "add") {

    } elseif ($do == "insert") {

    } elseif ($do == "edit") {

    } elseif ($do == 'update') {

    } elseif ($do == "delete") {

    } elseif ($do == "approve") {

    }

    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}

ob_end_flush();