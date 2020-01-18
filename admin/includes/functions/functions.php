<?php

/*
 * title function v1.0
 * *Page title function that echo page title if the variable $pageTitle is exists
 * * or default if not exists
 */
function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo "Default";
    }
}

/*
 * Redirect functions v1.0
 * * this function accept parameters
 * * $theMsg => echo the message
 * *url => the link of the page to redirect
 * * $seconds => number of seconds before redirect
 */
function redirectHome($theMsg, $url = null, $seconds = 3)
{
    if ($url === null) {
        $url = "index.php";
        $link = "Homepage";
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && ! empty($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
            $link = "Previous page";
        } else {
            $url = "index.php";
            $link = "Homepage";
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-success'>You will be directed to $link after: $seconds Seconds</div>";

    header("refresh:$seconds;url=$url");
    exit();
}

/*
 * * check items functions v1.0
 * *function to check items in database [function accept parameters]
 * *$select => the items to select from the table [ex: user, item, category]
 * *$from => the table to select from
 * *$value => the value of the select
 */
function checkItems($select, $from, $value)
{
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array(
        $value
    ));
    $count = $statement->rowCount();
    return $count;
}

/*
 * * count number of items function v1.0
 * * function to count number of items rows
 * *
 * *
 */
function countItems($items, $table)
{
    global $con;
    $itemCount = $con->prepare("SELECT COUNT($items) FROM $table");
    $itemCount->execute();
    return $itemCount->fetchColumn();
}

/*
 * * get latest records function v1.0
 * *function to get latest items added to database
 * * $select => the field to choose
 * * $from => the table to choose from
 * * $order => the column to order with
 * * $limit => the number of records wanted
 */
function getLatest($select, $from, $order, $limit = 5)
{
    global $con;

    $getStmt = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}
