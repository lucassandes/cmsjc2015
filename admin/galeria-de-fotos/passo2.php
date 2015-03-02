<?php

$Chave = "galeria-de-fotos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/tgaleriafoto.php");

$oGaleria = new tgaleria();
if(!$oGaleria->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: passo1.php?" . $_SERVER["QUERY_STRING"]);
	exit();
}

//post
if($_POST)
{
	//vars
	$hidID = ((is_array($_POST["hidID"])) ? $_POST["hidID"] : array());
	$txtLegenda = ((is_array($_POST["txtLegenda"])) ? $_POST["txtLegenda"] : array());
	
	//altera
	foreach($hidID as $c => $v)
	{
		$oGaleriaFotoAdd = new tgaleriafoto();
		if($oGaleriaFotoAdd->LoadByPrimaryKey($v))
		{
			$oGaleriaFotoAdd->Legenda = $txtLegenda[$c];
			$oGaleriaFotoAdd->Ordem = ($c + 1);
			$oGaleriaFotoAdd->Save();
		}
	}
	
	//remove
	$oGaleriaFotoDel = new tgaleriafoto();
	$oGaleriaFotoDel->SQLWhere = "(ID != '" . implode("' AND ID != '", $hidID) . "')";
	if($oGaleriaFotoDel->LoadByGaleriaID($oGaleria->ID))
	{
		for($c = 0; $c < $oGaleriaFotoDel->NumRows; $c++)
		{
			$oGaleriaFotoDel->RemoveFile("../.." . $oGaleriaFotoDel->Imagem);
			$oGaleriaFotoDel->MarkAsDelete();
			$oGaleriaFotoDel->Save();
			$oGaleriaFotoDel->MoveNext();
		}
	}
	
	//redireciona
	$oGaleria->SetMessage("Azul");
	header("Location: " . (($_POST["hFA"] == "outro") ? "passo1.php" : "index.php?" . $_SERVER["QUERY_STRING"]));
	exit();
}

session_id();

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageTop");
$passo = 2;
include("abas.php");
$oMasterPage->Close("PageTop");
$oMasterPage->Open("PageContent");
?>
<script language="javascript" type="text/javascript" src="passo2.js"></script>
<script language="javascript" type="text/javascript">
	$(function(){
		passo2.init("<?=$oGaleria->ID;?>");
	});
</script>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<div class="mensagem">
		<div class="amarelo">
			<span>Atenção!</span>
			Clique no botão abaixo para selecionar as fotos, utilize CTRL ou SHIFT para selecionar mais de uma.<br />
			Para trocar as fotos de posição clique sobre a imagem e arraste.<br />
			Após fazer todas as modificações clique em ENVIAR para salvar.
		</div>
	</div>
	<div class="mensagem" style="width:230px;">
		<div class="azul" style="padding:0;">
			<div id="botao"></div>
		</div>
	</div>
	<div class="item">
		<?php
		$oGaleriaFoto = new tgaleriafoto();
		if($oGaleriaFoto->LoadByGaleriaID($oGaleria->ID))
		{
			for($c = 0; $c < $oGaleriaFoto->NumRows; $c++)
			{
				?>
				<div class="area" id="item-<?=$oGaleriaFoto->ID;?>">
					<input type="hidden" name="hidID[]" value="<?=$oGaleriaFoto->ID;?>" />
					<table width="100%">
						<tr>
							<td width="150" align="center"><img class="carregando" style="cursor:move;" src="<?=$oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 80, 80);?>" alt="" title="" /><br /></td>
							<td><label>Legenda: <input type="text" size="60" maxlength="150" name="txtLegenda[]" value="<?=$oGaleriaFoto->Legenda;?>" /></label></td>
							<td width="110" align="right"><a href="javascript:void(0);" onclick="passo2.remove('<?=$oGaleriaFoto->ID;?>');"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a></td>
						</tr>
					</table>
				</div>
				<?php
				$oGaleriaFoto->MoveNext();
			}
		}
		?>
	</div>
    <input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="passo1.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>