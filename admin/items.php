<?php

/*==================================
==== Manage Items page ===========
==== add | delete | edit ===========
==================================*/

session_start();

$pageTitle = "Items";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    if ($do == "manage") {

        echo "Hello from items page";

    } elseif ($do == "add") { // add item page ?>
<h1 class="text-center">Add New Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">
        <!-- start name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="name" class="form-control" required placeholder="Name of the item" />
            </div>
        </div>
        <!-- end name feild -->
         <!-- start Description feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
            <div class="col-9 col-md-6">
                <input type="text" name="description" class="form-control" required placeholder="Descripe the item" />
            </div>
        </div>
        <!-- end Description feild -->
              <!-- start Price feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Price</label>
            <div class="col-9 col-md-6">
                <input type="text" name="price" class="form-control" required placeholder="Price the item" />
            </div>
        </div>
        <!-- end Price feild -->
         <!-- start Country feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Country</label>
            <div class="col-9 col-md-6">
                <input type="text" name="country" class="form-control" required  placeholder="Country the item" />
            </div>
        </div>
        <!-- end Country feild -->
          <!-- start Status feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Status</label>
            <div class="col-9 col-md-6">
               <select name="status" id="">
                   <option value="0">...</option>
                   <option value="1">New</option>
                   <option value="2">Like New</option>
                   <option value="3">Used</option>
                   <option value="4">Old</option>
               </select>
            </div>
        </div>
        <!-- end Status feild -->
        <!-- start submit feild -->
        <div class="form-group row">
            <div class="offset-3 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-success" />
            </div>
        </div>
        <!-- end submit feild -->
    </form>
</div>
<?php
} elseif ($do == "insert") {

    } elseif ($do == "edit") {

    } elseif ($do == 'Update') {

    } elseif ($do == "delete") {

    } elseif ($do == "approve") {

    }

    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}

ob_end_flush();