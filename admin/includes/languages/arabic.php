<?php

function lang($phrase)
{
    static $lang = array(
        "Message" => "Welcome",
        "Admin" => "Adminstrator",
    );

    return $lang[$phrase];
}
