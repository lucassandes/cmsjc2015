<?php

$Chave = "mesa-diretora";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tmesadiretora.php");
include_once("../../library/config/database/tvereador.php");

$oMesaDiretora = new tmesadiretora();
$bEditar = $oMesaDiretora->LoadSQLAssembled();

//post
if($_POST)
{
	//variáveis
	$oMesaDiretora->Titulo = $_POST["txtTitulo"];
	$oMesaDiretora->PresidenteID = ((intval($_POST["ddlPresidente"])) ? intval($_POST["ddlPresidente"]) : null);
	$oMesaDiretora->VicePresidente1ID = ((intval($_POST["ddlVicePresidente1"])) ? intval($_POST["ddlVicePresidente1"]) : null);
	$oMesaDiretora->VicePresidente2ID = ((intval($_POST["ddlVicePresidente2"])) ? intval($_POST["ddlVicePresidente2"]) : null);
	$oMesaDiretora->Secretario1ID = ((intval($_POST["ddlSecretario1"])) ? intval($_POST["ddlSecretario1"]) : null);
	$oMesaDiretora->Secretario2ID = ((intval($_POST["ddlSecretario2"])) ? intval($_POST["ddlSecretario2"]) : null);
	$oMesaDiretora->Descricao = $_POST["txtDescricao"];
	
	if(!$bEditar)
	{
		$oMesaDiretora->AddNew();
	}
	$oMesaDiretora->Save();
		
	//redireciona
	$oMesaDiretora->SetMessage((($bEditar) ? "Azul" : "Verde"));
	header("Location: index.php");
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<ul>
    	<li>
			<label>
				Título:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oMesaDiretora->Titulo;?>" />
			</label>
		</li>
		<li>
			<label>
				Presidente:
				<select id="ddlPresidente" name="ddlPresidente">
					<option value="" selected="selected">---</option>
					<?php tvereador::ddl($oMesaDiretora->PresidenteID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				1º Vice-Presidente:
				<select id="ddlVicePresidente1" name="ddlVicePresidente1">
					<option value="" selected="selected">---</option>
					<?php tvereador::ddl($oMesaDiretora->VicePresidente1ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				2º Vice-Presidente:
				<select id="ddlVicePresidente2" name="ddlVicePresidente2">
					<option value="" selected="selected">---</option>
					<?php tvereador::ddl($oMesaDiretora->VicePresidente2ID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				1º Secretário:
				<select id="ddlSecretario1" name="ddlSecretario1">
					<option value="" selected="selected">---</option>
					<?php tvereador::ddl($oMesaDiretora->Secretario1ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				2º Secretário:
				<select id="ddlSecretario2" name="ddlSecretario2">
					<option value="" selected="selected">---</option>
					<?php tvereador::ddl($oMesaDiretora->Secretario2ID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oMesaDiretora->HTMLDecode($oMesaDiretora->Descricao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "300";
				$oEditor->Create();
				?>
			</label>
		</li>
	</ul>
    <input type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="../"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>