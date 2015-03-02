<?php

$Chave = "mmkt-emails";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktemailfiltro.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oEmail = new tmmktemail();
$bEditar = $oEmail->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sEmail = $oEmail->Email;
	$oEmail->Ativo = intval($_POST["cbAtivo"]);
	$oEmail->Nome = $_POST["txtNome"];
	$oEmail->Email = $_POST["txtEmail"];
	$oEmail->Dia = intval($_POST["txtDia"]);
	$oEmail->Mes = intval($_POST["txtMes"]);
	$cbFiltro = (($_POST["cbFiltro"]) ? $_POST["cbFiltro"] : array());
	
	//verifica e-mails
	function Verifica($v)
	{
		global $sEmail;
		$oEmailVerifica = new tmmktemail();
		return !($sEmail != $v && $oEmailVerifica->LoadByEmail($v));
	}
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Nome", $oEmail->Nome, true, null, "Digite o nome.");
	$oValidator->Add("Email", $oEmail->Email, true, "email", "Digite o e-mail corretamente.");
	$oValidator->Add("Email", $oEmail->Email, false, "function", "E-mail já cadastrado!", Verifica);
	$oValidator->Add("Dia", $oEmail->Dia, false, "number", "Digite o dia corretamente.");
	$oValidator->Add("Mes", $oEmail->Mes, false, "number", "Digite o mês corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oEmail->AddNew();
			$oEmail->DataHora = date("Y-m-d H:i:s");
		}
		$oEmail->Save();
		
		//Remover - Filtros
		$oEmailFiltroDel = new tmmktemailfiltro();
		$oEmailFiltroDel->DeleteByEmailID($oEmail->ID);
		
		//Adicionar - Filtros
		foreach($cbFiltro as $c => $v)
		{
			$oEmailFiltroAdd = new tmmktemailfiltro();
			$oEmailFiltroAdd->AddNew();
			$oEmailFiltroAdd->EmailID = $oEmail->ID;
			$oEmailFiltroAdd->FiltroID = $v;
			$oEmailFiltroAdd->Save();
		}
		
		//redireciona
		$oEmail->SetMessage((($bEditar) ? "Azul" : "Verde"));
		header("Location: " . (($_POST["hFA"] == "outro") ? "novo.php" : "index.php?" . $_SERVER["QUERY_STRING"]));
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
$oMasterPage->Open("PageContent");

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				<input type="checkbox" id="cbAtivo" name="cbAtivo" value="1" <?php if($oEmail->Ativo) { ?> checked="checked" <?php } ?> />
				Ativo
			</label>
		</li>
    	<li>
			<label>
				Nome*:
				<input size="60" maxlength="150" type="text" id="txtNome" name="txtNome" value="<?=$oEmail->Nome;?>" class="{required:true, focus:true}" title="Digite o nome." />
			</label>
		</li>
		<li>
			<label>
				E-mail*:
				<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" value="<?=$oEmail->Email;?>" class="{required:true, email:true}" title="Digite o e-mail corretamente." />
			</label>
		</li>
		<li>
			Dia/Mês:
			<br />
			<input style="display:inline;" size="2" maxlength="2" type="text" id="txtDia" name="txtDia" value="<?=(($oEmail->Dia > 0) ? $oEmail->Dia : "");?>" class="{numeric:false, number:true}" title="Digite o dia corretamente." />
			/
			<input style="display:inline;" size="2" maxlength="2" type="text" id="txtMes" name="txtMes" value="<?=(($oEmail->Mes > 0) ? $oEmail->Mes : "");?>" class="{numeric:true, number:true}" title="Digite o mês corretamente." />
		</li>
		<?php
		$oFiltro = new tmmktfiltro();
		$oFiltro->SQLOrder = "Titulo ASC";
		if($oFiltro->LoadSQLAssembled())
		{
		?>
			<li>
				<fieldset>
					<legend>Filtros</legend>
					<div class="margem">
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
										$oEmailFiltro = new tmmktemailfiltro();
										$sel = $oEmailFiltro->LoadByEmailIDAndFiltroID($oEmail->ID, $oFiltro->ID);
									}
									?>
									<td>
										<label>
											<input type="checkbox" name="cbFiltro[]" value="<?=$oFiltro->ID;?>" <?php if($sel) { ?> checked="checked" <?php } ?> />
											<?=$oFiltro->Titulo;?>
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
			</li>
			<?php
		}
		?>
	</ul>
    <input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>