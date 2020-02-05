<?php
  ob_start();
  session_start();
  // page title variable
  $pageTitle = "Login";
  if (isset($_SESSION['member'])) {
      header("Location: index.php");
  }
  include "init.php";
  // check if user coming from HTTP Post request
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])){
      $user = $_POST["username"];
      $pass = $_POST["password"];
      $hashedPass = sha1($pass);
  // chech if user exist in database
      $stmt = $con->prepare("SELECT
                                  Username, Password
                              FROM
                                  users
                              WHERE
                                  Username = ?
                              AND
                                  Password = ? ");
      $stmt->execute(array($user, $hashedPass));
      $count = $stmt->rowCount();

  //    If count > 0 this mean the database contain record for this username
      if ($count > 0) {
          $_SESSION['member'] = $user;   //register session user name
          header("Location: index.php");
          exit();
      }
    } else {
      $formErrors = array();
      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $email = $_POST['email'];
      if (isset($username)){
        $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
        if (strlen($filteredUser)< 4){
          $formErrors[] = "* Username must be more than 4 characters!";
        }
      }
      if (isset($password) && isset($password2)){
        if (empty($password)){
          $formErrors[] = "* Sorry password can't be empty!";
        }
        if (sha1($password) !== sha1($password2)){
          $formErrors[] = "* Your password doesn,t match";
          }
        }
      if (isset($email)){
        $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
          if (filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true){
            $formErrors[] = "* This mail is not Valid!";
          }
        }
      // check if there is no errors update the database
      if (empty($formErrors)) {
          $check = checkItems("Username", "users", $username);
          if ($check == 1) {
            $formErrors[] = "* This user is already exist!";

          } else {
              // insert the user info to the database
              $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date)
                                          VALUES(:zuser, :zpass, :zmail, 0, now())");
              $stmt->execute(array(
                  "zuser" => $username,
                  "zpass" => sha1($password),
                  "zmail" => $email
              ));
              // echo success message

              $successMsg = "<div class='alert alert-success'>Congrats You have signed up successfully</div>";

          }
        }
      }
    }
?>

  <div class="container login-page">
    <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span></h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
      <div class="input-container">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your username" required/>
      </div>
      <div class="input-container">
      <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your Password" required/>
      </div>
      <input class="btn btn-primary btn-block" type="submit"name="login" value="Login" />
    </form>
    <!-- end login form -->
    <!-- start signup form -->
    <form class="signup" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
      <div class="input-container" >
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your username" pattern=".{4,}" title="Username must be more than 4 characters" required/>
      </div>
      <div class="input-container">
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your Password" minlength="4" required />
      </div>
      <div class="input-container">
      <input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Re-Type Your Password" minlength="4" required />
      </div>
      <div class="input-container">
      <input class="form-control" type="email" name="email" placeholder="Type Your Email" required/>
      </div>
      <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup" />
    </form>
        <!-- end signup form -->
      <?php
      if (! empty($formErrors)){
        foreach ($formErrors as $error) {
          echo '<div class="alert alert-danger message" role="alert">';
          echo $error . "<br />";
          echo '</div>';
        }
      }
      if (isset($successMsg)){
        echo '<div class="alert alert-success message" role="alert">';
        echo $successMsg ;
        echo '</div>';
      }
      ?>
  </div>


<?php
include $tpl . "footer.php";

ob_end_flush();
 ?>
