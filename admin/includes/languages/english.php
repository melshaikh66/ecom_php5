<?php

function lang($phrase)
{
    static $lang = array(

        // Navbar words
        "PAGE_BRAND"             => "Home",
        "CATEGORIES"             => "Categories",
        "EDITING_PROFILE"        => "Edit Profile",
        "CHANGE_SETTINS"         => "Settings",
        "LOGGING_OUT"            => "Logout",
        "ITEMS"                  => "Items",
        "MEMBERS"                => "Members",
        "STATISTICS"             => "Statistics",
        "COMMENTS"               => "Comments",
        "LOGS"                   => "Logs",
        "Visit-Shop"             => "Visit shop",
    );

    return $lang[$phrase];
}