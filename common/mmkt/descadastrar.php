<?php

include_once("../../library/config/database/tmmktemail.php");
	
$oEmail = new tmmktemail();
if($oEmail->LoadByEmail($_GET["email"]))
{
	for($c = 0; $c < $oEmail->NumRows; $c++)
	{
		$oEmail->Ativo = 0;
		$oEmail->Save();
		$oEmail->MoveNext();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Descadastramento</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
	<b>E-mail descadastrado com sucesso!</b>
</body>
</html>