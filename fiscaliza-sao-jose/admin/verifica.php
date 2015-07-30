<?php
if (!(login_check($mysqli) == true) || ($_SERVER["REMOTE_ADDR"] != "200.174.132.56" && $_SERVER["REMOTE_ADDR"] != "200.136.177.120" && $_SERVER["REMOTE_ADDR"] != "189.110.15.29")) {
    include("includes/logout.php");
    header("Location: index.php");
    exit();
}