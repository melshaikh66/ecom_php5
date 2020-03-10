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

        $stmt = $con->prepare("SELECT items.*,
 categories.Name AS Category,
 users.Username FROM items
INNER JOIN categories ON categories.ID = items.Cat_ID
INNER JOIN users ON users.UserID = items.Member_ID;");
        
        $stmt->execute();
        
        $items = $stmt->fetchAll();
       if (!empty($items)) {
        ?>
<h1 class="text-center">Manage Items</h1>
<div class="container">
    <div class="table-responsive">
        <table class="text-center main-table table table-bordered">
            <tr>
                <th>#id</th>
                <th>Name</th>
                <th>Description</th>
                <th>price</th>
                <th>Adding date</th>
                <th>Category</th>
                <th>Username</th>
                <th>Control</th>
            </tr>
            <?php

            foreach ($items as $item) {
            echo "<tr>";
            echo "<td>" . $item['Item_ID'] . "</td>";
            echo "<td>" . $item['Name'] . "</td>";
            echo "<td>" . $item['Description'] . "</td>";
            echo "<td>" . $item['Price'] . "</td>";
            echo "<td>" . $item['Category'] . "</td>";
            echo "<td>" . $item['Username'] . "</td>";
            echo "<td>" . $item['Add_Date'] . "</td>";
            echo "<td>
            <a href='items.php?do=edit&itemid=" . $item['Item_ID'] . " 'class='btn btn-success btn-sm'><i class='fa fa-edit'></i> Edit</a>
            <a href='items.php?do=delete&itemid=" . $item['Item_ID']. "' class='confirm btn btn-danger btn-sm'><i class='far fa-trash-alt'></i> Delete</a>";
            if ($item['Approve'] == 0) {
                
                echo "<a href='items.php?do=approve&itemid=" . $item['Item_ID'] . "' class='btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
            }
            echo "</td>";

            echo "</tr>";
        }
        ?>
        </table>
    </div>
    <a href='items.php?do=add' class='btn btn-primary btn-sm'><i class="fa fa-plus"></i> Add new item</a>
</div>
<?php
       } else {
    echo "<div class='container'>";
    echo "<div class='nice-message' >There is no Items to show</div>" ; 
    echo "<a href='items.php?do=add' class='btn btn-primary btn-sm'><i class='fa fa-plus'></i> Add new item</a>";
    echo "</div>";
}
    } elseif ($do == "add") { // add item page ?>
<h1 class="text-center">Add New Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">
        <!-- start name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="name" class="form-control"  placeholder="Name of the item" required />
            </div>
        </div>
        <!-- end name feild -->
         <!-- start Description feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
            <div class="col-9 col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Descripe the item" required />
            </div>
        </div>
        <!-- end Description feild -->
              <!-- start Price feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Price</label>
            <div class="col-9 col-md-6">
                <input type="text" name="price" class="form-control" placeholder="Price the item"  required />
            </div>
        </div>
        <!-- end Price feild -->
         <!-- start Country feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Country</label>
            <div class="col-9 col-md-6">
                <input type="text" name="country" class="form-control"  placeholder="Country the item" required />
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
          <!-- start members feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Member</label>
            <div class="col-9 col-md-6">
               <select name="member" id="">
                   <option value="0">...</option>
                      <?php 
                    $users = getAll("*", "users", "", "", "UserID", "ASC");
          			foreach ($users as $user) {
          			    echo "<option value='" .$user['UserID'] ."'>". $user['Username']."</option>";
          			}
          			
          			?>
               </select>
            </div>
        </div>
        <!-- end members feild -->
          <!-- start categories feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Category</label>
            <div class="col-9 col-md-6">
               <select name="category" id="">
                   <option value="0">...</option>
                      <?php 
                    $parentCats = getAll("*", "categories", "WHERE Parent = 0", "", "ID");
          			foreach ($parentCats as $cat) :
                          echo "<option value='" .$cat['ID'] ."'>". $cat['Name']."</option>";
                          $childCats = getAll("*", "categories","WHERE Parent ={$cat['ID']}", "", "ID");
                          foreach ($childCats as $child):
                            echo "<option value='" .$child['ID'] ."'> ---". $child['Name']."</option>"; 
                          endforeach;
                    endforeach;
          			?>
               </select>
            </div>
        </div>
        <!-- end categories feild -->
          <!-- start tags feild -->
          <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Tags</label>
            <div class="col-9 col-md-6">
                <input type="text" name="tags" class="form-control"  placeholder="separate with comma (,)" />
            </div>
        </div>
        <!-- end tags feild -->
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
} elseif ($do == "insert") { // insert page 
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h1 class='text-center'>Add Member</h1>";
        echo "<div class ='container'>";
        
        //get variables from form
        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $price      = $_POST['price'];
        $country    = $_POST['country'];
        $status     = $_POST['status'];
        $member     = $_POST['member'];
        $cat        = $_POST['category'];
        $tags        = $_POST['tags'];
       
        // Validate the form
        
        $formErrors = array();
      
        if (empty($name)) {
            $formErrors[] = " Name can't be <strong>Empty</strong>";
        }
        if (empty($desc)) {
            $formErrors[] = " Description can't be <strong>Empty</strong>";
            
        }
        
        if (empty($price)) {
            $formErrors[] = " Price can't be <strong>Empty</strong>";
            
        }
        
        if (empty($country)) {
            $formErrors[] = "Country can't be <strong>Empty</strong>";
            
        }
        if ($status == 0) {
            $formErrors[] = "You must choose <strong>Status</strong>";
            
        }
        if ($member == 0) {
            $formErrors[] = "You must choose <strong>Member</strong>";
            
        }
        if ($cat == 0) {
            $formErrors[] = "You must choose <strong>Category</strong>";
            
        }
        // loop into error array and echo it
        foreach ($formErrors as $error) {
            echo "<div class='alert alert-danger'>" . $error . "</div>";
        }
        
        // check if there is no errors update the database
        if (empty($formErrors)) {
            
                // insert the user info to the database
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country,Status, Add_Date, Cat_ID, Member_ID, Tags)
                                                VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");
                $stmt->execute(array(
                    "zname"     => $name,
                    "zdesc"     => $desc,
                    "zprice"    => $price,
                    "zcountry"  => $country,
                    "zstatus"   => $status,
                    "zcat"      => $cat,
                    "zmember"   => $member,
                    "ztags"     => $tags,
                ));
                // echo success message
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Inserted</div>";
                redirectHome($theMsg, "back");
            
        }
    } else {
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
        redirectHome($theMsg);
        echo "</div>";
    }
    echo "</div>";

    } elseif ($do == "edit") {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? LIMIT 1");
        $stmt->execute(array($itemid));
        $item= $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
<h1 class="text-center">Edit Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=update" method="POST">
    <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
        <!-- start name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="name" class="form-control"  placeholder="Name of the item" required value="<?php echo $item['Name'] ?>" />
            </div>
        </div>
        <!-- end name feild -->
         <!-- start Description feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
            <div class="col-9 col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Descripe the item" required value="<?php echo $item['Description'] ?>"/>
            </div>
        </div>
        <!-- end Description feild -->
              <!-- start Price feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Price</label>
            <div class="col-9 col-md-6">
                <input type="text" name="price" class="form-control" placeholder="Price the item"  required value="<?php echo $item['Price'] ?>"/>
            </div>
        </div>
        <!-- end Price feild -->
         <!-- start Country feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Country</label>
            <div class="col-9 col-md-6">
                <input type="text" name="country" class="form-control"  placeholder="Country the item" required value="<?php echo $item['Country'] ?>"/>
            </div>
        </div>
        <!-- end Country feild -->
          <!-- start Status feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Status</label>
            <div class="col-9 col-md-6">
               <select name="status" id="">
                   <option value="0">...</option>
                   <option value="1" <?php if ($item['Status'] == 1 ){ echo "selected";} ?> >New</option>
                   <option value="2" <?php if ($item['Status'] == 2 ){ echo "selected";} ?>>Like New</option>
                   <option value="3" <?php if ($item['Status'] == 3 ){ echo "selected";} ?>>Used</option>
                   <option value="4" <?php if ($item['Status'] == 4 ){ echo "selected";} ?>>Old</option>
               </select>
            </div>
        </div>
        <!-- end Status feild -->
          <!-- start members feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Member</label>
            <div class="col-9 col-md-6">
               <select name="member" id="">
                   <option value="0">...</option>
          			<?php 
          			$stmt = $con->prepare("SELECT * FROM users");
          			$stmt->execute();
          			$users = $stmt->fetchAll();
          			
          			foreach ($users as $user) {
          			    echo "<option value='" .$user['UserID'] ."'";
          			    if ($item['Member_ID'] == $user['UserID'] ){ echo "selected";} 
          			    echo ">". $user['Username']."</option>";
          			}
          			
          			?>
               </select>
            </div>
        </div>
        <!-- end members feild -->
          <!-- start categories feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Category</label>
            <div class="col-9 col-md-6">
               <select name="category" id="">
                   <option value="0">...</option>
          			<?php 
          			$stmt = $con->prepare("SELECT * FROM categories");
          			$stmt->execute();
          			$cats = $stmt->fetchAll();
          			
          			foreach ($cats as $cat) {
          			    echo "<option value='" . $cat['ID'] ."'";
          			    if ($item['Cat_ID'] == $cat['ID'] ){ echo "selected";} 
          			    echo ">". $cat['Name']."</option>";
          			}
          			?>
               </select>
            </div>
        </div>
        <!-- end categories feild -->
        <!-- start tags feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Tags</label>
            <div class="col-9 col-md-6">
            <input type="text" name="tags" class="form-control"  placeholder="separate with comma (,)" value="<?php echo $item['Tags'] ?>" />
            </div>
        </div>
        <!-- end tags feild -->
        <!-- start submit feild -->
        <div class="form-group row">
            <div class="offset-3 col-sm-10">
                <input type="submit" value="Edit Item" class="btn btn-success" />
            </div>
        </div>
        <!-- end submit feild -->
    </form>
<?php
    $stmt = $con->prepare("SELECT 
                                        comments.*, users.Username AS Username
                                FROM  
                                        comments 
                                INNER JOIN
                                        users
                                ON
                                        users.UserID = comments.User_ID 
                                WHERE 
                                        Item_ID = ?  
                                        ");
        $stmt->execute(array($itemid));
        $rows = $stmt->fetchAll();
        if (!empty($rows)){
?>
<h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>

    <div class="table-responsive">
        <table class="text-center main-table table table-bordered">
            <tr>
                <th>Comment</th>
                <th>User Name</th>
                <th>Added date</th>
                <th>Control</th>
            </tr>
            <?php

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $row['Comment'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['C_Date'] . "</td>";
            echo "<td>
            <a href='comments.php?do=edit&comid=" . $row['C_ID'] . " 'class='btn btn-success btn-sm'><i class='fa fa-edit'></i> Edit</a>
            <a href='comments.php?do=delete&comid=" . $row['C_ID'] . "' class='confirm btn btn-danger btn-sm'><i class='far fa-trash-alt'></i> Delete</a>";

            if ($row['Status'] == 0) {

                echo "<a href='comments.php?do=approve&comid=" . $row['C_ID'] . "' class='btn btn-warning approve btn-sm'><i class='far fa-thumbs-up'></i> Approve</a>";
            }

            echo "</td>";

            echo "</tr>";
        }
        ?>
        </table>
    </div>
        <?php } ?>
</div>
<?php
} else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
   

    } elseif ($do == 'update') {
        echo "<h1 class='text-center'>Update Item</h1>";
        echo "<div class ='container'>";
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            //get variables from form
            $id         = $_POST['itemid'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $price      = $_POST['price'];
            $country    = $_POST['country'];
            $status     = $_POST['status'];
            $member     = $_POST['member'];
            $cat        = $_POST['category'];
            $tags        = $_POST['tags'];
            
            // Validate the form
            
            $formErrors = array();
            
            if (empty($name)) {
                $formErrors[] = " Name can't be <strong>Empty</strong>";
            }
            if (empty($desc)) {
                $formErrors[] = " Description can't be <strong>Empty</strong>";
                
            }
            
            if (empty($price)) {
                $formErrors[] = " Price can't be <strong>Empty</strong>";
                
            }
            
            if (empty($country)) {
                $formErrors[] = "Country can't be <strong>Empty</strong>";
                
            }
            if ($status == 0) {
                $formErrors[] = "You must choose <strong>Status</strong>";
                
            }
            if ($member == 0) {
                $formErrors[] = "You must choose <strong>Member</strong>";
                
            }
            if ($cat == 0) {
                $formErrors[] = "You must choose <strong>Category</strong>";
                
            }
            // loop into error array and echo it
            foreach ($formErrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
            
            // check if there is no errors update the database
            if (empty($formErrors)) {
                // update the database
                $stmt = $con->prepare("UPDATE
                                             items 
                                        SET 
                                            Name = ?,
                                            Description = ?, 
                                            Price = ?,  
                                            Country = ?, 
                                            Status = ?,
                                            Cat_ID = ?,
                                            Member_ID = ?, 
                                            Tags = ?
                                        WHERE 
                                            Item_ID = ?");
                $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));
                // echo success message
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Updated</div>";
                redirectHome($theMsg, "back");
                
            }
        } else {
            $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
            redirectHome($theMsg, "back");
            
        }
        echo "</div>";
    } elseif ($do == "delete") {
        echo "<h1 class='text-center'>Delete Item</h1>";
        echo "<div class ='container'>";
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // select all data depend on this id
        $check = checkItems("Item_ID", "items", $itemid);
        
        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :itemid");
            $stmt->bindParam(":itemid", $itemid);
            $stmt->execute();
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Deleted</div>";
            redirectHome($theMsg, "back");
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
        }
        echo "</div>";
    } elseif ($do == "approve") {
        echo "<h1 class='text-center'>Approve Item</h1>";
        echo "<div class ='container'>";
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // select all data depend on this id
        $check = checkItems("Item_ID", "items", $itemid);
        
        if ($check > 0) {
            $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
            $stmt->execute(array($itemid));
            $theMsg = "<div class='alert alert-success'> Items Approved successfully !</div>";
            redirectHome($theMsg, "back");
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg, "back");
        }
        echo "</div>";
    }

    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}

ob_end_flush();

?>

