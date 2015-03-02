<?php

$Chave = "vereadores";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tvereador.php");
include_once("../../library/config/database/tpartido.php");

$oVereador = new tvereador();
$bEditar = $oVereador->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oVereador->Nome = $_POST["txtNome"];
	$oVereador->PartidoID = intval($_POST["ddlPartido"]);
	$oVereador->LiderPartidario = intval($_POST["cbLiderPartidario"]);
	$oVereador->LiderGoverno = intval($_POST["cbLiderGoverno"]);
	$oVereador->Informacao = $_POST["txtInformacao"];
	$oVereador->Email = $_POST["txtEmail"];
	$oVereador->Telefone = $_POST["txtTelefone"];
	$oVereador->LocalTrabalho = $_POST["txtLocalTrabalho"];
	$oVereador->Descricao = $_POST["txtDescricao"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Nome", $oVereador->Nome, true, null, "Digite o nome.");
	$oValidator->Add("Partido", $oVereador->PartidoID, true, null, "Selecione o partido.");
	$oValidator->Add("Email", $oVereador->Email, false, "email", "Digite o e-mail corretamente.");
	$oValidator->Add("Telefone", $oVereador->Telefone, false, "phone", "Digite o telefone corretamente.");
	
	$oUpload = new Upload($_FILES["flImagem"]);
	if(!$oUpload->Validate(false, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("Imagem", $oUpload->Message);
	}
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oVereador->AddNew();
			$oVereador->Ordem = $oVereador->GetOrdem();
		}
		$oVereador->Imagem = $oUpload->Save($Chave, $oVereador->Imagem);
		$oVereador->Save();
		
		//redireciona
		$oVereador->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				Nome*:
				<input size="60" maxlength="150" type="text" id="txtNome" name="txtNome" value="<?=$oVereador->Nome;?>" class="{required:true, focus:true}" title="Digite o nome." />
			</label>
		</li>
    	<li>
			<label>
				Partido*:
				<select id="ddlPartido" name="ddlPartido" class="{required:true}" title="Selecione o partido.">
					<option value="" selected="selected">Selecione</option>
					<?php tpartido::ddl($oVereador->PartidoID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				<input type="checkbox" id="cbLiderPartidario" name="cbLiderPartidario" value="1" <?php if($oVereador->LiderPartidario) { ?> checked="checked" <?php } ?> />
				Líder Partidário
			</label>
		</li>
		<li>
			<label>
				<input type="checkbox" id="cbLiderGoverno" name="cbLiderGoverno" value="1" <?php if($oVereador->LiderGoverno) { ?> checked="checked" <?php } ?> />
				Líder de Governo
			</label>
		</li>
		<li>
			<label>
				Dados Pessoais:
				<?php
				$oEditor = new FCKeditor("txtInformacao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oVereador->HTMLDecode($oVereador->Informacao);
				$oEditor->ToolbarSet = "Basico";
				$oEditor->Height = "100";
				$oEditor->Create();
				?>
			</label>
		</li>
		<li>
			<label>
				E-mail:
				<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" value="<?=$oVereador->Email;?>" class="{email:true}" title="Digite o e-mail corretamente." />
			</label>
		</li>
		<li>
			<label>
				Telefone:
				<input size="14" maxlength="14" type="text" id="txtTelefone" name="txtTelefone" value="<?=$oVereador->Telefone;?>" class="{phone:true, mask:'(99) 9999-9999'}" title="Digite o telefone corretamente." />
			</label>
		</li>
		<li>
			<label>
				Local de Trabalho:
				<input size="50" maxlength="50" type="text" id="txtLocalTrabalho" name="txtLocalTrabalho" value="<?=$oVereador->LocalTrabalho;?>" />
			</label>
		</li>
		<li>
			<label>
				Imagem (*.jpg, *.jpeg, *.gif):
				<input size="60" type="file" id="flImagem" name="flImagem" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem corretamente." />
				<?php
				if($oVereador->Imagem)
				{
					?>
					<br />
					<a title="<?=$oVereador->Nome;?>" rel="lightbox" href="<?=$oVereador->Thumbnail($oVereador->Imagem, 770, 440);?>">
						<img alt="<?=$oVereador->Nome;?>" title="<?=$oVereador->Nome;?>" src="<?=$oVereador->Thumbnail($oVereador->Imagem, 150, 100);?>" />
					</a>
					<br />
					<br />
					<?php $oVereador->CropImage($oVereador->Imagem, array(120, 340), array(120, 353), array("1:1", "101:104")); ?>
					<br />
					<a href="remover-imagem.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()">
						<img src="../imgs/botoes/remover-imagem.png" alt="Remover imagem" title="Remover imagem" />
					</a>
					<br />
					<?php
				}
				?>			
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oVereador->HTMLDecode($oVereador->Descricao);
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