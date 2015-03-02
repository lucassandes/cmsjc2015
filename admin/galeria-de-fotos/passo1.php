<?php

$Chave = "galeria-de-fotos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tgaleria.php");

$oGaleria = new tgaleria();
$bEditar = $oGaleria->LoadByPrimaryKey($_GET["id"]);

$cbChave = each($oGaleria->ChaveLista);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oGaleria->Titulo = $_POST["txtTitulo"];
	$oGaleria->Data = $_POST["txtData"];
	$oGaleria->Descricao = $_POST["txtDescricao"];
	
	if(!$oGaleria->Chave || $oGaleria->Chave == $cbChave["key"])
	{
		$oGaleria->Chave = $_POST["cbChave"];
	}	
		
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oGaleria->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Data", $oGaleria->Data, true, "date", "Digite a data corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oGaleria->AddNew();
		}
		$oGaleria->Data = $oGaleria->DateConvert($oGaleria->Data);
		$oGaleria->Save();
		
		//redireciona
		$oGaleria->SetMessage((($bEditar) ? "Azul" : "Verde"));
		header("Location: passo2.php?" . $oGaleria->RemoveQueryString(array("id")) . "id=" . $oGaleria->ID);
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
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<ul>
		<?php
		if(!$oGaleria->Chave || $oGaleria->Chave == $cbChave["key"])
		{
			?>
			<li>
				<label><input type="checkbox" id="cbChave" name="cbChave" value="<?=$cbChave["key"];?>" <?php if($oGaleria->Chave == $cbChave["key"]) { ?>checked="checked"<?php } ?> /> <?=$cbChave["value"];?></label>
			</li>
			<?php
		}
		?>
    	<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oGaleria->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Data*:
				<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oGaleria->Data != "" && $oGaleria->Data != "0000-00-00") ? (($_POST) ? $oGaleria->Data : date("d/m/Y", $oGaleria->DateShow($oGaleria->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
				<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
				<sub>(Ex.: dd/mm/yyyy)</sub>
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oGaleria->HTMLDecode($oGaleria->Descricao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "300";
				$oEditor->Create();
				?>
			</label>
		</li>
	</ul>
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
    <input type="image" src="../imgs/botoes/proximo.png" alt="Próximo" title="Próximo" />
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>