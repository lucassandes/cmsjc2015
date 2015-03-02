<?php

$Chave = "eventos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tevento.php");

$oEvento = new tevento();
$bEditar = $oEvento->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oEvento->Titulo = $_POST["txtTitulo"];
	$oEvento->Data = $_POST["txtData"];
	$oEvento->Hora = $_POST["txtHora"];
	$oEvento->Local = $_POST["txtLocal"];
	$oEvento->AudienciaPublica = intval($_POST["cbAudienciaPublica"]);
	$oEvento->Descricao = $_POST["txtDescricao"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oEvento->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Data", $oEvento->Data, true, "date", "Digite a data corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oEvento->AddNew();
		}
		$oEvento->Data = $oEvento->DateConvert($oEvento->Data);
		$oEvento->Save();
		
		//redireciona
		$oEvento->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oEvento->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Data*:
				<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oEvento->Data != "" && $oEvento->Data != "0000-00-00") ? (($_POST) ? $oEvento->Data : date("d/m/Y", $oEvento->DateShow($oEvento->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
				<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
				<sub>(Ex.: dd/mm/yyyy)</sub>
			</label>
		</li>
		<li>
			<label>
				Hora:
				<input size="50" maxlength="50" type="text" id="txtHora" name="txtHora" value="<?=$oEvento->Hora;?>" />
			</label>
		</li>
		<li>
			<label>
				Local:
				<input size="50" maxlength="50" type="text" id="txtLocal" name="txtLocal" value="<?=$oEvento->Local;?>" />
			</label>
		</li>
		<li>
			<label>
				<input type="checkbox" id="cbAudienciaPublica" name="cbAudienciaPublica" value="1" <?php if($oEvento->AudienciaPublica) { ?> checked="checked" <?php } ?> />
				Audiência Pública
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oEvento->HTMLDecode($oEvento->Descricao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "300";
				$oEditor->Create();
				?>
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