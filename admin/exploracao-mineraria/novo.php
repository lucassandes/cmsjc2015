<?php

$Chave = "exploracao-mineraria";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/texploracaomineraria.php");
include_once("../../library/config/database/texploracaominerariaarquivo.php");

$oExploracaoMineraria = new texploracaomineraria();
$bEditar = $oExploracaoMineraria->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oExploracaoMineraria->Titulo = $_POST["txtTitulo"];
	$oExploracaoMineraria->Data = $_POST["txtData"];
	$oExploracaoMineraria->Tipo = $_POST["ddlTipo"];
	$oExploracaoMineraria->GaleriaID = ((intval($_POST["ddlGaleria"])) ? intval($_POST["ddlGaleria"]) : null);
	$oExploracaoMineraria->URL = (($_POST["txtURL"]) ? $_POST["ddlProtocolo"] . $oExploracaoMineraria->RemoveProtocolo($_POST["txtURL"]) : "");
	$oExploracaoMineraria->Descricao = $_POST["txtDescricao"];
	$txtArquivo = ((is_array($_POST["txtArquivo"])) ? $_POST["txtArquivo"] : array());
	$flArquivo = ((is_array($_FILES["flArquivo"])) ? $_FILES["flArquivo"] : array());
	$hidArquivo = ((is_array($_POST["hidArquivo"])) ? $_POST["hidArquivo"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oExploracaoMineraria->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Data", $oExploracaoMineraria->Data, true, "date", "Digite a data corretamente.");
	$oValidator->Add("Tipo", $oExploracaoMineraria->Tipo, true, null, "Selecione o tipo.");
	$oValidator->Add("URL", $oExploracaoMineraria->URL, false, "url", "Digite a URL corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oExploracaoMineraria->AddNew();
		}
		$oExploracaoMineraria->Data = $oExploracaoMineraria->DateConvert($oExploracaoMineraria->Data);
		$oExploracaoMineraria->Save();
		
		//Remove
		$oExploracaoMinerariaArquivoDel = new texploracaominerariaarquivo();
		if($oExploracaoMinerariaArquivoDel->LoadByExploracaoMinerariaID($oExploracaoMineraria->ID))
		{
			for($c = 0; $c < $oExploracaoMinerariaArquivoDel->NumRows; $c++)
			{
				if(!in_array($oExploracaoMinerariaArquivoDel->ID, $hidArquivo))
				{
					$oExploracaoMinerariaArquivoDel->RemoveFile("../.." . $oExploracaoMinerariaArquivoDel->Arquivo);
					$oExploracaoMinerariaArquivoDel->MarkAsDelete();
					$oExploracaoMinerariaArquivoDel->Save();
				}
				$oExploracaoMinerariaArquivoDel->MoveNext();
			}
		}
		
		//Add
		foreach($hidArquivo as $key => $value)
		{
			$oUpload = new Upload($flArquivo, $key);
			$bUpload = $oUpload->Validate(true, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx"));
			
			$oExploracaoMinerariaArquivoAdd = new texploracaominerariaarquivo();
			if(!$oExploracaoMinerariaArquivoAdd->LoadByPrimaryKey($value))
			{
				if($bUpload)
				{
					$oExploracaoMinerariaArquivoAdd->AddNew();
					$oExploracaoMinerariaArquivoAdd->ExploracaoMinerariaID = $oExploracaoMineraria->ID;
					$oExploracaoMinerariaArquivoAdd->Titulo = $txtArquivo[$key];
					$oExploracaoMinerariaArquivoAdd->Arquivo = $oUpload->Save($Chave, $oExploracaoMinerariaArquivoAdd->Arquivo);
					$oExploracaoMinerariaArquivoAdd->Save();
				}
			}
			else
			{
				$oExploracaoMinerariaArquivoAdd->Titulo = $txtArquivo[$key];
				$oExploracaoMinerariaArquivoAdd->Arquivo = $oUpload->Save($Chave, $oExploracaoMinerariaArquivoAdd->Arquivo);
				$oExploracaoMinerariaArquivoAdd->Save();
			}
		}
		
		//redireciona
		$oExploracaoMineraria->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<ul>
    	<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oExploracaoMineraria->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Data*:
				<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oExploracaoMineraria->Data != "" && $oExploracaoMineraria->Data != "0000-00-00") ? (($_POST) ? $oExploracaoMineraria->Data : date("d/m/Y", $oExploracaoMineraria->DateShow($oExploracaoMineraria->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
				<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
				<sub>(Ex.: dd/mm/yyyy)</sub>
			</label>
		</li>
		<li>
			<label>
				Tipo*:
				<select id="ddlTipo" name="ddlTipo" class="{required:true}" title="Selecione o tipo.">
					<option value="" selected="selected">Selecione</option>
					<?php
					foreach($oExploracaoMineraria->TipoLista as $c => $v)
					{
						?>
						<option value="<?=$c;?>" <?php if($c == $oExploracaoMineraria->Tipo) { ?> selected="selected" <?php } ?>><?=$v;?></option>
						<?php
					}
					?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Galeria de Fotos:
				<select id="ddlGaleria" name="ddlGaleria">
					<option value="" selected="selected">Nenhuma</option>
					<?php tgaleria::ddl($oExploracaoMineraria->GaleriaID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Protocolo:
				<select id="ddlProtocolo" name="ddlProtocolo">
					<option value="http://" <?php if(strpos($oExploracaoMineraria->URL, "http://") !== false) { ?> selected="selected" <?php } ?>>http://</option>
					<option value="https://" <?php if(strpos($oExploracaoMineraria->URL, "https://") !== false) { ?> selected="selected" <?php } ?>>https://</option>
				</select>
			</label>
		</li>
		<li>
			<label>
				URL:
				<input size="60" maxlength="140" type="text" id="txtURL" name="txtURL" value="<?=$oExploracaoMineraria->RemoveProtocolo($oExploracaoMineraria->URL);?>" />
				<sub>(Ex.: www.exemplo.com.br)</sub>
			</label>
		</li>
		<li>
			<table class="lista" style="width:auto;">
				<thead>
					<tr>
						<td>Título</td>
						<td>Arquivo</td>
						<td>Opções</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$oExploracaoMinerariaArquivo = new texploracaominerariaarquivo();
					$oExploracaoMinerariaArquivo->LoadByExploracaoMinerariaID($oExploracaoMineraria->ID);
					$TotalArquivo = (($oExploracaoMinerariaArquivo->NumRows > 0) ? $oExploracaoMinerariaArquivo->NumRows : 1);
					for($c = 0; $c < $TotalArquivo; $c++)
					{
						?>
						<tr>
							<td><input size="30" maxlength="50" type="text" name="txtArquivo[]" value="<?=$oExploracaoMinerariaArquivo->Titulo;?>" /></td>
							<td><input size="30" type="file" name="flArquivo[]" /></td>
							<td align="center">
								<?php if($oExploracaoMinerariaArquivo->Arquivo) { ?><a href="<?=$oExploracaoMinerariaArquivo->DownloadURL($oExploracaoMinerariaArquivo->Arquivo);?>" class="remove"><img src="../imgs/icones16x16/down_16x16.gif" alt="Download" title="Download" /></a> <?php } ?>
								<a href="javascript:void(0);" onclick="addDefault($(this).parent().parent())" class="add" <?php if(($c + 1) < $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/add_16x16.gif" alt="Adicionar" title="Adicionar" /></a>
								<a href="javascript:void(0);" onclick="delDefault($(this).parent().parent())" class="del" <?php if(($c + 1) >= $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/delete_16x16.gif" alt="Remover" title="Remover" /></a>
								<input type="hidden" name="hidArquivo[]" value="<?=$oExploracaoMinerariaArquivo->ID;?>" />
							</td>
						</tr>
						<?php
						$oExploracaoMinerariaArquivo->MoveNext();
					}
					?>
				</tbody>
			</table>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oExploracaoMineraria->HTMLDecode($oExploracaoMineraria->Descricao);
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