<?php

$Chave = "mmkt-importar";
include("../verifica.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>E-mails</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../css/geral.css" />
	<link type="text/css" rel="stylesheet" href="../css/master.css" />
</head>
<body>
	<div class="margem">
		<table class="lista">
			<thead>
				<tr>
					<td width="50">Linha</td>
					<td>E-mail</td>
					<td>Nome</td>
					<td width="50">Dia</td>
					<td width="50">Mês</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$total = 0;
				if(($handle = fopen("../.." . $oAdministradorLogado->DirectoryUserFilesName . $Chave . "/" . $_GET["tipo"] . "/" . $_GET["id"] . ".csv", "r")) !== false)
				{
				    while (($data = fgetcsv($handle, 0, ";")) !== false)
					{
						$total++;
						?>
						<tr>
							<td align="center"><?=$total;?></td>
							<td><?=$data[0];?></td>
							<td><?=$data[1];?></td>
							<td align="center"><?=((intval($data[2]) > 0) ? $data[2] : "");?></td>
							<td align="center"><?=((intval($data[3]) > 0) ? $data[3] : "");?></td>
						</tr>
						<?php
				    }
				    fclose($handle);
				}
				if($total < 1)
				{
					?>
					<tr>
						<td colspan="5" align="center">Nenhum registro encontrado.</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>