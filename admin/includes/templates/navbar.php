<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><?php echo lang("PAGE_BRAND") ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="categories.php"><?php echo lang("CATEGORIES") ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"><?php echo lang("ITEMS") ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="members.php?do=manage"><?php echo lang("MEMBERS") ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"><?php echo lang("STATISTICS") ?></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"><?php echo lang("LOGS") ?></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "Menu";
}
?>

                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item"
                            href="members.php?do=edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang("EDITING_PROFILE") ?>
                        </a>
                        <a class="dropdown-item" href="#"><?php echo lang("CHANGE_SETTINS") ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><?php echo lang("LOGGING_OUT") ?>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
