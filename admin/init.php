<?php

// incloude the connection to database file
include "connect.php";

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


// incloude navbar in all pages expect the one with $noNavbar variable
if (!isset($noNavbar)) {
    include $tpl . "navbar.php";
}