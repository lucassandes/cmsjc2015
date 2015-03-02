<?php

$Chave = "mmkt-enviar-mensagem";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tparametro.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktenvio.php");
include_once("../../library/config/database/tmmktenviofiltro.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oEnvio = new tmmktenvio();
$bEditar = $oEnvio->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oEnvio->Nome = $_POST["txtNome"];
	$oEnvio->Email = $_POST["txtEmail"];
	$oEnvio->Assunto = $_POST["txtAssunto"];
	$oEnvio->Modelo = $_POST["ddlModelo"];
	$cbFiltro = ((is_array($_POST["cbFiltro"])) ? $_POST["cbFiltro"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Nome", $oEnvio->Nome, true, null, "Digite o nome do remetente.");
	$oValidator->Add("Email", $oEnvio->Email, true, "email", "Digite o e-mail do remetente corretamente.");
	$oValidator->Add("Assunto", $oEnvio->Assunto, true, null, "Digite o assunto da mensagem.");
	$oValidator->Add("Modelo", $oEnvio->Modelo, true, null, "Escolha o modelo a ser enviado.");
	$oValidator->Add("Filtro", (count($cbFiltro) > 0), true, null, "Escolha pelo menos um filtro para envio.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oEnvio->AddNew();
			$oEnvio->Enviado = 0;
			$oEnvio->DataHora = date("Y-m-d H:i:s");
			$oEnvio->DataHoraEnviado = "0000-00-00 00:00:00";
			$oEnvio->Total = 0;
			$oEnvio->TotalEnviado = 0;
			$oEnvio->TotalErro = 0;
		}
		$oEnvio->Save();
		
		//Remover - Filtros
		$oEnvioFiltroDel = new tmmktenviofiltro();
		$oEnvioFiltroDel->DeleteByEnvioID($oEnvio->ID);
		
		//Adicionar - Filtros
		foreach($cbFiltro as $c)
		{
			$oEnvioFiltroAdd = new tmmktenviofiltro();
			$oEnvioFiltroAdd->AddNew();
			$oEnvioFiltroAdd->EnvioID = $oEnvio->ID;
			$oEnvioFiltroAdd->FiltroID = $c;
			$oEnvioFiltroAdd->Save();
		}
		
		//total de e-mails
		$oEmail = new tmmktemail();
		$oEmail->SQLField = "DISTINCT(tmmktemail.Email)";
    	$oEmail->SQLJoin = "INNER JOIN tmmktemailfiltro ON tmmktemailfiltro.EmailID = tmmktemail.ID ";
    	$oEmail->SQLJoin .= "INNER JOIN tmmktenviofiltro ON tmmktenviofiltro.FiltroID = tmmktemailfiltro.FiltroID";
    	$oEmail->SQLWhere = "tmmktenviofiltro.EnvioID = '" . $oEnvio->ID . "' AND tmmktemail.Ativo = 1";
    	$oEnvio->Total = $oEmail->GetCount();
    	$oEnvio->Save();
		
		//redireciona
		header("Location: confirmacao-de-envio.php?id=" . $oEnvio->ID);
		exit();
	}
	else
	{
		$msg = $oValidator->Create();
	}
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageTop");
$passo = 1;
include("abas.php");
$oMasterPage->Close("PageTop");
$oMasterPage->Open("PageContent");

?>
<?=$msg;?>
<form action="" method="post" class="formMensagem">
	<p>Digite o nome do remetente:</p>
	<input size="60" maxlength="150" type="text" id="txtNome" name="txtNome" value="<?=(($oEnvio->Nome) ? $oEnvio->Nome : $oEnvio->WebTitle);?>" class="{required:true}" title="Digite o nome do remetente." />
	<br />
	<p>Digite o e-mail do remetente:</p>
	<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" value="<?=(($oEnvio->Email) ? $oEnvio->Email : tparametro::Get("email-sistema"));?>" class="{focus:true, required:true, email:true}" title="Digite o e-mail do remetente corretamente." />
	<br />
	<p>Digite o assunto da mensagem:</p>
	<input size="50" maxlength="50" type="text" id="txtAssunto" name="txtAssunto" value="<?=$oEnvio->Assunto;?>" class="{required:true}" title="Digite o assunto da mensagem." />
	<br />
	<p>Escolha o modelo a ser enviado:</p>
	<select id="ddlModelo" name="ddlModelo" class="{required:true}" title="Escolha o modelo a ser enviado.">
		<option value="" selected="selected">Escolha...</option>
		<?php
		$arModelo = $oEnvio->GetModelo();
		foreach($arModelo as $c)
		{
			?>
			<option value="<?=$c;?>" <?php if($oEnvio->Modelo == $c) { ?> selected="selected" <?php } ?>><?=$c;?></option>
			<?php
		}
		?>
	</select>
	<?php
	$oFiltro = new tmmktfiltro();
	$oFiltro->SQLField = "*, FiltroTotalEmail(ID) AS TotalEmail";
	$oFiltro->SQLOrder = "Titulo ASC";
	if($oFiltro->LoadSQLAssembled())
	{
		?>
		<fieldset id="filtros">
			<legend>Escolha o filtro para envio:</legend>
			<div class="margem">
				<a href="javascript:void(0);" onclick="$('input[type=checkbox]', $('#filtros')).attr('checked', 'checked');"><img src="../imgs/botoes/marcar-todos.png" title="Marcar todos" alt="Marcar todos" /></a>
				<a href="javascript:void(0);" onclick="$('input[type=checkbox]', $('#filtros')).removeAttr('checked');"><img src="../imgs/botoes/desmarcar-todos.png" title="Desmarcar todos" alt="Desmarcar todos" /></a>
				<div class="linha" style="margin-top:10px;margin-bottom:10px;"></div>
				<table cellspacing="5">
					<tr>
						<?php
						for($c = 0; $c < $oFiltro->NumRows; $c++)
						{
							$sel = false;
							if($_POST)
							{
								$sel = in_array($oFiltro->ID, $cbFiltro);
							}
							else
							{
								$oEnvioFiltro = new tmmktenviofiltro();
								$sel = $oEnvioFiltro->LoadByEnvioIDAndFiltroID($oEnvio->ID, $oFiltro->ID);
							}
							?>
							<td>
								<label>
									<input type="checkbox" name="cbFiltro[]" value="<?=$oFiltro->ID;?>" <?php if($sel) { ?> checked="checked" <?php } ?> class="{required:true}" title="Escolha pelo menos um filtro para envio." />
									<?=$oFiltro->Titulo;?> (<?=$oFiltro->TotalEmail;?>)
								</label>
							</td>
							<?php
							if(($c + 1) % 3 == 0)
							{
								?>
								</tr>
								<tr>
								<?php
							}
							else
							{
								?>
								<td width="20">&nbsp;</td>
								<?php
							}
							$oFiltro->MoveNext();
						}
						?>
					</tr>
				</table>
			</div>
		</fieldset>
		<?php
	}
	?>
	<div class="linha"></div>
	<input type="image" src="../imgs/botoes/proximo.png" alt="Próximo" title="Próximo" />
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>