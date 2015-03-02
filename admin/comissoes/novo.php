<?php

$Chave = "comissoes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tcomissao.php");
include_once("../../library/config/database/tvereador.php");

$oComissao = new tcomissao();
$bEditar = $oComissao->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sTipo = $oComissao->Tipo;
	$oComissao->Titulo = $_POST["txtTitulo"];
	$oComissao->Tipo = $_POST["ddlTipo"];
	$oComissao->PresidenteID = $_POST["ddlPresidente"];
	$oComissao->PresidenteSuplenteID = $_POST["ddlPresidenteSuplente"];
	$oComissao->RevisorID = $_POST["ddlRevisor"];
	$oComissao->RevisorSuplenteID = $_POST["ddlRevisorSuplente"];
	$oComissao->Relator1ID = $_POST["ddlRelator1"];
	$oComissao->Relator1SuplenteID = $_POST["ddlRelator1Suplente"];
	$oComissao->Relator2ID = $_POST["ddlRelator2"];
	$oComissao->Relator2SuplenteID = $_POST["ddlRelator2Suplente"];
	$oComissao->Relator3ID = $_POST["ddlRelator3"];
	$oComissao->Relator3SuplenteID = $_POST["ddlRelator3Suplente"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oComissao->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Tipo", $oComissao->Tipo, true, null, "Selecione o tipo.");
	$oValidator->Add("Presidente", $oComissao->PresidenteID, true, null, "Selecione o presidente.");
	$oValidator->Add("PresidenteSuplente", $oComissao->PresidenteSuplenteID, true, null, "Selecione o suplente do presidente.");
	$oValidator->Add("Revisor", $oComissao->RevisorID, true, null, "Selecione o revisor.");
	$oValidator->Add("RevisorSuplente", $oComissao->RevisorSuplenteID, true, null, "Selecione o suplente do revisor.");
	$oValidator->Add("Relator1", $oComissao->Relator1ID, true, null, "Selecione o relator 1.");
	$oValidator->Add("Relator1Suplente", $oComissao->Relator1SuplenteID, true, null, "Selecione o suplente do relator 1.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oComissao->AddNew();
		}
		if(!$bEditar || $sTipo != $oComissao->Tipo)
		{
			$oComissao->Ordem = $oComissao->GetOrdem("Tipo = '" . $oComissao->Tipo . "'");
		}
		$oComissao->Save();
		
		//redireciona
		$oComissao->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oComissao->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Tipo*:
				<select id="ddlTipo" name="ddlTipo" class="{required:true}" title="Selecione o tipo.">
					<option value="" selected="selected">Selecione</option>
					<?php
					foreach($oComissao->TipoLista as $c => $v)
					{
						?>
						<option value="<?=$c;?>" <?php if($c == $oComissao->Tipo) { ?> selected="selected" <?php } ?>><?=$v;?></option>
						<?php
					}
					?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Presidente*:
				<select id="ddlPresidente" name="ddlPresidente" class="{required:true}" title="Selecione o presidente.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->PresidenteID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Suplente do Presidente*:
				<select id="ddlPresidenteSuplente" name="ddlPresidenteSuplente" class="{required:true}" title="Selecione o suplente do presidente.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->PresidenteSuplenteID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Revisor*:
				<select id="ddlRevisor" name="ddlRevisor" class="{required:true}" title="Selecione o revisor.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->RevisorID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Suplente do Revisor*:
				<select id="ddlRevisorSuplente" name="ddlRevisorSuplente" class="{required:true}" title="Selecione o suplente do revisor.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->RevisorSuplenteID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Relator*:
				<select id="ddlRelator1" name="ddlRelator1" class="{required:true}" title="Selecione o relator.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->Relator1ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Suplente do Relator*:
				<select id="ddlRelator1Suplente" name="ddlRelator1Suplente" class="{required:true}" title="Selecione o suplente do relator.">
					<option value="" selected="selected">Selecione</option>
					<?php tvereador::ddl($oComissao->Relator1SuplenteID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Relator:
				<select id="ddlRelator2" name="ddlRelator2">
					<option value="" selected="selected">Nenhum</option>
					<?php tvereador::ddl($oComissao->Relator2ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Suplente do Relator:
				<select id="ddlRelator2Suplente" name="ddlRelator2Suplente">
					<option value="" selected="selected">Nenhum</option>
					<?php tvereador::ddl($oComissao->Relator2SuplenteID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Relator:
				<select id="ddlRelator3" name="ddlRelator3">
					<option value="" selected="selected">Nenhum</option>
					<?php tvereador::ddl($oComissao->Relator3ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Suplente do Relator:
				<select id="ddlRelator3Suplente" name="ddlRelator3Suplente">
					<option value="" selected="selected">Nenhum</option>
					<?php tvereador::ddl($oComissao->Relator3SuplenteID); ?>
				</select>
			</label>
		</li>
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