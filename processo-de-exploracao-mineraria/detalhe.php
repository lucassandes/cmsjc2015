<?php

include_once("../library/master-page.php");
include_once("../library/config/database/texploracaomineraria.php");
include_once("../library/config/database/texploracaominerariaarquivo.php");

$oExploracaoMineraria = new texploracaomineraria();
if(!$oExploracaoMineraria->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: " . $oExploracaoMineraria->WebURL);
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Processo de Exploração Minerária / " . $oExploracaoMineraria->Titulo);
$oMasterPage->AddParameter("css", "processo-de-exploracao-mineraria/detalhe");
$oMasterPage->AddParameter("pagina", "processo-de-exploracao-mineraria");
$oMasterPage->AddParameter("alt", "Processo de Exploração Minerária");
$oMasterPage->Open("PageContent");

?>
<div class="cabecalho">
    <span class="data"><?=$oExploracaoMineraria->DateFormat("d \d\e MONTH \d\e Y", $oExploracaoMineraria->Data);?></span>
    <p><?=$oExploracaoMineraria->Titulo;?></p>
</div>
<?php if(!$oExploracaoMineraria->IsClear($oExploracaoMineraria->Descricao)) { ?><div class="fckEditor"><?=$oExploracaoMineraria->HTMLDecode($oExploracaoMineraria->Descricao);?></div><br /><?php } ?>
<?php if($oExploracaoMineraria->URL) { ?><a href="<?=$oExploracaoMineraria->URL;?>" target="_blank" class="url"><?=$oExploracaoMineraria->RemoveProtocolo($oExploracaoMineraria->URL);?></a><?php } ?>
<?php

$oExploracaoMinerariaArquivo = new texploracaominerariaarquivo();
if($oExploracaoMinerariaArquivo->LoadByExploracaoMinerariaID($oExploracaoMineraria->ID))
{
	for($c = 0; $c < $oExploracaoMinerariaArquivo->NumRows; $c++)
	{
		?>
		<a href="<?=$oExploracaoMinerariaArquivo->DownloadURL($oExploracaoMinerariaArquivo->Arquivo);?>" class="download">
			<span></span>
			<?=$oExploracaoMinerariaArquivo->Titulo;?>
		</a>
		<?php
		$oExploracaoMinerariaArquivo->MoveNext();
	}
}

?>
<div class="clear"></div>
<?php

$GaleriaID = $oExploracaoMineraria->GaleriaID;
include("../common/galeria-de-fotos.php");

?>
<a href="javascript:history.back();" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>