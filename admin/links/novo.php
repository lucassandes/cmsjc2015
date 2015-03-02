<?php

$Chave = "links";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tlink.php");
include_once("../../library/config/database/tcategorialink.php");

$oLink = new tlink();
$bEditar = $oLink->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//vari�veis
	$sCategoriaLinkID = $oLink->CategoriaLinkID;
	$oLink->Titulo = $_POST["txtTitulo"];
	$oLink->CategoriaLinkID = intval($_POST["ddlCategoria"]);
	$oLink->URL = (($_POST["txtURL"]) ? $_POST["ddlProtocolo"] . $oLink->RemoveProtocolo($_POST["txtURL"]) : "");
	
	//valida��o
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oLink->Titulo, true, null, "Digite o t�tulo.");
	$oValidator->Add("Categoria", $oLink->CategoriaLinkID, true, null, "Selecione a categoria.");
	$oValidator->Add("URL", $oLink->URL, true, "url", "Digite a URL corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oLink->AddNew();
		}
		if(!$bEditar || $sCategoriaLinkID != $oLink->CategoriaLinkID)
		{
			$oLink->Ordem = $oLink->GetOrdem("CategoriaLinkID = '" . $oLink->CategoriaLinkID . "'");
		}
		$oLink->Save();
		
		//redireciona
		$oLink->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * s�o obrigat�rios)
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				T�tulo*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oLink->Titulo;?>" class="{required:true, focus:true}" title="Digite o t�tulo." />
			</label>
		</li>
		<li>
			<label>
				Categoria*:
				<select id="ddlCategoria" name="ddlCategoria" class="{required:true}" title="Selecione a categoria.">
					<option value="" selected="selected">Selecione</option>
					<?php tcategorialink::ddl($oLink->CategoriaLinkID); ?>
				</select>
			</label>
		</li>
		<li class="left">
			<label>
				Protocolo*:
				<select id="ddlProtocolo" name="ddlProtocolo" class="{required:true}" title="Selecione o protocolo.">
					<option value="http://" <?php if(strpos($oLink->URL, "http://") !== false) { ?> selected="selected" <?php } ?>>http://</option>
					<option value="https://" <?php if(strpos($oLink->URL, "https://") !== false) { ?> selected="selected" <?php } ?>>https://</option>
				</select>
			</label>
		</li>
		<li>
			<label>
				URL*:
				<input size="60" maxlength="140" type="text" id="txtURL" name="txtURL" value="<?=$oLink->RemoveProtocolo($oLink->URL);?>" class="{required:true}" title="Digite a URL corretamente." />
				<sub>(Ex.: www.exemplo.com.br)</sub>
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