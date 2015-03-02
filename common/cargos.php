<?php
               
header("Content-Type: text/html;  charset=ISO-8859-1", true);

include_once("../library/config/database/tcargo.php");
  
tcargo::ddl($_GET["vinculo"], $ddlCargo); 

?>