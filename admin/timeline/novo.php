<?php

$Chave = "timeline";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/ttimeline.php");
include_once("../../library/config/database/ttimelinepresidente.php");

$oTimeline = new ttimeline();
$bEditar = $oTimeline->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oTimeline->Titulo = $_POST["txtTitulo"];
	$oTimeline->Periodo = $_POST["txtPeriodo"];
	$oTimeline->Vereadores = $_POST["txtVereadores"];   
	$oTimeline->Suplentes = $_POST["txtSuplentes"];   
	$oTimeline->Observacao = $_POST["txtObservacao"];   
	$txtNomeImagem = ((is_array($_POST["txtNomeImagem"])) ? $_POST["txtNomeImagem"] : array());
	$txtPeriodoImagem = ((is_array($_POST["txtPeriodoImagem"])) ? $_POST["txtPeriodoImagem"] : array());
	$flImagem = ((is_array($_FILES["flImagem"])) ? $_FILES["flImagem"] : array());
	$hidImagem = ((is_array($_POST["hidImagem"])) ? $_POST["hidImagem"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oTimeline->Titulo, true, null, "Digite o título.");
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oTimeline->AddNew();
		}
		$oTimeline->Save();
		
		//Remove
		$oTimelinePresidenteDel = new ttimelinepresidente();
		if($oTimelinePresidenteDel->LoadByTimelineID($oTimeline->ID))
		{
			for($c = 0; $c < $oTimelinePresidenteDel->NumRows; $c++)
			{
				if(!in_array($oTimelinePresidenteDel->ID, $hidImagem))
				{
					$oTimelinePresidenteDel->RemoveFile("../.." . $oTimelinePresidenteDel->Imagem);
					$oTimelinePresidenteDel->MarkAsDelete();
					$oTimelinePresidenteDel->Save();
				}
				$oTimelinePresidenteDel->MoveNext();
			}
		}
		
		//Add
		foreach($hidImagem as $key => $value)
		{
			$oUpload = new Upload($flImagem, $key);
			$bUpload = $oUpload->Validate(true, array("jpg", "png", "gif"));
			
			$oTimelinePresidenteAdd = new ttimelinepresidente();
			if(!$oTimelinePresidenteAdd->LoadByPrimaryKey($value))
			{
				if($bUpload)
				{
					$oTimelinePresidenteAdd->AddNew();
					$oTimelinePresidenteAdd->TimelineID = $oTimeline->ID;
					$oTimelinePresidenteAdd->Nome = $txtNomeImagem[$key];
					$oTimelinePresidenteAdd->Periodo = $txtPeriodoImagem[$key];
					$oTimelinePresidenteAdd->Imagem = $oUpload->Save($Chave, $oTimelinePresidenteAdd->Imagem);
					$oTimelinePresidenteAdd->Save();
				}
			}
			else
			{
				$oTimelinePresidenteAdd->Nome = $txtNomeImagem[$key];
				$oTimelinePresidenteAdd->Periodo = $txtPeriodoImagem[$key];
				$oTimelinePresidenteAdd->Imagem = $oUpload->Save($Chave, $oTimelinePresidenteAdd->Imagem);
				$oTimelinePresidenteAdd->Save();
			}
		}
		
		//redireciona
		$oTimeline->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oTimeline->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
    	<li>
			<label>
				Periodo:
				<input size="60" maxlength="150" type="text" id="txtPeriodo" name="txtPeriodo" value="<?=$oTimeline->Periodo;?>"/>
			</label>
		</li>
		<li>
			Presidentes:
			<table class="lista" style="width:auto;">
				<thead>
					<tr>
						<td>Nome</td>
						<td>Período</td>
						<td>Imagem (*.jpg, *.png, *.gif)</td>
						<td>Opções</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$oTimelinePresidente = new ttimelinepresidente();
					$oTimelinePresidente->LoadByTimelineID($oTimeline->ID);
					$TotalImagem = (($oTimelinePresidente->NumRows > 0) ? $oTimelinePresidente->NumRows : 1);
					for($c = 0; $c < $TotalImagem; $c++)
					{
						?>
						<tr>
							<td><input size="30" maxlength="50" type="text" name="txtNomeImagem[]" value="<?=$oTimelinePresidente->Nome;?>" /></td>
							<td><input size="30" maxlength="50" type="text" name="txtPeriodoImagem[]" value="<?=$oTimelinePresidente->Periodo;?>" /></td>
							<td><input size="30" type="file" name="flImagem[]" /></td>
							<td align="center">
								<?php if($oTimelinePresidente->Imagem) { ?><a href="<?=$oTimelinePresidente->Thumbnail($oTimelinePresidente->Imagem, 800, 600, "", false, true);?>" class="remove" rel="lightbox"><img src="../imgs/icones16x16/image_16x16.gif" alt="Download" title="Download" /></a> <?php } ?>
								<a href="javascript:void(0);" onclick="delDefault($(this).parent().parent())" class="del"><img src="../imgs/icones16x16/delete_16x16.gif" alt="Remover" title="Remover" /></a>
								<a href="javascript:void(0);" onclick="addDefault($(this).parent().parent())" class="add" <?php if(($c + 1) < $TotalImagem) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/add_16x16.gif" alt="Adicionar" title="Adicionar" /></a>
								<input type="hidden" name="hidImagem[]" value="<?=$oTimelinePresidente->ID;?>" />
							</td>
						</tr>
						<?php
						$oTimelinePresidente->MoveNext();
					}
					?>
				</tbody>
			</table>
		</li>
		<li>
			<label>
				Vereadores:
				<?php
				$oEditor = new FCKeditor("txtVereadores");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oTimeline->HTMLDecode($oTimeline->Vereadores);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "300";
				$oEditor->Create();
				?>
			</label>
		</li>
		<li>
			<label>
				Observações:
				<?php
				$oEditor = new FCKeditor("txtObservacao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oTimeline->HTMLDecode($oTimeline->Observacao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "100";
				$oEditor->Create();
				?>
			</label>
		</li>   
		<li>
			<label>
				Suplentes:
				<?php
				$oEditor = new FCKeditor("txtSuplentes");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oTimeline->HTMLDecode($oTimeline->Suplentes);
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