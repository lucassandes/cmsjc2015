<?php

include("verifica.php");

$oAdministradorLogado->Logout();

header("Location: login.php");
exit();

?>