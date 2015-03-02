<?php

$Chave = "mmkt-enviar-mensagem";
include("../verifica.php");
include_once("../../library/config/sendmail.php");
include_once("../../library/config/database/tparametro.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktenvio.php");

//verifica envio
$oEnvio = new tmmktenvio();
if(!$oEnvio->LoadByPrimaryKey($_GET["id"]))
{
	echo "<script>window.close();</script>";
    exit();
}

//parans
$arParam = tparametro::Load();
$total_envio = intval($arParam["mmkt-envio"]);
$total_segundo = intval($arParam["mmkt-segundo"]);

//verifica se terminou de enviar
if(!$oEnvio->Enviado)
{
 	//pagina
	$pg = (($_GET["pg"]) ? intval($_GET["pg"]) : (($oEnvio->TotalEnviado + $oEnvio->TotalErro) / $total_envio));
	$pg = ($pg < 0) ? 0 : $pg;

    //e-mails
    $oEmail = new tmmktemail();
    $oEmail->SQLJoin = "INNER JOIN tmmktemailfiltro ON tmmktemailfiltro.EmailID = tmmktemail.ID ";
    $oEmail->SQLJoin .= "INNER JOIN tmmktenviofiltro ON tmmktenviofiltro.FiltroID = tmmktemailfiltro.FiltroID";
    $oEmail->SQLWhere = "tmmktenviofiltro.EnvioID = '" . $oEnvio->ID . "' AND tmmktemail.Ativo = 1";
    $oEmail->SQLGroup = "tmmktemail.Email";
    $oEmail->SQLOrder = "tmmktemail.ID ASC";
    if($oEmail->LoadByPaginator(($total_envio * $pg), $total_envio))
    {
    	for($c = 0; $c < $oEmail->NumRows; $c++)
	    {
	    	//vars
			$_ID = $oEmail->ID;
			$_Nome = $oEmail->Nome;
			$_Email = $oEmail->Email;
			$_EnvioID = $oEnvio->ID;
			
	    	//conteúdo
			ob_start();
			include($oEnvio->DirectoryMMKTPath . $oEnvio->Modelo . "/index.php");
			$Conteudo = ob_get_contents();
			ob_end_clean();
			
			//envia e-mail
			$oMail = new SendMail();
			$oMail->AddAddress($oEmail->Email, $oEmail->Nome);
			$oMail->SetFrom($oEnvio->Email, $oEnvio->Nome);
			$oMail->Sender = $arParam["email-retorno"];
			$oMail->Subject = $oEnvio->Assunto;
			$oMail->MsgHTML($Conteudo);
			if($oMail->Send())
			{
				$oEnvio->TotalEnviado++;
			}
			else
			{
				$oEnvio->TotalErro++;
	            
	            //desativa e-mail
	            $oEmail->Ativo = 0;
	            $oEmail->Save();
			}
			
		    //verifica se acabou
		    if(($oEnvio->TotalEnviado + $oEnvio->TotalErro) >= $oEnvio->Total)
		    {
				$oEnvio->Enviado = 1;
				$oEnvio->DataHoraEnviado = date("Y-m-d H:i:s");
				break;
			}
			
	        $oEmail->MoveNext();
	    }
    }
    else
    {
		$oEnvio->Enviado = 1;
		$oEnvio->DataHoraEnviado = date("Y-m-d H:i:s");
		$oEnvio->TotalErro = ($oEnvio->Total - $oEnvio->TotalEnviado);
    }
    
    $oEnvio->Save();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Enviando</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../css/geral.css"	/>
	<link type="text/css" rel="stylesheet" href="../css/master.css" />
</head>
<body>
	<div class="margem">
		<br />
		<div align="center">
			<?php
			if(!$oEnvio->Enviado)
			{
				?>
				<img src="../imgs/geral/enviando-email.jpg" alt="Enviando e-mails" title="Enviando e-mails" align="absmiddle" />
				<img src="../imgs/icones/enviando.gif" alt="" title="" align="absmiddle" />
				<br />
				<br />
				Tempo: <strong id="contagem">0</strong>
				<br />
				<script language="javascript" type="text/javascript">
					var milisec = 0;
					var seconds = 0;
					var intval;
					function display(){
						if (milisec >= 9){
							milisec=0;
							seconds+=1;
						}
						else{
							milisec+=1;
						}
						if(seconds >= <?=$total_segundo;?>){
							document.getElementById("contagem").innerHTML = "0";
							clearTimeout(intval);
							window.location.href = "?id=<?=$oEnvio->ID;?>&pg=<?=($pg + 1);?>";
						}else{
							document.getElementById("contagem").innerHTML = seconds + "." + milisec;
							intval = setTimeout("display()", 100);
						}
					}
					display();
				</script>
				<?php
			}
			else
			{
				?>
				<img src="../imgs/geral/mensagens-enviadas-com-sucesso.jpg" alt="Mensagens enviadas com sucesso!" title="Mensagens enviadas com sucesso!" />
				<?php
			}
			?>
		</div>
		<br />
		<div class="area">
			Nome do remetente:
			<p><?=$oEnvio->Nome;?></p>
			<br />
			E-mail do remetente:
			<p><?=$oEnvio->Email;?></p>
			<br />
			Assunto da mensagem:
			<p><?=$oEnvio->Assunto;?></p>
			<br />
			Quantidade de e-mails:
			<p><?=$oEnvio->Total;?></p>
			<br />
			Enviados com sucesso:
			<p><?=$oEnvio->TotalEnviado;?></p>
			<br />
			Erro ao envio:
			<p><?=$oEnvio->TotalErro;?></p>
		</div>
	</div>
</body>
</html>