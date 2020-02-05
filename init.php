<?php

// error reporting
ini_set("display-errors", "on");
error_reporting(E_ALL);

// incloude the connection to database file
include "admin/connect.php";

$sessionUser = "";

if(isset($_SESSION['member'])){
  $sessionUser = $_SESSION['member'];
}

/*=======================
====== Routes  ==========
=======================*/

// template directory
$tpl = "includes/templates/";
// css directory
$css = "layout/css/";
// js directory
$js = "layout/js/";
// language directory
$langs = "includes/languages/";
// functions directory
$func = "includes/functions/";

/*============================================
====== incloude the important file  ==========
=============================================*/

// incloude the language file
include $langs . "english.php";
// incloude the functions file
include $func . "functions.php";
// incloude the header file
include $tpl . "header.php";
